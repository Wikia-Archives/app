<?php
/**
 * LinkSuggest
 *
 * This extension provides the users with article title suggestions as he types
 * a link in wikitext.
 *
 * @file
 * @ingroup Extensions
 * @author Inez Korczyński <inez@wikia-inc.com>
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Lucas Garczewski (TOR) <tor@wikia-inc.com>
 * @author Sean Colombo <sean@wikia.com>
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @copyright Copyright (c) 2008-2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'LinkSuggest',
    'author' => 'Inez Korczyński, Bartek Łapiński, Ciencia al Poder, Lucas Garczewski, Sean Colombo, Maciej Brencz',
    'version' => '1.53',
);

$wgExtensionMessagesFiles['LinkSuggest'] = dirname(__FILE__).'/'.'LinkSuggest.i18n.php';
F::build('JSMessages')->registerPackage('LinkSuggest', array('tog-*'));

$wgHooks['GetPreferences'][] = 'wfLinkSuggestGetPreferences' ;
function wfLinkSuggestGetPreferences($user, &$preferences) {
	$preferences['disablelinksuggest'] = array(
		'type' => 'toggle',
		'section' => 'editing/editing-experience',
		'label-message' => 'tog-disablelinksuggest',
	);
	return true;
}

$wgHooks['EditForm::MultiEdit:Form'][] = 'AddLinkSuggest';
function AddLinkSuggest($a, $b, $c, $d) {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgUser, $wgHooks;
	wfProfileIn(__METHOD__);

	if($wgUser->getOption('disablelinksuggest') != true) {
		$js = "{$wgExtensionsPath}/wikia/LinkSuggest/LinkSuggest.js";

		// load YUI for Oasis - TODO: Refactor LinkSuggest.js to not use YUI.  Look in /trunk/skins/oasis/js/Search.js for an example of using LinkSuggest with jQuery.
		if ( F::app()->checkSkin( 'oasis' ) ) {
			$wgOut->addHTML('<script type="text/javascript">$(function() {$.loadYUI(function() {$.getScript('.Xml::encodeJsVar($js).')})})</script>');
		}
		else {
			$wgOut->addScript('<script type="text/javascript" src="'.$js.'"></script>');
		}

		// add global JS variables only when LinkSuggest is really loaded (BugId:20958)
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfLinkSuggestSetupVars';
	}

	wfProfileOut(__METHOD__);
	return true;
}

function wfLinkSuggestSetupVars( $vars ) {
	global $wgContLang;
	$vars['ls_template_ns'] = $wgContLang->getFormattedNsText( NS_TEMPLATE );
	$vars['ls_file_ns'] = $wgContLang->getFormattedNsText( NS_FILE );
	return true;
}

$wgAjaxExportList[] = 'getLinkSuggest';
$wgAjaxExportList[] = 'getLinkSuggestImage';

function getLinkSuggestImage() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$imageName = $wgRequest->getText('imageName');

	$out = 'N/A';
	try {
		$img = wfFindFile($imageName);
		if($img) {
			$out = $img->createThumb(180);
		}
	} catch (Exception $e) {
		$out = 'N/A';
	}

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60);

	wfProfileOut(__METHOD__);
	return $ar;
}

function wfLinkSuggestGetTextUpperBound( $text ) {
	$len = mb_strlen($text);
	if ($len == 0)
		return false;
	$lastChar = Wikia::ord(mb_substr($text,-1));
	if ($lastChar >= 0x7FFFFFFF)
		return wfLinkSuggestGetTextUpperBound( mb_substr($text,0,$len-1) );
	// this should check for invalid utf8 code points, but don't care about it (super-rare case)
	return mb_substr($text,0,$len-1) . Wikia::chr($lastChar + 1);
}

function getLinkSuggest() {
	global $wgRequest, $wgContLang, $wgCityId, $wgExternalDatawareDB, $wgContentNamespaces;
	wfProfileIn(__METHOD__);

	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = urldecode( trim( $wgRequest->getText('query') ) );
	$query = str_replace(' ', '_', $query);

	// Allow the calling-code to specify a namespace to search in (which at the moment, could be overridden by having prefixed text in the input field).
	// NOTE: This extension does parse titles to try to find things in other namespaces, but that actually doesn't work in practice because jQuery
	// Autocomplete will stop making requests after it finds 0 results.  So if you start to type "Category" and there is no page beginning
	// with "Cate", it will not even make the call to LinkSuggest.
	$namespace = $wgRequest->getVal('ns');

	// explode passed query by ':' to get namespace and article title
	$queryParts = explode(':', $query, 2);

	if(count($queryParts) == 2) {
		$query = $queryParts[1];

		$namespaceName = $queryParts[0];

		// try to get the index by canonical name first
		$namespace = MWNamespace::getCanonicalIndex(strtolower($namespaceName));
		if ( $namespace == null ) {
			// if we failed, try looking through localized namespace names
			$namespace = array_search(ucfirst($namespaceName), $wgContLang->getNamespaces());
			if (empty($namespace)) {
				// getting here means our "namespace" is not real and can only be part of the title
				$query = $namespaceName . ':' . $query;
			}
		}
	}

	// which namespaces to search in?
	if (empty($namespace)) {
		// search only within content namespaces (BugId:4625) - default behaviour
		$namespaces = $wgContentNamespaces;
	}
	else {
		// search only within a given namespace
		$namespaces = array($namespace);
	}

	$results = array();
	$redirResults = array();

	$query = mb_strtolower($query);
	$queryUpper = wfLinkSuggestGetTextUpperBound($query);
	$query = addslashes($query);
	$queryUpper = addslashes($queryUpper);

	$db = wfGetDB(DB_SLAVE, 'search');

	if (count($namespaces) > 0) {
		$commaJoinedNamespaces = count($namespaces) > 1 ?  array_shift($namespaces) . ', ' . implode(', ', $namespaces) : $namespaces[0];
	}

	$qcNamespaceClause = isset($commaJoinedNamespaces) ? 'AND qc_namespace IN (' . $commaJoinedNamespaces  . ')' : '';
	$pageNamespaceClause = isset($commaJoinedNamespaces) ?  'AND page_namespace IN (' . $commaJoinedNamespaces . ')' : '';

	$sql = "SELECT IFNULL(rd_title, page_title) AS link_title, page_title, page_namespace, SUM(qc_value) AS totalVal, page_is_redirect
			FROM 
				(
					SELECT page_title, rd_title, page_namespace, qc_value, page_is_redirect
					FROM   (SELECT page_id, page_title, page_is_redirect, page_namespace
							FROM page 
							WHERE 
								-- optimization instead of LIKE
								LOWER(page_title) >= '{$query}' 
								AND LOWER(page_title) < '{$queryUpper}'
								{$pageNamespaceClause}
						   ) matches

					LEFT JOIN redirect ON page_is_redirect = 1 AND page_id = rd_from

					LEFT JOIN 
						   (SELECT qc_title, qc_value  FROM querycache WHERE qc_type = 'Mostlinked' {$qcNamespaceClause}) mostlinked
						   ON qc_title = page_title OR rd_title = qc_title

				) `ordered_results`
			GROUP BY link_title HAVING min(page_is_redirect+1) -- i had to add one because min ignores 0 results. grr!
			ORDER BY totalVal DESC, page_is_redirect ASC
			LIMIT 10
			";

	$res = $db->query($sql);

	while($row = $db->fetchObject($res)) {
		$title = wfLinkSuggestFormatTitle($row->page_namespace, $row->link_title);
		$results[] = $title;
		if ($row->page_title != $row->link_title) {
			$redirTitle = wfLinkSuggestFormatTitle($row->page_namespace, $row->page_title);
			$redirResults[$title] = $redirTitle;
		}
	}
	$db->freeResult( $res );

	// bugid 29988: include special pages 
	// (registered in SpecialPage::$mList, not in the DB like a normal page)
	if (($namespaces == array('-1')) && (strlen($query) > 0)) {
		$specialPagesByAlpha = SpecialPage::$mList;
		ksort($specialPagesByAlpha, SORT_STRING);
		array_walk( $specialPagesByAlpha, 
					function($val,$key) use (&$results, $query) {
						if (strtolower(substr($key, 0, strlen($query))) === strtolower($query)) {
							$results[] = wfLinkSuggestFormatTitle('-1', $key);
						}
					} 
				  );
	}


	$format = $wgRequest->getText('format');

	if ($format == 'json') {
		$out = Wikia::json_encode(array('query' => $wgRequest->getText('query'), 'suggestions' => array_values($results), 'redirects' => $redirResults));

	// legacy: LinkSuggest.js uses this
	} else {
		// Overwrite canonical title with redirect title
		for($i = 0; $i < count($results); $i++) {
			if (isset($redirResults[$results[$i]])) {
				$results[$i] = $redirResults[$results[$i]];
			}
		}

		$out = implode("\n", $results);
	}

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60); // cache results for one hour

	// set proper content type to ease development
	if ($format == 'json') {
		$ar->setContentType('application/json; charset=utf-8');
	}
	else {
		$ar->setContentType('text/plain; charset=utf-8');
	}

	wfProfileOut(__METHOD__);
	return $ar;
}

/**
 * Returns formatted title based on given namespace and title
 *
 * @param $namespace integer page namespace ID
 * @param $title string page title
 * @return string formatted title (prefixed with localised namespace)
 */
function wfLinkSuggestFormatTitle($namespace, $title) {
	global $wgContLang;

	if ($namespace != NS_MAIN) {
		$title = $wgContLang->getNsText($namespace) . ':' . $title;
	}

	return str_replace('_', ' ', $title);
}

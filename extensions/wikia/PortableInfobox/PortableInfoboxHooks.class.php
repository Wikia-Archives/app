<?php

class PortableInfoboxHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		global $wgEnablePortableInfoboxEuropaTheme;

		Wikia::addAssetsToOutput( 'portable_infobox_js' );

		Wikia::addAssetsToOutput( 'portable_infobox_scss' );
		if ( !empty( $wgEnablePortableInfoboxEuropaTheme ) ) {
			Wikia::addAssetsToOutput( 'portable_infobox_europa_theme_scss' );
		}

		return true;
	}

	public static function onImageServingCollectImages( &$imageNamesArray, $articleTitle ) {
		if ( $articleTitle ) {
			$infoboxImages = PortableInfoboxDataService::newFromTitle( $articleTitle )->getImages();
			if ( !empty( $infoboxImages ) ) {
				$imageNamesArray = array_merge( $infoboxImages, (array)$imageNamesArray );
			}
		}

		return true;
	}

	/**
	 * Store data of all galleries in article to handle images in infoboxes
	 *
	 * @param $marker
	 * @param WikiaPhotoGallery $gallery
	 * @return bool
	 */
	public static function onAfterParserParseImageGallery( $marker, $gallery ) {
		if ( $gallery instanceof WikiaPhotoGallery ) {
			\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setGallery($marker, $gallery->getData());
		}
		return true;
	}

	public static function onWgQueryPages( &$queryPages = [ ] ) {
		$queryPages[] = [ 'AllinfoboxesQueryPage', 'AllInfoboxes' ];

		return true;
	}

	public static function onAllInfoboxesQueryRecached() {
		F::app()->wg->Memc->delete( wfMemcKey( ApiQueryAllinfoboxes::MCACHE_KEY ) );

		return true;
	}

	/**
	 * Purge memcache before edit
	 *
	 * @param $article Page|WikiPage
	 * @param $user
	 * @param $text
	 * @param $summary
	 * @param $minor
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $status
	 *
	 * @return bool
	 */
	public static function onArticleSave( Page $article, User $user, &$text, &$summary, $minor, $watchthis, $sectionanchor, &$flags, Status &$status ): bool {
		PortableInfoboxDataService::newFromTitle( $article->getTitle() )->invalidateCache();

		return true;
	}

	/**
	 * Purge memcache, this will not rebuild infobox data
	 *
	 * @param Page|WikiPage $article
	 *
	 * @return bool
	 */
	public static function onArticlePurge( Page $article ) {
		PortableInfoboxDataService::newFromTitle( $article->getTitle() )->invalidateCache();

		return true;
	}

	/**
	 * Purge articles memcache when template is edited
	 *
	 * @param Title[] $articles
	 *
	 * @return bool
	 */
	public static function onBacklinksPurge( Array $articles ) {
		foreach ( $articles as $title ) {
			PortableInfoboxDataService::newFromTitle( $title )->invalidateCache();
		}

		return true;
	}

	/**
	 * Insert a newly created infobox into querycache, and purge the list of
	 * infoboxes.
	 *
	 * @param  Page     $page          The created page object
	 * @param  User     $user          The user who created the page
	 * @param  string   $text          Text of the new article
	 * @param  string   $summary       Edit summary
	 * @param  int      $minoredit     Minor edit flag
	 * @param  boolean  $watchThis     Whether or not the user should watch the page
	 * @param  null     $sectionAnchor Not used, set to null
	 * @param  int      $flags         Flags for this page
	 * @param  Revision $revision      The newly inserted revision object
	 * @return boolean
	 */
	public static function onArticleInsertComplete( Page $page, User $user, $text, $summary, $minoredit,
	                                                $watchThis, $sectionAnchor, &$flags, Revision $revision ) {
		$title = $page->getTitle();
		if ( $title->inNamespace( NS_TEMPLATE ) ) {
			( new AllinfoboxesQueryPage() )->addTitleToCache( $title );
		}

		return true;
	}

	public static function onArticleAsJsonBeforeEncode( &$text ) {
		$tagController = PortableInfoboxParserTagController::getInstance();
		$tagController->moveFirstMarkerToTop( $text );

		$text = $tagController->replaceMarkers( $text );

		return true;
	}
}

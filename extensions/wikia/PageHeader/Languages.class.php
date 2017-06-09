<?php

namespace Wikia\PageHeader;

use \WikiaApp;

class Languages {

	public $currentLangName;
	public $languageList;

	private $title;
	private $shouldDisplay;

	/**
	 * Language constructor.
	 *
	 * @param WikiaApp $app
	 */
	public function __construct( WikiaApp $app ) {
		$this->title = \RequestContext::getMain()->getTitle();
		$this->currentLangName = \Language::getLanguageName( $this->title->getPageLanguage()->getCode() );
		$this->languageList = $this->handleLanguages( $app );

		$shouldDisplay = $this->title->isContentPage();
		wfRunHooks( 'PageHeaderLanguageSelectorShouldDisplay', [$this->title, &$shouldDisplay] );
		$this->shouldDisplay = $shouldDisplay;
	}

	/**
	 * @param WikiaApp $app
	 *
	 * @return array
	 */
	private function handleLanguages( WikiaApp $app ): array {
		$languageUrls = $app->getSkinTemplateObj()->data['language_urls'] ?: [];
		$languages = [];

		foreach ( $languageUrls as $key => $val ) {
			$languages[$key] = [
				'href' => $val['href'],
				'name' => $val['text'],
			];
		}

		ksort( $languages );

		return $languages;
	}

	public function isDisabled(): bool {
		return count( $this->languageList ) <= 0;
	}

	public function hasMoreLanguages(): bool {
		return count( $this->languageList ) > 0;
	}

	public function shouldDisplay(): bool {
		return $this->shouldDisplay;
	}
}
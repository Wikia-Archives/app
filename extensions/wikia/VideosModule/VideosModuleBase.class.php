<?php

namespace VideosModule;

use Wikia\Cache\AsyncCache;
use Wikia\Logger\WikiaLogger;

/**
 * Class VideosModuleBase
 */
abstract class Base extends \WikiaModel {

	const THUMBNAIL_WIDTH = 268;
	const THUMBNAIL_HEIGHT = 150;

	const CACHE_TTL = 43200; // 12 hours
	const NEGATIVE_CACHE_TTL = 300; // 5 minutes
	const CACHE_VERSION = 5;

	const LIMIT = 20;
	const SOURCE = '';
	const SORT = 'recent';

	// A label for the data source, used to construct cache keys and for logging
	protected $source = '';

	// The maximum number of videos to fetch
	protected $limit;

	// Black listed videos we never want to show in videos module
	protected $blacklist = [];

	// List of titles of existing videos (those which have been added already)
	protected $existingVideos = [];

	// A two character region code for getting region specific videos
	protected $userRegion;

	// How to sort video results (some modules)
	protected $sort = '';

	// Any categories to pull videos from (some modules)
	protected $categories = [];

	// The list of videos found
	protected $videos = [];

	// Options used when calling the getVideoDetail* methods in VideoHandlerHelper
	protected static $videoOptions = [
		'thumbWidth'   => self::THUMBNAIL_WIDTH,
		'thumbHeight'  => self::THUMBNAIL_HEIGHT,
		'getThumbnail' => true,
		'thumbOptions' => [
			'fluid'       => true,
			'forceSize'   => 'small',
		],
	];

	/**
	 * @param array $params Valid parameters are:
	 *
	 *   userRegion - A two character country code
	 *
	 * @throws MissingRequireParametersException
	 */
	public function __construct( array $params ) {
		parent::__construct();

		if ( empty( $params['userRegion'] ) ) {
			throw new MissingRequireParametersException( "Parameter 'userRegion' required" );
		}

		$this->initializeBlacklist();

		$this->userRegion = $params['userRegion'];
		$this->limit = static::LIMIT;
		$this->source = static::SOURCE;
		$this->sort = static::SORT;
	}

	/**
	 * Look for videos that are blacklisted in the wgVideosModuleBlackList variable on community central
	 */
	protected function initializeBlacklist() {
		$communityBlacklist = \WikiFactory::getVarByName( "wgVideosModuleBlackList", \WikiFactory::COMMUNITY_CENTRAL );

		if ( is_object( $communityBlacklist ) && !empty( $communityBlacklist->cv_value ) ) {
			$this->blacklist = unserialize( $communityBlacklist->cv_value );
		}
	}

	/**
	 * This is an entry point for the AsyncCache class to call the getModuleVideos method on a specific VideosModule
	 * class.
	 *
	 * @param string $class The class name to use to create a new VideosModule\Base object
	 * @param string $region The two character region code to pull videos for
	 * @param string $sort How to sort video results that are found
	 *
	 * @return array
	 */
	public static function getVideosCallback( $class, $region ) {
		/** @var Base $module */
		$module = new $class( [ 'userRegion' => $region ] );
		$videos = $module->getModuleVideos();
		return $videos;
	}

	/**
	 * Get a list of videos for the source defined by this class
	 *
	 * @return array
	 */
	public function getVideos() {
		$cacheKey = $this->getCacheKey();

		$asyncCache = $this->getCache();
		$asyncCache
			->key( $cacheKey )
			->ttl( self::CACHE_TTL )
			->negativeResponseTTL( self::NEGATIVE_CACHE_TTL )
			->callback( 'VideosModule\Base::getVideosCallback' )
			->callbackParams( [ get_class( $this ), $this->userRegion ] );

		if ( $asyncCache->foundInCache() ) {
			$this->logInfo( 'Cache HIT' );
		} else {
			$this->logInfo( 'Cache MISS' );
		}

		$videos = $asyncCache->value();

		if ( empty( $videos ) ) {
			$this->logInfo( 'Zero videos' );
			return [];
		} else {
			return $videos;
		}
	}

	/**
	 * This method should be overridden to return a unique key to use to cache videos found
	 *
	 * @return mixed
	 */
	protected function getCacheKey() {
		$cacheKey = wfSharedMemcKey(
			self::CACHE_VERSION,
			__CLASS__,
			$this->userRegion,
			$this->source
		);
		return $cacheKey;
	}

	/**
	 * Returns a caching client for this class
	 *
	 * @return AsyncCache
	 */
	public function getCache() {
		return new AsyncCache();
	}

	/**
	 * This method should be overridden to do the actual work of getting videos for the source of the implementing class
	 *
	 * @return mixed
	 */
	abstract public function getModuleVideos();

	/**
	 * Method to clear all caches related to this video module
	 *
	 * @return bool
	 */
	public function clearCache() {
		$cacheKey = $this->getCacheKey();
		$this->getCache()->purge( $cacheKey );
		return true;
	}

	/**
	 * Can be used by subclasses to clear the external video list (from the video wiki) if they require it
	 *
	 * @return bool
	 */
	protected function clearExternalVideoListCache() {
		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'clearVideoListCache',
			'sort'       => $this->sort,
			'limit'      => $this->getPaddedVideoLimit(),
			'category'   => $this->categories,
		];

		$response = \ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, \ApiService::WIKIA );
		return !empty( $response ) && $response['status'] == 'ok';
	}

	/**
	 * General logging method
	 * @param $message
	 */
	protected function logInfo( $message ) {
		$log = WikiaLogger::instance();
		$log->info( __METHOD__ . ' : ' . $message, $this->getLogParams() );
	}

	/**
	 * Parameters to send when logging
	 *
	 * @return array
	 */
	protected function getLogParams() {
		return [
			'method' => __METHOD__,
			'region' => $this->userRegion,
			'limit' => $this->limit,
			'source' => $this->source,
		];
	}

	/**
	 * Returns whether we've currently found enough videos given our current limit
	 *
	 * @return bool
	 */
	public function atVideoLimit() {
		return  count( $this->videos ) >= $this->limit;
	}

	/**
	 * Get video list from Video wiki
	 *
	 * @return array
	 */
	public function addVideosFromVideoWiki() {
		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'getVideoList',
			'sort'       => $this->sort,
			'limit'      => $this->getPaddedVideoLimit(),
			'category'   => $this->categories,
		];

		$response = \ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, \ApiService::WIKIA );
		$videosWithDetails = $this->getVideoDetailFromVideoWiki( $this->getVideoTitles( $response['videos'] ) );

		foreach ( $videosWithDetails as $video ) {
			if ( $this->atVideoLimit() ) {
				break;
			}
			$this->addVideo( $video );
		}
	}

	/**
	 * Return a list of just titles given a list of video details.
	 *
	 * @param array $videos An array of video details
	 * @return array
	 */
	protected function getVideoTitles( array $videos ) {
		$videoTitles = [];
		foreach ( $videos as $video ) {
			$videoTitles[] = $video['title'];
		}
		return $videoTitles;
	}

	/**
	 * Call 'VideoHandlerHelper::getVideoDetail' on the video wiki for each of a list of video titles.  Returns a list
	 * of video details for each title passed
	 *
	 * @param array $videos A list of video titles
	 * @return array
	 */
	public function getVideoDetailFromVideoWiki( $videos ) {
		$videoDetails = [];
		if ( !empty( $videos ) ) {
			$helper = new \VideoHandlerHelper();
			$videoDetails = $helper->getVideoDetailFromWiki(
				$this->wg->WikiaVideoRepoDBName,
				$videos,
				self::$videoOptions
			);
		}

		return $videoDetails;
	}

	/**
	 * Get the video details (things like videoId, provider, description, regional restrictions, etc)
	 * for video from the local wiki.
	 *
	 * @param array $videos A list of video titles
	 * @return array
	 */
	public function getVideoDetailFromLocalWiki( array $videos ) {
		$videoDetails = [];
		$helper = new \VideoHandlerHelper();
		foreach ( $videos as $video ) {
			$details = $helper->getVideoDetail( $video, self::$videoOptions );
			if ( !empty( $details ) ) {
				$videoDetails[] = $details;
			}
		}
		return $videoDetails;
	}

	/**
	 * Get video limit (include the number of blacklisted videos)
	 *
	 * @return integer
	 */
	protected function getPaddedVideoLimit( ) {
		$limit = $this->limit + count( $this->blacklist );

		return $limit;
	}

	/**
	 * Checks if a video can be added to the list of videos for this module.  If so, we add the source of that video
	 * to it's detail, as well as appending it to the list of existingVideos which includes all videos added from all
	 * lists. We use this existingVideos list to filter as we're adding videos to ensure we don't include duplicates.
	 *
	 * @param array $video Details for one video
	 * @return bool
	 */
	protected function addVideo( $video ) {
		if ( $this->canAddVideo( $video ) ) {
			$this->existingVideos[$video['title']] = true;
			$this->videos[] = $this->normalizeVideoDetail( $video );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Return whether the video can be added to the current list of videos being
	 * collected (eg, staffPicks, videosByCategory, wikiRelated).
	 *
	 * @param array $video Details of one video
	 * @return bool
	 */
	protected function canAddVideo( array $video ) {
		return !( $this->isRegionallyRestricted( $video )
			|| $this->isBlackListed( $video )
			|| $this->isAlreadyAdded( $video ) );
	}

	/**
	 * Return whether the video is regionally restricted in the user's country.
	 *
	 * @param array $video Details for a single video
	 * @return bool
	 */
	public function isRegionallyRestricted( array $video ) {
		return !empty( $video['regionalRestrictions'] )
			&& !empty( $this->userRegion )
			&& !preg_match( "/$this->userRegion/", $video['regionalRestrictions'] );
	}

	/**
	 * Return whether the video is blacklisted or not.
	 *
	 * @param array $video Details for a single video
	 * @return bool
	 */
	public function isBlackListed( array $video ) {
		return in_array( $video['title'], $this->blacklist );
	}

	/**
	 * Return whether a video has already been added to a list of videos
	 * to send out to the user (eg, staffPicks, videosByCategory, wikiRelated).
	 * Any video which we're going to send out we add to the existingVideos list.
	 *
	 * @param array $video
	 * @return bool
	 */
	protected function isAlreadyAdded( array $video ) {
		return array_key_exists( $video['title'], $this->existingVideos );
	}

	/**
	 * Normalize video details to a set of keys understood by this module
	 * @param array $video Details for a single video
	 * @return array
	 */
	protected function normalizeVideoDetail( array $video ) {
		return [
			'title'       => $video['fileTitle'],
			'url'         => $video['fileUrl'],
			'thumbnail'   => $video['thumbnail'],
			'thumbUrl'    => $video['thumbUrl'],
			'description' => wfShortenText( $video['description'], 50 ),
			'videoKey'    => $video['title'],
			'duration'    => $video['duration'],
			'source'      => $this->source,
		];
	}
}

class MissingRequireParametersException extends \Exception {}
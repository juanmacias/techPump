<?php

namespace techPump\Framework\Data;

use techPump\Config\Config;
use techPump\Domain\Chicas\Chica;
use techPump\Domain\Chicas\ChicasRepository;
use techPump\Framework\Http\HttpCache;

/**
 * Class Cache. Manage basic validations of system cache.
 *
 * @package Data
 */
class AppCache {

	private const CACHE_ID       = 'techpump_token';

	private const CACHE_PAGES_ID = 'techpump_pages_token';

	/**
	 * App_token is also time of last update in API.
	 *
	 * @var int
	 */
	private $app_token;
	private $expire_time;

	/**
	 * Cache constructor.
	 *
	 * @param int $token_cache
	 * @param int $expire_time
	 */
	public function __construct( int $token_cache, int $expire_time = Config::CACHE_EXPIRATION_TIME ) {
		$this->app_token   = $token_cache;
		$this->expire_time = $expire_time;

		if(0 === $this->app_token) {
			$this->app_token = $this->guessNewToken();
			$this->updateToken();
		}
	}

	/**
	 * Named constructor. Retrieve Cache using token generated from cache system.
	 *
	 * @return static
	 */
	public static function fromCacheSystem(): self {
		$token_cache = self::getCurrentToken();

		return new self( $token_cache );
	}

	/**
	 * Retrieve current token from cache system.
	 *
	 * @return int
	 */
	public static function getCurrentToken(): int {
		return intval( apcu_fetch( self::CACHE_ID ) );
	}

	/**
	 * Generate a new app token using last login of last logged chica.
	 *
	 * @return int
	 */
	private function guessNewToken(): int {
		$repository = new ChicasRepository();
		$last_chicas = $repository->getOutstandings();
		$chica = new Chica( $last_chicas[0], 1 );

		$last_update = $chica->get('LastLogin');

		return  \strtotime( $last_update );
	}

	/**
	 * Check if current token has expired
	 *
	 * @return bool
	 */
	public function isTokenExpired(): bool {
		return intval( $this->app_token ) + intval( $this->expire_time ) <= time();
	}

	/**
	 * Update token in cache system
	 */
	public function updateToken() {
		$this->app_token = $new_token = $this->generateNewToken();

		apcu_store( self::CACHE_ID, $new_token );
		apcu_store( self::CACHE_PAGES_ID, [] );
	}

	/**
	 * Generate a new token from last token. Guess when API was updated last time.
	 *
	 * @return int
	 */
	private function generateNewToken(): int {
		$last_token       = $this->app_token;
		$new_token        = $last_token;
		$token_is_expired = ( $new_token + $this->expire_time ) < time();

		while ( $token_is_expired ) {
			$new_token        = $last_token;
			$last_token       += $this->expire_time;
			$token_is_expired = $last_token < time();
		}

		return $new_token;
	}

	/**
	 * Generate a http cache from etag token of navigator.
	 *
	 * @param null $token_etag_from_navigator
	 *
	 * @return HttpCache
	 */
	public function getHttpCache( ?int $token_etag_from_navigator = null ): HttpCache {
		$token_etag_from_navigator ??= $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ?? '-1';

		return new HttpCache( $token_etag_from_navigator, $this->app_token );
	}
}
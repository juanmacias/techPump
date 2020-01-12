<?php

namespace techPump\Framework\Http;

/**
 * Class HttpCache. Cache based in HTTP
 *
 * @see     https://trasweb.net/webperf/optimizacion-web-con-etags
 *
 * @package Http
 */
class HttpCache {

	private $navigator_etag;
	private $app_token;

	public const  UNDEFINED_ETAG    = - 1;

	private const NOT_MODIFIED_CODE = 304;

	private const ETAG_HEADER       = 'ETag: %s';

	/**
	 * HttpCache constructor.
	 *
	 * @param int $current_etag
	 * @param int $expected_etag
	 */
	public function __construct( string $navigator_etag, string $expected_etag ) {
		$this->navigator_etag = $navigator_etag;
		$this->app_token      = $expected_etag;
	}

	/**
	 * Token navigator is expired if that token is different of current tag of app.
	 *
	 * @return bool
	 */
	public function isTokenExpired(): bool {
		return $this->navigator_etag !== $this->app_token;
	}

	/**
	 * Navigator can use its cache
	 *
	 * @return void
	 */
	public function useCache(): void {
		http_response_code( self::NOT_MODIFIED_CODE );
	}

	/**
	 * Send new etag token to navigator.
	 */
	public function sendNewToken(): void {
		$etag_header = sprintf( self::ETAG_HEADER, $this->app_token );
		header( $etag_header );
	}
}
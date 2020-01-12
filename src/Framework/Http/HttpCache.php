<?php

namespace techPump\Framework\Http;

/**
 * Class HttpCache. Cache based in HTTP
 *
 * @see https://trasweb.net/webperf/optimizacion-web-con-etags
 *
 * @package Http
 */
class HttpCache {
	private $navigator_etag;
	private $app_token;

	/**
	 * HttpCache constructor.
	 *
	 * @param int $current_etag
	 * @param int $expected_etag
	 */
	public function __construct(int $navigator_etag, int $expected_etag ) {
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
		http_response_code(304 );
	}

	/**
	 * Send new etag token to navigator.
	 */
	public function sendNewToken():void {
		header('ETag: ' . $this->app_token);
	}
}
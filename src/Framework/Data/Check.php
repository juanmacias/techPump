<?php

namespace techPump\Framework\Data;

/**
 * Class Check. Do validations in data.
 *
 * @package Data
 */
class Check {

	/**
	 * Check if a value is a valid domain.
	 *
	 * @param        $maybe_domain
	 * @param string $default
	 *
	 * @return string
	 */
	static public function domain( $maybe_domain, string $default = '' ): string {
		return self::key( $maybe_domain, $default, '\.\_\-' );
	}

	/**
	 * Check if a value is a valid alphameric
	 *
	 * @param mixed  $maybe_alphameric
	 * @param string $default
	 * @param string $others
	 *
	 * @return string
	 */
	static public function key( $maybe_alphameric, string $default = '', $others = '' ): string {
		if ( isset( $maybe_alphameric ) && preg_match( '/^[a-z0-9' . $others . ']+$/i', $maybe_alphameric ) ) {
			return $maybe_alphameric;
		}

		return $default;
	}

	/**
	 * Check if a value is a valid analytics code.
	 *
	 * @param mixed  $maybe_analytics_code Value to check.
	 * @param string $default
	 *
	 * @return string
	 */
	static public function analytics( $maybe_analytics_code, string $default = '' ): string {
		$maybe_analytics_code = self::key( $maybe_analytics_code, $default );

		if ( empty( $maybe_analytics_code ) ) {
			return $default;
		}

		$code = sscanf( $maybe_analytics_code, "UA-%d-%d" );
		if ( empty( $code[ 0 ] ) || !empty( $code[ 1 ] ) ) {
			return $default;
		}

		$code1_size = strlen( $code[ 0 ] );
		if ( $code1_size < 3 || $code1_size > 9 ) {
			return $default;
		}

		$code2_size = strlen( $code[ 1 ] );
		if ( $code2_size < 1 || $code2_size > 3 ) {
			return $default;
		}

		return $maybe_analytics_code;
	}

	/**
	 * Check if a value is a valid url.
	 *
	 * @param mixed  $url
	 * @param string $default
	 * @param int    $flags
	 *
	 * @return string
	 */
	static public function url( $url, $default = '', $flags = FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED ) {
		if ( isset( $url ) && filter_var( $url, FILTER_VALIDATE_URL, $flags ) !== false ) {
			return $url;
		}

		return $default;
	}
}
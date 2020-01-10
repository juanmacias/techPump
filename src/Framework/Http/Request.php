<?php

namespace techPump\Framework\Http;

/**
 * Class Request
 *
 * @package Http
 */
class Request {

	private $data;

	/**
	 * Request constructor.
	 *
	 * @param array<string, mixed> $request_data
	 */
	public function __construct( array $request_data ) {
		$this->data = $request_data;
	}

	/**
	 * Retrieve a request data according to field name
	 *
	 * @param string $field_name    Field of request.
	 * @param mixed  $default_value Default value when field name doesn't exist.
	 *
	 * @return mixed|string
	 */
	public function get( string $field_name, $default_value = '' ) {
		return $this->data[ $field_name ] ?? $default_value;
	}

	/**
	 * Retrieve site param from request.
	 *
	 * @return string
	 */
	public function getRequestedSite(): string {
		return $this->get( 'site', '-' );
	}

	/**
	 * Retrieve current page( useful in pagination mode ).
	 *
	 * @return int
	 */
	public function getCurrentNumPage(): int {
		$current_page = intval( $this->data[ 'page' ] ?? 0 );

		return $current_page ?: 1;
	}
}
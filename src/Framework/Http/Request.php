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
	 * @param string $field_name Field of request.
	 *
	 * @return mixed|string
	 */
	public function get( $field_name ) {
		return $this->data[ $field_name ]??'';
	}

	/**
	 * Retrieve current page( useful in pagination mode ).
	 *
	 * @return int
	 */
	public function get_current_num_page():int {
		$current_page = intval( $this->data[ 'page' ]??0 );

		return $current_page ?: 1;
	}
}
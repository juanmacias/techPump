<?php

namespace techPump\Framework\Http;

use techPump\Config\Config;

/**
 * Class Auth. Checking user using HTTP protocol
 *
 * @package Http
 */
class Auth {

	private $user_name;
	private $user_passwd;

	/**
	 * Auth constructor.
	 *
	 * @param string|null $sent_name
	 * @param string|null $sent_passwd
	 */
	public function __construct( ?string $sent_name = null, ?string $sent_passwd = null ) {
		$this->user_name   = $sent_name ?? $_SERVER[ 'PHP_AUTH_USER' ] ?? '';
		$this->user_passwd = $sent_passwd ?? $_SERVER[ 'PHP_AUTH_PW' ] ?? '';
	}

	/**
	 * Check if current Auth is valid using a valid username and a valid passwd.
	 *
	 * @param string|null $valid_user_name
	 * @param string|null $valid_user_passwd
	 *
	 * @return bool
	 */
	public function isUserLoggedIn( ?string $valid_user_name = null, ?string $valid_user_passwd = null ): bool {
		$valid_user_name   ??= Config::ADMIN_USER;
		$valid_user_passwd ??= Config::ADMIN_PASSWD;

		return trim( $this->user_name ) === $valid_user_name && trim( $this->user_passwd ) === $valid_user_passwd;
	}

	/**
	 * Request a user/passwd using HTTP.
	 *
	 * @return string
	 */
	public function requestLogin(): void {
		header( 'WWW-Authenticate: Basic techpump="TechPump"' );
		header( 'HTTP/1.0 401 Unauthorized' );
		echo 'Please, try again in order to can manage sites.';
		exit;
	}
}
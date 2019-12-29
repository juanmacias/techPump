<?php

namespace techPump\Loaders;

use techPump\Pages\Page;
use techPump\Pages\SitePage;

/**
 * Class Site. Front controller
 *
 * @link    https://en.wikipedia.org/wiki/Front_controller
 *
 * @package techPump\Loaders
 */
class Site {

	private $site_path;
	private $is_admin;

	private const SITE_CONF_FILE = '/.metadata/site.conf.php';
	private const SITE_PROTOCOL  = 'http://';

	public function __construct( string $site_path, bool $is_admin = false ) {
		$this->site_path = $site_path;
		$this->is_admin  = $is_admin;
	}

	/**
	 * Load site
	 *
	 * @param $array $custom_options Array with vars for page template
	 *
	 * @return void
	 */
	public function load( array $custom_options = [] ):void {
		$page = $this->get_current_page();

		$options = $custom_options + $this->get_site_options();

		$page->show( $options );
	}

	/**
	 * Helper: Retrieve current page.
	 *
	 * @return Page
	 */
	private function get_current_page():Page {
		return new SitePage();
	}

	/**
	 * Retrieve site options( like name, nats, ... )
	 *
	 * @return array
	 */
	public function get_site_options():array {
		$default_options = [];

		if ( $this->is_admin ) {
			return $default_options;
		}

		$absolute_site_config_file = $this->site_path . self::SITE_CONF_FILE;

		if ( ! \file_exists( $absolute_site_config_file ) ) {
			return $default_options;
		}

		$site_options = include ( $absolute_site_config_file ) ?: $default_options;

		$site_domain           = \basename( $this->site_path );
		$site_options[ 'url' ] = self::SITE_PROTOCOL . $site_domain;

		return $site_options;
	}
}
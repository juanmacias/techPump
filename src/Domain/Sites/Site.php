<?php

namespace techPump\Domain\Sites;

use techPump\Config\Config;
use techPump\Framework\Data\Check;

/**
 * Class Site. Entity class
 *
 * @package Sites
 */
class Site {

	protected const SITE_CONF_DIR = '/.metadata';
	protected const SITE_CONF_FILE = self::SITE_CONF_DIR.'/site.conf.php';

	protected const SITE_PROTOCOL  = 'http://';

	protected $name;
	protected $path;
	protected $domain;
	protected $nats;
	protected $nats_webcams;
	protected $analytics;

	/**
	 * Site constructor.
	 *
	 * @param array{name: string, path: string, domain: string, nats: string, nats_webcams: string, analytics: string} $site_options
	 */
	public function __construct( array $site_options ) {
		if ( empty( $site_options ) ) {
			return;
		}

		$this->setName( $site_options[ 'name' ] ?? '' );
		$this->setDomain( $site_options[ 'domain' ] ?? '' );
		$this->setPath( $site_options[ 'path' ] ?? '' );
		$this->setNats( $site_options[ 'nats' ] ?? '' );
		$this->setNatsWebcam( $site_options[ 'nats_webcams' ] ?? '' );
		$this->setAnalytics( $site_options[ 'analytics' ] ?? '' );

		if ( !$this->exists() ) {
			$this->reset();
		}
	}

	/**
	 * Reset site properties
	 *
	 * @return void
	 */
	protected function reset(): void {
		$this->name = $this->path = $this->domain = $this->nats = $this->nats_webcams = $this->analytics = '';
	}

	/**
	 * Setter of name
	 *
	 * @param string $name
	 */
	private function setName( string $name ): void {
		$this->name = Check::information( $name );
	}

	/**
	 * Setter of domain
	 *
	 * @param string $domain
	 */
	private function setDomain( string $domain ): void {
		$domain = str_replace( self::SITE_PROTOCOL, '', $domain );
		$domain = str_replace( 'wwww.', '', $domain );

		$this->domain = Check::domain( $domain );
	}

	/**
	 * Setter of path
	 *
	 * @param string $site_path
	 */
	protected function setPath( string $site_path ): void {
		if ( empty( $site_path ) ) {
			$site_path = Config::SITES_DIRECTORY . '/' . $this->domain;
		} else {
			$site_path = Check::key( $site_path, '', '\.\_\-\/' );
		}

		if ( !\file_exists( $site_path ) || !\is_dir( $site_path ) || !\file_exists( $site_path . self::SITE_CONF_FILE ) ) {
			$site_path = '';
		}

		$this->path = $site_path;
	}

	/**
	 * Setter of nats
	 *
	 * @param string $nats
	 */
	private function setNats( string $nats ) {
		$this->nats = Check::key( $nats );
	}

	/**
	 * Setter of nats_webcam
	 *
	 * @param string $nats
	 */
	private function setNatsWebcam( string $nats ) {
		$this->nats_webcams = Check::key( $nats );
	}

	/**
	 * Setter of analytics code
	 *
	 * @param string $analytics
	 */
	private function setAnalytics( string $analytics ) {
		$this->analytics = Check::analytics( $analytics );
	}

	/**
	 * Check if current site is valid( directory exists and also metada ).
	 *
	 * @return bool
	 */
	public function exists(): bool {
		return !empty( $this->name ) && !empty( $this->path ) && !empty( $this->domain ) && !empty( $this->nats ) && !empty( $this->nats_webcams ) && !empty( $this->analytics );
	}

	/**
	 * Retrieve absolute path to site config file
	 *
	 * @return string
	 */
	public function getFileConfigPath(): string {
		return $this->path . self::SITE_CONF_FILE;
	}

	/**
	 * Custom url getter in order to add current port.
	 * In docker port is 8080. In real life port is 80.
	 *
	 * @return string
	 */
	public function getUrl(): string {
		if ( empty( $this->domain ) ) {
			return '';
		}

		$url = self::SITE_PROTOCOL . $this->domain;

		$default_port = 80;
		$current_port = intval( $_SERVER[ 'SERVER_PORT' ] ?? $default_port );

		if ( $default_port === $current_port ) {
			return $url;
		}

		return $url . ':' . $current_port;
	}

	/**
	 * Retrieve value of a attribute
	 *
	 * @param string $field_name
	 *
	 * @return string
	 */
	public function get( string $field_name ): string {
		return $this->$field_name ?? '';
	}

	/**
	 * Retrieve attributes from site
	 *
	 * @return array{name: string, path: string, domain: string, nats: string, nats_webcams: string, analytics: string} $site_options
	 */
	public function export(): array {
		$vars = [];

		if( !$this->exists() ) {
			return $vars;
		}

		return  \get_object_vars( $this );
	}
}
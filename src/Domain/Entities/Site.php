<?php

namespace techPump\Domain\Entities;

/**
 * Class Site
 *
 * @package Entities
 */
final class Site {

	private const SITE_CONF_FILE = '/.metadata/site.conf.php';

	private const SITE_PROTOCOL  = 'http://';

	private $name;
	private $path;
	private $domain;
	private $url;
	private $nats;
	private $nats_webcams;
	private $analytics;

	/**
	 * Site constructor.
	 *
	 * @param array{name: string, path: string, domain: string, url: string, nats: string, NATS_webcams: string, analytics: string} $site_options
	 */
	public function __construct( array $site_options ) {
		if ( empty( $site_options ) ) {
			return;
		}

		$this->name         = $site_options[ 'name' ];
		$this->path         = $site_options[ 'path' ];
		$this->domain       = $site_options[ 'domain' ];
		$this->url          = $site_options[ 'url' ];
		$this->nats         = $site_options[ 'NATS' ];
		$this->nats_webcams = $site_options[ 'NATS_webcams' ];
		$this->analytics    = $site_options[ 'analytics' ];
	}

	/**
	 * Named constructor based on path of site.
	 *
	 * @param string $site_path
	 *
	 * @return self;
	 */
	static public function fromSitePath( string $site_path ): self {
		$default_options = [];

		$absolute_site_config_file = $site_path . self::SITE_CONF_FILE;

		if ( !\file_exists( $absolute_site_config_file ) ) {
			return self::getNoOpInstance();
		}

		$site_options = include ( $absolute_site_config_file ) ?: $default_options;

		$site_options[ 'path' ]   = $site_path;
		$site_options[ 'domain' ] = \basename( $site_path );
		$site_options[ 'url' ]    = self::SITE_PROTOCOL . $site_options[ 'domain' ];

		return new self( $site_options );
	}

	/**
	 * Named constructor. Retrieve a NoOp instance of this class.
	 *
	 * @see https://en.wikipedia.org/wiki/NOP_(code)
	 *
	 * @return static
	 */
	static public function getNoOpInstance(): self {
		return new self( [] );
	}

	/**
	 * Check if current site is valid( directory exists and also metada ).
	 *
	 * @return bool
	 */
	public function exists(): bool {
		return !empty( $this->path );
	}

	/**
	 * Custom url getter in order to add current port.
	 * In docker port is 8080. In real life port is 80.
	 *
	 * @return string
	 */
	public function getUrl(): string {
		$url = $this->url ?? '';

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
	public function get( string $field_name ) {
		return $this->$field_name ?? '';
	}

	/**
	 * Retrieve css file from site
	 *
	 * @return string
	 */
	public function getCss(): string {
		$default_css_code = '';

		if ( !$this->exists() ) {
			return $default_css_code;
		}

		$css_file = $this->path . '/css/estilos.css';

		if ( !\file_exists( $css_file ) ) {
			return $default_css_code;
		}

		return \file_get_contents( $css_file ) ?: $default_css_code;
	}
}
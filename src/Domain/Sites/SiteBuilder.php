<?php

namespace techPump\Domain\Sites;

use techPump\Config\Config;
use techPump\Framework\Data\Check;

/**
 * Class SiteBuilder. A builder of site using builder pattern.
 *
 * @see     https://en.wikipedia.org/wiki/Builder_pattern
 *
 * @package Sites
 */
class SiteBuilder extends Site {

	private $notices = [];

	/**
	 * Named constructor based on path of site.
	 *
	 * @param string $site_path
	 *
	 * @return Site;
	 */
	public static function fromSitePath( string $site_path ): Site {
		$default_options = [];

		$site_path = Check::key( $site_path, '-', '\.\_\-\/' );

		$absolute_site_config_file = $site_path . Site::SITE_CONF_FILE;

		if ( !\file_exists( $absolute_site_config_file ) ) {
			return self::getNoOpInstance();
		}

		$site_options = include ( $absolute_site_config_file ) ?: $default_options;

		$site_options[ 'path' ]   = $site_path;
		$site_options[ 'domain' ] = \basename( $site_path );

		return new Site( $site_options );
	}

	/**
	 * Named constructor. Retrieve a NoOp instance of this class.
	 *
	 * @see https://en.wikipedia.org/wiki/NOP_(code)
	 *
	 * @return Site
	 */
	static public function getNoOpInstance(): Site {
		return new Site( [] );
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

		if ( \file_exists( $site_path ) && !\is_dir( $site_path ) ) {
			$this->addNotice( 'directory exists but it\'s not valid' );

			return;
		}

		$this->path = $site_path;
	}

	/**
	 * Add a notice to stack.
	 *
	 * @param string $msg
	 * @param string $type
	 *
	 * @return bool Retrieve false with an error, otherwise true
	 */
	private function addNotice( string $msg, $type = 'error' ): bool {
		$this->notices          ??= [];
		$this->notices[ 'msg' ] ??= [];

		$this->notices[ $type ]   = true;
		$this->notices[ 'msg' ][] = $msg;

		return 'error' !== $type;
	}

	/***
	 * Retrieve generated notices
	 */
	public function getNotices(): array {
		return $this->notices;
	}

	/**
	 * Create a site according site data
	 *
	 * @return Site
	 */
	public function create(): Site {
		if ( !$this->createSiteBase() ) {
			return self::getNoOpInstance();
		}

		$site = new Site( $this->export() );

		//Save data
		 ( new SitesStore() )->update( $site );

		 return $site;
	}

	/**
	 * Create structure base of site.
	 *
	 * @return bool
	 */
	private function createSiteBase(): bool {
		if ( !$this->exists() ) {
			return $this->addNotice( 'Not valid data' );
		}

		if ( !$this->createSiteDir() ) {
			return $this->addNotice( 'Directory cannot be created. Talk with administrator' );
		}

		if ( !$this->createMetadataDir() ) {
			return $this->addNotice( 'Metadata directory cannot be created. Talk with administrator' );
		}

		if ( !$this->createPlaceholderConfigfile() ) {
			return $this->addNotice( 'Config file cannot be created. Talk with administrator' );
		}


		if ( !$this->createFronControllerIndex() ) {
			return $this->addNotice( 'index.php file cannot be created. Talk with administrator' );
		}
		
		return $this->addNotice( 'Please, add domain to /server/conf/dns/etc_hosts and add css to '.$this->path.'. Thanks', 'successful');
	}

	/**
	 * Create site directory
	 *
	 * @return bool
	 */
	private function createSiteDir(): bool {
		if ( \file_exists( $this->path ) ) {
			return \is_dir( $this->path );
		}

		return mkdir( $this->path, $mode = 0777, $recursive = true );
	}

	/**
	 * Create Metadata directory
	 *
	 * @return bool
	 */
	private function createMetadataDir(): bool {
		$metadata_dir = $this->path . self::SITE_CONF_DIR;

		if ( \file_exists( $metadata_dir ) ) {
			return \is_dir( $metadata_dir );
		}

		return mkdir( $metadata_dir, $mode = 0777, $recursive = true );
	}


	/**
	 * Create a placeholder config file.
	 *
	 * @return bool
	 */
	private function createPlaceholderConfigfile(): bool {
		if ( \file_exists( $this->getFileConfigPath() ) ) {
			return !\is_dir( $this->getFileConfigPath() );
		}

		return touch( $this->getFileConfigPath() );
	}

	/**
	 * Create a front controller index for site.
	 *
	 * @return bool
	 */
	private function createFronControllerIndex():bool {
		$index_file = $this->path . '/index.php';

		if ( \file_exists( $index_file ) ) {
			return !\is_dir( $index_file );
		}

		$index_content =<<<'INDEX'
<?php

define( '__TECH_PUMP_SITE__', basename( __DIR__ ) );

include __DIR__ . '/../bootstrap.php';
INDEX;

		return \file_put_contents( $index_file, $index_content );
	}
}
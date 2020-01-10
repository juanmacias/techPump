<?php

namespace techPump\Domain\Repositories;

use techPump\Config\Config;
use techPump\Domain\Collections\Sites;
use techPump\Domain\Entities\Site;
use techPump\Framework\Data\Check;

/**
 * Class SitesStore. Manage store of sites.
 *
 * @package Repositories
 */
class SitesStore {

	private const STORE_PATH = Config::SITES_DIRECTORY;

	/**
	 * Simple Factory. Retrieve all Repositories in a collecion
	 *
	 * @return Sites
	 */
	public function getAll(): Sites {
		return Sites::fromPathAndEntity( self::STORE_PATH, Site::class );
	}

	/**
	 * Simple Factory. Retrieve a site according to domain
	 *
	 * @param string $site_domain
	 *
	 * @return Site
	 */
	public function getSite( string $site_domain ): Site {
		$site_domain = Check::domain( $site_domain, '-' );

		return Site::fromSitePath( self::STORE_PATH . '/' . $site_domain );
	}
}
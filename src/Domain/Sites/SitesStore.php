<?php

namespace techPump\Domain\Sites;

use techPump\Config\Config;

/**
 * Class SitesStore. Manage store of sites.
 *
 * @package Sites
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
		return SiteBuilder::fromSitePath( self::STORE_PATH . '/' . $site_domain );
	}

	/**
	 * Update metadata form Site.
	 *
	 * @param Site $site
	 */
	public function update( Site $site ): bool {
		if ( !$site->exists() ) {
			return false;
		}

		$site_data = $this->generateMetadata( $site );
		$site_metadata_file    = $site->getFileConfigPath();
		$site_metadata_content = $this->generateMetadataContent( $site_data );

		return \file_put_contents( $site_metadata_file, $site_metadata_content );
	}

	/**
	 * Retrieve site data useful for saving.
	 *
	 * @param Site $site
	 *
	 * @return array
	 */
	protected function generateMetadata(Site $site): array {
		$site_data = $site->export();

		//Remove unnecessary data
		unset($site_data['path']);
		unset($site_data['domain']);

		return $site_data;
	}

	/**
	 * Generate new metadata file content
	 *
	 * @param array $site_data <string, string> New data to metadata
	 *
	 * @return string
	 */
	protected function generateMetadataContent( array $site_data ) {
		$content_file_template = "<?php\n\nreturn %s;";

		return \sprintf( $content_file_template, \var_export( $site_data, true ) );
	}
}
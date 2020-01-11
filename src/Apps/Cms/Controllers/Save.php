<?php

namespace techPump\Apps\Cms\Controllers;

use techPump\Apps\Cms\Pages\AdminPage;
use techPump\Domain\Sites\Site;
use techPump\Domain\Sites\SiteBuilder;
use techPump\Domain\Sites\SitesStore;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\Page;

/**
 * Class Save. This save data from site form.
 *
 * @package techPump\Apps\Cms\Controllers
 */
class Save extends Controller {
	final public function getPage( ):Page {

		$site_form_data = $this->request->get( 'site_form' );

		//No need a service here( not more overengineering )
		$notices = [];
		if( $this->site->exists() ) {
			$site = new Site( $site_form_data );
			$updated = ( new SitesStore() )->update( $site );
			$type = $updated?  'succesfull' : 'error';
			$notices[$type] = true;

			if('error' === $type){
				$notices['msg'][] = "You don't have permissions in config file";
			}
		}else {
			$site_builder = new SiteBuilder( $site_form_data  );
			$site = $site_builder->create();
			$notices = $site_builder->getNotices();
		}

		$site_form = new AdminPage( $this->templates_path );
		$site_form->setMainPage( 'sites/save');
		$site_form->addVar( 'site', $site );
		$site_form->addVar( 'notices', $notices );
		$site_form->loadAssetsForForm();

		return $site_form;
	}
}
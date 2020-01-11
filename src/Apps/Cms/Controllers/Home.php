<?php

namespace techPump\Apps\Cms\Controllers;

use techPump\Apps\Cms\Pages\AdminPage;
use techPump\Domain\Sites\SitesStore;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\Page;

/**
 * Class Home. List of sites.
 *
 * @package techPump\Apps\Cms\Controllers
 */
class Home extends Controller {

	final public function getPage(): Page {
		$home_page = new AdminPage( $this->templates_path );
		$home_page->setMainPage( 'sites/list' );
		$home_page->loadAssetsForList();
		$home_page->addVar( 'sites', ( new SitesStore() )->getAll() );

		return $home_page;
	}
}
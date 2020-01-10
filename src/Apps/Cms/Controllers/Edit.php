<?php

namespace techPump\Apps\Cms\Controllers;

use techPump\Apps\Cms\Pages\AdminPage;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\Page;

/**
 * Class Edit. Edit form of sites
 *
 * @package techPump\Apps\Cms\Controllers
 */
class Edit extends Controller {

	final public function get_page( ):Page {
		$site_form = new AdminPage( $this->templates_path );
		$site_form->setMainPage( 'sites/form');
		$site_form->addVar( 'site', $this->site );
		$site_form->loadAssetsForForm();

		return $site_form;
	}
}
<?php

namespace techPump\Apps\Cms\Controllers;

use techPump\Apps\Cms\Pages\AdminPage;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\Page;

/**
 * Class Add. Add form of sites
 *
 * @package techPump\Apps\Cms\Controllers
 */
class Add extends Controller {

	final public function getPage( ):Page {
		$site_form = new AdminPage( $this->templates_path );
		$site_form->setMainPage( 'sites/form');
		$site_form->addVar( 'site', $this->site );
		$site_form->loadAssetsForForm();

		return $site_form;
	}
}
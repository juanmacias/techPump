<?php

namespace techPump\Apps\Sites\Controllers;

use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\AppPage;
use techPump\Framework\Pages\Page;

class Home extends Controller {

	final public function get_page(): Page {
		$home_page = new AppPage( $this->templates_path );
		$home_page->addVar( 'site', $this->site );

		return $home_page;
	}
}
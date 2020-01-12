<?php

namespace techPump\Apps\Sites\Controllers;

use techPump\Domain\Chicas\ChicasRepository;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Pages\AppPage;
use techPump\Framework\Pages\Page;

class Home extends Controller {

	final public function getPage(): Page {
		$page = (int)$this->request->getCurrentNumPage();

		$chicas_store = new ChicasRepository($page);
		$chicas_list = $chicas_store->getAll(  );

		$home_page = new AppPage( $this->templates_path );
		$home_page->addVar( 'site', $this->site );
		$home_page->addVar( 'chicas_list', $chicas_list );
		$home_page->addVar( 'page', $page );

		return $home_page;
	}
}
<?php

namespace techPump\Apps\Sites\Controllers;

use techPump\Domain\Chicas\ChicasRepository;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Data\AppCache;
use techPump\Framework\Http\HttpCache;
use techPump\Framework\Pages\AppPage;
use techPump\Framework\Pages\Page;

class Home extends Controller {

	final public function getPage(): Page {
		$page = (int) $this->request->getCurrentNumPage();

		$cache = AppCache::fromCacheSystem();

		if ( $cache->isTokenExpired() ) {
			$cache->updateToken();
		}

		$this->checkCacheHttp( $cache->getHttpCache( $this->request ) );

		$chicas_store = new ChicasRepository( $page );
		$chicas_list  = $chicas_store->getAll();

		$home_page = new AppPage( $this->templates_path );
		$home_page->addVar( 'site', $this->site );
		$home_page->addVar( 'chicas_list', $chicas_list );
		$home_page->addVar( 'page', $page );

		return $home_page;
	}

	/**
	 * Helper:Check HTTP Cache.
	 *
	 * @param HttpCache $cache_http
	 */
	private function checkCacheHttp( HttpCache $cache_http ) {
		if ( !$cache_http->isTokenExpired() ) {
			$cache_http->useCache();
			die();
		}

		$cache_http->sendNewToken();
	}
}
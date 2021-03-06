<?php

namespace techPump\Apps\Sites\Controllers;

use techPump\Domain\Chicas\ChicasRepository;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Data\AppCache;
use techPump\Framework\Http\HttpCache;
use techPump\Framework\Pages\AppPage;
use techPump\Framework\Pages\Page;
use techPump\Framework\Pages\TemplateCache;

class Home extends Controller {

	final public function getPage(): Page {
		$page = $this->request->getCurrentNumPage();

		$cached_template_file = $this->templates_path . '/cached_main/page_' . $page . '.php';

		$this->checkCaches( $cached_template_file);

		$home_page = new AppPage( $this->templates_path );
		$home_page->setMainPage( $cached_template_file );
		$home_page->addVar( 'site', $this->site );
		$home_page->addVar( 'page', $page );

		return $home_page;
	}

	/**
	 * Helper: Check if any cache related to cache_template_file( or current page ) can be used .
	 *
	 * @param string $cached_template_file
	 */
	private function checkCaches(string $cached_template_file) {
		$cache = AppCache::fromCacheSystem();

		if ( $cache->isTokenExpired() ) {
			$cache->updateToken();
		}

		$this->checkIfHttpCacheCanBeUsed( $cache->getHttpCache( $this->request ) );

		$this->checkIfTemplateCacheNeedBeGenerated($cache->getTemplateCache( $cached_template_file ) );

		return ;
	}

	/**
	 * Helper: Check HTTP Cache.
	 *
	 * This cache is only for current site.
	 *
	 * @param HttpCache $cache_http
	 */
	private function checkIfHttpCacheCanBeUsed( HttpCache $cache_http ) {
		if ( !$cache_http->isTokenExpired() ) {
			$cache_http->useCache();
			die();
		}

		$cache_http->sendNewToken();
	}

	/**
	 * Check if a template cached can be generated.
	 *
	 * This cache is only for all site.
	 *
	 * @param TemplateCache $cached_template
	 */
	private function checkIfTemplateCacheNeedBeGenerated( TemplateCache $cached_template ) {
		if ( !$cached_template->isCacheExpired() ) {
			return ;
		}

		$chicas_store = new ChicasRepository( $this->request->getCurrentNumPage() );

		$chicas_list  = $chicas_store->getAll();

		$cached_template->generate( $this->templates_path . '/base/main.php', [ 'chicas_list' => $chicas_list ] );
	}

}
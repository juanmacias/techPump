<?php

return [
	/**
	 * Framework
	 */
	\techPump\Config\Config::class,
	\techPump\Framework\Pages\Page::class,
	\techPump\Framework\Pages\AppPage::class,
	\techPump\Framework\Controllers\Controller::class,
	\techPump\Framework\Loaders\Route::class,
	\techPump\Framework\Http\Request::class,
	\techPump\Framework\Http\Auth::class,
	\techPump\Framework\Data\Check::class,

	/**
	 * Domain. Site module.
	 */
	\techPump\Domain\Sites\Site::class,
	\techPump\Domain\Sites\Sites::class,
	\techPump\Domain\Sites\SitesStore::class,
	\techPump\Domain\Sites\SiteBuilder::class,

	/**
	 * Sites
	 */
	\techPump\Apps\Sites\App::class,
	\techPump\Apps\Sites\Controllers\Home::class,

	/**
	 * Cms
	 */
	\techPump\Apps\Cms\App::class,
	\techPump\Apps\Cms\Controllers\Home::class,
	\techPump\Apps\Cms\Controllers\Edit::class,
	\techPump\Apps\Cms\Controllers\Add::class,
	\techPump\Apps\Cms\Controllers\Save::class,
	\techPump\Apps\Cms\Pages\AdminPage::class,
];
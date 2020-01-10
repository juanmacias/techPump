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
	 * Domain
	 */
	\techPump\Domain\Entities\Site::class,
	\techPump\Domain\Collections\Sites::class,
	\techPump\Domain\Repositories\SitesStore::class,

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
	\techPump\Apps\Cms\Pages\AdminPage::class,
];
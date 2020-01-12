<?php
/**
 * Bootstrap and front controller script
 */

namespace techPump\Apps\Sites;

use techPump\Domain\Sites\SitesStore;
use techPump\Framework\Http\Request;
use techPump\Framework\Loaders\Route;

if ( !defined( '__TECH_PUMP_SITE__' ) ) {
	die( "Hello, World!" );
}

$site    = ( new SitesStore() )->getSite( __TECH_PUMP_SITE__ );
$request = new Request( $_REQUEST, $_SERVER ?: $_ENV );

$route      = new Route( App::NAMESPACE, $request, $site );
$controller = $route->getController();

$page = $controller->getPage();
$page->show();
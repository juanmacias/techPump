<?php
/**
 * Front controller script
 */

namespace techPump\Apps\Cms;

use techPump\Domain\Sites\SitesStore;
use techPump\Framework\Http\Auth;
use techPump\Framework\Http\Request;
use techPump\Framework\Loaders\Route;

$user = new Auth();
if ( !$user->isUserLoggedIn() ) {
	$user->requestLogin();
}

$request = new Request( $_REQUEST );
$site    = ( new SitesStore() )->getSite( $request->getRequestedSite() );

$route      = new Route( App::NAMESPACE, $request, $site );
$controller = $route->getController();

$page = $controller->getPage();
$page->show();
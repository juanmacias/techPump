<?php
/**
 * Bootstrap and front controller script
 */
namespace techPump\Apps\Site;

if( !defined('__TECH_PUMP_SITE__' )) {
	die("Hello, World!");
}

use techPump\Framework\Loaders\Site;

( new Site( __TECH_PUMP_SITE__ ) )->load();
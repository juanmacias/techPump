<?php

define('__TECHPUMP__', dirname(__DIR__ ) );

/**
 * This script preloads classes of framework in order to improve performance and avoid to have to use autoload
 */
use techPump\Framework\Loaders\ClassPreloader;

//avoid double execution
if ( class_exists( ClassPreloader::class ) ) {
	return;
}

require __DIR__ . '/Loaders/Preloader.php';

$classes_list = [
	\techPump\Framework\Loaders\Site::class,
	\techPump\Framework\Pages\Page::class,
	\techPump\Framework\Pages\SitePage::class,
];

$preloader = new ClassPreloader(  __TECHPUMP__ );
$preloader->load( $classes_list );
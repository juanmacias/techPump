<?php

/**
 * This script preloads classes of framework in order to improve performance and avoid to have to use autoload
 */
use techPump\Loaders\ClassPreloader;

//avoid double execution
if ( class_exists( ClassPreloader::class ) ) {
	return;
}

require __DIR__ . '/Loaders/Preloader.php';

$classes_list = [
	'\techPump\Pages\Page',
	'\techPump\Pages\SitePage',
];

$preloader = new ClassPreloader( __DIR__ );
$preloader->load( $classes_list );
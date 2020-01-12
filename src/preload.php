<?php
/**
 * This script preloads classes of framework in order to improve performance and avoid to have to use autoload
 */

use techPump\Framework\Loaders\ClassPreloader;

//avoid double execution
if ( class_exists( ClassPreloader::class ) ) {
	return;
}

require __DIR__ . '/Framework/Loaders/Preloader.php';
$preloader = new ClassPreloader( __DIR__ );

$classes_to_preload = include __DIR__ . '/Config/classes_to_preload.php';
$preloader->load( $classes_to_preload );

//preload site bootstraps
opcache_compile_file( __DIR__.'/../public/sites/bootstrap.php' );
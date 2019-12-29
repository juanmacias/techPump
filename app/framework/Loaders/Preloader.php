<?php

namespace techPump\Loaders;

/**
 * Class ClassPreloader. Preload classes for PHP 7.4
 *
 * @link    https://wiki.php.net/rfc/preload
 *
 * @package Performance
 */
class ClassPreloader {

	protected $base_dir;

	private const VENDOR_PREFIX = '\techPump';

	/**
	 * Preloader constructor.
	 *
	 * @param string $base_dir Absolute path base of all classes
	 */
	public function __construct( string $base_dir ) {
		$this->base_dir = $base_dir;
	}

	/**
	 * Preloading array of classes
	 *
	 * @param $class_list
	 *
	 * @return void
	 */
	public function load( array $classes_list ) {
		foreach ( $classes_list as $class_name ) {
			if ( \class_exists( $class_name ) ) {
				continue;
			}

			$class_file = $this->transformClassNameToFileName( $class_name );
			$this->loadClass( $class_file );
		}
	}

	/**
	 * Helper transform a class name to absolute class file
	 *
	 * @param string $class_name
	 *
	 * @return string
	 */
	private function transformClassNameToFileName( string $class_name ):string {
		$class_name_with_vendor = str_replace( self::VENDOR_PREFIX, '', $class_name );
		$class_file             = str_replace( '\\', '/', $class_name_with_vendor );

		return $this->base_dir . $class_file . '.php';
	}

	/**
	 * Helper: opcache a class
	 *
	 * @param string $class_file
	 *
	 * @return bool
	 */
	private function loadClass( string $class_file ):bool {
		$is_opcached_class = \function_exists( 'opcache_compile_file' ) && opcache_compile_file( $class_file );
		if ( $is_opcached_class ) {
			error_log( "Preloaded: {$class_file}" );
		} else {
			error_log( "Not preloaded: {$class_file}" );

			//Force load
			require_once( $class_file );
		}

		return $is_opcached_class;
	}
}

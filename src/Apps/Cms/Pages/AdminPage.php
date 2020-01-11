<?php

namespace techPump\Apps\Cms\Pages;

use techPump\Framework\Pages\AppPage;

class AdminPage extends AppPage {
	private const PLUGINS_PATH = '/plugins/';

	/**
	 * Load commons css files
	 *
	 * @return void
	 */
	private function loadCss(): void {
		//Font Awesome
		$this->addCss( self::PLUGINS_PATH.'fontawesome-free/css/all.min.css');
		//Ionicons
		$this->addCss( 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
		//overlayScrollbars
		$this->addCss( '/css/adminlte.min.css');
		//Google Font: Source Sans Pro
		$this->addCss('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
	}

	/**
	 * Load commons js files
	 *
	 * @return void
	 */
	private function loadJs(): void {
		//jQuery
		$this->addJs( self::PLUGINS_PATH.'jquery/jquery.min.js' );
		//Bootstrap 4
		$this->addJs( self::PLUGINS_PATH.'bootstrap/js/bootstrap.bundle.min.js' );
		//AdminLTE App
		$this->addJs( '/js/adminlte.min.js' );
	}


	/**
	 * Common task in page
	 *
	 * @return void
	 */
	protected function commons(): void {
		$this->loadCss();
		$this->loadJs();
	}

	/**
	 * Commons assets for list pages.
	 *
	 * @return void
	 */
	public function loadAssetsForList(): void {
		$this->addCss( self::PLUGINS_PATH.'datatables-bs4/css/dataTables.bootstrap4.css' );

		$this->addJs( self::PLUGINS_PATH.'datatables/jquery.dataTables.js' );
		$this->addJs( self::PLUGINS_PATH.'datatables-bs4/js/dataTables.bootstrap4.js' );
		$this->addJs( '/js/list.js');
	}

	/**
	 * Commons assets for list pages.
	 *
	 * @return void
	 */
	public function loadAssetsForForm(): void {

	}
}
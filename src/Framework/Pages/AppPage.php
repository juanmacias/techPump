<?php

namespace techPump\Framework\Pages;

use techPump\Config\Config;

/**
 * Class AppPage. A template page.
 *
 * @package Pages
 */
class AppPage extends Page {

	public const TOP_ASSET    = 'top';
	public const BOTTOM_ASSET = 'bottom';

	private $main_page_file;

	/**
	 * Return head tag in html site.
	 *
	 * @return string
	 */
	protected function head(): string {
		$template_file = $this->getTemplateAbsolutePath( 'head' );

		return $this->render( $template_file );
	}

	/**
	 * Return top of webpage.
	 *
	 * @return string
	 */
	protected function top(): string {
		$template_file = $this->getTemplateAbsolutePath( 'top' );

		return $this->render( $template_file );
	}

	/**
	 * Return main of webpage. Default is 404 page.
	 *
	 * @return string
	 */
	protected function main(): string {
		$template_file = $this->main_page_file ?? $this->get_default_main_template();

		return $this->render( $template_file );
	}

	/**
	 * Return boottom of webpage.
	 *
	 * @return string
	 */
	protected function bottom(): string {
		$template_file = $this->getTemplateAbsolutePath( 'bottom' );

		return $this->render( $template_file );
	}

	/**
	 * Set a page main template. Normally where content is showed
	 *
	 * @param string $main_page_file
	 *
	 * @return void
	 */
	public function setMainPage( string $main_page_file ) {
		if ( !isset( $main_page_file ) || '' === $main_page_file ) {
			$main_page_file = $this->get_default_main_template();
		}

		$has_absolute_path = '/' === $main_page_file[ 0 ];

		if ( !$has_absolute_path ) {
			$main_page_file = $this->getTemplateAbsolutePath( $main_page_file );
		}

		$this->main_page_file = $main_page_file;
	}

	/**
	 * Retrieve el main template of page.
	 *
	 * @return string
	 */
	private function get_default_main_template() {
		return $this->getTemplateAbsolutePath( 'main' );
	}

	/**
	 * Add a asset of type css to page.
	 *
	 * @param string $css_file Url to css file. Better if it is a url path.
	 * @param string $position top or bottom. For performance it't recommendable in top.
	 *
	 * @return void
	 */
	public function addCss( string $css_file, $position = self::TOP_ASSET ): void {
		$this->vars[ 'css_files' ]              ??= [];
		$this->vars[ 'css_files' ][ $position ] ??= [];

		$this->vars[ 'css_files' ][ $position ][] = $css_file;
	}

	/**
	 * Add a asset of type javascript to page.
	 *
	 * @param string $js_file  Url to js file. Better if it is a url path.
	 * @param string $position top or bottom. For performance it't recommendable in bottom.
	 *
	 * @return void
	 */
	public function addJs( string $js_file, $position = self::BOTTOM_ASSET ): void {
		$this->vars[ 'js_files' ]              ??= [];
		$this->vars[ 'js_files' ][ $position ] ??= [];

		$this->vars[ 'js_files' ][ $position ][] = $js_file;
	}

	/**
	 * Retrieve a suburl from cdn url
	 *
	 * @param string $sub_url
	 *
	 * @return string
	 */
	public function getCdnUrl(string $sub_url = ''): string {
		return sprintf(Config::CDN_URL, $sub_url );
	}
}
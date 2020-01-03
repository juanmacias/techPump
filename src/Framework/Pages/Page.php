<?php

namespace techPump\Framework\Pages;

/**
 * Class Page. Abstract class using Template pattern.
 *
 * @link    https://es.wikipedia.org/wiki/Patr%C3%B3n_de_m%C3%A9todo_de_la_plantilla
 *
 * @package Pages
 */
abstract class Page {

	protected $templates_path;
	protected $vars = [];

	protected const PARTS = [
		'head',
		'top',
		'main',
		'bottom',
	];

	/**
	 * Page constructor.
	 *
	 * @param string $templates_path Absolute path to templates
	 */
	public function __construct( string $templates_path ) {
		$this->templates_path = $templates_path;

		$this->commons();
	}

	/**
	 * Return head tag in html site.
	 *
	 * @return string
	 */
	abstract protected function head(): string;

	/**
	 * Return top of webpage.
	 *
	 * @return string
	 */
	abstract protected function top(): string;

	/**
	 * Return main of webpage.
	 *
	 * @return string
	 */
	abstract protected function main(): string;

	/**
	 * Return boottom of webpage.
	 *
	 * @return string
	 */
	abstract protected function bottom(): string;

	/**
	 * Commons tasks after page is created but before page is displayed .
	 *
	 * @return void
	 */
	protected function commons(): void {
		return;
	}

	/**
	 * Commons task after page is displayed.
	 *
	 * @return void
	 */
	protected function down(): void {
		return;
	}

	/**
	 * Show a page
	 *
	 * @param array vars Vars which can be used in templates
	 *
	 * @return void
	 */
	final public function show( array $vars = [] ): void {
		$this->vars = $vars + $this->vars;

		foreach ( self::PARTS as $part ) {
			echo $this->$part();
			\flush();
		}

		$this->down();
	}

	/**
	 * Helper: Render a site file
	 *
	 * @param string $template Path to site file.
	 *
	 * @return string Output of render.
	 */
	final protected function render( string $template_file ): string {
		if ( !\file_exists( $template_file ) ) {
			error_log( "Not found template file: {$template_file}" );

			return '';
		}

		\ob_start();
		include( $template_file );

		$template_content = \ob_get_clean() ?: '';

		return $template_content;
	}

	/**
	 * Helper: Return absolute path to a template file.
	 *
	 * @param string $template_file Template file with path from template directory.
	 *
	 * @return string Absolute path from root of filesystem.
	 */
	final protected function getTemplateAbsolutePath( string $template_file ): string {
		$template_file = ltrim( $template_file, '/' );
		$template_file = str_replace( '.php', '', $template_file ) . '.php';

		$template = $this->templates_path . '/' . $template_file;

		return $template;
	}

	/**
	 * Add a variable in order to can be used in pages
	 *
	 * @param string $var_name
	 * @param mixed  $var_value
	 */
	final public function addVar( string $var_name, $var_value ): void {
		$this->vars[ $var_name ] = $var_value;
	}

	/**
	 * Magic method
	 *
	 * @param string $var_name
	 *
	 * @return string
	 */
	final public function __get( string $var_name ) {
		return $this->vars[ $var_name ] ?? '';
	}
}
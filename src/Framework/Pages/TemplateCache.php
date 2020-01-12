<?php

namespace techPump\Framework\Pages;

/**
 * Class TemplateCache. Create cache of a template.
 *
 * @package Pages
 */
class TemplateCache {

	private   $template;
	private   $last_update_time_in_api;
	protected $vars = [];

	const LINE_BREAKS = '/[\n\r]/';
	const COMMENTS = '/<!--\s.*?-->/';
	const MORE_THAN_TWO_WHITE_SPACES = '/\s{2,}/s';
	const WHITE_SPACE = ' ';

	/**
	 * TemplateCache constructor.
	 *
	 * @param string $template                Absolute path of template to be cached.
	 *
	 * @param int    $last_update_time_in_API Last time of update of API.
	 */
	public function __construct( string $template, int $last_update_time_in_API ) {
		$this->template                = $template;
		$this->last_update_time_in_api = $last_update_time_in_API;
	}

	/**
	 * Retrieve if template cache must be refreshed.
	 *
	 * @return bool
	 */
	public function isCacheExpired(): bool {
		if ( !\file_exists( $this->template ) ) {
			return true;
		}

		$mtime = \filemtime( $this->template );

		return $mtime >= $this->last_update_time_in_api;
	}

	/**
	 * Generate a new template cached and later save it in cache.
	 *
	 * @param string $base_template
	 * @param array  $vars
	 *
	 * @return bool
	 */
	public function generate( string $base_template, array $vars = [] ): bool {
		$this->vars = $vars;

		$template_content = $this->getTemplateContent( $base_template );

		return \file_put_contents( $this->template, $template_content ) ?: false;
	}

	/**
	 * Helper: Generate template contend to cached.
	 *
	 * @param string $base_template
	 *
	 * @return string
	 */
	private function getTemplateContent( string $base_template ): string {
		\ob_start();
		include( $base_template );

		$template_content = \ob_get_clean() ?: '';

		$template_content = str_replace( [ '[[PHP]]', '[[ECHO_PHP]]', '[[CLOSE_PHP]]' ], [ '<?php', '<?=', '?>' ], $template_content );

		return $this->minify_html_content( $template_content );
	}

	/**
	 * Helper: Minify html content of template.
	 *
	 * @param $html_content
	 *
	 * @return string
	 */
	private function minify_html_content($html_content): string {
		$to_remove = [ self::LINE_BREAKS, self::COMMENTS, self::MORE_THAN_TWO_WHITE_SPACES ];
		$replacement = self::WHITE_SPACE;

		return preg_replace($to_remove, $replacement, $html_content)?: '';
	}
}
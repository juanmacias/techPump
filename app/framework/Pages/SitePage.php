<?php

namespace techPump\Pages;

/**
 * Class SitePage. A template page.
 *
 * @package Pages
 */
class SitePage extends Page {

	/**
	 * Return head tag in html site.
	 *
	 * @return string
	 */
	protected function head():string {
		return $this->render( 'head' );
	}

	/**
	 * Return top of webpage.
	 *
	 * @return string
	 */
	protected function top():string {
		return $this->render( 'top' );
	}

	/**
	 * Return main of webpage.
	 *
	 * @return string
	 */
	protected function main():string {
		return $this->render( 'main' );
	}

	/**
	 * Return boottom of webpage.
	 *
	 * @return string
	 */
	protected function bottom():string {
		return $this->render( 'bottom' );
	}
}
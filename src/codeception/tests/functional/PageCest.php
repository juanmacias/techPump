<?php namespace techPump;

use techPump\Framework\Pages\AppPage;

class PageCest {

	private $page;

	function _before( AcceptanceTester $I ) {
		$template_path = __DIR__ . '/page_templates';
		$this->page    = new AppPage( $template_path );
	}

	public function PageCanBeCreatedTest( FunctionalTester $I ) {
		$expected_page_content = 'head|top|main|bottom';

		$I->assertSame( $expected_page_content, $this->get_page_content() );
	}

	/**
	 * Helper: Retrieve page content
	 *
	 * @return string
	 */
	private function get_page_content():string {
		\ob_start();
		$this->page->show();

		return \ob_get_clean();
	}
}

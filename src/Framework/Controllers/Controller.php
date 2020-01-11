<?php

namespace techPump\Framework\Controllers;

use techPump\Domain\Sites\Site;
use techPump\Framework\Http\Request;
use techPump\Framework\Pages\Page;

/**
 * Class Controller. Base of all controllers
 *
 * @package Controllers
 */
abstract class Controller {

	protected $request;
	protected $site;
	protected $templates_path;

	/**
	 * Controller constructor.
	 *
	 * @param Request   $request
	 * @param Site|null $site
	 * @param string    $templates_path
	 *
	 * @throws \ReflectionException
	 */
	public function __construct( Request $request, ?Site $site, string $templates_path = '' ) {
		$this->request = $request;
		$this->site    = $site;

		$current_class        = new \ReflectionClass( $this );
		$this->templates_path = $templates_path ?: dirname( $current_class->getFileName(), 2 ) . '/templates';
	}

	abstract public function getPage(): Page;
}
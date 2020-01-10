<?php

namespace techPump\Framework\Loaders;

use techPump\Domain\Entities\Site;
use techPump\Framework\Controllers\Controller;
use techPump\Framework\Http\Request;

/**
 * Class Route
 *
 * @package Loaders
 */
class Route {

	private const DEFAULT_CONTROLLER       = 'Home';

	private const CONTROLLERS_SUBNAMESPACE = '\\Controllers\\';

	private $request;
	private $site;
	private $controller_namespace;

	/**
	 * Route constructor.
	 *
	 * @param string                              $app_namespace Namespace of current app
	 * @param Request                             $request       Request from navigator
	 * @param \techPump\Domain\Entities\Site|null $site          Current site object
	 */
	public function __construct( string $app_namespace, Request $request, ?Site $site ) {
		$this->request              = $request;
		$this->site                 = $site;
		$this->controller_namespace = $app_namespace . self::CONTROLLERS_SUBNAMESPACE;
	}

	/**
	 * Retrieve Controller of current app relative to request.
	 *
	 * @return Controller
	 */
	public function getController(): Controller {
		$action = $this->request->get( 'action' ) ?: '';

		if ( !$action ) {
			return $this->getDefaultController();
		}

		$controller_class = $this->controller_namespace . $action;

		if ( !\class_exists( $controller_class ) ) {
			return $this->getDefaultController();
		}

		return $this->instanceController( $controller_class );
	}

	/**
	 * Helper: Retrieve an instance of default controller
	 *
	 * @return Controller
	 */
	private function getDefaultController(): Controller {
		$default_controller_class = $this->controller_namespace . self::DEFAULT_CONTROLLER;

		return $this->instanceController( $default_controller_class );
	}

	/**
	 * Helper: Retrieve an instance using controllar class name
	 *
	 * @param string $controller_class
	 *
	 * @return Controller
	 */
	private function instanceController( string $controller_class ): Controller {
		return new $controller_class( $this->request, $this->site );
	}
}
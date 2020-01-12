<?php

namespace techPump\Domain\Chicas;

use techPump\Config\Config;

/**
 * Class ChicasStore. Repositoy of chicas
 *
 * @package Chicas
 */
class ChicasRepository {

	private const ENDPOINT = 'https://webcams.cumlouder.com/feed/webcams/online/61/%d/';

	private $page;

	/**
	 * ChicasStore constructor.
	 *
	 * @param int $page Page of chicas.
	 *
	 */
	public function __construct( int $page = 1 ) {
		$this->pagge = $page ?: 1;
	}

	/**
	 * Chicas Factory. Retrieve all Chicas in a collecion
	 *
	 * @return array
	 */
	public function getAll(): Chicas {
		$chicas_list = $this->getChicasFromAPI();

		if ( empty( $chicas_list ) ) {
			return new Chicas( [] );
		}

		$outstandings = $this->getOutstandings();

		$chicas_list = $this->addOutstandingsInTheirPlace( $chicas_list, $outstandings );

		//Remove first girl. According specification
		array_shift( $chicas_list );

		return new Chicas( $chicas_list );
	}

	/**
	 * Helper, add a outstanding chica each {OUTSTANDING_CHICAS_INTERVAL} chicas.
	 *
	 * @param $chicas_list
	 * @param $outstandings
	 */
	private function addOutstandingsInTheirPlace( $chicas_list, $outstandings ): array {
		//-1 because of photo removed after
		$position             = - 1;
		$foto_grande_position = Config::OUTSTANDING_CHICAS_INTERVAL;
		foreach ( $outstandings as $outstanding ) {
			$position += $foto_grande_position;

			//end when there aren't more chicas.
			if ( !isset( $chicas_list[ $position ] ) ) {
				break;
			}

			\array_splice( $chicas_list, $position, 0, [ $outstanding ] );
		}

		return $chicas_list;
	}

	/**
	 * Retrieve outstanding chicas for current page.
	 *
	 * @return array
	 */
	public function getOutstandings() {
		static $chicas;

		if ( isset( $chicas[ $this->page ] ) ) {
			return $chicas[ $this->page ];
		}

		$chicas[ $this->page ] = [];
		$chicas_cache          = &$chicas[ $this->page ];

		$chicas_cache = $this->getChicasFromAPI();

		if ( empty( $chicas_cache ) ) {
			return [];
		}

		foreach ( $chicas_cache as & $chica ) {
			$chica[ 'outstanding' ] = true;
		}

		return \array_splice( $chicas_cache, 0, 5 );
	}

	/**
	 * Retrieve chicas from API( endpoint ) for current page.
	 * Result is cached only per current request( for now ).
	 *
	 * @return array
	 */
	private function getChicasFromAPI(): array {
		static $chicas = [];

		if ( isset( $chicas[ $this->page ] ) ) {
			return $chicas[ $this->page ];
		}

		$chicas[ $this->page ] = [];
		$chicas_cache          = &$chicas[ $this->page ];

		$endpoint = sprintf( self::ENDPOINT, $this->pagge );

		$json         = \file_get_contents( $endpoint ) ?: '';
		$chicas_cache = json_decode( $json, true ) ?: [];

		return $chicas_cache;
	}
}
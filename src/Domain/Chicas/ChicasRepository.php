<?php

namespace techPump\Domain\Chicas;

use techPump\Config\Config;

/**
 * Class ChicasStore. Repositoy of chicas
 *
 * @package Chicas
 */
class ChicasRepository {

	private const ENDPOINT           = 'http://webcams.cumlouder.com/feed/webcams/online/61/%d/';
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

		$outgoings = $this->getOutgoings();

		$chicas_list = $this->addOutgoingsInTheirPlace($chicas_list, $outgoings);

		//Remove first girl. According specification
		array_shift( $chicas_list );

		return new Chicas( $chicas_list );
	}

	/**
	 * Helper, add a outgoing chica each {OUTGOING_CHICAS_INTERVAL} chicas.
	 *
	 * @param $chicas_list
	 * @param $outgoings
	 */
	private function addOutgoingsInTheirPlace($chicas_list, $outgoings): array {
		//-1 because of photo removed after
		$position             = - 1;
		$foto_grande_position = Config::OUTGOING_CHICAS_INTERVAL;
		foreach ( $outgoings as $outgoing ) {
			$position += $foto_grande_position;

			//end when there aren't more chicas.
			if ( !isset( $chicas_list[ $position ] ) ) {
				break;
			}

			\array_splice( $chicas_list, $position, 0, [ $outgoing ] );
		}

		return $chicas_list;
	}

	/**
	 * Retrieve outgoing chicas for current page.
	 *
	 * @return array
	 */
	public function getOutgoings() {
		static $chicas;

		if(isset($chicas[$this->page])) {
			return $chicas;
		}

		$chicas[$this->page] = [];
		$chicas_cache = &$chicas[$this->page];

		$chicas_cache = $this->getChicasFromAPI();

		if ( empty( $chicas_cache ) ) {
			return [];
		}

		foreach ( $chicas_cache as & $chica ) {
			$chica[ 'outgoing' ] = true;
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

		$chicas[$this->page] = [];
		$chicas_cache = &$chicas[$this->page];

		$endpoint = sprintf( self::ENDPOINT, $this->pagge );

		$json                  = \file_get_contents( $endpoint ) ?: '';
		$chicas_cache = json_decode( $json, true ) ?: [];

		return $chicas_cache;
	}
}
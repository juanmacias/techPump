<?php

namespace techPump\Domain\Chicas;

use Iterator;

/**
 * Class Chicas. Collection of chicas.
 *
 * @package Chicas
 */
class Chicas implements Iterator {

	private $index;
	private $chicas_list;
	private $entity;

	public function __construct( array $chicas_list, ?string $entity = null ) {
		$this->chicas_list = $chicas_list;
		$this->entity      = $entity ?? Chica::class;

		$this->rewind();
	}

	/**
	 * Return current chica
	 */
	public function current(): Chica {
		$chica_class   = $this->entity;
		$current_chica = $this->chicas_list[ $this->index ];

		return new $chica_class( $current_chica, $this->index );
	}

	/**
	 * Next chica
	 */
	public function next() {
		$this->index ++;
	}

	/**
	 * key of current chica
	 */
	public function key() {
		return $this->index;
	}

	/**
	 * Chica exists ?
	 */
	public function valid() {
		return isset( $this->chicas_list[ $this->index ] );
	}

	/**
	 * Return to begin
	 */
	public function rewind() {
		$this->index = 0;
	}
}
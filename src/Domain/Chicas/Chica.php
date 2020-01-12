<?php

namespace techPump\Domain\Chicas;

use techPump\Config\Config;

/**
 * Class Chica. Entity of chica
 *
 * @package Chicas
 */
class Chica {

	/**
	 * Prefix used in chicas fields. E.g:  wbmerTwitter, wbmerId, wbmerNick, ...
	 */
	private const FIELD_PREFIX = 'wbmer';

	private $data;
	private $position;

	/**
	 * Chica constructor.
	 *
	 * @param array<string, string> $chica_data
	 * @param int                   $position
	 */
	public function __construct( array $chica_data, int $position ) {
		$this->data     = $chica_data;
		$this->position = $position;
	}

	/**
	 * Retrieve value of a field from chica data.
	 *
	 * @param string $field_name
	 *
	 * @return mixed|string
	 */
	public function get( string $field_name ): string {
		return strval( $this->data[ self::FIELD_PREFIX . $field_name ] ?? '' );
	}

	/**
	 * Retrieve if chica is outgoing or not.
	 *
	 * @return bool
	 */
	public function isOutgoing(): bool {
		return boolval( $this->data[ 'outgoing' ] ?? false );
	}

	/**
	 * Name of chica in order to use in HTML
	 *
	 * @return string
	 */
	public function getName(): string {
		return \htmlentities( $this->get( 'Nick' ) );
	}

	/**
	 * Retrieve file image name
	 *
	 * @return string
	 */
	public function getImage(): string {
		if ( $this->isOutgoing() ) {
			return $this->get( 'Thumb4' );
		}

		return $this->get( 'Thumb1' );
	}

	/**
	 * Link to image of chica
	 *
	 * @return string
	 */
	public function getImageUrl(): string {
		return sprintf( Config::IMAGES_URL, $this->getImage() );
	}

	/**
	 * Retrieve tags of chica.
	 *
	 * @return string
	 */
	public function getTags(): string {
		$tags = 'chica';

		if ( !$this->isOutgoing() ) {
			return $tags;
		}

		$tags .= ' chica-grande';

		$position_of_outgoing = ceil( $this->position / Config::OUTGOING_CHICAS_INTERVAL );
		$is_odd               = $position_of_outgoing % 2;

		if ( !$is_odd ) {
			$tags .= ' grande-derecha';
		}

		return $tags;
	}

	/**
	 * Retrieve Internet status of chica.
	 *
	 * @return string
	 */
	public function getStatus(): string {
		return $this->get( 'Online' ) ? 'online' : 'offline';
	}

	/**
	 * Retrieve a webcam link of chica
	 *
	 * @return string
	 */
	public function getWebCamLink(): string {
		return sprintf( Config::WEBCAMS_LINK, $this->get( 'Permalink' ) );
	}
}
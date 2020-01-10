<?php

namespace techPump\Domain\Collections;

use DirectoryIterator;
use techPump\Domain\Entities\Site;

/**
 * Class Sites. It is an iterator in order to iterate sites.
 *
 * @package Collections
 */
class Sites extends DirectoryIterator {

	private $entity;

	/**
	 * Named constructor
	 *
	 * @param string $path   Default is sites directory.
	 * @param string $entity Default is Site entity class.
	 *
	 * @return self
	 */
	public static function fromPathAndEntity( string $path, string $entity ): self {
		$sites         = new self( $path );
		$sites->entity = $entity;

		return $sites;
	}

	/**
	 * Returns current site in loop.
	 *
	 * @return \techPump\Domain\Entities\Site
	 */
	public function current(): Site {
		$current_file = parent::current();

		$site = Site::fromSitePath( $current_file->getRealPath() );

		return $site;
	}

	/**
	 * Check if current file/directory is a valid site
	 *
	 * @return bool
	 */
	public function valid(): bool {
		if ( !parent::valid() ) {
			return false;
		}

		if ( !$this->isDir() || $this->isDot() ) {
			return $this->checkNext();
		}

		$site = Site::fromSitePath( $this->getRealPath() );
		if ( !$site->exists() ) {
			return $this->checkNext();
		}

		return true;
	}

	/**
	 * Helper: retrieve if next element is valid or not.
	 *
	 * @return bool
	 */
	protected function checkNext(): bool {
		$this->next();

		//recursive mode on
		return (bool) $this->valid();
	}
}
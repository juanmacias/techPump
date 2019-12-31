<?php

namespace techPump;

/**
 * Class SiteCest
 *
 * @package techPump
 */
class SiteCest {

	private const EXPECTED_CHICAS_COUNT = 36;

	public function _before( AcceptanceTester $I ) {
		$I->amOnPage( 'http://cerdas.com' );
	}

	public function topIsRightTest( AcceptanceTester $I ) {
		$I->canSeeLink( 'Cerdas.com' );
		$I->canSee( 'Acceso a las Chicas en Directo', '.header' );
	}

	public function mainIsRightTest( AcceptanceTester $I ) {
		$I->canSeeLink( 'Siguiente Página' );

		$chicas_count = $I->grabMultiple( '.listado-chicas .chica' );
		$I->assertSame( self::EXPECTED_CHICAS_COUNT, count( $chicas_count ) );
	}

	public function bottomIsRightTest( AcceptanceTester $I ) {
		$I->canSee( 'Acceso a las Chicas en Directo', '.box-footer' );
		$I->canSee( 'WAMCash Spain Todos los derechos reservados' );
	}
}

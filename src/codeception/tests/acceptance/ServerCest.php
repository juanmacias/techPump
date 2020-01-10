<?php

namespace techPump;

use techPump\Config\Config;

class ServerCest {

	public function AdminSiteExiststTest( AcceptanceTester $I ) {
		$I->amOnPage( 'http://sites.techpump.local' );
		$I->seeResponseCodeIs( 401 );
	}

	public function AdminLoginTest( AcceptanceTester $I ) {
		$I->wantToTest( 'I can do loggin with right user' );
		$I->amOnPage( 'http://sites.techpump.local' );
		$I->seeResponseCodeIs( 401 );
		$I->haveHttpHeader( 'Content-Type', 'WWW-Authenticate: Basic techpump="TechPump"' );
		$I->amHttpAuthenticated( Config::ADMIN_USER, Config::ADMIN_PASSWD );
		$I->amOnPage( 'http://sites.techpump.local' );
		$I->seeResponseCodeIs( 200 );
	}

	/**
	 * @param AcceptanceTester $I
	 *
	 * @example { "name": "techPump", "passwd": "" }
	 * @example { "name": "", "passwd": "techPump" }
	 * @example { "name": "techPump", "passwd": "techPump" }
	 * @example { "name": "pepito", "passwd": "grillo" }
	 * @example { "name": "", "passwd": "" }
	 */
	public function AdminNotLoginTest( AcceptanceTester $I, \Codeception\Example $example_user ) {
		$I->wantToTest( 'I cannot do loggin with wrong user' );
		$I->amOnPage( 'http://sites.techpump.local' );
		$I->seeResponseCodeIs( 401 );
		$I->haveHttpHeader( 'Content-Type', 'WWW-Authenticate: Basic techpump="TechPump"' );
		$I->amHttpAuthenticated( $example_user[ 'name' ], $example_user[ 'passwd' ] );
		$I->amOnPage( 'http://sites.techpump.local' );
		$I->seeResponseCodeIs( 401 );
	}
}

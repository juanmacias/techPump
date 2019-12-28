<?php 

namespace techPump;

class ServerCest
{
    public function AdminSiteExiststTest(AcceptanceTester $I)
    {
		$I->amOnPage('http://sites.techpump.local');
		$I->seeResponseCodeIs(200);
    }
}

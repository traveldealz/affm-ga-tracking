<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class DigidipTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://travel-dealz.digidip.net/visit' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://travel-dealz.digidip.net/visit?ref=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://travel-dealz-eu.digidip.net/visit?url=https%3A%2F%2Fdigidip.net%2Fpublisher%2Fmerchant-lookup' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://travel-dealz-eu.digidip.net/visit?url=https%3A%2F%2Fdigidip.net%2Fpublisher%2Fmerchant-lookup&ref=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://travel-dealz-eu.digidip.net/visit?url=https%3A%2F%2Fdigidip.net%2Fpublisher%2Fmerchant-lookup&ref=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://travel-dealz-eu.digidip.net/visit?url=https%3A%2F%2Fdigidip.net%2Fpublisher%2Fmerchant-lookup&ref=test456', $url );
	}

}

<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class ImpactTest extends TestCase {

	public function test_set_subid_airbnb() {
		$Subid = new Subid( 'https://airbnb.pvxt.net/c/297275/567379/4273' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://airbnb.pvxt.net/c/297275/567379/4273?subId2=test123', $url );
	}

	public function test_set_subid_with_subid3() {
		$Subid = new Subid( 'https://hyatt.jewn.net/c/297275/624189/4882?subId3=eu' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://hyatt.jewn.net/c/297275/624189/4882?subId2=test123&subId3=eu', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://omio.sjv.io/c/297275/409973/7385?u=https%3A%2F%2Fde.omio.com' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://omio.sjv.io/c/297275/409973/7385?subId2=test123&u=https%3A%2F%2Fde.omio.com', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://airbnb.pvxt.net/c/297275/567379/4273?subId2=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://airbnb.pvxt.net/c/297275/567379/4273?subId2=test456', $url );
	}

}

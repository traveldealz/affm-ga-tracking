<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class TradetrackerTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251&r=test123', $url );
	}

	public function test_set_subid_with_r() {
		$Subid = new Subid( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251&r=&u=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251&r=test123&u=', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://tc.tradetracker.net/?c=32919&m=12&a=88251&u=%2Fflights%2FDUS-NYC%2F2020-11-26%2F2020-12-03' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tc.tradetracker.net/?c=32919&m=12&a=88251&r=test123&u=%2Fflights%2FDUS-NYC%2F2020-11-26%2F2020-12-03', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251&r=test456&u=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tc.tradetracker.net/?c=32919&m=1796191&a=88251&r=test456&u=', $url );
	}

}

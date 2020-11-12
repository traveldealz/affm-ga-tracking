<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class DaisyconTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://lt45.net/c/?si=13146&li=1676216&wi=210327' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://lt45.net/c/?si=13146&li=1676216&ws3=test123&wi=210327', $url );
	}

	public function test_set_subid_with_ws_in_the_url() {
		$Subid = new Subid( 'https://lt45.net/c/?si=13146&li=1676216&wi=210327&ws=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://lt45.net/c/?si=13146&li=1676216&ws3=test123&wi=210327&ws=', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://lt45.net/c/?si=13146&li=1577952&wi=210327&dl=de%2Farrangementen%2Ffletcher-25-euro-aktion%2Fhotels' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://lt45.net/c/?si=13146&li=1577952&ws3=test123&wi=210327&dl=de%2Farrangementen%2Ffletcher-25-euro-aktion%2Fhotels', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://lt45.net/c/?si=13146&li=1577952&ws3=test456&wi=210327&ws=&dl=de%2Farrangementen%2Ffletcher-25-euro-aktion%2Fhotels' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://lt45.net/c/?si=13146&li=1577952&ws3=test456&wi=210327&ws=&dl=de%2Farrangementen%2Ffletcher-25-euro-aktion%2Fhotels', $url );
	}

}

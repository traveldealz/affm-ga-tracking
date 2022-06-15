<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class Go2Test extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://go2.travel-dealz.de/' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go2.travel-dealz.de/?subid=test123', $url );
	}

	public function test_set_subid_eu() {
		$Subid = new Subid( 'https://go2.travel-dealz.eu/' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go2.travel-dealz.eu/?subid=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://go2.travel-dealz.de/?destination=momondo&url=https%3A%2F%2Fwww.google.de%2Fflights%2F%23flt%3DDUS.HAM.2019-02-14.DUSHAM0EW7063*HAM.DUS.2019-02-15.HAMDUS0EW7062%3Bc%3AEUR%3Be%3A1%3Bsd%3A1%3Bt%3Af' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go2.travel-dealz.de/?destination=momondo&url=https%3A%2F%2Fwww.google.de%2Fflights%2F%23flt%3DDUS.HAM.2019-02-14.DUSHAM0EW7063*HAM.DUS.2019-02-15.HAMDUS0EW7062%3Bc%3AEUR%3Be%3A1%3Bsd%3A1%3Bt%3Af&subid=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://go2.travel-dealz.de/?destination=momondo&url=https%3A%2F%2Fwww.google.de%2Fflights%2F%23flt%3DDUS.HAM.2019-02-14.DUSHAM0EW7063*HAM.DUS.2019-02-15.HAMDUS0EW7062%3Bc%3AEUR%3Be%3A1%3Bsd%3A1%3Bt%3Af&subid=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go2.travel-dealz.de/?destination=momondo&url=https%3A%2F%2Fwww.google.de%2Fflights%2F%23flt%3DDUS.HAM.2019-02-14.DUSHAM0EW7063*HAM.DUS.2019-02-15.HAMDUS0EW7062%3Bc%3AEUR%3Be%3A1%3Bsd%3A1%3Bt%3Af&subid=Test', $url );
	}

}
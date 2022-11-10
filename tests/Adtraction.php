<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AdtractionTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://track.adtraction.com/t/t?a=1634356829&as=1759152014&t=2&tk=1&epi=test123&url=https://ferien.lastminute.ch/search?bookingType=PACKAGE&travellers=25-1_25-2&airportCodes=ZRH_BSL_BRN_GVA_LUG_FDH' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.adtraction.com/t/t?a=1634356829&as=1759152014&t=2&tk=1&epi=test123&url=https://ferien.lastminute.ch/search?bookingType=PACKAGE&travellers=25-1_25-2&airportCodes=ZRH_BSL_BRN_GVA_LUG_FDH&epi2=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://track.adtraction.com/t/t?a=1634356829&as=1759152014&t=2&tk=1&epi=test123&url=https://ferien.lastminute.ch/search?bookingType=PACKAGE&travellers=25-1_25-2&airportCodes=ZRH_BSL_BRN_GVA_LUG_FDH&epi2=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.adtraction.com/t/t?a=1634356829&as=1759152014&t=2&tk=1&epi=test123&url=https://ferien.lastminute.ch/search?bookingType=PACKAGE&travellers=25-1_25-2&airportCodes=ZRH_BSL_BRN_GVA_LUG_FDH&epi2=test456', $url );
	}

}
<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class WebgainsTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=11093&wgtarget=https%3A%2F%2Fhorizn-studios.com%2Fen%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=11093&clickref=test123&wgtarget=https%3A%2F%2Fhorizn-studios.com%2Fen%2F', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=7341&wgtarget=https://www.momondo.de/flightsearch/?Search=true&TripType=4&SegNo=3&SO0=HAM&SD0=NYC&SDP0=07-11-2017&SO1=NYC&SD1=KEF&SDP1=13-11-2017&SO2=KEF&SD2=HAM&SDP2=21-11-2017&AD=1&TK=ECO&DO=false&NA=false&utm_source=webgains&utm_medium=affiliate&utm_campaign=%20159911&utm_content=7341' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=7341&clickref=test123&wgtarget=https://www.momondo.de/flightsearch/?Search=true&TripType=4&SegNo=3&SO0=HAM&SD0=NYC&SDP0=07-11-2017&SO1=NYC&SD1=KEF&SDP1=13-11-2017&SO2=KEF&SD2=HAM&SDP2=21-11-2017&AD=1&TK=ECO&DO=false&NA=false&utm_source=webgains&utm_medium=affiliate&utm_campaign=%20159911&utm_content=7341', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=11093&clickref=test456&wgtarget=https%3A%2F%2Fhorizn-studios.com%2Fen%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.webgains.com/click.html?wgcampaignid=159911&wgprogramid=11093&clickref=test456&wgtarget=https%3A%2F%2Fhorizn-studios.com%2Fen%2F', $url );
	}

}

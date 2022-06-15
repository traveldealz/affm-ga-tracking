<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AffMTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://affm.travel-dealz.de/sites/1/redirect' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://affm.travel-dealz.de/sites/1/redirect?subid=test123', $url );
	}

	public function test_set_subid_eu() {
		$Subid = new Subid( 'https://affm.travel-dealz.eu/sites/1/redirect' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://affm.travel-dealz.eu/sites/1/redirect?subid=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://affm.travel-dealz.de/sites/1/redirect?url=https%3A%2F%2Fwww.meinschiff.com%2Fkreuzfahrt-buchen%2Freiserouten-details%3FrouteCode%3DDubai%2520mit%2520Oman%2520II%26amp%3Bchildren%3D0%26amp%3BtripCode%3DMSS225758SEE%26amp%3Badults%3D2%26amp%3Bship%3DMs6%26amp%3Bsort%3DpriceMin%26amp%3Bpage%3D1' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://affm.travel-dealz.de/sites/1/redirect?url=https%3A%2F%2Fwww.meinschiff.com%2Fkreuzfahrt-buchen%2Freiserouten-details%3FrouteCode%3DDubai%2520mit%2520Oman%2520II%26amp%3Bchildren%3D0%26amp%3BtripCode%3DMSS225758SEE%26amp%3Badults%3D2%26amp%3Bship%3DMs6%26amp%3Bsort%3DpriceMin%26amp%3Bpage%3D1&subid=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://affm.travel-dealz.de/sites/1/redirect?url=https%3A%2F%2Fwww.meinschiff.com%2Fkreuzfahrt-buchen%2Freiserouten-details%3FrouteCode%3DDubai%2520mit%2520Oman%2520II%26amp%3Bchildren%3D0%26amp%3BtripCode%3DMSS225758SEE%26amp%3Badults%3D2%26amp%3Bship%3DMs6%26amp%3Bsort%3DpriceMin%26amp%3Bpage%3D1&subid=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://affm.travel-dealz.de/sites/1/redirect?url=https%3A%2F%2Fwww.meinschiff.com%2Fkreuzfahrt-buchen%2Freiserouten-details%3FrouteCode%3DDubai%2520mit%2520Oman%2520II%26amp%3Bchildren%3D0%26amp%3BtripCode%3DMSS225758SEE%26amp%3Badults%3D2%26amp%3Bship%3DMs6%26amp%3Bsort%3DpriceMin%26amp%3Bpage%3D1&subid=Test', $url );
	}

}
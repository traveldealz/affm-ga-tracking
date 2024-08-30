<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class CruiseCompassTest extends TestCase {

	public function test_set_subid_homepage() {
		$Subid = new Subid( 'https://kreuzfahrten.travel-dealz.de/de' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://kreuzfahrten.travel-dealz.de/de?subid=test123', $url );
	}

	public function test_set_subid_search() {
		$Subid = new Subid( 'https://kreuzfahrten.travel-dealz.de/de/angebot?cruise_id=811-240919-22&t=NS' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://kreuzfahrten.travel-dealz.de/de/angebot?cruise_id=811-240919-22&t=NS&subid=test123', $url );
	}

	public function test_set_subid_with_subid_set() {
		$Subid = new Subid( 'https://kreuzfahrten.travel-dealz.de/de/suche?dur=3-20&f=f&sdt=2025-04-05&shipid=447&sort=&subid=am107a818d143e4daeba24b906dce82525&t=S&bdt=2025-04-27' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://kreuzfahrten.travel-dealz.de/de/suche?dur=3-20&f=f&sdt=2025-04-05&shipid=447&sort=&subid=test123&t=S&bdt=2025-04-27', $url );
	}

}

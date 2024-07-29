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

}

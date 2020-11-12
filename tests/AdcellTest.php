<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AdcellTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://t.adcell.com/p/click?promoId=163096&slotId=43024' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://t.adcell.com/p/click?promoId=163096&slotId=43024&subId=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://t.adcell.com/p/click?promoId=163097&slotId=43024&param0=https%3A%2F%2Fwww.reiseschein.de%2Fmulti-reisescheine%2Fmega-multi-2020-3-tage-kurzurlaub-in-einem-von-20-deutschen-h-hotels-ihrer-wahl_9274_10988' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://t.adcell.com/p/click?promoId=163097&slotId=43024&subId=test123&param0=https%3A%2F%2Fwww.reiseschein.de%2Fmulti-reisescheine%2Fmega-multi-2020-3-tage-kurzurlaub-in-einem-von-20-deutschen-h-hotels-ihrer-wahl_9274_10988', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://t.adcell.com/p/click?promoId=163097&slotId=43024&subId=test456&param0=https%3A%2F%2Fwww.reiseschein.de%2Fmulti-reisescheine%2Fmega-multi-2020-3-tage-kurzurlaub-in-einem-von-20-deutschen-h-hotels-ihrer-wahl_9274_10988' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://t.adcell.com/p/click?promoId=163097&slotId=43024&subId=test456&param0=https%3A%2F%2Fwww.reiseschein.de%2Fmulti-reisescheine%2Fmega-multi-2020-3-tage-kurzurlaub-in-einem-von-20-deutschen-h-hotels-ihrer-wahl_9274_10988', $url );
	}

	public function test_set_subid_on_old_adcell_de_url() {
		$Subid = new Subid( 'https://www.adcell.de/promotion/click/promoId/147294/slotId/43024' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.adcell.de/promotion/click/promoId/147294/slotId/43024/subId/test123', $url );
	}

}
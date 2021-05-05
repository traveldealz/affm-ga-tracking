<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class EasyAffiliateTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://pvn.mediamarkt.de/trck/eclick/0b54fd8b50a22ea6ff74aee73eb408bf' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://pvn.mediamarkt.de/trck/eclick/0b54fd8b50a22ea6ff74aee73eb408bf?subid=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://pvn.saturn.de/trck/eclick/148b2a11fd32fffbd24f26db95f0b13a?url=https%3A%2F%2Fwww.saturn.de%2Fde%2Fproduct%2F_acer-aspire-3-a317-33-p9j7-2705824.html' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://pvn.saturn.de/trck/eclick/148b2a11fd32fffbd24f26db95f0b13a?subid=test123&url=https%3A%2F%2Fwww.saturn.de%2Fde%2Fproduct%2F_acer-aspire-3-a317-33-p9j7-2705824.html', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://pvn.saturn.de/trck/eclick/148b2a11fd32fffbd24f26db95f0b13a?subid=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://pvn.saturn.de/trck/eclick/148b2a11fd32fffbd24f26db95f0b13a?subid=Test', $url );
	}

}
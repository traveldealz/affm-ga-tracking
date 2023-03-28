<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AdrecordTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://click.adrecord.com/?c=156838&p=236' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://click.adrecord.com/?c=156838&p=236&epi=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://click.adrecord.com/?c=156838&p=236&url=https://www.ttline.com/sv/biljettoversikt/' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://click.adrecord.com/?c=156838&p=236&epi=test123&url=https://www.ttline.com/sv/biljettoversikt/', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://click.adrecord.com/?c=156838&p=236&epi=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://click.adrecord.com/?c=156838&p=236&epi=test456', $url );
	}

}
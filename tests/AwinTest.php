<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AwinTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115&clickref2=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115&p=https%3A%2F%2Fwww.travelzoo.com%2Fde%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115&clickref2=test123&p=https%3A%2F%2Fwww.travelzoo.com%2Fde%2F', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115&clickref2=test456&p=https%3A%2F%2Fwww.travelzoo.com%2Fde%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.awin1.com/cread.php?awinmid=10885&awinaffid=135115&clickref2=test456&p=https%3A%2F%2Fwww.travelzoo.com%2Fde%2F', $url );
	}

}

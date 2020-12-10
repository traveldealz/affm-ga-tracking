<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class EbayTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://rover.ebay.com/rover/1/711-53200-19255-0/1?mpre=https%3A%2F%2Fwww.ebay.com%2F&campid=5338765576&toolid=10001' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://rover.ebay.com/rover/1/711-53200-19255-0/1?mpre=https%3A%2F%2Fwww.ebay.com%2F&campid=5338765576&customid=test123&toolid=10001', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://rover.ebay.com/rover/1/711-53200-19255-0/1?mpre=https%3A%2F%2Fwww.ebay.com%2F&campid=5338765576&toolid=10001&customid=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://rover.ebay.com/rover/1/711-53200-19255-0/1?mpre=https%3A%2F%2Fwww.ebay.com%2F&campid=5338765576&toolid=10001&customid=Test', $url );
	}

}
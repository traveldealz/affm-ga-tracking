<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class TradedoublerTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://clk.tradedoubler.com/click?p=307227&a=3123206' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://clk.tradedoubler.com/click?p=307227&a=3123206&epi2=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://clk.tradedoubler.com/click?p=307227&a=3123206&url=https%3A%2F%2Fwww.eurowings.com%2Fde.html' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://clk.tradedoubler.com/click?p=307227&a=3123206&epi2=test123&url=https%3A%2F%2Fwww.eurowings.com%2Fde.html', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://clk.tradedoubler.com/click?p=307227&a=3123206&epi2=test456&url=https%3A%2F%2Fwww.eurowings.com%2Fde.html' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://clk.tradedoubler.com/click?p=307227&a=3123206&epi2=test456&url=https%3A%2F%2Fwww.eurowings.com%2Fde.html', $url );
	}

	public function test_set_subid_on_clkde() {
		$Subid = new Subid( 'https://clkde.tradedoubler.com/click?p=283784&a=2231388&g=24031056' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://clkde.tradedoubler.com/click?p=283784&a=2231388&epi2=test123&g=24031056', $url );
	}

	public function test_set_subid_with_breakeds() {
		$Subid = new Subid( 'http://clkde.tradedoubler.com/click?p(224467)a(2231388)g(20638248)' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'http://clkde.tradedoubler.com/click?p(224467)a(2231388)epi2(test123)g(20638248)', $url );
	}

}

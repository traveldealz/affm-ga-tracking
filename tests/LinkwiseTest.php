<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class LinkwiseTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://go.linkwi.se/z/73-0/CD17549/' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go.linkwi.se/z/73-0/CD17549/?subid5=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://go.linkwi.se/z/73-0/CD17549/?lnkurl=https%3A%2F%2Fde.aegeanair.com%2F&subid1=de' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go.linkwi.se/z/73-0/CD17549/?subid5=test123&lnkurl=https%3A%2F%2Fde.aegeanair.com%2F&subid1=de', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://go.linkwi.se/z/73-0/CD17549/?lnkurl=https%3A%2F%2Fde.aegeanair.com%2F&subid5=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://go.linkwi.se/z/73-0/CD17549/?lnkurl=https%3A%2F%2Fde.aegeanair.com%2F&subid5=Test', $url );
	}

}
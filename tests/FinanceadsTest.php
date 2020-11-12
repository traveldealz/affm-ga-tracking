<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class FinanceadsTest extends TestCase {

	public function test_set_subid_financeads() {
		$Subid = new Subid( 'https://www.financeads.net/tc.php?t=14406C14343941B' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.financeads.net/tc.php?t=14406C14343941B&subid=test123', $url );
	}

	public function test_set_subid_retailsads() {
		$Subid = new Subid( 'https://cdn.retailads.net/tc.php?t=150461C2176132254T' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://cdn.retailads.net/tc.php?t=150461C2176132254T&subid=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://cdn.retailads.net/tc.php?t=150461C2176132295T&deeplink=https%3A%2F%2Fwww.koffer-kopf.de%2Fdetail%2Findex%2FsArticle%2F33022' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://cdn.retailads.net/tc.php?t=150461C2176132295T&subid=test123&deeplink=https%3A%2F%2Fwww.koffer-kopf.de%2Fdetail%2Findex%2FsArticle%2F33022', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://www.financeads.net/tc.php?t=14406C14343941B&subid=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.financeads.net/tc.php?t=14406C14343941B&subid=test456', $url );
	}

}

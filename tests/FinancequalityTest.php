<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class FinancequalityTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://l.neqty.net/klick.html?fq=MjQzXzM1MjZfMjEyMDM=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://l.neqty.net/klick.html?fq=MjQzXzM1MjZfMjEyMDM=&subid=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://l.neqty.net/klick.html?fq=MjQzXzM1MjZfMjEyMDM=&subid=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://l.neqty.net/klick.html?fq=MjQzXzM1MjZfMjEyMDM=&subid=test456', $url );
	}

}

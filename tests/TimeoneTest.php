<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class TimeoneTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966&cb=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966&dpl=https%3A%2F%2Fwww.thalys.com%2Fde%2Fde' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966&dpl=https%3A%2F%2Fwww.thalys.com%2Fde%2Fde&cb=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966&dpl=https%3A%2F%2Fwww.thalys.com%2Fde%2Fde&cb=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://tracking.publicidees.com/clic.php?progid=4066&partid=31966&dpl=https%3A%2F%2Fwww.thalys.com%2Fde%2Fde&cb=test456', $url );
	}

}
<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class ShareasaleTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://shareasale.com/r.cfm?b=856658&u=1242077&m=17495&urllink=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://shareasale.com/r.cfm?b=856658&u=1242077&m=17495&afftrack=test123&urllink=', $url );
	}

	public function test_set_subid_with_afftrack_in_the_url() {
		$Subid = new Subid( 'https://shareasale.com/r.cfm?b=856658&u=1242077&m=17495&urllink=&afftrack=' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://shareasale.com/r.cfm?b=856658&u=1242077&m=17495&urllink=&afftrack=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://shareasale.com/r.cfm?b=124412&u=1242077&m=17495&urllink=www%2Eprioritypass%2Ecom%2Ffr%2Fairport%2Dlounges' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://shareasale.com/r.cfm?b=124412&u=1242077&m=17495&afftrack=test123&urllink=www%2Eprioritypass%2Ecom%2Ffr%2Fairport%2Dlounges', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://shareasale.com/r.cfm?b=124412&u=1242077&m=17495&urllink=www%2Eprioritypass%2Ecom%2Ffr%2Fairport%2Dlounges&afftrack=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://shareasale.com/r.cfm?b=124412&u=1242077&m=17495&urllink=www%2Eprioritypass%2Ecom%2Ffr%2Fairport%2Dlounges&afftrack=test456', $url );
	}

}

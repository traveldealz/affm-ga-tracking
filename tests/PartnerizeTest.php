<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class PartnerizeTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://prf.hn/click/camref:1101l7QFP' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://prf.hn/click/camref:1101l7QFP/pubref:test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://prf.hn/click/camref:1l3vcSe/[p_id:1l1002514]/destination:https%3A%2F%2Fwww.klm.de%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://prf.hn/click/camref:1l3vcSe/pubref:test123/[p_id:1l1002514]/destination:https%3A%2F%2Fwww.klm.de%2F', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://prf.hn/click/camref:1101l7QFP/pubref:test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://prf.hn/click/camref:1101l7QFP/pubref:test456', $url );
	}

}

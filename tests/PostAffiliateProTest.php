<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class PostAffiliateProTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://www.seereisedienst.de/?utm_medium=CPO&utm_source=Selecdoo&a_aid=traveldealz&a_cid=88e45564' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.seereisedienst.de/?utm_medium=CPO&utm_source=Selecdoo&a_aid=traveldealz&a_cid=88e45564&subID2=test123', $url );
	}

}

<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AdmitadTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec?subid3=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid('https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec/?ulp=https%3A%2F%2Fwww.prioritypass.com%2Fen%2Fcampaigns%2Fldn%2Fkeyword%2Fairportlounge%3Fsourcecode%3DTAG08%26currency%3DGBP%26tagrid%3D54581172');
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec/?ulp=https%3A%2F%2Fwww.prioritypass.com%2Fen%2Fcampaigns%2Fldn%2Fkeyword%2Fairportlounge%3Fsourcecode%3DTAG08%26currency%3DGBP%26tagrid%3D54581172&subid3=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec?subid3=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://ad.admitad.com/g/gwdmsol01g237ff9c5b87e5d1cb6ec?subid3=test456', $url );
	}

}
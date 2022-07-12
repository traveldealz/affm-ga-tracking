<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class AdserviceTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://online.adservicemedia.dk/cgi-bin/click.pl?cid=12349&pid=18663&productGroup=BNLoan&media_id=91111' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://online.adservicemedia.dk/cgi-bin/click.pl?cid=12349&pid=18663&productGroup=BNLoan&media_id=91111&sub2=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://online.adservicemedia.dk/cgi-bin/click.pl?cid=12349&pid=18663&productGroup=BNLoan&media_id=91111&sub2=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://online.adservicemedia.dk/cgi-bin/click.pl?cid=12349&pid=18663&productGroup=BNLoan&media_id=91111&sub2=test456', $url );
	}

}
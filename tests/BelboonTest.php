<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class BelboonTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?typ=r&amc=con.blbn.456151.471983.CRTfi6tU9e6' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?typ=r&amc=con.blbn.456151.471983.CRTfi6tU9e6&smc3=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?amc=con.blbn.456151.471983.14670145&rmd=3&trg=https%3A%2F%2Fwww.stage-entertainment.de%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?amc=con.blbn.456151.471983.14670145&rmd=3&trg=https%3A%2F%2Fwww.stage-entertainment.de%2F&smc3=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?typ=r&amc=con.blbn.456151.471983.CRTfi6tU9e6&smc3=Test' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://nument.r.stage-entertainment.de/ts/i5034048/tsc?typ=r&amc=con.blbn.456151.471983.CRTfi6tU9e6&smc3=Test', $url );
	}

}
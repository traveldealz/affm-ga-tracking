<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class IngeniousTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://atlas.r.akipam.com/ts/i5036400/tsc?typ=r&amc=con.blbn.456151.471983.CRT2-TEl0AA&tst=!!TIMESTAMP!!' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://atlas.r.akipam.com/ts/i5036400/tsc?smc3=test123&typ=r&amc=con.blbn.456151.471983.CRT2-TEl0AA&tst=!!TIMESTAMP!!', $url );
	}

	public function test_set_subid_starcar() {
		$Subid = new Subid( 'https://janus.r.jakuli.com/ts/i5533913/tsc?typ=r&amc=con.blbn.456151.471983.CRTsBS2zilS&tst=!!TIMESTAMP!!' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://janus.r.jakuli.com/ts/i5533913/tsc?smc3=test123&typ=r&amc=con.blbn.456151.471983.CRTsBS2zilS&tst=!!TIMESTAMP!!', $url );
	}

}

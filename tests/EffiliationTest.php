<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class EffiliationTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845&effi_id2=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845&url=https%3A%2F%2Fde.oui.sncf%2Fde%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845&url=https%3A%2F%2Fde.oui.sncf%2Fde%2F&effi_id2=test123', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845&url=https%3A%2F%2Fde.oui.sncf%2Fde%2F&effi_id2=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22658845&url=https%3A%2F%2Fde.oui.sncf%2Fde%2F&effi_id2=test456', $url );
	}

}
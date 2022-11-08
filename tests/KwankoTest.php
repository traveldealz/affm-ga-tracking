<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;


class KwankoTest extends TestCase {

	public function test_accorhotels() {
		$Subid = new Subid( 'https://action.metaffiliation.com/trk.php?mclic=P5120A956B28D2111&redir=https%3A%2F%2Fall.accor.com%2Fdeutschland%2Findex.de.shtml' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://action.metaffiliation.com/trk.php?mclic=P5120A956B28D2111&redir=https%3A%2F%2Fall.accor.com%2Fdeutschland%2Findex.de.shtml&argsite=test123', $url );
	}

	public function test_msccruises() {
		$Subid = new Subid( 'https://vix.msc-kreuzfahrten.de/?P4E9EB56B28D21B1&redir=https%3A%2F%2Fwww.msccruises.de%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://vix.msc-kreuzfahrten.de/?P4E9EB56B28D21B1&redir=https%3A%2F%2Fwww.msccruises.de%2F&argsite=test123', $url );
	}

	public function test_with_existing_subid() {
		$Subid = new Subid( 'https://vix.msc-kreuzfahrten.de/?P4E9EB56B28D21B1&redir=https%3A%2F%2Fwww.msccruises.de%2F&argsite=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://vix.msc-kreuzfahrten.de/?P4E9EB56B28D21B1&redir=https%3A%2F%2Fwww.msccruises.de%2F&argsite=test456', $url );
	}

}

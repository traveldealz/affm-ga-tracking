<?php
namespace AffM\Tests;

use PHPUnit\Framework\TestCase;
use Affm\Subid;

class CjTest extends TestCase {

	public function test_set_subid() {
		$Subid = new Subid( 'https://www.anrdoezrs.net/click-3987156-14338822' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.anrdoezrs.net/click-3987156-14338822?sid=test123', $url );
	}

	public function test_set_subid_with_deeplink() {
		$Subid = new Subid( 'https://www.dpbolvw.net/click-3987156-14343807?url=https%3A%2F%2Fwww.expedia.de%2F' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.dpbolvw.net/click-3987156-14343807?sid=test123&url=https%3A%2F%2Fwww.expedia.de%2F', $url );
	}

	public function test_existing_subid_will_not_be_overwritten() {
		$Subid = new Subid( 'https://www.dpbolvw.net/click-3987156-14343807?sid=test456' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.dpbolvw.net/click-3987156-14343807?sid=test456', $url );
	}

	public function test_set_subid_with_type_dlg_url() {
		$Subid = new Subid( 'https://www.anrdoezrs.net/links/3987156/type/dlg/https://www.qatarairways.com/de-de/homepage.html' );
		$url = $Subid->add_subid('test123')->get();
        $this->assertEquals( 'https://www.anrdoezrs.net/links/3987156/type/dlg/sid/test123/https://www.qatarairways.com/de-de/homepage.html', $url );
	}

}

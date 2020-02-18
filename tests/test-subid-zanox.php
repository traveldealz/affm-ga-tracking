<?php
require_once 'subid-class.php';
class TestSubidZanox extends SubidTestClass {
	public function test_url_gets_subid_attached() {
		$url = $this->prli_target_url( 'https://ad.zanox.com/ppc/?38260839C128989284T', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://ad.zanox.com/ppc/?38260839C128989284T&zpar3=[[am1564851476418786d1379025341db88f81ee5c788391b]]', $url );
	}

	public function test_url_with_deeplink_gets_subid_attached() {
		$url = $this->prli_target_url( 'https://ad.zanox.com/ppc/?37355597C79194162&ulp=[[https://www.eurowings.com/de/buchen/angebote/fluege-ab/DE/LEJ/nach/US/MIA.html]]', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://ad.zanox.com/ppc/?37355597C79194162&zpar3=[[am1564851476418786d1379025341db88f81ee5c788391b]]&ulp=[[https://www.eurowings.com/de/buchen/angebote/fluege-ab/DE/LEJ/nach/US/MIA.html]]', $url );
	}

	public function test_url_overrides_subid() {
		$url = $this->prli_target_url( 'https://ad.zanox.com/ppc/?38260839C128989284T&zpar3=[[test123]]', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://ad.zanox.com/ppc/?38260839C128989284T&zpar3=[[am1564851476418786d1379025341db88f81ee5c788391b]]', $url );
	}
}

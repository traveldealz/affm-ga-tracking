<?php
require_once 'subid-class.php';
class TestSubidAffilinet extends SubidTestClass {
	public function test_url_gets_subid_attached() {
		$url = $this->prli_target_url( 'https://partners.webmasterplan.com/click.aspx?ref=534603&site=15750&type=text&tnb=3&diurl=https%3A%2F%2Fflug.idealo.de%2Fflugroute%2FZuerich-ZRH%2FLissabon-LIS%2F%3Fpid%3Daffilinet%26idcamp%3D114%23tinyId%3DKvf8U%26utm_medium%3Daffiliate%26utm_source%3Daffilinet%26utm_campaign%3D534603%26affmt%3D2%26affmn%3D43%26pid%3Daffilinet%26idcamp%3D114', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://partners.webmasterplan.com/click.aspx?ref=534603&site=15750&subid=am1564851476418786d1379025341db88f81ee5c788391b&type=text&tnb=3&diurl=https%3A%2F%2Fflug.idealo.de%2Fflugroute%2FZuerich-ZRH%2FLissabon-LIS%2F%3Fpid%3Daffilinet%26idcamp%3D114%23tinyId%3DKvf8U%26utm_medium%3Daffiliate%26utm_source%3Daffilinet%26utm_campaign%3D534603%26affmt%3D2%26affmn%3D43%26pid%3Daffilinet%26idcamp%3D114', $url );
	}

	public function test_url_overrides_subid() {
		$url = $this->prli_target_url( 'https://partners.webmasterplan.com/click.aspx?ref=534603&site=15750&type=text&tnb=3&subid=test123', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://partners.webmasterplan.com/click.aspx?ref=534603&site=15750&type=text&tnb=3&subid=am1564851476418786d1379025341db88f81ee5c788391b', $url );
	}
}

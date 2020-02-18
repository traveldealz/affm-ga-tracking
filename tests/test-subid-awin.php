<?php
require_once 'subid-class.php';
class TestSubidAwin extends SubidTestClass {
	public function test_url_gets_subid_attached() {
		$url = $this->prli_target_url( 'https://www.awin1.com/awclick.php?gid=323861&mid=9399&awinaffid=135115&linkid=2052012', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://www.awin1.com/awclick.php?gid=323861&mid=9399&awinaffid=135115&clickref2=am1564851476418786d1379025341db88f81ee5c788391b&linkid=2052012', $url );
	}

	public function test_url_overrides_subid() {
		$url = $this->prli_target_url( 'https://www.awin1.com/awclick.php?gid=323861&mid=9399&awinaffid=135115&linkid=2052012&clickref2=test123', 'am1564851476418786d1379025341db88f81ee5c788391b' );
        $this->assertEquals( 'https://www.awin1.com/awclick.php?gid=323861&mid=9399&awinaffid=135115&linkid=2052012&clickref2=am1564851476418786d1379025341db88f81ee5c788391b', $url );
	}
}

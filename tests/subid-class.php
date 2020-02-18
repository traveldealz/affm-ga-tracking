<?php
class SubidTestClass extends WP_UnitTestCase {
	public function prli_target_url( $url, $subid ) {
		$_GET['subid'] = $subid;
		$prli = apply_filters( 'prli_target_url', [ 'url' => $url ] );
		return $prli['url'];
	}
}

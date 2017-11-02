<?php
if (!defined('ABSPATH')) die; //no direct access
/*
Plugin Name: AffM Google Analytics Tracking
Plugin URI: https://affm.travel-dealz.de
Description: Google Analytics Tracking for AffM
Version: 1.0.0
Author: Johannes Kinast
Author URI: https://affm.travel-dealz.de
Update Server: http://travel-dealz.de/wp-content/download/wp/
Min WP Version: 2.5.3
Max WP Version: 4.4
*/

//add_action( 'plugins_loaded', array( 'AffM_Tracking', 'init' ) );
//add_action('init', array('AffM_Tracking', 'init'));


new AffM_Tracking();

class AffM_Tracking {

	private $ga_id;

	public function init() {

	}

	public function __construct() {
		$this->ga_id = 'UA-1896878-6'; // Später in Optionen sichern

		add_filter( 'prli_target_url', array( $this, 'save_prli_clickout' ), 110 ); //priority has to be >99 to work with the feature "Target URL Rotation" of Prli Pro

	}

	public function save_prli_clickout( $prli ) {

		$url = parse_url( $prli['url'] );

		$networks = [
			'affili.net' => 'partners.webmasterplan.com',
			'zanox' => 'ad.zanox.com',
			'awin' => 'awin1.com',
			'webgains' => 'track.webgains.com',
			'financeads' => 'www.financeads.net',
			'phg' => 'prf.hn',
			'belboon' => 'www1.belboon.de',
		];

		if ( ! $network = array_search( $url["host"], $networks ) ) {
			return $prli;
		}

		$subid = $this->get_new_subid();

		switch ( $network ) {
			case 'affili.net':
				if ( strpos( $prli['url'], '&subid=' ) ) {
					$prli['url'] = preg_replace( '/\&subid=\w*/', '&subid=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\&site=\d*/', '${0}&subid=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'zanox':
				if ( strpos( $prli['url'], '&zpar3=' ) ) {
					$prli['url'] = preg_replace( '/\&zpar3=\[\[\w*]]/', '&zpar3=[[' . $subid . ']]', $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\?\d*C\d*/', '${0}&zpar3=[[' . $subid . ']]', $prli['url'], 1 );
				}
				break;
			case 'awin':
				if ( strpos( $prli['url'], '&clickref2=' ) ) {
					$prli['url'] = preg_replace( '/\&clickref2=\w*/', '&clickref2=' . $subid, 1 );
				} else {
					$prli['url'] = preg_replace( '/\&awinaffid=\d*/', '${0}&clickref2=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'webgains':
				if ( strpos( $prli['url'], '&clickref=' ) ) {
					$prli['url'] = preg_replace( '/\&clickref=\w*/', '&clickref=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\&wgprogramid=\d*/', '${0}&clickref=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'financeads':
				if ( strpos( $prli['url'], '&subid=' ) ) {
					$prli['url'] = preg_replace( '/\&subid=\w*/', '&subid=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/[?&]t=\w*/', '${0}&subid=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'phg':
				if ( strpos( $prli['url'], '/pubref:' ) ) {
					$prli['url'] = preg_replace( '/\/pubref:\w*/', '/pubref:' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\/camref:\w*/', '${0}/pubref:' . $subid, $prli['url'], 1 );
				}
				break;
			case 'belboon':
				$prli['url'] = preg_replace(
					[
						'/\w*\.html\?/', // If there is already a parameter like ?deeplink
						'/\w*\.html$/', // If there is no parameter after .html
					],
					[
						'${0}affm=' . $subid . '&',
						'${0}?affm=' . $subid,
					],
					$prli['url'],
					1
				);
				break;
			default:
				return $prli;
				break;
		}

		$this->send_transaction( $subid );
		$this->send_clickout_event( $subid );

		var_dump($prli);
		exit();

		return $prli;

	}

	private static function get_new_subid() {
		// PHP 7 only http://php.net/manual/en/function.random-bytes.php
		return 'am' . bin2hex( random_bytes( 23 ) ); // = 48 Zeichen
	}

	private function send_transaction( $subid ) {

		// https://ga-dev-tools.appspot.com/hit-builder/

		if ( ! $cliendId = $this->get_clientId() ) {
			return false;
		}

		$sendtransaction = [
			'v' => 1, // Protocol Version
			'tid' => $this->ga_id, // Google Analytics ID
			'cid' => $cliendId, //ClientId
			't' => 'transaction',
			'ti' => $subid, // Transaction ID: Subid
			'tr' => '0.00', //Transaction Revenue
			'dl' => $_SERVER["HTTP_REFERER"] ?: '', // Document location URL (from Referer)
		];

		var_dump( $sendtransaction );

		$url = 'https://www.google-analytics.com/collect' . '?' . http_build_query( $sendtransaction );

		$response = wp_remote_get( $url );
		//$body = wp_remote_retrieve_body( $response );

		if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		return true;
	}

	private function send_clickout_event( $subid ) {

		if ( ! $cliendId = $this->get_clientId() ) {
			return false;
		}

		$sendevent = [
			'v' => 1, // Protocol Version
			'tid' => $this->ga_id, // Google Analytics ID
			'cid' => $cliendId, //ClientId
			't' => 'event',
			'ec' => 'clickOut',
			'ea' => 'transaction',
			'el' => $subid, // Transaction ID: Subid
			'dl' => $_SERVER["HTTP_REFERER"] ?: '', // Document location URL (from Referer)
		];

		var_dump( $sendevent );

		$url = 'https://www.google-analytics.com/collect' . '?' . http_build_query( $sendevent );

		$response = wp_remote_get( $url );
		//$body = wp_remote_retrieve_body( $response );

		if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		return true;
	}

	private static function get_clientId() {
		// https://stackoverflow.com/questions/42865307/how-to-gather-google-analytics-client-id-server-side-from-a-get-request
		if ( ! $ga_cookie = $_COOKIE["_ga"] ) {
			return false;
		}

		return substr( $ga_cookie, 6);

	}

}

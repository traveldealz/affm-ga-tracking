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


add_filter( 'prli_target_url', array( new AffM_Tracking, 'save_prli_clickout' ), 110 );

class AffM_Tracking {

	/**
	 * Instance of the class
	 *
	 * @static
	 * @var    object
	 */
	protected static $instance;

	private $ga_id;

	public static function init() {
		null === self::$instance and self::$instance = new self;
		return self::$instance;
	}

	public function __construct() {
		$this->ga_id = 'UA-1896878-6'; // Später in Optionen sichern
	}

	public function save_prli_clickout( $prli ) {

		$url = parse_url( $prli['url'] );

		$networks = [
			'affili.net' => 'partners.webmasterplan.com',
			'zanox' => 'ad.zanox.com',
			'awin' => 'awin1.com',
			'webgains' => 'track.webgains.com',
			'financeads' => 'financeads.net',
			'phg' => 'prf.hn',
			'belboon' => 'www1.belboon.de',
			'tradedoubler' => 'clkde.tradedoubler.com',
			'adcell' => 'adcell.de',
			'tradetracker' => 'tc.tradetracker.net',
			'daisycon' => 'ds1.nl',
			'shareasale' => 'shareasale.com',
		];

		if ( false === $network = array_search( str_replace( 'www.', '', $url["host"] ), $networks ) ) {
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
			case 'tradedoubler':
				$prli['url'] = preg_replace(
					[
						'/\&g=\d*/', // normal url structur
						'/g\(\d*\)/', // url () structur
					],
					[
						'${0}&epi2=' . $subid,
						'${0}epi2(' . $subid . ')',
					],
					$prli['url'],
					1
				);
				break;
			case 'adcell':
				if ( strpos( $prli['url'], '/subId/' ) ) {
					$prli['url'] = preg_replace( '/\/subId\/\w*/', '/subId/' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\/slotId\/\d*/', '${0}/subId/' . $subid, $prli['url'], 1 );
				}
				break;
			case 'tradetracker':
				if ( strpos( $prli['url'], '&r=' ) ) {
					$prli['url'] = preg_replace( '/\&r=\w*/', '&r=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\&a=\d*/', '${0}&r=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'daisycon':
				if ( strpos( $prli['url'], '&ws3=' ) ) {
					$prli['url'] = preg_replace( '/\&ws3=\w*/', '&ws3=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\&li=\d*/', '${0}&ws3=' . $subid, $prli['url'], 1 );
				}
				break;
			case 'shareasale':
				if ( strpos( $prli['url'], '&afftrack=' ) ) {
					$prli['url'] = preg_replace( '/\&afftrack=\w*/', '&afftrack=' . $subid, $prli['url'], 1 );
				} else {
					$prli['url'] = preg_replace( '/\&[Mm]=\d*/', '${0}&afftrack=' . $subid, $prli['url'], 1 );
				}
				break;
			default:
				return $prli;
				break;
		}

		$this->send_clickout_event( $subid );

		//var_dump($prli);
		//exit();

		return $prli;

	}

	public static function get_new_subid() {
		// PHP 7 only http://php.net/manual/en/function.random-bytes.php
		return 'am' . bin2hex( random_bytes( 23 ) ); // = 48 Zeichen
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

		//var_dump( $sendevent );

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

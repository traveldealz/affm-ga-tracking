<?php
namespace AffM;

if (!defined('ABSPATH')) die
- - //no direct access

class Subid {

	public $url, $URL;

	public $networks = [
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
		'cj_1' => 'jdoqocy.com',
		'cj_2' => 'anrdoezrs.net',
		'cj_3' => 'tkqlhce.com',
		'cj_4' => 'kqzyfj.com',
		'cj_5' => 'dpbolvw.net',
		'financequality' => 'l.neqty.net',
	];

	public function __construct( string $url ) {
		$this->url = $url;
		$this->URL = parse_url( $url );
	}

	public function add_subid( string $subid ) {

		if ( false === $this->network = array_search( str_replace( 'www.', '', $this->URL["host"] ), $this->networks ) ) {
			return $this;
		}

		switch ( $this->network ) {
			case 'affili.net':
				if ( strpos( $this->url, '&subid=' ) ) {
					$this->url = preg_replace( '/\&subid=\w*/', '&subid=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&site=\d*/', '${0}&subid=' . $subid, $this->url, 1 );
				}
				break;
			case 'zanox':
				if ( strpos( $this->url, '&zpar3=' ) ) {
					$this->url = preg_replace( '/\&zpar3=\[\[\w*]]/', '&zpar3=[[' . $subid . ']]', $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\?\w*/', '${0}&zpar3=[[' . $subid . ']]', $this->url, 1 );
				}
				break;
			case 'awin':
				if ( strpos( $this->url, '&clickref2=' ) ) {
					$this->url = preg_replace( '/\&clickref2=\w*/', '&clickref2=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&awinaffid=\d*/', '${0}&clickref2=' . $subid, $this->url, 1 );
				}
				break;
			case 'webgains':
				if ( strpos( $this->url, '&clickref=' ) ) {
					$this->url = preg_replace( '/\&clickref=\w*/', '&clickref=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&wgprogramid=\d*/', '${0}&clickref=' . $subid, $this->url, 1 );
				}
				break;
			case 'financeads':
				if ( strpos( $this->url, '&subid=' ) ) {
					$this->url = preg_replace( '/\&subid=\w*/', '&subid=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/[?&]t=\w*/', '${0}&subid=' . $subid, $this->url, 1 );
				}
				break;
			case 'phg':
				if ( strpos( $this->url, '/pubref:' ) ) {
					$this->url = preg_replace( '/\/pubref:\w*/', '/pubref:' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\/camref:\w*/', '${0}/pubref:' . $subid, $this->url, 1 );
				}
				break;
			case 'belboon':
				$this->url = preg_replace(
					[
						'/\w*\.html\?/', // If there is already a parameter like ?deeplink
						'/\w*\.html$/', // If there is no parameter after .html
					],
					[
						'${0}affm=' . $subid . '&',
						'${0}?affm=' . $subid,
					],
					$this->url,
					1
				);
				break;
			case 'tradedoubler':
				$this->url = preg_replace(
					[
						'/\&g=\d*/', // normal url structur
						'/g\(\d*\)/', // url () structur
					],
					[
						'${0}&epi2=' . $subid,
						'${0}epi2(' . $subid . ')',
					],
					$this->url,
					1
				);
				break;
			case 'adcell':
				if ( strpos( $this->url, '/subId/' ) ) {
					$this->url = preg_replace( '/\/subId\/\w*/', '/subId/' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\/slotId\/\d*/', '${0}/subId/' . $subid, $this->url, 1 );
				}
				break;
			case 'tradetracker':
				if ( strpos( $this->url, '&r=' ) ) {
					$this->url = preg_replace( '/\&r=\w*/', '&r=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&a=\d*/', '${0}&r=' . $subid, $this->url, 1 );
				}
				break;
			case 'daisycon':
				if ( strpos( $this->url, '&ws3=' ) ) {
					$this->url = preg_replace( '/\&ws3=\w*/', '&ws3=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&li=\d*/', '${0}&ws3=' . $subid, $this->url, 1 );
				}
				break;
			case 'shareasale':
				if ( strpos( $this->url, '&afftrack=' ) ) {
					$this->url = preg_replace( '/\&afftrack=\w*/', '&afftrack=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&[Mm]=\d*/', '${0}&afftrack=' . $subid, $this->url, 1 );
				}
				break;
			case 'cj_3':
			case 'cj_4':
			case 'cj_5':
			case 'cj_1':
				if ( strpos( $this->url, '?sid=' ) ) {
					$this->url = preg_replace( '/\?sid=\w*/', '?sid=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/-\d+$/', '${0}?sid=' . $subid, $this->url, 1 );
				}
				break;
			case 'cj_2':
				if ( strpos( $this->url, '/type/dlg/' ) ) {
					if ( strpos( $this->url, '/sid/' ) ) {
						$this->url = preg_replace( '/\/sid\/\w*/', '/sid/' . $subid, $this->url, 1 );
					} else {
						$this->url = preg_replace( '/\/type\/dlg/', '${0}/sid/' . $subid, $this->url, 1 );
					}
				} elseif ( strpos( $this->url, '/click-' ) && false === strpos( $this->url, '?sid=' ) ) {
					$this->url = preg_replace( '/\/click-\d+-\d+$/', '${0}?sid=' . $subid, $this->url, 1 );
				}

				break;
			case 'financequality':
				if ( false === strpos( $this->url, '&subid=' ) ) {
					$this->url = preg_replace( '/\?fq=\w*=/', '${0}&subid=' . $subid, $this->url, 1 );
				}
				break;
			default:
				return $this;
				break;
		}

		return $this;

	}

	public function get() {
		return $this->url;
	}

}

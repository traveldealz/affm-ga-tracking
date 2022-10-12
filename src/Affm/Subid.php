<?php
namespace Affm;

class Subid {

	public $url, $URL;

	public $networks = [
		'awin1.com' => 'awin',
		'track.webgains.com' => 'webgains',
		'financeads.net' => 'financeads',
		'cdn.retailads.net' => 'financeads',
		'prf.hn' => 'partnerize',
		'clkde.tradedoubler.com' => 'tradedoubler',
		'clk.tradedoubler.com' => 'tradedoubler',
		'adcell.de' => 'adcell.de',
		't.adcell.com' => 'adcell.com',
		'tc.tradetracker.net' => 'tradetracker',
		'ds1.nl' => 'daisycon',
		'lt45.net' => 'daisycon',
		'shareasale.com' => 'shareasale',
		'jdoqocy.com' => 'cj',
		'anrdoezrs.net' => 'cj',
		'tkqlhce.com' => 'cj',
		'kqzyfj.com' => 'cj',
		'dpbolvw.net' => 'cj',
		'l.neqty.net' => 'financequality',
		'rover.ebay.com' => 'ebay',
		'pvn.saturn.de' => 'easyaffiliate',
		'pvn.mediamarkt.de' => 'easyaffiliate',
		'read.apartena.net' => 'easyaffiliate',
		'go.linkwi.se' => 'linkwise',
		'track.effiliation.com' => 'effiliation',
		'tracking.publicidees.com' => 'timeone',
		'campaign.mobility-ads.de' => 'coyotoaffiliate',
		'go2.travel-dealz.de' => 'traveldealz',
		'go2.travel-dealz.eu' => 'traveldealz',
		'affm.travel-dealz.de' => 'traveldealz',
		'affm.travel-dealz.eu' => 'traveldealz',
		'online.adservicemedia.dk' => 'adservice',
		'digidip.net' => 'digidip',
		'belboon.com' => 'belboon',
	];

	public $network = '';

	public function __construct( string $url ) {
		$this->url = $url;
		$this->URL = parse_url( $url );
	}

	public function add_subid( string $subid ) {
		$domain = str_replace( 'www.', '', $this->URL["host"] );

		$domain = str_contains($domain, 'digidip.net') ? 'digidip.net' : $domain;
		$domain = str_contains($this->url, 'amc=con.blbn.') ? 'belboon.com' : $domain;

		if ( isset( $this->networks[$domain] ) ) {
			$this->network = $this->networks[$domain];
		} elseif ( preg_match( '/\w+\.\w+\.\w+\/c\/\d+\/\d+\/\d+/', $this->url ) ) {
			// Impact Radius
			$this->network = 'impact';
		} elseif ( preg_match( '/\w+\.r\.\w+\.\w+\/ts\/i\d+\/tsc/', $this->url ) ) {
			// Ingenious
			$this->network = 'ingenious';
		} elseif ( str_contains( $this->url, 'a_aid=' ) ) {
			// PostAffiliatePro
			$this->network = 'postaffiliatepro';
		} else {
			return $this;
		}

		switch ( $this->network ) {
			case 'awin':
				if ( false === strpos( $this->url, 'clickref2=' ) ) {
					$this->url = preg_replace( '/\&awinaffid=\d*/', '${0}&clickref2=' . $subid, $this->url, 1 );
				}
				break;
			case 'webgains':
				if ( false === strpos( $this->url, 'clickref=' ) ) {
					$this->url = preg_replace( '/\&wgprogramid=\d*/', '${0}&clickref=' . $subid, $this->url, 1 );
				}
				break;
			case 'financeads':
				if ( false === strpos( $this->url, '&subid=' ) ) {
					$this->url = preg_replace( '/[?&]t=\w*/', '${0}&subid=' . $subid, $this->url, 1 );
				}
				break;
			case 'partnerize':
				if ( false === strpos( $this->url, '/pubref:' ) ) {
					$this->url = preg_replace( '/\/camref:\w*/', '${0}/pubref:' . $subid, $this->url, 1 );
				}
				break;
			case 'belboon':
				if ( false === str_contains( $this->url, 'smc3=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?smc3=' . $subid;
					} else {
						$this->url = $this->url . '&smc3=' . $subid;
					}
				}
				break;
			case 'tradedoubler':
				if ( false === strpos( $this->url, 'epi2' ) ) {
					$this->url = preg_replace(
						[
							'/\&a=\d+/', // normal url structur
							'/a\(\d+\)/', // url () structur
						],
						[
							'${0}&epi2=' . $subid,
							'${0}epi2(' . $subid . ')',
						],
						$this->url,
						1
					);
				}
				break;
			case 'adcell.de':
				if ( false === strpos( $this->url, '/subId/' ) ) {
					$this->url = preg_replace( '/\/slotId\/\d*/', '${0}/subId/' . $subid, $this->url, 1 );
				}
				break;
			case 'adcell.com':
				if ( false === strpos( $this->url, 'subId=' ) ) {
					$this->url = preg_replace( '/\&slotId=\d*/', '${0}&subId=' . $subid, $this->url, 1 );
				}
				break;
			case 'tradetracker':
				if ( 0 < strpos( $this->url, '&r=&' ) ) {
					$this->url = preg_replace( '/\&r=&/', '&r=' . $subid . '&', $this->url, 1 );
				} elseif( false === strpos( $this->url, 'r=' ) ) {
					$this->url = preg_replace( '/\&a=\d+/', '${0}&r=' . $subid, $this->url, 1 );
				}
				break;
			case 'daisycon':
				if ( false === strpos( $this->url, 'ws3=' ) ) {
					$this->url = preg_replace( '/\&li=\d+/', '${0}&ws3=' . $subid, $this->url, 1 );
				}
				break;
			case 'shareasale':
				if ( strpos( $this->url, '&afftrack=' ) ) {
					$this->url = preg_replace( '/\&afftrack=$/', '&afftrack=' . $subid, $this->url, 1 );
				} else {
					$this->url = preg_replace( '/\&[Mm]=\d*/', '${0}&afftrack=' . $subid, $this->url, 1 );
				}
				break;
			case 'cj':
				if ( false === strpos( $this->url, 'sid=' ) ) {
					if ( 0 < strpos( $this->url, '/type/dlg/' ) ) {
						$this->url = preg_replace( '/\/type\/dlg\//', '${0}sid/' . $subid . '/', $this->url, 1 );
					} elseif ( 0 < strpos( $this->url, '?' ) ) {
						$this->url = preg_replace( '/\?/', '?sid=' . $subid . '&', $this->url, 1 );
					} else {
						$this->url = $this->url . '?sid=' . $subid;
					}
				}
				break;
			case 'financequality':
				if ( false === strpos( $this->url, '&subid=' ) ) {
					$this->url = preg_replace( '/\?fq=\w*=/', '${0}&subid=' . $subid, $this->url, 1 );
				}
				break;
			case 'impact':
				if ( false === strpos( $this->url, 'subId2=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?subId2=' . $subid;
					} else {
						$this->url = preg_replace( '/\?/', '${0}subId2=' . $subid . '&', $this->url, 1 );
					}
				}
				break;
			case 'ingenious':
				if ( false === strpos( $this->url, 'smc3=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?smc3=' . $subid;
					} else {
						$this->url = preg_replace( '/\?/', '${0}smc3=' . $subid . '&', $this->url, 1 );
					}
				}
				break;
			case 'ebay':
				if ( false === strpos( $this->url, 'customid=' ) ) {
					$this->url = preg_replace( '/campid=\d+/', '${0}&customid=' . $subid, $this->url, 1 );
				}
				break;
			case 'easyaffiliate':
				if ( false === strpos( $this->url, 'subid=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?subid=' . $subid;
					} else {
						$this->url = preg_replace( '/\?/', '${0}subid=' . $subid . '&', $this->url, 1 );
					}
				}
				break;
			case 'linkwise':
				if ( false === strpos( $this->url, 'subid5=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?subid5=' . $subid;
					} else {
						$this->url = preg_replace( '/\?/', '${0}subid5=' . $subid . '&', $this->url, 1 );
					}
				}
				break;
			case 'effiliation':
				if ( false === strpos( $this->url, 'effi_id2=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?effi_id2=' . $subid;
					} else {
						$this->url = $this->url . '&effi_id2=' . $subid;
					}
				}
				break;
			case 'timeone':
				if ( false === strpos( $this->url, 'cb=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?cb=' . $subid;
					} else {
						$this->url = $this->url . '&cb=' . $subid;
					}
				}
				break;
			case 'coyotoaffiliate':
				if ( false === str_contains( $this->url, 'subIdentifier=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?subIdentifier=' . $subid;
					} else {
						$this->url = $this->url . '&subIdentifier=' . $subid;
					}
				} else {
					$this->url = preg_replace( '/subIdentifier=(?=\&|$)/', 'subIdentifier=' . $subid, $this->url, 1 );
				}
				break;
			case 'postaffiliatepro':
				if ( false === str_contains( $this->url, 'subID2=' ) ) {
					$this->url = $this->url . '&subID2=' . $subid;
				}
				break;
			case 'adservice':
				if ( false === str_contains( $this->url, 'sub2=' ) ) {
					$this->url = $this->url . '&sub2=' . $subid;
				}
				break;
			case 'digidip':
				if ( false === str_contains( $this->url, 'ref=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?ref=' . $subid;
					} else {
						$this->url = $this->url . '&ref=' . $subid;
					}
				}
				break;
			case 'traveldealz':
				if ( false === str_contains( $this->url, 'subid=' ) ) {
					if ( false === strpos( $this->url, '?' ) ) {
						$this->url = $this->url . '?subid=' . $subid;
					} else {
						$this->url = $this->url . '&subid=' . $subid;
					}
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

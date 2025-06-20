<?php
namespace AffM;

require_once( 'src/Affm/Subid.php' );

use AffM\Subid;

/*
 * Plugin Name: AffM Tracking
 * Plugin URI: https://affm.travel-dealz.de
 * Description: Link Tracking for AffM
 * Version: 3.1.0
 * Author: Johannes Kinast
 * Author URI: https://affm.travel-dealz.de
 * Min WP Version: 2.5.3
 * Max WP Version: 4.4
 */

function save_prli_clickout( $prli ) {

	if ( ! isset( $_GET['subid'] ) ) {
		return $prli;
	}

	$subid = urlencode( (string) $_GET['subid'] );

	$url = new Subid( $prli['url'] );
	$url->add_subid( $subid );

	$prli['url'] = $url->get();

	return $prli;

}
add_filter( 'prli_target_url',  __NAMESPACE__ . '\save_prli_clickout', 110 );

class AffM_Autolink {

	public array $destinations = [];
	public array $no_destinations = [];

	public array $blocklist = [
		'pvn.mediamarkt.de',
		'pvn.saturn.de',
	];

	public function is_affm_destination( array $hosts ): bool {
		foreach ($hosts as $host) {
			if ( in_array($host, $this->destinations) ) {
				return true;
			}
		}

		$hosts_not_found = [];
		foreach ($hosts as $host) {
			if ( false === in_array($host, $this->no_destinations) ) {
				$is_all_no_destination = false;
				$hosts_not_found[] = $host;
			}
		}
		if (empty($hosts_not_found)) {
			return false;
		}

		$hosts_to_query = [];
		foreach ($hosts_not_found as $host) {
			$destination = get_transient( 'affm_destination_' . $host );
			if (false !== $destination) {
				if ('no' === $destination) {
					$this->no_destinations[] = $host;
				} else {
					$this->destinations[] = $destination;
					return true;
				}
			} else {
				$hosts_to_query[] = $host;
			}
		}

		if (empty($hosts_to_query)) {
			return false;
		}

		$site_id = get_option('affm_site_id', 1);

		$response = wp_remote_get( 'https://affm.travel-dealz.de/api/sites/' . $site_id . '/ads/destinations?filter[destination]=' . urlencode(implode(',', $hosts_to_query)), [
			'timeout' => 6,
		] );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return true;
		}

		$destinations = array_values((array) json_decode( $response['body'] ));

		foreach ($destinations as $destination) {
			$this->destinations[] = $destination;
			set_transient( 'affm_destination_' . $destination, $destination, 24 * 60 * MINUTE_IN_SECONDS );
		}

		foreach ($hosts_to_query as $host) {
			if (false === in_array($host, $this->destinations)) {
				$this->no_destinations[] = $host;
				set_transient( 'affm_destination_' . $host, 'no', 60 * MINUTE_IN_SECONDS );
			}
		}

		if (!empty($destinations)) {
			return true;
		} else {
			return false;
		}
	}

	public function check_link( string $url ): bool {

		if ( str_contains($url, 'noaffm') || str_contains($url, 'mailto:') || str_contains($url, 'tel:') ) {
			return false;
		}

		$host = parse_url( $url,  PHP_URL_HOST );
		if ( null === $host || false === $host ) {
			return false;
		}
		$host = str_replace( ['www.', 'wwws.'], '', $host );

		if ( in_array( $host, $this->blocklist ) ) {
			return false;
		}

		$hosts = [$host];

		$host_parts = explode( '.', $host );

		if ( 3 === count($host_parts) ) {
			$hosts[] = $host_parts[count($host_parts) - 2] . '.' . $host_parts[count($host_parts) - 1];
		}

		if ( 4 === count($host_parts)) {
			$hosts[] = $host_parts[1] . '.' . $host_parts[2] . '.' . $host_parts[3];
		}

		return $this->is_affm_destination($hosts);
	}

	public function get_affm_url( string $url, ?string $referrer = null ): string {
		$site_id = get_option('affm_site_id', 1);
		$url = 'https://affm.travel-dealz.de/sites/' . $site_id . '/redirect?url=' . urlencode($url);

		$is_rest = defined( 'REST_REQUEST' ) && REST_REQUEST;
		if ( false === $is_rest ) {
			$referrer = $referrer ?: home_url( $_SERVER['REQUEST_URI'] );
			$url .= '&referrer=' . urlencode( $referrer );
		}
		return 'https://affm.travel-dealz.de/sites/' . $site_id . '/redirect?url=' . urlencode($url);
	}

	public function check_match( array $match ): string {
		$url = $match[1];

		// Check Link
		if ( false === $this->check_link( $url ) ) {
			return $match[0];
		}

		return str_replace( $url, $this->get_affm_url($url), $match[0] );
	}

	public function filter_the_content( $content ) {

		$content = preg_replace_callback(
			'/<a[^>]+href="([^"]+)"[^>]*>/',
			[$this, 'check_match'],
			$content
		);

		return $content;
	}

	public function filter_prettylink(array $prli): array {

		if ( $this->check_link( $prli['url'] ) ) {
			$referrer = $_SERVER['HTTP_REFERER'] ?? null;
			$prli['url'] = $this->get_affm_url($prli['url'], $referrer);
		}

		return $prli;
	}


}
$Autolink = new AffM_Autolink;
add_filter( 'the_content', [$Autolink, 'filter_the_content'], 10 );
add_filter( 'term_description', [$Autolink, 'filter_the_content'], 10 );
add_filter( 'comment_text', [$Autolink, 'filter_the_content'], 10 );
add_filter( 'prli_target_url',  [$Autolink, 'filter_prettylink'], 109 );

class AffM_Target {

	public string $domain;

	public function __construct()
	{
		$this->domain = parse_url( get_site_url(),  PHP_URL_HOST );
	}

	public function check_match( array $match ): string {
		$host = parse_url( $match[1],  PHP_URL_HOST );

		if ( ! $host ) {
			return $match[0];
		}

		if (
			$host === $this->domain
			&& ! str_contains( $match[1], '/go/')
			&& ! str_contains( $match[1], '/suche/')
			&& ! str_contains( $match[1], '/search/')
			&& ! str_contains( $match[1], '/flugsuche/')
			&& ! str_contains( $match[1], '/flightsearch/')
			&& ! str_contains( $match[1], '/flughotelsuche/')
			&& ! str_contains( $match[1], '/hotelsuche/')
			&& ! str_contains( $match[1], '/hotelsearch/')
			&& ! str_contains( $match[1], '/mietwagensuche/')
			&& ! str_contains( $match[1], '/rentalcarsearch/')
			&& ! str_contains( $match[1], '/hotelsearch/')
			&& ! str_contains( $match[1], '/buchen/')
			&& ! str_contains( $match[1], '/book/')
		) {
			return $match[0];
		}

		if ( str_contains( $match[0], '_blank' ) ) {
			return $match[0];
		}

		if ( str_contains( $match[0], 'onclick="' ) ) {
			return $match[0];
		}

		$count = 0;
		$match[0] = preg_replace( '/target="[^"]+"/', 'target="_blank"', $match[0], 1, $count );

		// if there is no target-paramter
		if ( 0 === $count ) {
			$match[0] = str_replace( 'href', 'target="_blank" href', $match[0] );
		}

		return $match[0];
	}

	public function filter_the_content( $content ) {

		if (!is_singular() || is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return $content;
		}

		$content = preg_replace_callback(
			'/<a[^>]+href="([^"]+)"[^>]*>/',
			[$this, 'check_match'],
			$content
		);

		return $content;
	}
}
$Target = new AffM_Target;
add_filter( 'the_content', [$Target, 'filter_the_content'], 10 );
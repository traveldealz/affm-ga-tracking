<?php
namespace AffM;

require_once( 'src/Affm/Subid.php' );

use AffM\Subid;

/*
 * Plugin Name: AffM Tracking
 * Plugin URI: https://affm.travel-dealz.de
 * Description: Link Tracking for AffM
 * Version: 3.0.1
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

	public function load_affm_destinations(): void {

		if ( false === ( $destinations = get_transient( 'affm_destinations' ) ) ) {

			$site_id = get_option('affm_site_id', 1);

			$response = wp_remote_get( 'https://affm.travel-dealz.de/api/sites/' . $site_id . '/ads/destinations', [
				'timeout' => 6,
			] );

			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				return;
			}

			$destinations = array_values((array) json_decode( $response['body'] ));

			set_transient( 'affm_destinations', $destinations, 10 * MINUTE_IN_SECONDS );

		}

		$this->destinations =  array_flip((array) $destinations);

	}

	public function check_link( string $url ): bool {

		if ( str_contains($url, 'noaffm') ) {
			return false;
		}

		if (! $this->destinations) {
			$this->load_affm_destinations();
		}

		$host = parse_url( $url,  PHP_URL_HOST );
		$host = str_replace( ['www.', 'wwws.'], '', $host );

		if ( isset( $this->destinations[$host] ) ) {
			return true;
		}

		$host_parts = explode( '.', $host );

		if ( 3 > count($host_parts) ) {
			return false;
		}

		$host_main = $host_parts[count($host_parts) - 2] . '.' . $host_parts[count($host_parts) - 1];

		return isset( $this->destinations[$host_main] );
	}

	public function get_affm_url( string $url): string {
		$site_id = get_option('affm_site_id', 1);
		return 'https://affm.travel-dealz.de/sites/' . $site_id . '/redirect?url=' . urlencode($url);
	}

	public function check_match( array $match ): string {
		$url = $match[1];

		// Add target="_blank" if missing


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
			$prli['url'] = $this->get_affm_url($prli['url']);
		}

		return $prli;
	}


}
$Autolink = new AffM_Autolink;
add_filter( 'the_content', [$Autolink, 'filter_the_content'], 10 );
add_filter( 'prli_target_url',  [$Autolink, 'filter_prettylink'], 109 );

class AffM_Target {

	public string $domain;

	public function __construct()
	{
		$this->domain = parse_url( get_site_url(),  PHP_URL_HOST );
	}

	public function check_match( array $match ): string {
		$host = parse_url( $match[1],  PHP_URL_HOST );

		if ( ! $host || $host === $this->domain ) {
			return $match[0];
		}

		if ( str_contains( $match[0], '_blank' ) ) {
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
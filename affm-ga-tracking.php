<?php
namespace AffM;

if (!defined('ABSPATH')) die
- - //no direct access
//require_once( 'vendor/autoload.php' );
require_once( 'src/subid.php' );

use AffM\Subid;

/*
Plugin Name
- - AffM Google Analytics Tracking
Plugin URI
- - https://affm.travel-dealz.de
Description
- - Google Analytics Tracking for AffM
Version
- - 1.0.0
Author
- - Johannes Kinast
Author URI
- - https://affm.travel-dealz.de
Update Server
- - http://travel-dealz.de/wp-content/download/wp/
Min WP Version
- - 2.5.3
Max WP Version
- - 4.4
*/

\add_filter( 'prli_target_url', 'Affm\save_prli_clickout', 110 );

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
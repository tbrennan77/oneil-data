<?php

/**
 * Template Name: ONEsuite Page Template
 *
 * This file adds the ONEsuite template. This file assumes that nothing has been moved
 * from the Genesis default.
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Page
 * @author     Travis Smith
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 */

/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

// Custom Filters and Actions
add_filter('body_class', 'gs_add_landing_body_class' );
add_filter('genesis_attr_entry-content', 'custom_add_css_attr' );
add_action('wp_enqueue_scripts', 'custom_load_custom_style_sheet' );
add_action('wp_enqueue_scripts', 'custom_load_custom_javascripts' );
	
/**
 * Add page specific body class
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 */
function gs_add_landing_body_class( $classes ) {
   $classes[] = 'landing';
   return $classes;
}

function custom_add_css_attr( $attributes ) {
 
 // add original plus extra CSS classes
 $attributes['class'] .= ' onesuite toggled-on';
 
 // return the attributes
 return $attributes;
 
}

add_action('genesis_after_header', 'set_background_image');

function set_background_image() {
    if ( is_singular( 'post' ) || ( is_singular( 'page' ) && has_post_thumbnail() ) ) {
            
        //$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : '' );
		$image = genesis_get_image( array( 'format' => 'url' ));

    } else {
        // the fallback – our current active theme's default bg image
        $image = get_background_image();
    }

    // And below, spit out the <style> tag... 
	if ($image <> '') {
	?>
    <style type="text/css" id="custom-background-css-override">
        .site-container {background: #435968 url('<?php echo $image; ?>') no-repeat center 124px!important; }
    </style>
	<?php 
	}
}

/**
 * Add other page specific css
 *
 */
function custom_load_custom_style_sheet() {
	wp_enqueue_style('onesuite-stylesheet', CHILD_URL . '/css/onesuite.css', array(), PARENT_THEME_VERSION );
	wp_enqueue_style('magnificent-popup-stylesheet', CHILD_URL . '/css/magnific-popup.css', array(), PARENT_THEME_VERSION );
}

function custom_load_custom_javascripts() {
	wp_enqueue_script('magnificent-popup-stylesheet', CHILD_URL . '/css/magnificPopup.js', array(), PARENT_THEME_VERSION );
}

}

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

genesis();
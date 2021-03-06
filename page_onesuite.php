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
add_filter('body_class', 'gs_add_landing_body_class');
add_filter('genesis_attr_entry-content', 'custom_add_css_attr');
add_action('wp_enqueue_scripts', 'custom_load_custom_style_sheet');
add_action('wp_enqueue_scripts', 'custom_load_custom_javascripts');


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
		
		@media only screen and (max-width: 1024px) {
			.site-container {
				background: #435968 url('<?php echo $image; ?>') no-repeat center 0px!important; 
				width: 100%;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: 100% auto;
			}
		}
    </style>
	<?php 
	}
}

/**
 *
 * Add other page specific css
 */
function custom_load_custom_style_sheet() {
	wp_enqueue_style('onesuite-stylesheet', CHILD_URL . '/css/onesuite.css', array(), PARENT_THEME_VERSION );
	wp_enqueue_style('magnificent-popup-stylesheet', CHILD_URL . '/css/magnific-popup.css', array(), PARENT_THEME_VERSION );
	
	// Gravity Forms style sheet only load on contact page
	if(is_page('contact-us')){
		wp_enqueue_style( 'gforms_reset_css-css', plugins_url() . '/gravityforms/css/formreset.min.css', array(), PARENT_THEME_VERSION );
		wp_enqueue_style( 'gforms_formsmain_css-css', plugins_url() . '/gravityforms/css/formsmain.min.css', array(), PARENT_THEME_VERSION );
		wp_enqueue_style( 'gforms_ready_class_css-css', plugins_url() . '/gravityforms/css/readyclass.min.css', array(), PARENT_THEME_VERSION );
		wp_enqueue_style( 'gforms_browsers_css-css', plugins_url() . '/gravityforms/css/browsers.min.css', array(), PARENT_THEME_VERSION );
	}

}

function custom_load_custom_javascripts() {
	wp_enqueue_script('magnificent-js', CHILD_URL . '/js/magnificPopup.js', array(), PARENT_THEME_VERSION );
	wp_enqueue_script('onesuite-js', CHILD_URL . '/js/onesuite.js', array(), PARENT_THEME_VERSION );
	
	if(is_page( 'contact-us' )) {
		gravity_form_enqueue_scripts(1, true );
	}
}

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

genesis();
<?php

/**
 * Template Name: Industry 2 Col Page Template
 *
 * This file adds the Industry template. This file assumes that nothing has been moved
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
 $attributes['class'] .= ' industry toggled-on';
 
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
		.site-inner {background: #fff url(http://www.boondockwalkerstaging.com/oneil/wp-content/themes/oneil-child-theme/images/industry-bg.png) repeat-x center 420px;}
		.after-post {background: transparent url();}
		.site-inner .wrap {max-width: 1152px;}
		.et_lb_module.et_lb_column.et_lb_1_2 {
			float: right !important;
			width: 45% !important;
			margin-top: 40px;
		}
		.et_lb_module.et_lb_column.et_lb_1_2.et_lb_first {
			float: left !important;
			width: 45% !important;
			margin-top: 40px;
		}
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
 * Add other page specific css
 *
 */
function custom_load_custom_style_sheet() {
	wp_enqueue_style('industry-stylesheet', CHILD_URL . '/css/industry.css', array(), PARENT_THEME_VERSION );
}


/** Force Layout */
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter('genesis_site_layout', '__genesis_return_full_width_content' );

genesis();
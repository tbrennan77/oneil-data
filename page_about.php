<?php

/**
 * Template Name: Standard Page Template
 *
 * This file adds the standard (default) interior page template. This file assumes that nothing has been moved
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
   $classes[] = 'about';
   return $classes;
}

function custom_add_css_attr( $attributes ) {
 
 // add original plus extra CSS classes
 $attributes['class'] .= ' standard toggled-on';
 
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
	wp_enqueue_style('onesuite-stylesheet', CHILD_URL . '/css/standard.css', array(), PARENT_THEME_VERSION );
}

function custom_layout() {

echo '<div id="standard-widgets" class="standard-widgets gs-standard-widgets-3">';
  echo '<div class="wrap">';

		genesis_widget_area('standard-one', array(
			'before' => '<div class="standard-widgets-1 widget-area first">',
			'after' => '</div>',
		) );
  
		genesis_widget_area('standard-two', array(
			'before' => '<div class="standard-widgets-2 widget-area first">',
			'after' => '</div>',
		) );

		genesis_widget_area('standard-three', array(
			'before' => '<div class="standard-widgets-3 widget-area first">',
			'after' => '</div>',
		) );

  echo '</div>';
echo '</div>';

}

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

genesis();
?>
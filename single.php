<?php

/**
 * Template Name: Single Post Template
 *
 * This file adds the template for posts
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

add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
add_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

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
		// $image = genesis_get_image( array( 'format' => 'url' ));
		//$image = wp_get_attachment_url(156, 'full');
		$image = wp_get_attachment_url( get_post_thumbnail_id(156, 'full') );	
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
	wp_enqueue_style('onesuite-stylesheet', CHILD_URL . '/css/blank.css', array(), PARENT_THEME_VERSION );
}

function custom_load_custom_javascripts() {
	wp_enqueue_script('news-js', CHILD_URL . '/js/news.js', array(), PARENT_THEME_VERSION );
}
/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );


/** Customize the post info function. */
add_filter( 'genesis_post_info', 'wpse_108715_post_info_filter' );

/** Customize the post meta function. */
add_filter( 'genesis_post_meta', 'wpse_108715_post_meta_filter' );

//genesis();

/**
 * Change the default post information line.
 */
function wpse_108715_post_info_filter( $post_info ) {
    $post_info = 'On [post_date]'; //'by [post_author_posts_link] on [post_date]';
    return $post_info;
}

/**
 * Change the default post meta line.
 */
function wpse_108715_post_meta_filter( $post_meta ) {
    $post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
    return $post_meta;
}

//add_action( 'genesis_after_header', 'genesis_do_subnav2' );

function genesis_do_subnav2(){
    wp_nav_menu( array( 'theme_location' => 'secondary-menu' ) );
}

genesis();
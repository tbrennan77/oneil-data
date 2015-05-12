<?php
 
/**
 * Template Name: Tag Template
 *
 * This file adds the template for tags
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Page
 * @author     Travis Smith
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 
*/

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5);
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15);

//* Remove the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8);


//* Add Image, Post Info, Title, Excerpt & Entry Footer Entry Meta
add_action( 'genesis_entry_header', 'genesis_do_post_image', 2);

//* Add Header Markup & Post Info 
add_action('genesis_entry_header', 'genesis_entry_header_markup_open', 5);
add_action('genesis_entry_header', 'genesis_post_info', 16);
add_action('genesis_entry_header', 'genesis_entry_header_markup_close', 15);

add_filter('body_class', 'archive_body_class' );
add_action('wp_enqueue_scripts', 'custom_load_custom_style_sheet');

/** Customize the post info function. */
add_filter('genesis_post_info', 'wpse_108715_post_info_filter' );

/** Customize the post meta function. */
add_filter('genesis_post_meta', 'wpse_108715_post_meta_filter' );

//genesis();

/**
 * Change the default post information line.
 */
function wpse_108715_post_info_filter( $post_info ) {
    $post_info = 'by [post_author_posts_link] on [post_date]';
    return $post_info;
}

/**
 * Change the default post meta line.
 */
function wpse_108715_post_meta_filter( $post_meta ) {
    $post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
    return $post_meta;
}

function archive_body_class( $classes ) {
   $classes[] = 'category-class';
   return $classes;
}
function custom_load_custom_style_sheet() {
	wp_enqueue_style('tag-stylesheet', CHILD_URL . '/css/onesuite.css', array(), PARENT_THEME_VERSION );
}
//* Run the Genesis loop
genesis();
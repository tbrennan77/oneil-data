	<?php

/**
 * Home Page.
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Home
 * @author     Travis Smith and Jonathan Perez, for Surefire Themes
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 */

add_action( 'get_header', 'gs_home_helper' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action('genesis_footer', 'genesis_do_footer');

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function gs_home_helper() {

        if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-01' ) || is_active_sidebar( 'home-middle-02' ) || is_active_sidebar( 'home-middle-03' ) || is_active_sidebar( 'home-bottom' ) ) {

                remove_action('genesis_loop', 'genesis_do_loop' );
                add_action('genesis_loop', 'gs_home_widgets' );
                add_action('genesis_before_footer', 'gs_home_widgets2');
				
                /** Force Full Width */
                add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
                add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
                
        }
}



/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function gs_home_widgets() {

        genesis_widget_area(
                'home-top', 
                array( 'before' => '<aside id="home-top" class="home-widget widget-area">', ) 
        );
        
        echo '<div id="home-middle" class="home-middle">';
        genesis_widget_area( 
                'home-middle-01', 
                array(
                        'before' => '<aside id="home-middle-01"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-left -->',
                ) 
        );

        echo '</div>';
        

        genesis_widget_area( 
                'home-bottom', 
                array(
                        'before' => '<aside id="home-bottom"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-bottom -->',
                ) 
        );                              
}

function gs_home_widgets2() {
	    genesis_widget_area( 
                'home-middle-02', 
                array(
                        'before' => '<div id="home-middle-02" class="site-inner-2"><div class="wrap"><div class="home-widget widget-area">', 
                        'after' => '</div></div></div><!-- end #home-middle -->',
                ) 
        );

        genesis_widget_area( 
                'home-middle-03', 
                array(
                        'before' => '<div id="home-middle-03" class="site-inner-3"><div class="wrap"><div class="home-widget widget-area">', 
                        'after' => '</div></div></div><!-- end #home-right -->',
                ) 
        );
}

genesis();
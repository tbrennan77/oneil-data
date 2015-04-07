<?php

/**
 * Custom amendments for the theme.
 *
 * @category   Genesis_Sandbox
 * @package    Functions
 * @subpackage Functions
 * @author     Travis Smith and Jonathan Perez
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://surefirewebservices.com/
 * @since      1.1.0
 */

// Initialize Sandbox ** DON'T REMOVE **
require_once( get_stylesheet_directory() . '/lib/init.php');

add_action( 'genesis_setup', 'gs_theme_setup', 15 );

//Theme Set Up Function
function gs_theme_setup() {
	
	//Enable HTML5 Support
	add_theme_support( 'html5' );

	//Enable Post Navigation
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	/** 
	 * 01 Set width of oEmbed
	 * genesis_content_width() will be applied; Filters the content width based on the user selected layout.
	 *
	 * @see genesis_content_width()
	 * @param integer $default Default width
	 * @param integer $small Small width
	 * @param integer $large Large width
	 */
	$content_width = apply_filters('content_width', 600, 430, 920 );
	
	//Custom Image Sizes
	add_image_size('featured-image', 225, 160, TRUE );
	
	// Enable Custom Background
	add_theme_support( 'custom-background' );

	// Enable Custom Header
	add_theme_support('genesis-custom-header');

	// Add support for after entry widget
	add_theme_support('genesis-after-entry-widget-area' );

	// Add support for structural wraps
	add_theme_support('genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'inner',
		'footer-widgets',
		'footer',
		'menu-footer'
	) );

	//* Add support for custom header
	add_theme_support( 'custom-header', array(
		'width'			=> 470,
		'height'		=> 100,
		'header-selector'	=> '.site-header .title-area',
		'header-text'		=> false
	) );
	/**
	 * 07 Footer Widgets
	 * Add support for 3-column footer widgets
	 * Change 3 for support of up to 6 footer widgets (automatically styled for layout)
	 */
	// add_theme_support( 'genesis-footer-widgets', 3 );

	/**
	 * 08 Genesis Menus
	 * Genesis Sandbox comes with 4 navigation systems built-in ready.
	 * Delete any menu systems that you do not wish to use.
	 */
	add_theme_support(
		'genesis-menus', 
		array(
			'primary'   => __( 'Primary Navigation Menu', CHILD_DOMAIN ), 
			'secondary' => __( 'Secondary Navigation Menu', CHILD_DOMAIN ),
			'footer'    => __( 'Footer Navigation Menu', CHILD_DOMAIN ),
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);
	
	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );
	
	//Enqueue Sandbox Scripts
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts' );
	
	/**
	 * 13 Editor Styles
	 * Takes a stylesheet string or an array of stylesheets.
	 * Default: editor-style.css 
	 */
	//add_editor_style();
	
	
	// Register Sidebars
	gs_register_sidebars();
	
	// Custom Actions
	unregister_sidebar('sidebar');
	unregister_sidebar('sidebar-alt');

	remove_action('genesis_footer', 'genesis_do_footer' );	// Remove Default Footer
	
	add_action('login_enqueue_scripts', 'my_login_logo' );  // Custom Login Page
	add_action('genesis_after_entry', 'gs_do_after_entry'); // Add Widget Area After Post
	add_action('genesis_footer', 'sp_custom_footer' );		// Custom Footer Design
	add_action( 'genesis_before_entry', 'reposition_entry_header' );	// Move the post title inside the content area
	
	add_filter( 'genesis_search_text', 'sp_search_text' );  // Custom Search box Text
	add_filter( 'genesis_footer_output', 'custom_footer_copyright' ); // Remove copyright text
	
} // End of Set Up Function

// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(
		array(
			'id'			=> 'home-top',
			'name'			=> __( 'Home: Slider', CHILD_DOMAIN ),
			'description'	=> __( 'This is where the slider widget goes.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-01',
			'name'			=> __( 'Home: Featured Solutions', CHILD_DOMAIN ),
			'description'	=> __( 'This is where the two featured solutions posts go.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-02',
			'name'			=> __( 'Home: Recent News and Success', CHILD_DOMAIN ),
			'description'	=> __( 'This is the recent news and featured news item go.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-03',
			'name'			=> __( 'Home: OneSuite', CHILD_DOMAIN ),
			'description'	=> __( 'This is the OneSuite section. This is where the text widgets go.', CHILD_DOMAIN ),
		),
		/*array(
			'id'			=> 'home-bottom',
			'name'			=> __( 'Home Bottom', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'portfolio',
			'name'			=> __( 'Portfolio', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase your portfolio.', CHILD_DOMAIN ),
		),*/
		array(
			'id'            => 'header-right',
			'name'         	=> __( 'Header Search', CHILD_DOMAIN ),
			'description'  	=> __( 'This is where the search widget for the header goes.', CHILD_DOMAIN ),
		),
		array(
			'id' 			=> 'footer-one',
			'name' 			=> __( 'Footer: Contact Info', CHILD_DOMAIN ),
			'description' 	=> __( 'This is where you enter your logo and contact info.', CHILD_DOMAIN ),
		),
		array(
			'id' 			=> 'footer-two',
			'name' 			=> __( 'Footer: Links', CHILD_DOMAIN ),
			'description' 	=> __( 'This is where you can put links or additional content.', CHILD_DOMAIN ),
		),
		/*array(
			'id' 			=> 'footer-three',
			'name' 			=> __( 'Footer Content', CHILD_DOMAIN ),
			'description' 	=> __( 'This is where you can put links or additional content.', CHILD_DOMAIN ),
		),*/
		array(
			'id' 			=> 'footer-social',
			'name' 			=> __( 'Footer: Social', CHILD_DOMAIN ),
			'description' 	=> __( 'This is where you can put social icons.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-post',
			'name'			=> __( 'Request a Quote', CHILD_DOMAIN ),
			'description'	=> __( 'This content will display after every page content.', CHILD_DOMAIN ),
		),
	);
	
	foreach ( $sidebars as $sidebar )
		genesis_register_sidebar( $sidebar );
}

/**
 * Enqueue and Register Scripts - Twitter Bootstrap, Font-Awesome, and Common.
 */
require_once('lib/scripts.php');

/**
 * Add navigation menu 
 * Required for each registered menu.
 * 
 * @uses gs_navigation() Sandbox Navigation Helper Function in gs-functions.php.
 */

//Add Mobile Menu
function gs_mobile_navigation() {
	
	$mobile_menu_args = array(
		'echo' => true,
	);
	
	gs_navigation( 'mobile', $mobile_menu_args );
}

function gs_do_after_entry() {
 	if (  is_singular( array( 'page' )) ) {
 	genesis_widget_area( 
                'after-post', 
                array(
                        'before' => '<aside id="after-post" class="after-post"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-left -->',
                ) 
        );
 }
 }

// Custom Login Logo
function my_login_logo() { ?>

	    <style type="text/css">
		body {background: url('http://localhost:8080/oneildata/wp-content/themes/oneil-child-theme/images/login-bg.png') no-repeat top center fixed;}
		body.login div#login {width: 500px;}
        body.login div#login h1 a {
            background-image: url('http://www.oneildata.com/wp-content/themes/oneil/css/assets/logo.png');
            padding-bottom: 30px;
			background-size: 201px;
			width: 201px;
			height: 40px;
        }
		#login {padding: 80px 0 0;}
		.login form {background: transparent; -webkit-box-shadow: none; box-shadow: none;}
		.login label {font-size: 18px; color: #fff;}
		.login form .input {
			background: transparent;
			padding: 10px;
			border: 3px solid #fff;
			border-radius: 10px;
			color: #fff;
			font-size: 28px;
		}
		.login #backtoblog a, .login #nav a {
			color: #fff;
			font-size: 15px;
		}
		.login #nav {
			margin: 0;
			width: 200px;
			float: right;
		}
		.login #backtoblog {
			margin: 0;
			float: left;
		}	
    </style>
<?php }

/**
* Add Widget area to right header
*/
function right_header_widget() {
	if (is_active_sidebar('header-right') ) {
		genesis_widget_area('header-right', array(
			'before' => '<div class="header-right">',
			'after'  => '</div>',
		) );
	}
}

function sp_search_text( $text ) {
	return esc_attr( 'Search' );
}


function sp_custom_footer() {

echo '<div id="footer-widgets" class="footer-widgets gs-footer-widgets-3">';
  echo '<div class="wrap">';

		genesis_widget_area('footer-one', array(
			'before' => '<div class="footer-widgets-1 widget-area first one-third">',
			'after' => '</div>',
		) );
  
		genesis_widget_area('footer-two', array(
			'before' => '<div class="footer-widgets-2 widget-area first one-third">',
			'after' => '</div>',
		) );

		genesis_widget_area('footer-three', array(
			'before' => '<div class="footer-widgets-3 widget-area first one-third">',
			'after' => '</div>',
		) );

  echo '</div>';
  echo '<div class="nav-footer">';
			$args = array(
					'theme_location'  => 'footer',
					'container'       => 'nav',
					'container_class' => 'wrap',
					'menu_class'      => 'menu genesis-nav-menu menu-footer',
					'depth'           => 1,
				);
			wp_nav_menu( $args );
    echo '</div>';
    echo '<div class="wrap">';
			genesis_widget_area('footer-social', array(
			'before' => '<div class="social-icons">',
			'after' => '</div>',
		) );
	echo '</div>';
	
echo '</div>';


	
}

// Register and Hook Footer Navigation Menu
// add_action('genesis_before_footer', 'sample_footer_menu', 10);
function sample_footer_menu() {

	register_nav_menu( 'footer', 'Footer Navigation Menu' );
	
	genesis_nav_menu( array(
		'theme_location' => 'footer',
		'menu_class'     => 'menu genesis-nav-menu menu-footer',
	) );
}

//* Move Post Title and Post Info from inside Entry Header to Entry Content on Posts page
function reposition_entry_header() {

	if (!is_home() ) {

		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		//add_action( 'genesis_entry_content', 'genesis_do_post_title', 9 );
		//add_action( 'genesis_entry_content', 'genesis_post_info', 9 );

	}

}


function custom_footer_copyright( $output ) {

	$output = sprintf();
	return $output;

}
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
	add_image_size('featured-image-lg', 400, 225, true );
	
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
			'industry'  => __( 'Industry Navigation Menu', CHILD_DOMAIN ),
			'onesuite'  => __( 'OneSuite Navigation Menu', CHILD_DOMAIN ),
			'about'     => __( 'About Navigation Menu', CHILD_DOMAIN ),
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
	add_action('genesis_before_entry', 'reposition_entry_header' );	// Move the post title inside the content area
	
	add_filter('genesis_search_text', 'sp_search_text' );  // Custom Search box Text
	add_filter('genesis_search_form', 'new_search_form', 10, 4);
	add_filter('genesis_footer_output', 'custom_footer_copyright' ); // Remove copyright text
	
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
		array(
			'id'			=> 'standard-one',
			'name'			=> __( 'Standard: Featured News', CHILD_DOMAIN ),
			'description'	=> __( 'This content will display the featured news item on ', CHILD_DOMAIN ),
		),	
		array(
			'id'			=> 'careers-one',
			'name'			=> __( 'Careers Page Header', CHILD_DOMAIN ),
			'description'	=> __( 'This content will display above the job postings ', CHILD_DOMAIN ),
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
function new_search_form( $form, $search_text, $button_text, $label ) {

		$form = '<form method="get" class="searchform search-form" action="' . home_url() . '" >' . $label . '
		<input type="search" value="' . esc_attr( $search_text ) . '" name="q" class="s search-input"' . $onfocus . $onblur . ' />
		<input type="submit" value="' . esc_attr( $button_text ) . '" />
		</form>
		<span class="client-login"><i class="fa fa-lock"></i><a href="https://oneview.oneildata.com/ONEsuite/Default.aspx" target="_blank">Client Login</a></span>';

		return $form;

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

	if (!is_home() && !is_single() && !is_category() ) {

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


$my_custom_post_types = array(
	'job_postings' => array(
		'config' => array(
			'labels' => array(
				'name' 				=> 'Careers',
				'singular_name' 	=> 'Career',
				'add_new'			=> 'Add Job Posting',
				'add_new_item'		=> 'Add New Job Posting',
				'edit_item'			=> 'Edit Job Posting',
			),
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'supports' 				=> array('title')
		),
		'panels' => array(
			'description_meta' => array(
				'config' => array(
					'label' => 'Job Details',
				),
				'content' => array(
					array(
						'name' => 'job_description',
						'label' => 'Description',
						'type' => 'wysiwyg',
					),
					array(
						'name' => 'job_duties',
						'label' => 'Duties',
						'type' => 'wysiwyg',
					),
					array(
						'name' => 'job_qualif',
						'label' => 'Qualifications',
						'type' => 'wysiwyg',
					),
				)
			),
			'location_meta' => array(
				'config' => array(
					'label' => 'Location',
				),
				'content' => array(
					array(
						'name' => 'job_location',
						'label' => 'Location',
						'type' => 'textarea',
					),
				)
			),
			'details_meta' => array(
				'config' => array(
					'label' => 'Additional Information',
				),
				'content' => array(
					array(
						'name' => 'job_pdf',
						'label' => 'Application File',
						'type' => 'file',
					),
					array(
						'name' => 'job_type',
						'label' => 'Position Type',
						'type' => 'select',
						'options' => array(
							'Contract',
							'Full Time',
							'Part Time',
							'Intership',
						)
					),
					array(
						'name' => 'job_details',
						'label' => 'More Details',
						'type' => 'wysiwyg',
					),
				)
			),
		),
		'taxonomies' => array(
			'job_department' => array(
				"hierarchical" => true, 
				"label" => "Job Departments",
				"singular_label" => "Job Department",
				"rewrite" => false,
				"name"=>"job_department",
			),
		),
		/*
		'columns' => array(
			'labels' => array(
				'cb' => '<input type="checkbox" />',
				'title'=> 'Title',
				'description' => 'Description',
				'start' => 'Start (lbs)',
				'end' => 'End (lbs)',
				'weeks' => 'Months',
			),
			'values' => array(
				'title' 		=> '%story_name%',
				'description'	=> '%story_content%',
				'start' 		=> '%story_start%',
				'end' 			=> '%story_end%',
				'weeks' 		=> '%story_weeks%',
			)
		),
		*/
	),
);

/* Create custom post types */
function admin_init(){
	global $my_custom_post_types;
	if(is_array($my_custom_post_types) && count($my_custom_post_types)){
		foreach($my_custom_post_types as $post_name => $custom_post){
			register_post_type($post_name,$custom_post['config']);
			flush_rewrite_rules();
			if(isset($custom_post['columns']) && count($custom_post['columns'])){
				add_filter("manage_edit-".$post_name."_columns", "custom_edit_columns");
			}
			if(is_array($custom_post['taxonomies']) && count($custom_post['taxonomies'])){
				foreach($custom_post['taxonomies'] as $taxonomy_id => $taxonomy){
					register_taxonomy($taxonomy_id, array($post_name), $taxonomy);
				}
			}
		}
	}
}
add_action("init", "admin_init");
/* Configures the post custom types created before */
function custom_posts_config(){
	global $my_custom_post_types;
	if(is_array($my_custom_post_types) && count($my_custom_post_types)){
		foreach($my_custom_post_types as $post_name => $custom_post){
			if(is_array($custom_post['panels']) && count($custom_post['panels'])){
				foreach($custom_post['panels'] as $panel_id => $panel){
					add_meta_box($panel_id, $panel['config']['label'], 'generate_form', $post_name, "normal", "low",$panel['content']);
				}
			}
		}
	}
}
add_action("admin_init", "custom_posts_config");
/* Helper function to generate the form depending on the fields and its types */
function generate_form($post,$arg1){
	global $post;
	$custom = get_post_custom($post->ID);
	//wp_debug($arg1);
	$data = $arg1['args'];
	if(is_array($data) && count($data)){
		?>
		<table>
			<?php
			foreach($data as $field){
				?>
				<tr style="border-bottom:#CCC solid 1px;">
					<th style="text-align:right;padding:10px;font-weight:bold;width:220px;">
						<label for="input_<?php echo $field['name']?>"><?php echo ucwords($field['label'])?>:</label>
					</th>
					<td style="text-align:left;padding:10px;">
						<?php
						switch($field['type']){
							case 'image':
								echo '<input type="file" id="input_'.$field['name'].'" style="width:400px;" size="40" name="'.$field['name'].'" /><br /><br />';
								echo ucwords($field['label']).':<br />';
								echo '<img style="color:red;max-width:60px" src="'.$custom[$field['name']][0].'" alt="Can\'t load image" />';
								break;
							case 'file':
								$value = "";
								if(isset($custom[$field['name']][0])){
									$value = $custom[$field['name']][0];
								}
								echo '<input type="file" id="input_'.$field['name'].'" style="width:400px;" size="40" name="'.$field['name'].'" /><br /><br />';
								if(!empty($value)){
									echo '<small>Current file: <a href="'.$value.'" target="_blank">'.basename($value).'</a></small>';
								}
								break;
							case 'textarea':
								echo '<textarea cols="40" rows="10" id="input_'.$field['name'].'" style="width:400px;height:100px;border:#CCC solid 1px;" name="'.$field['name'].'">'.$custom[$field['name']][0].'</textarea>';
								break;
							case 'select':
								$value = $custom[$field['name']][0];
								echo '<select id="input_'.$field['name'].'" style="width:400px;" name="'.$field['name'].'">';
								if(isset($field['options']) && is_array($field['options']) && count($field['options'])){
									foreach($field['options'] as $key => $option){
										$selected = '';
										if($value == $option){
											$selected = 'selected="selected"';
										}
										echo "\n".'<option '.$selected.'>'.$option.'</option>';
									}
								} else {
									'<option enabled="disabled">No options specified</option>';
								}
								echo '</select>';
								break;
							case 'wysiwyg':
								echo '<textarea cols="40" rows="10" id="input_'.$field['name'].'" name="'.$field['name'].'" class="tinymce">'.$custom[$field['name']][0].'</textarea>';
								echo '<script>
									jQuery(document).ready(function(){
										jQuery(\'#input_'.$field['name'].'\').addClass("mceEditor");
										if(typeof(tinyMCE) == "object" && typeof(tinyMCE.execCommand == "function")){
											tinyMCE.execCommand("mceAddControl",false,"input_'.$field['name'].'");
										}
									});
								</script>';
								break;
							case 'message':
								echo '<small>'.$field['message'].'</small>';
								break;
							default:
								echo '<input type="text" id="input_'.$field['name'].'" name="'.$field['name'].'" style="width:400px;" value="'.$custom[$field['name']][0].'" />';
								break;
						}
						?>
					</td>
				</tr>
				<?php
				echo '<p>';
			}
			?>
			<tr>
				<td colspan="2" style="text-align:right;padding-top:20px;">
					<input type="submit" value="Update" class="button-primary" />
				</td>
			</tr>
		</table>
		<?php
	}
}
/* This function takes care of saving the information of each custom post type */
function save_details($post_id = null){
	global $my_custom_post_types, $post;
	if(!isset($post_id) || is_null($post_id)){
		$post_id = $post->ID;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return $post_id;
	}
	if(isset($_POST) && count($_POST)){
		if(isset($my_custom_post_types[$_POST['post_type']])){
			$post_data = $my_custom_post_types[$_POST['post_type']];
			$panels_data = array();
			if(is_array($post_data['panels']) && count($post_data['panels'])){
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				foreach($post_data['panels'] as $panel_id => $panel_data){
					$data = $panel_data['content'];
					if(is_array($data) && count($data)){
						foreach($data as $field){
							switch($field['type']){
								case 'image':
								case 'file':
									if(!empty($_FILES[$field['name']]['name'])){
										$override['action'] = 'editpost';
										$uploaded_file = wp_handle_upload($_FILES[$field['name']], $override);
										
										$post_id = $post->ID;
										$attachment = array(
											'post_title' => $_FILES[$field['name']]['name'],
											'post_content' => '',
											'post_type' => 'attachment',
											'post_parent' => $post_id,
											'post_mime_type' => $_FILES[$field['name']]['type'],
											'guid' => $uploaded_file['url']
										);
										// Save the data
										$id = wp_insert_attachment( $attachment,$_FILES[$field['name']][ 'file' ], $post_id );
										wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $_FILES[$field['name']]['file'] ) );
										update_post_meta($post_id, $field['name'], $uploaded_file['url']);
									}
									break;
								default:
									if(isset($_POST[$field['name']])){
										update_post_meta($post_id, $field['name'], $_POST[$field['name']]);
									}
									break;
							}
						}
					}
				}
			}
		}
	}
}
add_action('save_post', 'save_details');

function fileupload_metabox_header(){
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('form#post').attr('enctype','multipart/form-data');
	jQuery('form#post').attr('encoding','multipart/form-data');
});
</script>
<?php
}
add_action('admin_head', 'fileupload_metabox_header');

add_action("manage_posts_custom_column",  "custom_columns_values");
function custom_columns_values($column){
	global $post;
	global $my_custom_post_types;
	
	$column_values = $my_custom_post_types[$post->post_type]['columns']['values'];
	if(isset($column_values[$column])){
		$custom = get_post_custom();
		$custom_field = str_replace('%','',$column_values[$column]);
		if(isset($custom[$custom_field]) && !empty($custom[$custom_field])){
			echo substr(strip_tags($custom[$custom_field][0]),0,150);
		}
	}
}
function custom_edit_columns($column){
	global $post;
	global $my_custom_post_types;
	return $my_custom_post_types[$post->post_type]['columns']['labels'];
}

/* Saving post filter */
function careers_formatter($content) {
	global $post;
	$new_content = $content;
	if($post->post_type == 'job_postings'){
		$new_content = '';
		$new_content = str_replace(
			array(
				'<h1>',
				'<h2>',
				'<h3>',
				'<h4>',
				'<h5>',
				'<ul>'
			),
			array(
				'<h3 class="h4">',
				'<h3 class="h4">',
				'<h3 class="h3">',
				'<h3 class="h4">',
				'<h3 class="h4">',
				'<ul class="group-list">'
			),
			$content
		);
	}
	return $new_content;
}
add_filter('the_content', 'careers_formatter', 99);


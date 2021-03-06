<?php
 
/**
 * Template Name: Job Postings Custom Template
 *
 * This file adds the template for categories
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Page
 * @author     Travis Smith
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 
 
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
	wp_enqueue_style('onesuite-stylesheet', CHILD_URL . '/css/standard.css', array(), PARENT_THEME_VERSION );
	wp_enqueue_style('magnificent-popup-stylesheet', CHILD_URL . '/css/magnific-popup.css', array(), PARENT_THEME_VERSION );
}
function custom_load_custom_javascripts() {
	wp_enqueue_script('magnificent-js', CHILD_URL . '/js/magnificPopup.js', array(), PARENT_THEME_VERSION );
	wp_enqueue_script('careers-js', CHILD_URL . '/js/careers.js', array(), PARENT_THEME_VERSION );
}

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );



/** Replace the standard loop with our custom loop */
remove_action('genesis_loop', 'genesis_do_loop' );
add_action('genesis_loop', 'wnd_do_custom_loop' );
  
function wnd_do_custom_loop() { 

        genesis_widget_area(
                'careers-one', 
                array( 'before' => '<aside id="careers-top" class="home-widget widget-area">',
						'after' => '</aside><!-- end #home-left -->',) 
        );
            
	the_content();			

?>
<div class="standard-intro-copy">
<section id="content" class="group careers">
	<div class="wrap">
		<nav id="content-nav" class="half left">		
			<ul class="primary half left">
				<li><h3>Opportunities Available</h3></li>
				<?php
				$i = 0;
				$custom;
				$post_id = 0;
				$job = "";
				
				$job_postings = new WP_Query(array(
					'post_type' => 'job_postings'
				));
				
				if($job_postings->have_posts()){
					
					while($job_postings->have_posts()): $job_postings->the_post();
					global $post;  // Add this line and you're golden
					//echo $post->ID;
					
					$job = get_post_meta( $post->ID, 'job_location', true);
					
					if($i == 0)
					{
						$post_id = $post->ID;
					}
					$i++;
					?>
					<li <?php echo $selected?>><a href="<?php the_permalink()?>"><?php the_title()?></a>
						<?php if(!empty($job)) {?>
							<br /><span><?php echo $job; ?></span></li>
						<?php } ?>
					</li>
					<?php
					endwhile;
					wp_reset_postdata();
				} else {
					?>
					<li class="healthcare-nav">No job opportunities available</li>
					<?php
				}
				
				$custom = get_post_custom($post_id);
				?>
			</ul>

			
			<?php
			if(isset($custom['job_pdf'][0]) && !empty($custom['job_pdf'][0])) {
				$app_doc = $custom['job_pdf'][0];
			} else {
				$app_doc = get_option('cfct_job_app');
			}
			?>
			<div class="half right">
				<ul class="secondary">
					<?php if(isset($custom['job_description'][0]) && !empty($custom['job_description'][0])) {?>
						<li><a href="#job_description">Description</a></li>
					<?php } ?>
					<?php if(isset($custom['job_duties'][0]) && !empty($custom['job_duties'][0])) {?>
						<li><a href="#job_duties">Duties</a></li>
					<?php } ?>
					<?php if(isset($custom['job_qualifications'][0]) && !empty($custom['job_qualifications'][0])) {?>
						<li><a href="#job_qualifications">Qualifications</a></li>
					<?php } ?>
					<?php if(isset($custom['job_location'][0]) && !empty($custom['job_location'][0])) {?>
						<li><a href="#job_location">Location</a></li>
					<?php } ?>
					<li><a href="#job_details">More Details</a></li>
					<li><a href="#job_apply">How to Apply?</a></li>
					<li class="list-emphasis"><a href="<?php echo $app_doc?>" target="_blank">Download Application</a></li>
					<li class="list-emphasis"><a href="#top">Back to top &uarr;</a></li>
					<li class="apply-btn"><span><a href="#">Apply Now!</a></span></li>
				</ul>

			</div>
		</nav>
		<article class="main right">
			<header>
				<h2 class="h2"><?php echo get_the_title($post_id);?></h2>
			</header>
			
			<?php if(isset($custom['job_description'][0]) && !empty($custom['job_description'][0])) {?>
				<h3 class="h3" id="job_description">Job Description</h3>
				<?php echo careers_formatter($custom['job_description'][0])?>
			<?php } ?>
			<?php if(isset($custom['job_duties'][0]) && !empty($custom['job_duties'][0])) {?>
				<h3 class="h3" id="job_duties">Job Duties</h3>
				<?php echo careers_formatter($custom['job_duties'][0])?>
			<?php } ?>
			<?php if(isset($custom['job_qualifications'][0]) && !empty($custom['job_qualifications'][0])) {?>
				<h3 class="h3" id="job_qualifications">Qualifications</h3>
				<?php echo careers_formatter($custom['job_qualifications'][0])?>
			<?php } ?>
			<?php if(isset($custom['job_location'][0]) && !empty($custom['job_location'][0])) {?>
				<h3 class="h3" id="job_location">Location</h3>
				<p><?php echo nl2br($custom['job_location'][0])?></p>
			<?php } ?>
			
			<h3 class="h3" id="job_details">More Details</h3>
			<?php
			$os_list = wp_get_object_terms( get_the_ID(), 'job_department');
			if(is_array($os_list) && count($os_list)){
				$department = $os_list[0]->name;
			}
			?>
			<?php echo careers_formatter($custom['job_details'][0]);?>
			<ul class="group-list">
				<li><strong>Department:</strong> <?php echo $department?></li>
				<li><strong>Position Type:</strong> <?php echo $custom['job_type'][0]?></li>
			</ul>
			
			<h3 class="h3" id="job_apply">How to Apply?</h3>
			<ol class="group-list">
				<li><a href="<?php echo $app_doc; ?>" target="_blank">Download the Application Form</a></li>
				<li>Fill out your information</li>
				<li>Click on the "Apply Now" button below</li>
				<li>Fill out your information. Make sure you attach the Application Form.</li>
			</ol>
			
			<p class="button"><br />
				<?php if(isset($custom['job_pdf'][0]) && !empty($custom['job_pdf'][0])) {?>
				<span><a target="_blank" href="<?php echo $app_doc?>">Download Application Form</a></span>
				<br />
				<?php } ?>
				<span><a class="popup-modal btn" href="#test-modal">Apply Now!</a></span>
			</p>
		</article>
		<div class="gray-notch"></div>
	</div>
</section>
</div>
<div id="test-modal" class="white-popup-block mfp-hide">
	<h1>Apply Now</h1>
	<?php gravity_form(5, true, true, false, null, true); ?>
	<p><a class="popup-modal-dismiss" href="#">Close</a></p>
</div>
<?php 
}
     
genesis();
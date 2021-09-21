<?php
/**
 * test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}


add_action('wp_enqueue_style','removestyle',50);

if ( ! function_exists( 'test_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function test_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on test, use a find and replace
		 * to change 'test' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'test', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'test' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'test_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
      );
      // adding a x-large image for cover images 
      add_image_size( 'x-large', 1920, 1920, false );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'test_content_width', 640 );
}
add_action( 'after_setup_theme', 'test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'test_widgets_init' );


/* Adding google api for maps */
function my_acf_google_map_api( $api ){
	
	$api['key'] = 'AIzaSyAQv7MHjN6tfMOEEa8TmJFHnXCC2PENSp8';
	
	return $api;
	
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
/* / Adding google api for maps */





/**
 * Enqueue scripts and styles.
 */
function test_scripts() {
	wp_enqueue_style( 'test-style', get_stylesheet_uri(), array(), '4.0.1' );
   wp_style_add_data( 'test-style', 'rtl', 'replace' );
   
   wp_enqueue_script( 'jquery-3.5.1', get_template_directory_uri() . '/js/jquery-3.5.1.min.js'); 

   wp_enqueue_script( 'test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
   
   /* wp_enqueue_script( 'universal-navigation', get_template_directory_uri() . '/js/universalNavigation.js' ); */

   wp_enqueue_script( 'section-expand', get_template_directory_uri() . '/js/sectionExpand.js' );
   




   /*get post content with ajax*/
      wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/js/ajax-pagination.js', array( 'jquery' ), '1.0', true );

      global $wp_query;
      wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(
         'ajaxurl' => admin_url( 'admin-ajax.php' ),
         'query_vars' => json_encode( $wp_query->query )
      ));
   /* / get post content with ajax*/

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}  

add_action( 'wp_enqueue_scripts', 'test_scripts' );

add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );

/* enables console.log for debugging php*/
   function console_log($output, $with_script_tags = true) {
      $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
   ');';
      if ($with_script_tags) {
         $js_code = '<script>' . $js_code . '</script>';
      }
      echo $js_code;
   }
/* / enables console.log for debugging php*/
function my_ajax_pagination() {

   $post_id = json_decode( stripslashes( $_POST['query_vars'] ), true );
   //print_r($query_vars);
/*    $content =  get_the_content( $post_id ); ;

   $post = get_post( $post_id , ARRAY_A); */

   
    
   
   $post['thumbnail_url'] = get_the_post_thumbnail_url( $post_id, 'x-large' );
   $post['event_start_time'] = get_field('event_start_time', $post_id);
   $post['event_type'] = get_field('event_type', $post_id);
   $post['short_description'] = get_field('short_description', $post_id);
   $post['tag_candidates'] = get_field('tag_candidates', $post_id);
   $post['event_end_time'] = get_field('event_end_time', $post_id);
   $post['event_venue'] = get_field('event_venue', $post_id);
   $post['temp_address'] = get_field('temp_address', $post_id);
   $post['location_type'] = get_field('location_type', $post_id);
   $post['location_type_online_url'] = get_field('location_type_online_url', $post_id);
   $post['location_physical'] = get_field('location_physical', $post_id);
   $post['post_title'] = get_the_title($post_id);
   $post['post_content'] = get_the_content(412);
   
   echo json_encode($post); 
   //echo get_post($query_vars);
   die();
}



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}








/**
 * Adding odoo features
 */
require_once ( get_template_directory() . '/odoo-shortcodes.php' );

/* Adding sorting by ACF to  CPT  events */
add_action( 'elementor/query/events_sorted_by_date', function( $query ) {
   $query->set( 'meta_key', 'event_start_date_time' );
   $query->set( 'orderby', 'event_start_date_time' );
   $query->set( 'order', 'ASC' );
});


/*
/*
 * filter the arguments to get my custom posts
 * args - original arguments
 * $widgetControlsValues - all the values of the current widget. 
 * it can be used for the post list
 */
function sortEventsByDate($args, $widgetControlsValues){
	
   /* Sorts posts "kurser" by starting date  */

   /* $date_now = date('YmdHis'); */
   $date_now = date('Y-m-d H:i:s');


	
   $args = array(
      'posts_per_page'	=> -1,
      'category'		=> 'event',
   
      'meta_query'	=> array(
         
         array(
            'key'		=> 'event_start_time',
            'value'		=> $date_now,
            'type' => 'DATETIME',
            'compare'	=> '>=' 
         )
      ), 

      'orderby' => 'meta_value',
      'meta_key' => 'event_start_time', 
      'order' => 'ASC'
   );
    
					
	return($args);
}

add_filter("sort_events_by_date", "sortEventsByDate", 10, 2);


function sortCandidateEventsByDate($args, $widgetControlsValues){

   $date_now = date('Y-m-d H:i:s');
	
   $currentPost =  get_the_id();

   $args = array(
      'posts_per_page'	=> -1,
      'category'		=> 'event',
   
      'meta_query'	=> array(
         'relation'		=> 'AND',
         array(
            'key'		=> 'tag_candidates',
            'value'		=> $currentPost,
            'compare'	=> 'LIKE' 
         ),
         array(
            'key'		=> 'event_start_time',
            'value'		=> $date_now,
            'type' => 'DATETIME',
            'compare'	=> '>=' 
         )
      ),

      'orderby' => 'meta_value',
      'meta_key' => 'event_start_time', 
      'order' => 'ASC'
   );
   
   return($args);
}

add_filter("sortCandidateEventsByDate", "sortCandidateEventsByDate", 10, 2);




/* New post from category */

function set_category () {

   global $post;
 //Check for a category parameter in our URL, and sanitize it as a string
   $category_slug = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING, array("options" => array("default" => 0)));

 //If we've got a category by that name, set the post terms for it
   if ( $category = get_category_by_slug($category_slug) ) {
       wp_set_post_terms( $post->ID, array($category->term_id), 'category' );
   }

}

//hook it into our post-new.php specific action hook
add_action( 'admin_head-post-new.php', 'set_category', 10, 1 );

/* formidable - filters by */
add_filter('frm_setup_new_fields_vars', 'frm_populate_posts', 20, 2);
add_filter('frm_setup_edit_fields_vars', 'frm_populate_posts', 20, 2); //use this function on edit too
function frm_populate_posts($values, $field){
  if($field->id == 6){ //replace 125 with the ID of the field to populate
   
   $date_now = date('Y-m-d H:i:s');
   
   $posts = get_posts( array(
      'posts_per_page'	=> 5,
      'category'		=> 'event',
   
      'meta_query'	=> array(
         'relation'		=> 'AND',
            array(
               'key'		=> 'event_type',
               'value'		=> 'event_activist',
               'compare'	=> '=' 
            ),
            array(
               'key'		=> 'event_start_time',
               'value'		=> $date_now,
               'type' => 'DATETIME',
               'compare'	=> '>=' 
            )
         ),

      'orderby' => 'meta_value',
      'meta_key' => 'event_start_time', 
      'order' => 'ASC'
   ));
    unset($values['options']);
    $values['options'] = array(''); //remove this line if you are using a checkbox or radio button field
    $values['options'][''] = ''; //remove this line if you are using a checkbox or radio button field

    foreach($posts as $p){
      /* $date_now = date('YmdHis');
      $compare_time = get_field('event_start_time', $p->ID, false );
      $compare_time = preg_replace("/[^0-9]/", "", $compare_time); */
      
      $start_time = get_field('event_start_time', $p->ID );
      $end_time = get_field('event_end_time', $p->ID );
      $short_desc = get_field('short_description', $p->ID );
      $values['options'][$p->ID] = $p->post_title.': '.$start_time.' – '.$end_time;
      
            
      
    }
    $values['use_key'] = false; //this will set the field to save the post ID instead of post title
    unset($values['options'][0]);
  }
  return $values;
}


/* / Test formidable*/


/* AFC event time validation */

function afc_validate_event_time( $valid, $event_start_value, $field, $input_name ) {
   $event_start_value = preg_replace("/[^0-9]/", "", $_POST['acf']['field_60cb2a218ceb5']);
   $event_end_value = preg_replace("/[^0-9]/", "", $_POST['acf']['field_60cb2b568ceb6']);
  
   // Bail early if value is already invalid.
   if( $valid !== true ) {
       return $valid;
   }
   
   // Prevent value from saving if it contains the companies old name.
   if( $event_start_value > $event_end_value  !== false ) {
       return __( 'Eventen skal slutte senere end den starter - med mindre du har lånt sekretariatets tidsmaskine' );
   }
   return $valid;
}

add_filter('acf/validate_value/name=event_start_time', 'afc_validate_event_time', 10, 4);
add_filter('acf/validate_value/name=event_end_time', 'afc_validate_event_time', 10, 4);

/* / AFC event time validation */

?>
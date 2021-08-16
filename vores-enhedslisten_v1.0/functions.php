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
	// wp_enqueue_style( 'test-style', get_stylesheet_uri(), array(), _S_VERSION );
   //wp_style_add_data( 'test-style', 'rtl', 'replace' );
   
   wp_enqueue_script( 'jquery-3.5.1', get_template_directory_uri() . '/js/jquery-3.5.1.min.js'); 

   wp_enqueue_script( 'test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
   
   wp_enqueue_script( 'universal-navigation', get_template_directory_uri() . '/js/universalNavigation.js' );

   wp_enqueue_script( 'section-expand', get_template_directory_uri() . '/js/sectionExpand.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'test_scripts' );

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
	
    $args[post_type] = kurser;
    $args[orderby] = meta_value;
    $args[meta_key] = 'event_start_date_time'; 
    $args[order] = ASC;
    
					
	return($args);
}

add_filter("sort_events_by_date", "sortEventsByDate", 10, 2);

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

/*Test formidable*/
add_filter('frm_setup_new_fields_vars', 'frm_populate_posts', 20, 2);
add_filter('frm_setup_edit_fields_vars', 'frm_populate_posts', 20, 2); //use this function on edit too
function frm_populate_posts($values, $field){
  if($field->id == 6){ //replace 125 with the ID of the field to populate
    $posts = get_posts( array('post_type' => 'post', 'post_status' => array('publish', 'private'), 'numberposts' => 999, 'orderby' => 'title', 'order' => 'ASC'));
    unset($values['options']);
    $values['options'] = array(''); //remove this line if you are using a checkbox or radio button field
    $values['options'][''] = ''; //remove this line if you are using a checkbox or radio button field
    foreach($posts as $p){
      $values['options'][$p->ID] = $p->post_title;
    }
    $values['use_key'] = false; //this will set the field to save the post ID instead of post title
    unset($values['options'][0]);
  }
  return $values;
}
/* / Test formidable*/




?>
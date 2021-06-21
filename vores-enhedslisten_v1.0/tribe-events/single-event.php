<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>
<!-- content-event.php -->
<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>

<!--   Calendar time variables -->
   <?php
      /**
       * Single Event Meta (Details) Template
      *
      * Override this template in your own theme by creating a file at:
      * [your-theme]/tribe-events/modules/meta/details.php
      *
      * @link http://evnt.is/1aiy
      *
      * @package TribeEventsCalendar
      *
      * @version 4.6.19
      */


      $event_id             = Tribe__Main::post_id_helper();
      $time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
      $time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
      $show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
      $time_zone_label      = Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

      $start_datetime = tribe_get_start_date();
      $start_date = tribe_get_start_date( null, false );
      $start_time = tribe_get_start_date( null, false, $time_format );
      $start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

      $end_datetime = tribe_get_end_date();
      $end_date = tribe_get_display_end_date( null, false );
      $end_time = tribe_get_end_date( null, false, $time_format );
      $end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

      $time_formatted = null;
      if ( $start_time == $end_time ) {
         $time_formatted = esc_html( $start_time );
      } else {
         $time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
      }

      /**
       * Returns a formatted time for a single event
      *
      * @var string Formatted time string
      * @var int Event post id
      */
      $time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

      /**
       * Returns the title of the "Time" section of event details
      *
      * @var string Time title
      * @var int Event post id
      */
      $time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'the-events-calendar' ), $event_id );

      $cost    = tribe_get_formatted_cost();
      $website = tribe_get_event_website_link();
      $url = tribe_get_event_website_url( $event );
   ?>
<!-- / Calendar time variables -->

<!--   Location variables -->
<?php
/**
 * Address Module Template
 * Render an address. This is used by default in the single event view.
 *
 * This view contains the filters required to create an effective address module view.
 *
 * You can recreate an ENTIRELY new address module by doing a template override, and placing
 * a address.php file in a tribe-events/modules/ directory within your theme directory, which
 * will override the /views/modules/address.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$venue_id = get_the_ID();

$full_region = tribe_get_full_region( $venue_id );

?>
<!-- / Location variables -->




<!-- content-page.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- <header class="entry-header">
		<?php /* the_title( '<h1 class="entry-title">', '</h1>' ); */ ?>
	</header> --><!-- .entry-header -->
   <?php if ( has_post_thumbnail() ):  ?> 
      <section id="coverImg" style="--bg-img:url(<?php the_post_thumbnail_url( 'x-large' ); ?>)" > </section>
   <?php endif; ?> 
         
   

   <?php if( get_the_post_thumbnail_caption() ): ?>
         <h6 class="coverImg-caption"> <?php the_post_thumbnail_caption() ;  ?> </h6>
   <?php endif; ?>

<div class="headerContainer">
   <?php if( get_field('event_title') ): ?> 
            <h1> <?php the_field('event_title'); ?></h1> 
         <?php else : the_title( '<h1>', '</h1>' ); ?>
         <?php endif; ?> 
         <?php if( get_field('minor_header') ): ?> 
            <h2> <?php the_field('minor_header'); ?></h2> 
   <?php endif; ?>
</div>

<?php if( get_field('event_short_description') ): ?> 
   <div id="kicker"> 
      <?php the_field('event_short_description'); ?>
   </div> 
<?php endif; ?>

<div class="factbox event-factbox"> 
<!--   script for google maps rendering -->
   <script>
   function my_acf_google_map_api( $api ){
      $api['key'] = 'AIzaSyAQv7MHjN6tfMOEEa8TmJFHnXCC2PENSp8';
      return $api;
   }
   add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
   </script>
   <style type="text/css">
   .acf-map {
      width: 100%;
      height: 250px;
      border: #ccc solid 1px;
      margin: 20px 0;
   }

   // Fixes potential theme css conflict.
   .acf-map img {
      max-width: inherit !important;
   }
   </style>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQv7MHjN6tfMOEEa8TmJFHnXCC2PENSp8"></script>
   <script type="text/javascript">
   (function( $ ) {

   /**
   * initMap
   *
   * Renders a Google Map onto the selected jQuery element
   *
   * @date    22/10/19
   * @since   5.8.6
   *
   * @param   jQuery $el The jQuery element.
   * @return  object The map instance.
   */
   function initMap( $el ) {

      // Find marker elements within map.
      var $markers = $el.find('.marker');

      // Create gerenic map.
      var mapArgs = {
         zoom        : $el.data('zoom') || 16,
         mapTypeId   : google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map( $el[0], mapArgs );

      // Add markers.
      map.markers = [];
      $markers.each(function(){
         initMarker( $(this), map );
      });

      // Center map based on markers.
      centerMap( map );

      // Return map instance.
      return map;
   }

   /**
   * initMarker
   *
   * Creates a marker for the given jQuery element and map.
   *
   * @date    22/10/19
   * @since   5.8.6
   *
   * @param   jQuery $el The jQuery element.
   * @param   object The map instance.
   * @return  object The marker instance.
   */
   function initMarker( $marker, map ) {

      // Get position from marker.
      var lat = $marker.data('lat');
      var lng = $marker.data('lng');
      var latLng = {
         lat: parseFloat( lat ),
         lng: parseFloat( lng )
      };

      // Create marker instance.
      var marker = new google.maps.Marker({
         position : latLng,
         map: map
      });

      // Append to reference for later use.
      map.markers.push( marker );

      // If marker contains HTML, add it to an infoWindow.
      if( $marker.html() ){

         // Create info window.
         var infowindow = new google.maps.InfoWindow({
               content: $marker.html()
         });

         // Show info window when marker is clicked.
         google.maps.event.addListener(marker, 'click', function() {
               infowindow.open( map, marker );
         });
      }
   }

   /**
   * centerMap
   *
   * Centers the map showing all markers in view.
   *
   * @date    22/10/19
   * @since   5.8.6
   *
   * @param   object The map instance.
   * @return  void
   */
   function centerMap( map ) {

      // Create map boundaries from all map markers.
      var bounds = new google.maps.LatLngBounds();
      map.markers.forEach(function( marker ){
         bounds.extend({
               lat: marker.position.lat(),
               lng: marker.position.lng()
         });
      });

      // Case: Single marker.
      if( map.markers.length == 1 ){
         map.setCenter( bounds.getCenter() );

      // Case: Multiple markers.
      } else{
         map.fitBounds( bounds );
      }
   }

   // Render maps on page load.
   $(document).ready(function(){
      $('.acf-map').each(function(){
         var map = initMap( $(this) );
      });
   });

   })(jQuery);
   </script>

<!-- / script for google maps rendering -->



<!--   event time section -->

    
      <h5>Varighed</h5><p><?php echo $start_datetime.' – '.$end_datetime ?></p>
   
<!-- / event time section -->

<!--   location section -->
   <?php if( get_field('event_physlcal') ) : ?>
      <?php if( have_rows('event_physical_info') ):
         while( have_rows('event_physical_info') ): the_row(); ?>
            <?php if( get_sub_field('event_physical_title') ): ?> 
               <h5>Sted</h5><h6><?php the_sub_field('event_physical_title'); ?></h6>
            <?php endif; ?>
            <?php if( get_sub_field('event_physical_desc') ): ?>
               <p><?php the_sub_field('event_physical_desc'); ?></p>
            <?php endif; ?>
            <?php if( get_sub_field('event_physical_location') ): ?>
               <?php $location = get_sub_field('event_physical_location'); ?>
               
               <div class="acf-map">
                     <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
               </div>      
         <?php endif; ?> 
      <?php endwhile; 
      endif; ?>  
   <?php else : ?>
      <?php if( get_field('event_online_desc') ): ?>
      <h5>Online</h5> 
         <p><?php the_field('event_online_desc'); ?></p>
      <?php endif; ?>
      <?php if( get_field('event_online_location') ): ?> 
         <a href="<?php the_field('event_online_location'); ?>" class="btn btn-success btn-medium btn-inline-block">Start nu</a> 
      <?php endif; ?>
   <?php endif; ?>



<!--   adresse fra cal -->
   <h5>Adresse</h5>
   <?php
   // This location's street address.
   if ( tribe_get_address( $venue_id ) ) : ?>
   <span class="tribe-street-address"><?php echo tribe_get_address( $venue_id ); ?></span>
      <?php if ( ! tribe_is_venue() ) : ?>
         <span class="tribe-delimiter">,</span>
      <?php endif; ?>
   <?php endif; ?>

   <?php
   // This location's postal code.
   if ( tribe_get_zip( $venue_id ) ) : ?>
      <span class="tribe-postal-code"><?php echo tribe_get_zip( $venue_id ); ?></span>
   <?php endif; ?>

   <?php
   // This locations's city.
   if ( tribe_get_city( $venue_id ) ) :?>
      
      <span class="tribe-locality"><?php echo tribe_get_city( $venue_id ); ?></span>
   <?php endif; ?>

   <?php
   // This location's country.
   if ( tribe_get_country( $venue_id ) ) : ?> <span class="tribe-delimiter">,</span>
      <span class="tribe-country-name"><?php echo tribe_get_country( $venue_id ); ?></span>
   <?php endif; ?>
<!-- / adresse fra cal -->

<!-- / location section -->

<!--   sign up section -->






      <?php if( $website ): ?> 
      
         <a href="<?php echo $url ?>" class="btn btn-success btn-medium btn-inline-block">Tilmeld dig nu</a>      
      <?php endif; ?>



   





      


   <?php if( get_field('sign_up_required') ) : ?>
      <?php if( get_field('sign_up_end_date') ): ?> 
         <h5>Tilmeldingsfrist</h5><p><?php the_field('sign_up_end_date'); ?></p>     
      <?php endif; ?>
      <?php if( $website ): ?> 
         <a href="<?php echo $website; ?>"class="btn btn-success btn-medium btn-inline-block">Tilmeld dig nu</a>      
      <?php endif; ?>
   <?php endif; ?>
<!-- / sign up section -->

 </div>





	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'test' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'test' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
<!-- / content-page.php -->
<!-- #post-->
<!-- / content-event.php --> 

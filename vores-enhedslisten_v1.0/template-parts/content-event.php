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
   <?php if( get_field('event_start_date_time') ): ?> 
      <h5>Varighed</h5><p><?php the_field('event_start_date_time'); ?>
   <?php endif; ?>
   <?php if( get_field('event_end_date_time') ): ?> 
      – <?php the_field('event_end_date_time'); ?></p>
   <?php endif; ?>
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
               <h5>Adresse</h5>
               <p class="address"><?php echo $location['address']; ?></p>
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
<!-- / location section -->

<!--   sign up section -->
   <?php if( get_field('sign_up_required') ) : ?>
      <?php if( get_field('sign_up_end_date') ): ?> 
         <h5>Tilmeldingsfrist</h5><p><?php the_field('sign_up_end_date'); ?></p>     
      <?php endif; ?>
      <?php if( get_field('sign_up_link') ): ?> 
         <a href="<?php the_field('sign_up_link'); ?>"class="btn btn-success btn-medium btn-inline-block">Tilmeld dig nu</a>      
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

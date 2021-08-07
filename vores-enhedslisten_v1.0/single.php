<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package test
 */

get_header();
?>
<!-- single.php -->
	<main id="primary" class="site-main">
   
		<?php echo "<!-- 00 -->";
      while ( have_posts() ) :
         echo "<!-- 01 -->";
			the_post();
         echo "<!-- 02 -->";
         




         /* the_content();  */
         /*get post type*/
         $isEvent;
         $this_post = get_the_ID();
         $thisPostType = get_post_type($this_post);
         /* / get post type*/

         /*get post categories*/
         $post_categories = wp_get_post_categories( $this_post );
         $cats = array();
         /* / get post categories*/   
         /*make a search for event in category slug */
         foreach($post_categories as $c){
            $cat = get_category( $c );
            $cats[$c] =   $cat->slug ;
         }
         
         $as_event = array_search(event , $cats, true );
         $as_candidates = array_search(candidates , $cats, true );
         /* / make a search for event in category slug */
         if ( $as_event != '') : {
            get_template_part('template-parts/content', 'event');
         }
         elseif ( $as_candidates != '') : {
            get_template_part('template-parts/content', 'candidates');
         }
          
         elseif ( $thisPostType == kurser): {
            get_template_part('template-parts/content', 'event');
         } else : 
            get_template_part( 'template-parts/content', get_post_type() );
         endif;  
         echo "<!-- 03 -->";
         $next_post = get_next_post();
         $prev_post = get_previous_post();
			the_post_navigation(

            
				array(
					'prev_text' => '<span class="nav-subtitle"><span class="icon_arrow-l_white_medium"></span>'.get_the_post_thumbnail($prev_post->ID,'thumbnail').'<span class="nav-title">%title</span></span>',
					'next_text' => '<span class="nav-subtitle">'.get_the_post_thumbnail($next_post->ID,'thumbnail').'<span class="nav-title">%title</span><span class="icon_arrow-r_white_medium"></span></span>',
				)
			);
         echo "<!-- 04 -->";
			// If comments are open or we have at least one comment, load up the comment template.
         if ( comments_open() || get_comments_number() ) :
            echo "<!-- 05 -->";
            comments_template();
            echo "<!-- 06 -->";
			endif;
         echo "<!-- 07 -->";
      endwhile; // End of the loop.
      echo "<!-- 08 -->";
		?>

	</main><!-- #main -->

<!-- END single.php -->
<?php
get_sidebar();
get_footer();

<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>
<!-- content.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if (is_singular() ) :  ?>
   <!-- single -->
   <section id="coverImg" 
      <?php if ( has_post_thumbnail() ):  ?> 
         style="--bg-img:url(<?php the_post_thumbnail_url( 'x-large' ); ?>)" 
      <?php endif; ?> 
      > 
            
   </section>
   <div class="headerContainer">
      <?php if( get_field('page_header') ): ?> 
         <h1> <?php the_field('page_header'); ?></h1> 
      <?php else : the_title( '<h1>', '</h1>' ); ?>
      <?php endif; ?>

      <?php if( get_field('minor_header') ): ?> 
         <h2> <?php the_field('minor_header'); ?></h2> 
      <?php endif; ?>
      
   </div>
   <?php if( get_field('kicker') ): ?> 
         <div id="kicker"> 
            <?php the_field('kicker'); ?>
         </div> 
   <?php endif; ?>
<?php else : ?>
<!-- not single -->

   <section id="coverImg" 
      <?php if ( has_post_thumbnail() ):  ?> style="--bg-img:url(<?php the_post_thumbnail_url( 'medium-large' ); ?>)"
      <?php endif; ?> > 
      <?php the_title( '<h5 class="entry-title "><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
   </section>
         
<?php endif; ?>
<!-- .entry-header -->

<!-- / .entry-header -->
	<?php	if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				test_posted_on();
				test_posted_by();
				?>
			</div><!-- .entry-meta -->
	<?php endif ; ?>
	
   <?php if (is_singular() ) :  ?>
      <div class="entry-content">
         <?php
         the_content(
            sprintf(
               wp_kses(
                  /* translators: %s: Name of current post. Only visible to screen readers */
                  __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'test' ),
                  array(
                     'span' => array(
                        'class' => array(),
                     ),
                  )
               ),
               wp_kses_post( get_the_title() )
            )
         );

         wp_link_pages(
            array(
               'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'test' ),
               'after'  => '</div>',
            )
         );
         ?>
      </div><!-- .entry-content -->
   <?php endif; ?>

	<footer class="entry-footer">
		<?php test_entry_footer(); ?>
	</footer><!-- .entry-footer -->
   
</article><!-- #post-->
<!-- / content.php --> 

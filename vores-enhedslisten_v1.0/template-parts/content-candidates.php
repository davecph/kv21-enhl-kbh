<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

?>
<!-- content-candidates.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if (is_singular() ) :  ?>
         <!-- single -->

         <section id="coverImg" 
            <?php if ( has_post_thumbnail() ):  ?> 
               style="--bg-img:url(<?php the_post_thumbnail_url( 'medium_large' ); ?>)" 
            <?php endif; ?> 
            > 
            
         </section>
         <section id="personImg" 
            <?php if ( has_post_thumbnail() ):  ?> style="--bg-img:url(<?php the_post_thumbnail_url( 'medium' ); ?>)"
            <?php endif; ?> > 
         </section>
      <?php else : ?>
         <!-- not single -->
         
            <section id="coverImg" 
               <?php if ( has_post_thumbnail() ):  ?> style="--bg-img:url(<?php the_post_thumbnail_url( 'medium' ); ?>)"
               <?php endif; ?> > 
               <?php the_title( '<h5 class="entry-title "><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
            </section>


         
      <?php endif; ?>
<!-- .entry-header -->
   <?php if (is_singular() ) :  ?>
      <header class="headerContainer">
         <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
   
      </header>
   <?php endif; ?>
<!-- / .entry-header -->

	
   <?php if (is_singular() ) :  ?>
      <div class="entry-content">

         
         <?php endif; ?><?php if (get_field('candidate_text')) : ?>
            <?php the_field('candidate_text'); ?>  
         <?php endif; ?>











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
      <div class="factbox">
         <?php if (get_field('sex')) : ?>
            <h6>Køn: <span class="fw-light"><?php the_field('sex'); ?></span></h6>
         <?php endif; ?>
         <?php if (get_field('age')) : ?>
            <h6>Alder: <span class="fw-light"><?php the_field('age'); ?></span>  </h6>
         <?php endif; ?><?php if (get_field('afdeling')) : ?>
            <h6>Bydel: <span class="fw-light"><?php the_field('afdeling'); ?> </span> </h6>
         <?php endif; ?><?php if (get_field('education')) : ?>
            <h6>Uddannelse: <span class="fw-light"><?php the_field('education'); ?> </span> </h6>
         <?php endif; ?><?php if (get_field('job')) : ?>
            <h6>Beskæftigelse: <span class="fw-light"><?php the_field('job'); ?> </span> </h6>
         <?php endif; ?><?php if (get_field('union')) : ?>
            <h6>Fagforening: <span class="fw-light"><?php the_field('union'); ?> </span> </h6>
         <?php endif ?>
         <div class="iconBlock"> 
               <?php if( have_rows('candidate_contact_info') ): ?>
                  <!-- bob is fucked -->
                  <?php while( have_rows('candidate_contact_info') ): the_row(); ?>
                     <?php if( get_sub_field('e-mail') ): ?> 
                        <a class="icon_mail_white_small" href="mailto:<?php the_sub_field('e-mail'); ?>"></a>
                     <?php endif; ?>
                     <?php if( get_sub_field('facebook') ): ?>
                        <a class="icon_facebook_white_small" href="<?php the_sub_field('facebook'); ?>"></a>
                     <?php endif; ?>
                     <?php if( get_sub_field('instagram') ): ?>
                        <a class="icon_instagram_white_small" href="<?php the_sub_field('instagram'); ?>"></a>
                     <?php endif; ?>
                     <?php if( get_sub_field('twitter') ): ?>
                        <a class="icon_twitter_white_small" href="<?php the_sub_field('twitter'); ?>"></a>
                     <?php endif; ?>
                     <?php if( get_sub_field('linkedin') ): ?>
                        <a class="icon_linkedin_white_small" href="<?php the_sub_field('linkedin'); ?>"></a>
                     <?php endif; ?>
                     
                  <?php endwhile;  ?> 
         </div>
      </div>
   <?php endif; ?>
   [elementor-template id="521"]
	<footer class="entry-footer">
		<?php test_entry_footer(); ?>
	</footer><!-- .entry-footer -->
   
</article><!-- #post-->
<!-- / content.php --> 

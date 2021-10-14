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




   <?php if( get_field('kicker') ): ?> 
      <div id="kicker"> 
         <?php the_field('kicker'); ?>
      </div> 
   <?php endif; ?>

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

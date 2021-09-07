<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="profile" href="https://gmpg.org/xfn/11"> <?php wp_head(); ?> 

   
   </link> 
</head>
<!-- Great comment -->
<body <?php body_class(); ?>> <?php wp_body_open(); ?> <div id="page" class="site">
      <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'test' ); ?></a>
      <header id="masthead" class="site-header <?php if ( has_post_thumbnail() ):  ?> with-coverImg <?php endif; ?>">
         <div class="site-branding">  
             <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a></p> 
          </div><!-- .site-branding -->
          <!--   site description -->
            <?php/*  $test_description = get_bloginfo( 'description', 'display' );
            if ( $test_description || is_customize_preview() ) : */ ?> 
               <!-- <p class="site-description"><?php /* echo $test_description; */ // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p> -->
            <?php /* endif; */ ?>
         <!--  / site description -->  

         <nav id="site-navigation" class="main-navigation">
            <button class="menu-toggle icon_menu_white" aria-controls="primary-menu" aria-expanded="false"><?php/*  esc_html_e( 'Primary Menu', 'test' );  */?></button> <?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?> </nav><!-- #site-navigation -->
      </header><!-- #masthead -->



<!-- PHP FAILED HERE -->
<?php /* $hero = get_field('hero');
if( !empty($hero) ): */ ?> 
   <!-- <div id="headimg" class="header-image featured-image-header"> <?php /* echo $hero; */ ?> </div> -->
   <?php /* else: */ ?> 
      <?php /* poseidon_header_image(); */ ?>
<?php /* endif; */ ?> 
<!-- END PHP FAILED HERE -->

<?php /* poseidon_slider(); */ ?> 
<?php /* poseidon_breadcrumbs(); */ ?> 

<div id="content" class="site-content container clearfix">
<!-- END header.php -->
   
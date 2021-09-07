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
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
   <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri( ); ?>/style.css?v=<?php echo date("ymdhis"); ?>">
</head>
<!-- Great FUCK -->
<body <?php body_class(); ?> > 
<?php wp_body_open(); ?> 

<div id="page" class="site">



     



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
   
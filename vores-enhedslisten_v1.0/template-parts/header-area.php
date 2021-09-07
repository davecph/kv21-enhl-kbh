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
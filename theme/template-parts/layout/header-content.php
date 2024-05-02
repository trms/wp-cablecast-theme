<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

?>

<header id="masthead" class="bg-brand-secondary">
    <div id="topbar-container">



        <!-- Site Name (hidden) -->
        <div>
            <?php
			if ( is_front_page() ) :
				?>
            <h1 class="hidden"><?php bloginfo( 'name' ); ?></h1>
            <?php
			else :
				?>
            <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
			endif;

			$cablecast_description = get_bloginfo( 'description', 'display' );
			if ( $cablecast_description || is_customize_preview() ) :
				?>
            <p><?php echo $cablecast_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- site navigation -->
        <nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'cablecast' ); ?>">
            <button class="hidden" aria-controls="primary-menu"
                aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'cablecast' ); ?></button>
            <div class="relative mx-auto flex max-w-7xl items-center justify-between md:px-8 border-b border-gray-500">
                <div class="w-[50%]">
                    <a class="" href="/">
                        <!-- Custom Logo -->
                        <?php 
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						?>
                        <img class="h-auto w-auto max-h-20 max-w-full" src=" <?php echo $image[0]; ?>" alt="">
                    </a>
                </div>
                <div class="lg:hidden">
                    <a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
                        <svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                                <g id="icon-shape">
                                    <path
                                        d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="text-white w-[50%]">
                    <?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s flex flex-row items-center space-x-4" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
                </div>
            </div>
        </nav><!-- #site-navigation -->
    </div>

</header><!-- #masthead -->
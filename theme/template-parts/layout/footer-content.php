<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

?>

<footer class="bg-brand-secondary relative w-full  py-8">
    <div id="bottombar-container" <!-- site navigation -->
        <nav id=" site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'cablecast' ); ?>">
            <button class="hidden" aria-controls="primary-menu"
                aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'cablecast' ); ?></button>
            <div
                class="relative mx-auto flex max-w-7xl items-center justify-around md:px-8 border-b border-gray-500 pb-8">
                <div class="">
                    <a class="" href="/">
                        <!-- Custom Logo -->
                        <?php 
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						?>
                        <img class="h-auto w-auto max-h-20 max-w-full" src=" <?php echo $image[0]; ?>" alt="">
                    </a>
                </div>
                <div class="flex w-1/2 justify-between">
                    <div class="text-white ">
                        <?php
						$locations = get_nav_menu_locations();
						$menu = wp_get_nav_menu_object( $locations['menu-2'] );
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'footer-menu-col-1',
						'items_wrap'     => '<div class="menu-name font-bold">' . wp_kses_post( $menu->name ) . '</div><ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
                    </div>
                    <div class="text-white ">
                        <?php
						$menu = wp_get_nav_menu_object( $locations['menu-3'] );
				wp_nav_menu(
					array(
						'theme_location' => 'menu-3',
						'menu_id'        => 'footer-menu-col-2',
						'items_wrap'     => '<div class="menu-name font-bold">' . wp_kses_post( $menu->name ) . '</div><ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
                    </div>
                    <div class="text-white ">
                        <?php
						$menu = wp_get_nav_menu_object( $locations['menu-4'] );
				wp_nav_menu(
					array(
						'theme_location' => 'menu-4',
						'menu_id'        => 'footer-menu-col-3',
						'items_wrap'     => '<div class="menu-name font-bold">' . wp_kses_post( $menu->name ) . '</div><ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
                    </div>
                    <?php if (is_user_logged_in()) : ?>
                    <div class="text-white">
                        <?php wp_nav_menu(
                            array(
                                'theme_location' => 'menu-5',
                                'menu_id'        => 'footer-menu-col-4',
                                'items_wrap'     => '<div class="menu-name font-bold">Member Links</div><ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
                            )
                        ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav><!-- #site-navigation -->
        <div class="text-white text-center mt-4">
            <?php
                        // Output the footer widget area
                        if ( is_active_sidebar( 'sidebar-1' ) ) {
                            dynamic_sidebar( 'sidebar-1' );
                        }
                        ?>
        </div>
    </div>
</footer>
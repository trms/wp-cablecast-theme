<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

?>

<footer class="bg-brand-secondary relative w-full  py-8 px-2">
    <div id="bottombar-container"> <!-- site navigation -->
        <nav id=" site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'cablecast' ); ?>">
            <button class="hidden" aria-controls="primary-menu"
                aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'cablecast' ); ?></button>
            <div
                class="relative mx-auto lg:flex max-w-7xl items-center justify-around md:px-8 border-b border-gray-500 pb-8">
                <div class="flex justify-center">
                    <a class="" href="/">
                        <!-- Custom Logo -->
                        <?php 
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						?>
                        <img class="h-auto w-auto max-h-20 max-w-full mb-5" src=" <?php echo $image[0]; ?>" alt="">
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row lg:w-1/2 justify-between gap-4 sm:gap-0 text-center sm:text-left">
                        <?php
						$locations = get_nav_menu_locations();
                        /* -- Keeping this code in case we want to add another menu to the footer --
                        if (isset($locations['menu-2'])) {
                            
                           echo '<div class="text-white menu-2">';
                            $menu = wp_get_nav_menu_object( $locations['menu-2'] );
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'menu-2',
                                    'menu_id'        => 'footer-menu-col-1',
                                    'items_wrap'     => '<ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
                                )
                            );
                            echo '</div>';
                         } */
                       
                        if (isset($locations['menu-3'])) {
                            echo '<div class="text-white menu-3">';
                            $menu = wp_get_nav_menu_object( $locations['menu-3'] );
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'menu-3',
                                    'menu_id'        => 'footer-menu-col-2',
                                    'items_wrap'     => '<ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
                                )
                            );
                            echo '</div>';
                        }
                        
                        if (isset($locations['menu-4'])) {
                            echo '<div class="text-white menu-4">';
                            $menu = wp_get_nav_menu_object( $locations['menu-4'] );
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'menu-4',
                                    'menu_id'        => 'footer-menu-col-3',
                                    'items_wrap'     => '<ul id="%1$s" class="%2$s flex justify-start flex-col" aria-label="submenu">%3$s</ul>',
                                )
                            );
                            echo '</div>';
                        }
                        ?>
                    
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

        <div class="footer-social-media-container flex flex-row justify-center gap-3 mt-5">
            <?php
            // Retrieve the settings
            $contact_info = get_option('contact_info_settings');

            if ($contact_info) {
                $socials = ['facebook', 'instagram', 'linkedin', 'tiktok', 'youtube'];
                foreach ($socials as $social) {
                    if (!empty($contact_info[$social . '_image'])) {
                        echo '<a href="' . esc_url($contact_info[$social]) . '" target="_blank">';
                        echo '<img src="' . esc_url($contact_info[$social . '_image']) . '" alt="' . ucfirst($social) . ' Download Image">';
                        echo '</a>';
                    }
                }
            } 
            ?>
        </div>

        <div class="text-white text-center mt-4">
            <?php
                        // Output the footer widget area
                        if ( is_active_sidebar( 'sidebar-1' ) ) {
                            dynamic_sidebar( 'sidebar-1' );
                        }
                        ?>
        </div>
        <div class="footer-copyright"> Copyright &copy; <? the_date('Y') ?> Tightrope Media Systems</div>
    </div>

</footer>
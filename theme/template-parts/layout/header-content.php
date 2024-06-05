<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

?>

<header id="masthead" class="banner">
    <div id="topbar-container" class="relative mx-auto px-8 w-full md:px-8 border-b border-gray-500">
        <!-- site navigation -->
        <nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'cablecast' ); ?>"
            class="flex justify-between items-center w-full">
            <button class="hidden" aria-controls="primary-menu"
                aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'cablecast' ); ?></button>
            <div
                class="relative mx-auto flex w-full px-8 lg:max-w-7xl items-center justify-between md:px-8 border-b border-gray-500">
                <div class="">
                    <a class="" href="/">
                        <!-- Custom Logo -->
                        <?php 
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						?>
                        <img class="h-auto w-auto max-h-20 p-1 max-w-full" src=" <?php echo $image[0]; ?>" alt="">
                    </a>
                </div>
                <div class="lg:hidden absolute right-0 hamburger-icon">
                    <a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
                        <svg viewBox="0 0 20 20" class="inline-block w-6 h-6 menu-icon" fill="white"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path
                                d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z" />
                        </svg>
                    </a>
                </div>
                <div class="text-white">
                    <div class="mobile-menu hidden">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'container_class' => 'menu-container', // Simplified for clarity
                                'items_wrap' => '<ul id="%1$s" class="%2$s flex flex-col gap-y-2">%3$s</ul>', 
                            )
                        );
                        ?>
                        <!-- Close button -->
                        <button class="close-btn" aria-label="Close Menu">&times;</button>
                    </div>
                    <div class="text-white  hidden lg:flex">
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
        </nav><!-- #site-navigation -->
    </div>

</header><!-- #masthead -->


<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('primary-menu-toggle');
    var menu = document.querySelector('.mobile-menu');
    var closeButton = document.querySelector('.close-btn');

    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });
    }

    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });
    }

    function toggleMenu() {
        var expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
        menuToggle.setAttribute('aria-expanded', !expanded);
        menu.classList.toggle('hidden');
    }
});
</script>
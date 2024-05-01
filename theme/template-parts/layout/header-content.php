<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

?>

<header id="masthead">
	<div id="topbar-container" class="flex flex-row space-x-10 bg-brand-secondary">

		<!-- Custom Logo -->
		<?php 
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			?>
		<img src="<?php echo $image[0]; ?>" alt="">

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
				<p><?php echo $cablecast_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div>
		
		<!-- site navigation -->
		<nav id="site-navigation" class="flex items-center" aria-label="<?php esc_attr_e( 'Main Navigation', 'cablecast' ); ?>">
			<button class="hidden" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'cablecast' ); ?></button>
			
			
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'container_class'        => 'bg-black',
						'items_wrap'     => '<ul id="%1$s" class="%2$s flex flex-row space-x-4" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
		
		</nav><!-- #site-navigation -->
	</div>

</header><!-- #masthead -->

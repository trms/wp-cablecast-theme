<?php
/**
 * The template for displaying the front page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */
?>

    <?php
get_header();
?>

<main id="main" class="homepage-section-color">

	<?php if (has_excerpt() && has_post_thumbnail()) { ?>
		<section id="homepage-header" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.75)), url(<?php echo the_post_thumbnail_url(); ?>);">
			<div class="homepage-info-container">
				<div class="homepage-description">
					<h2 class="page-title">Welcome to <br><?php echo get_bloginfo( 'name' ); ?></h2>
					<div><?php the_excerpt(); ?></div>
				</div>
			</div>
		</section>
	<?php } ?>

	<section id="homepage-main-content">
			<?php /* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

			endwhile; // End of the loop. ?>
	</section>		

			<?php // Retrieve the shortcode settings
			$news_shortcode_output = do_shortcode('[cablecastnews]');
			$partners_shortcode_output = do_shortcode('[cablecastpartners]');

			if ($news_shortcode_output !== '') { ?>
				<section id="homepage-news-section" class="section-1-background">
					<div class="homepage-news-container">
						<h2 class="homepage-news-title text-3xl font-bold text-center heading-text-color">NEWS</h2>
						<?php echo $news_shortcode_output; ?>
					</div>
				</section>
			<?php }

			// Retrieve the settings
            $contact_info = get_option('contact_info_settings');

			if ($contact_info) { ?>
				<section id="homepage-app-info-section">
					<div class="homepage-app-container mb-20">

						<h3 class="app-info-title text-3xl heading-text-color">Find us on your favorite app</h3>

						<div class="app-icons-container">
							<?php // Display each app link and image
							$apps = ['apple', 'roku', 'firetv', 'androidmobile'];
							foreach ($apps as $app) {

								if (!empty($contact_info[$app . '_image'])) {
									echo '<a href="' . esc_url($contact_info[$app]) . '" target="_blank">';
									echo '<img src="' . esc_url($contact_info[$app . '_image']) . '" alt="' . ucfirst($app) . ' Download Image" style="max-width:200px;">';
									echo '</a>';
								}
							} ?>
						</div>
					</div>
				</section>

			<?php }

			if ($partners_shortcode_output !== '') { ?>
				<section id="homepage-partners-section">
					<div class="homepage-partners-container">
						<h2 class="homepage-partners-title text-3xl font-bold text-center heading-text-color">OUR PARTNERS</h2>
						<?php echo $partners_shortcode_output; ?>
					</div>
				</section>
			<?php } ?>

        </main>


<?php
get_footer();

?>
</div>
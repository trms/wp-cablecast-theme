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
<div>
    <?php
get_header();
?>

    <section id="primary" class="p-2">
        <main id="main">

		<?php if (has_excerpt() && has_post_thumbnail()) { ?>

			<div class="homepage-info-container">
				<div class="homepage-feature-image"><?php echo the_post_thumbnail(); ?></div>
				<div class="homepage-description">
					<h2 class="page-title">Welcome to <?php echo get_bloginfo( 'name' ); ?></h2>
					<div><?php the_excerpt(); ?></div>
				</div>
			</div>

		<?php } 

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

			endwhile; // End of the loop.
			
			$news_shortcode_output = do_shortcode('[cablecastnews]');

			$partners_shortcode_output = do_shortcode('[cablecastpartners]');

			if ($news_shortcode_output !== '' or $partners_shortcode_output !== ''){ ?>
				<hr class="homepage-hr">
			<?php }

			if ($news_shortcode_output !== '') { ?>
				<h2 class="homepage-news-title text-3xl font-bold text-center">NEWS</h2>
				<?php echo $news_shortcode_output;
			}
			if ($partners_shortcode_output !== '') { ?>
				<h2 class="homepage-partners-title text-3xl font-bold text-center">PARTNERS</h2>
				<?php echo $partners_shortcode_output;
			}

			?>

        </main><!-- #main -->
    </section><!-- #primary -->
</div>
<?php
get_footer();

?>
</div>
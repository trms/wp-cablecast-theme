<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no `home.php` file exists.
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
<main id="main">
<article><div class="page-info-container">

            <?php
		if ( have_posts() ) {

			if ( is_home() && ! is_front_page() ) :
				?>
            <header class="entry-header">
                
            </header><!-- .entry-header -->
            <?php
			endif;

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content' );
			}

			// Previous/next page navigation.
			cablecast_the_posts_navigation();

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		}
		?>

	</div><article>
	</main>
</div>
<?php
get_footer();
<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package cablecast
 */

get_header();
?>

<main id="main">
<article><div class="page-info-container">

        <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <?php
				printf(
					/* translators: 1: search result title. 2: search term. */
					'<h1 class="page-title">%1$s <span>%2$s</span></h1>',
					esc_html__( 'Search results for:', 'cablecast' ),
					get_search_query()
				);
				?>
        </header><!-- .page-header -->

        <?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'excerpt' );

				// End the loop.
			endwhile;

			// Previous/next page navigation.
			cablecast_the_posts_navigation();

		else :

			// If no content is found, get the `content-none` template part.
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>
	</div><article>
</main>

<?php
get_footer();
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
		
            <?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

                // If comments are open, or we have at least one comment, load
                // the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile; // End of the loop.
			?>

        </main><!-- #main -->
    </section><!-- #primary -->
</div>
<?php
get_footer();

?>
</div>
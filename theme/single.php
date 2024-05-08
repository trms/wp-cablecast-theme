<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cablecast
 */

 ?>
<div>
    <?php
 get_header();
 ?>
    <section id="primary">
        <main id="main" class="pb-8">
            <?php
			// Start the Loop.
			while (have_posts()) :
				the_post(); ?>
            <article <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
            <?php endwhile; // End of the loop. ?>
        </main><!-- #primary -->
    </section><!-- #primary -->
</div>
<?php
 get_footer();
 ?>
</div>
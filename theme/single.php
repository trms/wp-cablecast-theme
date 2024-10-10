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
<main id="main">
    <article><div class="page-info-container">
            <?php
			// Start the Loop.
			while (have_posts()) :
				the_post(); ?>
            <article <?php post_class(); ?>>
                <?php the_content(); ?>
            </div><article>
            <?php endwhile; // End of the loop. ?>
    </div><article>
</main>
</div>
<?php
 get_footer();
 ?>
</div>
<?php 
/*
Template Name: Cablecast About Page
*/
// Start the WordPress session

get_header();
?>

<section id="primary">
        <main id="main">
		
        <h2 class="page-title text-center"><?php single_post_title(); ?></h2>

        <div class="about-info-container">
            <div class="about-feature-image"><?php echo the_post_thumbnail(); ?></div>
            <div class="about-description"><?php the_excerpt(); ?></div>
        </div>

        <!-- put featured custom collection here? -->

        <h3 class="contact-info-title">GET IN TOUCH</h3>
        <div class="contact-info-container">
        <?php the_meta(); ?>
            <!-- <div class="contact-info"><strong>Phone:</strong><p>952-223-4455</p></div>
            <div class="contact-info"><strong>Address:</strong><p>400 South 4th Street #410,<br> Minneapolis MN 55415</p></div>
            <div class="contact-info"><strong>Email:</strong><p>support@cablecast.tv</p></div> -->
        </div>

        <div class="about-page-main-content"><?php the_content(); ?></div>

        </main><!-- #main -->
    </section><!-- #primary -->

<?php get_footer(); ?>
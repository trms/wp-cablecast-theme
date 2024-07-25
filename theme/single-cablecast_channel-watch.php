<?php
/* Template Name: Channel Watch */
get_header();
global $wp_query;
$channel_slug = get_query_var('cablecast_channel');
$channel_page = get_query_var('channel_page'); ?>

<main id="main">
    <article>
        <div class="watch-page-info-container">

            <?php // Load and display watch content for this channel
    if ($channel_page == 'watch') {

        $permalink = get_permalink(); // Retrieve post permalink
        
        echo '<div class="watch-page-nagivation pb-3"><a href="/channels" class="link-color hover:underline">« Back to Channels</a>';
        echo '<a href="' . $permalink . 'schedule" class="link-color hover:underline">View Schedule »</a></div>';
        // Display content added through WordPress editor
        if (have_posts()) {
            while (have_posts()) { ?>

            <div class="watch-content-container">

                <?php the_post();
                the_content(); ?>
            </div>
            <?php }
        }

        echo '<h2 class="watch-title heading-text-color">' . esc_html($channel_slug) . '</h2>';
    } ?>

        </div>
        <article>
</main>

<?php get_footer();

?>
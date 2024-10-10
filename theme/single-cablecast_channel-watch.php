<?php
/* Template Name: Channel Watch */
get_header();
global $wp_query;
$channel_slug = get_query_var('cablecast_channel');
$channel_page = get_query_var('channel_page');

// Load and display watch content for this channel
if ($channel_page == 'watch') {

    $permalink = get_permalink(); // Retrieve post permalink
    
    echo '<div class="watch-page-nagivation pb-3"><a href="/channels" class="!text-brand-accent hover:underline">« Back to Channels</a>';

    echo '<a href="' . $permalink . 'schedule" class="!text-brand-accent hover:underline">View Schedule »</a></div>';

     // Display content added through WordPress editor
     if (have_posts()) {
        while (have_posts()) { ?>

<div class="watch-content-container">

    <?php the_post();
            the_content(); ?>
</div>
<?php }
    }

     echo '<h2 class="page-title">' . esc_html($channel_slug) . '</h2>';
}
get_footer();

?>
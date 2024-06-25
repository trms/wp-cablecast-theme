<?php
/* Template Name: Channel Schedule */
get_header();
global $wp_query;
$channel_slug = get_query_var('cablecast_channel');
$channel_page = get_query_var('channel_page');

if ($channel_page == 'schedule') {
    $permalink = get_permalink(); // Retrieve post permalink
    
    echo '<div class="schedule-page-nagivation"><a href="/channels" class="!text-brand-accent hover:underline">« Back to Channels</a>';

    echo '<a href="' . $permalink . 'watch" class="!text-brand-accent hover:underline">Watch Channel »</a></div>';

    // Load and display schedule content for this channel
    echo '<h2 class="page-title text-center">' . esc_html($channel_slug) . ' Schedule</h2>';

    // Display content added through WordPress editor
    if (have_posts()) {
        while (have_posts()) { ?>

<div class="schedule-content-container">

    <?php the_post();
            the_content(); ?>
</div>
<?php }
    }
}

get_footer();
?>
<?php
/* Template Name: Channel Schedule */
get_header();
global $wp_query;
$channel_slug = get_query_var('cablecast_channel');
$channel_page = get_query_var('channel_page'); 
$permalink = get_permalink(); // Retrieve post permalink?>

<main id="main">
    <article>
        <div class="page-title accent-color">
            <h2 class="text-center title-text-color"><?php echo esc_html($channel_slug)?> Schedule</h2>
            <?php if ($channel_page == 'schedule') {
                echo '<a href="' . $permalink . 'watch" class="watch-button text-center grow rounded secondary-button px-2 py-2 text-sm font-semibold text-white shadow-sm">Watch ' . $channel_slug . '</a>';
             } ?>
        </div>

        <div class="schedule-page-info-container">

            <?php if ($channel_page == 'schedule') {

        echo '<div class="schedule-page-nagivation"><a href="/channels" class="!text-brand-accent hover:underline">« Back to Channels</a></div>';
        // Display content added through WordPress editor
        if (have_posts()) {
            while (have_posts()) { ?>

            <div class="schedule-content-container">

                <?php the_post();
                the_content(); ?>
            </div>
            <?php }
        }
    }?>

        </div>
        <article>
</main>

<?php get_footer();
?>
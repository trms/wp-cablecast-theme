<?php
/* Template Name: Channel Schedule */
get_header();
global $wp_query;
$channel_slug = get_query_var('cablecast_channel');
$channel_page = get_query_var('channel_page');

if ($channel_page == 'schedule') {
    // Load and display schedule content for this channel
    echo '<h1>Schedule Page for Channel: ' . esc_html($channel_slug) . '</h1>';
}
get_footer();
?>
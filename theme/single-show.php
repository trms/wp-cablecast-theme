<?php
/**
 * The template for displaying all single shows
 *
 * @package cablecast
 */

 ?>
<div>
    <?php
 get_header();
 ?>
    <section id="primary" class="content-area">
        <main id="main" class="site-main pb-8">
            <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
                <?php
                $post_id = get_the_ID();
                
                // Check if the rcp_user_can_access function exists and run it if so
                if (function_exists('rcp_user_can_access')) {
                    $can_access = rcp_user_can_access(get_current_user_id(), $post_id);
                } else {
                    // If the function doesn't exist, default to true (access granted)
                    $can_access = true;
                }

                if ($can_access) {
                    $video_iframe = get_post_meta($post_id, 'cablecast_vod_embed', true);
                    if ($video_iframe) {
                        echo '<div class="embed-responsive">' . $video_iframe . '</div>';
                    }
                } else {
                    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
                    if ($thumbnail_url) {
                        echo '<div class="relative">';
                        echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image">';
                        // Overlay for restricted content
                        echo '
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-10">
                                <div class="flex justify-center flex-col gap-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 my-0 mx-auto" viewBox="0 0 448 512"><path fill="#ffffff" d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                                    <span>This Content requires a membership to view.</span>
                                    <span class="text-xs">Login or register below.</span>
                                    <div class="mt-4">
                                        <a href="/login" class="bg-brand-accent hover:shadow-xl text-white  py-2 px-4 ">Login</a>
                                        <a href="/register" class="bg-brand-accent hover:shadow-xl text-white  py-2 px-4 ">Register</a>
                                    </div>
                                </div>  
                            </div>';
                        echo '</div>';
                    }
                }

                the_title('<h1 class="text-3xl mt-8 mb-4">', '</h1>');
                
                echo '<div class="mb-4">' . get_post_meta($post_id, 'cablecast_show_comments', true) . '</div>';

                // Flex container for custom fields in two columns
                echo '<div class="sm:flex justify-between sm:w-2/3">';
                $fields = [
                    'cablecast_producer_name' => 'Producer',
                    'cablecast_category_name' => 'Category',
                    'cablecast_project_name' => 'Project'
                ];
                
                // Retrieve and format the TRT field
                $trt = get_post_meta($post_id, 'cablecast_show_trt', true);
                $trtFormatted = $trt ? gmdate("H:i:s", $trt) : '';

                // If TRT is available, add to fields array at the desired position
                if ($trtFormatted) {
                    $fields = ['cablecast_show_trt' => 'Length'] + $fields;
                }

                $col1 = array_slice($fields, 0, 2, true);  // First half of fields
                $col2 = array_slice($fields, 2, null, true); // Second half of fields

                // Column 1
                echo '<div class="flex-1">';
                foreach ($col1 as $key => $label) {
                    $value = get_post_meta($post_id, $key, true);
                    if ($key == 'cablecast_show_trt') {
                        $value = $trtFormatted; // Use formatted time for TRT
                    }
                    if ($value) {
                        echo '<div><span class="font-bold">' . $label . ': </span>' . $value . '</div>';
                    }
                }
                echo '</div>';

                // Column 2
                echo '<div class="flex-1">';
                foreach ($col2 as $key => $label) {
                    $value = get_post_meta($post_id, $key, true);
                    if ($value) {
                        echo '<div><span class="font-bold">' . $label . ': </span>' . $value . '</div>';
                    }
                }
                echo '</div>';
                
                echo '</div>';
                ?>
            </article>
            <?php endwhile; ?>
        </main><!-- #main -->
    </section><!-- #primary -->
</div>
<?php
 get_footer();
 ?>
</div>
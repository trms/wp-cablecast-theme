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
                                    <span>This Content requires a membership to view.</span>
                                    <span>Login or register below.</span>
                                    <div class="mt-4">
                                        <a href="/login" class="btn secondary-button hover:shadow text-white  py-2 px-4 ">Login</a>
                                        <a href="/register" class="btn secondary-button hover:shadow text-white  py-2 px-4 ">Register</a>
                                    </div>
                                </div>  
                            </div>';
                        echo '</div>';
                    }
                }
?>
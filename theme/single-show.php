<?php ?>
<div>
    <?php
get_header();
?>
    <section id="primary">
        <main id="primary" class="entry-content">
            <div id="content" class="site-content" role="main">

                <?php
        // Start the Loop.
        while (have_posts()) :
            the_post();
            //VIDEO PLAYER
            $video_iframe = get_post_meta(get_the_ID(), 'cablecast_vod_embed', true);// Assuming you are using Advanced Custom Fields
            if ($video_iframe) {
                echo '<div class="embed-responsive">';
                echo $video_iframe;
                echo '</div>';
            }
            // SHOW TITLE 
            the_title('<h1 class="text-3xl mt-8">', '</h1>');
            ?>
                <div className="flex flex-row justify-between">
                    <?php 
                    // SHOW DESCRIPTION 
                    $description = get_post_meta(get_the_ID(), 'Program Description', true); 
                    if ($description) {
                        echo '<p class="w-3/5 my-4">';
                        echo $description;
                        echo '</p>';
                    }
                    comments_template('/comments.php'); 

                
                    endwhile; // End of the loop.
                ?>

                </div><!-- #content -->
        </main><!-- #primary -->
    </section><!-- #primary -->
</div>
<?php
get_footer();
?>
</div>
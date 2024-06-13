<?php get_header(); 

    while (have_posts()) {
        the_post(); ?>
        <a href="/news" class="!text-brand-accent hover:underline pl-5">« Back to News</a>
        <div class="news-single-page-content prose">
            
            <h2 class="news-single-title page-title"><?php the_title(); ?></h2>

            <div class="news-date">
                Posted by <?php the_author(); ?> - <?php the_time('n.j.y'); ?>
            </div>
            
            <div class="news-thumbnail-single"><?php echo the_post_thumbnail(); ?></div> <!-- remove this line to remove the large thumbnail image -->

            <div class="news-full-text">
                <div class=""><?php the_content(); ?></div>
            </div>

        </div>
        
    <?php } 
    
    get_footer(); 
    ?>
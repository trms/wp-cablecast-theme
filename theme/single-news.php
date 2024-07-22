<?php get_header(); ?>

<main id="main">
    <article>
        <div class="page-title accent-color">
            <h2 class="news-single-title text-center title-text-color"><?php the_title(); ?></h2>
        </div>
    
    <div class="news-page-info-container">
    <div><a href="/news" class="!text-brand-accent hover:underline pl-5">« Back to News</a></div>

    <?php while (have_posts()) {
        the_post(); ?>
        <div class="news-single-page-content prose">

            
            
            <div class="news-thumbnail-single"><?php echo the_post_thumbnail(); ?></div> <!-- remove this line to remove the large thumbnail image -->

            <div class="news-full-text">
                <div><?php the_content(); ?></div>
                <span class="italic text-gray-400 text-sm">Posted by <?php the_author(); ?> - <?php the_time('n.j.y'); ?></span>
            </div>
            <div class="clear-float"></div>
        </div>
        
    <?php } ?>
    
    </div><article>
</main>
    <?php get_footer(); 
    ?>
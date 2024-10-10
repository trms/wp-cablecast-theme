<?php get_header(); ?>

<main id="main">
    <article><div class="page-info-container">

        <?php while (have_posts()) {
            the_post(); ?>
            <a href="/channels" class="!text-brand-accent hover:underline pl-5">« Back to Channels</a>
            <div class="channel-single-page-container prose pl-5 pr-5">
                <h2 class="channel-single-page-title"><?php the_title(); ?></h2>
                
                <div class="channel-single-page-content">
                    <div class=""><?php the_content(); ?></div>
                </div>

            </div>
            
        <?php } ?>
        
    </div><article>
</main>

    <?php get_footer(); 
    ?>
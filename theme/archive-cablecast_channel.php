<?php get_header(); ?>
<main id="main">
  <article>
  <h2 class="page-title text-center accent-color title-text-color">CHANNELS</h2>  
  <div class="channels-page-info-container">

    <div class="channel-archive-container">
      <?php
        while (have_posts()) {
          the_post(); 
          $permalink = get_permalink(); // Retrieve post permalink ?>
            <div class="channel-archive-item gap-10 pb-10">
              <div class="channel-archive-thumbnail mt-2"><?php echo the_post_thumbnail(); ?></div>
              <div>
                <h3 class="channel-archive-titles pb-2 heading-text-color"><?php the_title(); ?></h3>
                <?php the_content(); ?>
                <div class="py-5">
                  <a href="<?php echo $permalink; ?>watch" class="text-center rounded secondary-button px-4 py-2 mr-3 text-xs font-semibold text-white shadow-sm">Watch Channel</a>  <a href="<?php echo $permalink; ?>schedule" class="text-center rounded secondary-button px-4 py-2 text-xs font-semibold text-white shadow-sm">View Schedule</a>
                </div>
              </div>
            </div>
      <?php } ?>

    </div>
  </div><article>
</main>
<?php get_footer(); ?>
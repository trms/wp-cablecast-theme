<?php get_header(); ?>

<h2 class="page-title text-center">CHANNELS</h2>

<div class="channel-archive-container">
  <?php
    while (have_posts()) {
      the_post(); ?>
        <div class="channel-archive-item">
            <h3 class="channel-archive-titles"><?php the_title(); ?></h3>
          <div class="channel-archive-thumbnail"><a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail(); ?></a></div>
          <h4 class="channel-archive-schedule-title">SCHEDULE</h4>
          <div><?php the_content(); ?></div>
        </div>
        
      
  <?php } ?>

</div>

<?php get_footer(); ?>
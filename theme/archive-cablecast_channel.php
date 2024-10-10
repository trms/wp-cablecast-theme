<?php get_header(); ?>

<h2 class="page-title text-center">CHANNELS</h2>

<div class="channel-archive-container">
  <?php
    while (have_posts()) {
      the_post(); 
      $permalink = get_permalink(); // Retrieve post permalink ?>
        <div class="channel-archive-item">
            <h3 class="channel-archive-titles"><?php the_title(); ?></h3>
          <div class="channel-archive-thumbnail"><?php echo the_post_thumbnail(); ?></div>
          <div class="pt-3 pb-3 flex flex-row gap-4 justify-center"><a href="<?php echo $permalink; ?>watch" class="text-center grow rounded secondary-button px-2 py-2 text-xs font-semibold text-white shadow-sm">Watch Channel</a>  <a href="<?php echo $permalink; ?>schedule" class="text-center grow rounded secondary-button px-2 py-2 text-xs font-semibold text-white shadow-sm">View Schedule</a></div>
          <div><?php the_content(); ?></div>
        </div>
        
      
  <?php } ?>

</div>

<?php get_footer(); ?>
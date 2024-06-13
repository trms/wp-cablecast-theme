<?php get_header(); ?>

<h2 class="page-title text-center">NEWS</h2>

<div class="container">
  <?php 
    while (have_posts()) {
      the_post(); ?>

        <div class="news-item">
          <div class="news-thumbnail-archive"><?php echo the_post_thumbnail(); ?></div>

          <div class="news-item-text">
            <div class="news-date">
              <?php the_time('n.j.y'); ?>
            </div>
            
            <h3 class="news-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

            <div class="news-content">
              <?php if (has_excerpt()) {
                      echo get_the_excerpt();
                    } else {
                      echo wp_trim_words(get_the_content(), 18);
                    }  ?>
              <p><a class="news-readmore-btn" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
            </div>
          </div>

        </div>
  <?php } ?>
    <div class="news-pagination-container">
    <?php echo paginate_links();?>
    </div>
</div>

<?php get_footer(); ?>
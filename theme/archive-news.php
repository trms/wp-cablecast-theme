<?php get_header(); ?>
<main id="main">
  <article>
    <h2 class="page-title text-center accent-color title-text-color">NEWS</h2>
  <div class="news-page-info-container">
    
    <div class="news-container">
      <?php 
        while (have_posts()) {
          the_post(); ?>

            <div class="news-item">
              <div class="news-thumbnail-archive"><?php echo the_post_thumbnail('newsHomepage'); ?></div>

              <div class="news-item-text">
                <div class="news-date">
                  <?php the_time('n.j.y'); ?>
                </div>
                
                <h3 class="news-item-title heading-text-color"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                <div class="news-content">
                  <?php if (has_excerpt()) {
                          echo get_the_excerpt();
                        } else {
                          echo wp_trim_words(get_the_content(), 18);
                        }  ?>
                  <p><a class="news-readmore-btn link-color hover:underline pt-3 block" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
                </div>
              </div>

            </div>
      <?php } ?>
        <div class="news-pagination-container">
        <?php echo paginate_links();?>
        </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
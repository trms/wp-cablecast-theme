<?php get_header(); ?>

<main>
  <article>
  <h2 class="page-title accent-color title-text-color text-center">MEET OUR STAFF</h2>
	
	<div class="page-info-container">
  <div class="staff-listing-container">
  <?php 
    // Custom query to order staff alphabetically by title and display all posts
    $args = array(
        'post_type' => 'staff', // Replace 'staff' with your actual custom post type name if different
        'posts_per_page' => -1, // Display all posts
        'orderby' => 'title', // Order by title
        'order' => 'ASC' // Ascending order
    );
    $staff_query = new WP_Query($args);

    while ($staff_query->have_posts()) {
      $staff_query->the_post(); ?>

        <?php
            // Retrieve custom meta data
            $phone = get_post_meta(get_the_ID(), '_cep_staff_phone', true);
            $email = get_post_meta(get_the_ID(), '_cep_staff_email', true);
            $staffTitle = get_post_meta(get_the_ID(), '_cep_staff_title', true);
        ?>

        <div class="staff-item-container">
          <div class="staff-thumbnail-archive"><a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail('staffSquare'); ?></a></div>
            
            <h3 class="staff-item-title heading-text-color"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if ($staffTitle) : ?>
                        <h6 class=""><?php echo esc_html($staffTitle); ?></h6>
            <?php endif; ?>
            
              <?php if ($phone) : ?>
                  <div><a href="tel:<?php echo esc_html($phone); ?>" class="!text-brand-accent hover:underline"><?php echo esc_html($phone); ?></a></div>
              <?php endif; ?>

              <?php if ($email) : ?>
                  <div><a href="mailto:<?php echo esc_attr($email); ?>" class="!text-brand-accent hover:underline"><?php echo esc_html($email); ?></a></div>
              <?php endif; ?>

        </div>
  <?php } 
    // Reset post data to ensure the main query is not affected
    wp_reset_postdata();
  ?>
    <!-- Add this back in if client wants pagination
    <div class="news-pagination-container">
    <?php //echo paginate_links();?>
    </div> -->
  </div>
  </div><article>
</main>
<?php get_footer(); ?>

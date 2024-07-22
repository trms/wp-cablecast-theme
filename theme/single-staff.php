<?php get_header(); ?>
<main>
    <article>
    <?php
        // Retrieve custom meta data
        $phone = get_post_meta(get_the_ID(), '_cep_staff_phone', true);
        $email = get_post_meta(get_the_ID(), '_cep_staff_email', true);
        $staffTitle = get_post_meta(get_the_ID(), '_cep_staff_title', true);
    ?>
        <div class="page-title accent-color mb-3">
            <h2 class="text-center title-text-color mb-2"><?php the_title(); ?></h2>
                <?php if ($staffTitle) : ?>
                        <h3 class="text-center title-text-color text-lg"><?php echo esc_html($staffTitle); ?></h3>
                <?php endif; ?>
        </div>
    <?php while (have_posts()) {
        the_post(); ?>

        <div class="staff-single-page-content prose">
         <a href="/staff" class="!text-brand-accent hover:underline">« Back to Staff</a>   
            <div class="staff-info-container">
                <div class="staff-thumbnail-single"><?php echo the_post_thumbnail('staffPortrait'); ?></div> 
                
                <div class="staff-full-text"><?php the_content(); ?></div>
                <div class="clear-float"></div>
                <div class="staff-contact-info pb-10">
                    <?php if ($phone) : ?>
                        <div><strong>Phone:</strong> <a href="tel:<?php echo esc_html($phone); ?>" class="!text-brand-accent hover:underline"><?php echo esc_html($phone); ?></a></div>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                        <div><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($email); ?>" class="!text-brand-accent hover:underline"><?php echo esc_html($email); ?></a></div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        
    <?php } ?>
    </div><article>
</main>
    <?php get_footer(); ?>
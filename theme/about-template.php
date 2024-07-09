<?php 
/*
Template Name: Cablecast About Page
*/
// Start the WordPress session

get_header();
?>

<section id="primary">
        <main id="main">
		
        <h2 class="page-title text-center"><?php single_post_title(); ?></h2>

        <div class="about-info-container">
            <div class="about-feature-image"><?php echo the_post_thumbnail(); ?></div>
            <div class="about-description"><?php the_excerpt(); ?></div>
        </div>

        <!-- put featured custom collection here? -->

            <?php
            // Retrieve the settings
            $contact_info = get_option('contact_info_settings');
            ?>

        <h3 class="contact-info-title">GET IN TOUCH</h3>
        <div class="contact-info-container">
            <?php
            $columns = [];

            if ($contact_info['email']) {
                $columns[] = '<div class="contact-info-column"><span class="meta-title">Email:</span> <a href="mailto:' . esc_html($contact_info['email']) . '" class="!text-brand-accent hover:underline" target="_blank">' . esc_html($contact_info['email']) . '</a></div>';
            }
            if ($contact_info['address']) {
                $columns[] = '<div class="contact-info-column"><span class="meta-title">Address:</span> <a href="https://www.google.com/maps/search/?api=1&query=' . urlencode($contact_info['address']) . '" class="!text-brand-accent hover:underline" target="_blank">' . esc_html($contact_info['address']) . '</a></div>';
            }
            if ($contact_info['phonenumber']) {
                $columns[] = '<div class="contact-info-column"><span class="meta-title">Phone Number:</span> <a href="tel:' . esc_html($contact_info['phonenumber']) . '" class="!text-brand-accent hover:underline" target="_blank">' . esc_html($contact_info['phonenumber']) . '</a></div>';
            }
            if ($contact_info['fax']) {
                $columns[] = '<div class="contact-info-column"><span class="meta-title">Fax:</span> <a href="tel:' . esc_html($contact_info['fax']) . '" class="!text-brand-accent hover:underline" target="_blank">' . esc_html($contact_info['fax']) . '</a></div>';
            }

            // Output the columns
            foreach ($columns as $column) {
                echo $column;
            }
            ?>
        </div>

        <div class="about-page-main-content"><?php the_content(); ?></div>

        <?php
        if ($contact_info) { ?>

            <div class="app-information mb-10">

                <h3 class="app-info-title">Find us on your favorite app</h3>

                <div class="app-icons-container">
                    <?php // Display each app link and image
                    $apps = ['apple', 'roku', 'firetv', 'androidmobile'];
                    foreach ($apps as $app) {

                        if (!empty($contact_info[$app . '_image'])) {
                            echo '<a href="' . esc_url($contact_info[$app]) . '" target="_blank">';
                            echo '<img src="' . esc_url($contact_info[$app . '_image']) . '" alt="' . ucfirst($app) . ' Download Image" style="max-width:200px;">';
                            echo '</a>';
                        }
                    } ?>
                </div>
            </div>

        <?php } ?>

        </main><!-- #main -->
    </section><!-- #primary -->

<?php get_footer(); ?>
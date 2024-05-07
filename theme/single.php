<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cablecast
 */

 ?>
<div>
    <?php
 get_header();
 ?>
    <section id="primary">
        <main id="main">
            <?php
			// Start the Loop.
			while (have_posts()) :
				the_post(); ?>

            <?php if( rcp_user_can_access() ) : ?>
            <article <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
            <?php endif;  ?>
            <?php if( !rcp_user_can_access() ) : ?>
            <!-- CONTENT RESTRICTED  -->
            <div class="content-restricted flex flex-col justify-center items-center gap-y-2 ">
                <div class="border border-gray-300 bg-gray-100 p-20">
                    <div class=" w-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-10 w-10 my-4 mx-auto">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                        </svg>
                    </div>
                    <div class="text-center font-bold">This content is for members only!</div>
                    <div class="text-center font-bold">Please <a href="/login" class="text-brand-main">log in </a>to
                        view
                    </div>
                </div>
            </div>
            <?php endif;  ?>
            <?php endwhile; // End of the loop. ?>
        </main><!-- #primary -->
    </section><!-- #primary -->
</div>
<?php
 get_footer();
 ?>
</div>
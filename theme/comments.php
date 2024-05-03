<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both
 * the current comments and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cablecast
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
    <h2 class="comments-title text-lg font-bold mb-4">
        <?php
			$cablecast_comment_count = get_comments_number();
			if ( '1' === $cablecast_comment_count ) {
				printf(
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'cablecast' ),
					get_the_title()
				);
			} else {
				printf(
					esc_html( _nx( '%1$s comments on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $cablecast_comment_count, 'comments title', 'cablecast' ) ),
					number_format_i18n( $cablecast_comment_count ),
					get_the_title()
				);
			}
			?>
    </h2>

    <nav class="comment-navigation flex justify-between mb-4" role="navigation">
        <?php previous_comments_link( esc_html__( 'Older Comments', 'cablecast' ) ); ?>
        <?php next_comments_link( esc_html__( 'Newer Comments', 'cablecast' ) ); ?>
    </nav>

    <ol class="comment-list space-y-4">
        <?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'callback'   => 'cablecast_html5_comment',
					'short_ping' => true,
				)
			);
			?>
    </ol>

    <nav class="comment-navigation flex justify-between mt-4" role="navigation">
        <?php previous_comments_link( esc_html__( 'Older Comments', 'cablecast' ) ); ?>
        <?php next_comments_link( esc_html__( 'Newer Comments', 'cablecast' ) ); ?>
    </nav>

    <?php if ( ! comments_open() ) : ?>
    <p class="no-comments text-gray-600"><?php esc_html_e( 'Comments are closed.', 'cablecast' ); ?></p>
    <?php endif; ?>

    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
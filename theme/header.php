<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cablecast
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class();?>>

    <?php wp_body_open(); ?>

    <div id="page" class="flex min-h-screen flex-col justify-between bg-brand-secondary">
        <a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'cablecast' ); ?></a>
        <div class="flex min-h-screen flex-col justify-between">
            <div>
                <?php get_template_part( 'template-parts/layout/header', 'content' ); ?>
            <div class="bg-white w-full pt-7 pb-7">
                <div id="content" class="background_color">
<?php
/**
 * cablecast functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cablecast
 */

if ( ! defined( 'CABLECAST_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'CABLECAST_VERSION', '0.1.0' );
}

if ( ! defined( 'CABLECAST_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `cablecast_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'CABLECAST_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'cablecast_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cablecast_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on cablecast, use a find and replace
		 * to change 'cablecast' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cablecast', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'cablecast' ),
				'menu-2' => __( 'Footer Menu Col-1', 'cablecast' ),
				'menu-3' => __( 'Footer Menu Col-2', 'cablecast' ),
				'menu-4' => __( 'Footer Menu Col-3', 'cablecast' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );

		// Add Custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'cablecast_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cablecast_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'cablecast' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'cablecast' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cablecast_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cablecast_scripts() {
	wp_enqueue_style( 'cablecast-style', get_stylesheet_uri(), array(), CABLECAST_VERSION );
	wp_enqueue_script( 'cablecast-script', get_template_directory_uri() . '/js/script.min.js', array(), CABLECAST_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cablecast_scripts' );

/**
 * Enqueue the block editor script.
 */
function cablecast_enqueue_block_editor_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'cablecast-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			CABLECAST_VERSION,
			true
		);
		wp_add_inline_script( 'cablecast-editor', "tailwindTypographyClasses = '" . esc_attr( CABLECAST_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'cablecast_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function cablecast_tinymce_add_class( $settings ) {
	$settings['body_class'] = CABLECAST_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'cablecast_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

function display_shows_by_category_shortcode($atts) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'category' => '', // Default category is empty
    ), $atts);

    // Get category from shortcode attribute
    $category = sanitize_text_field($atts['category']);

    // Initialize output variable
    $output = '';

    // Query shows based on category
    $args = array(
        'post_type' => 'show', // Custom post type name
        'posts_per_page' => -1, // Retrieve all shows
        'tax_query' => array(
            array(
                'taxonomy' => 'category', // Taxonomy name
                'field' => 'name', // Query by category name
                'terms' => $category, // Category name from shortcode attribute
            ),
        ),
    );

    $query = new WP_Query($args);
	if ($query->have_posts()) {

		$output .= '<div class="show-list">';
		$output .= '<div class="flex justify-between items-center">';
		$output .= '<h2 class="uppercase text-3xl my-4">' . $category . '</h2>';
	
		$output .= '<a class="!text-brand-accent no-underline hover:underline my-4" href="' . esc_url(get_post_type_archive_link('show')) . '">View All</a>';
		$output .= '</div>';
		$output .= '<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">'; // 
	
		$counter = 0;

		while ($query->have_posts() && $counter < 5) {
			$query->the_post();
			$output .= '<div class="flex flex-col items-center">';
			$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>'; 
			$output .= '<a class="!text-brand-secondary no-underline hover:underline" href="' . get_permalink() . '">' . get_the_title() . '</a>'; 
			$output .= '</div>';
		}
	
		// Reset post data
		wp_reset_postdata();
	
		$output .= '</div>'; // Close the grid container
		$output .= '</div>'; // Close the show-list container
	} else {
        // No shows found
        $output .= '<p>No shows found in the ' . $category . ' category.</p>';
    }

    return $output;
}

// Register the shortcode
add_shortcode('display_shows_by_category', 'display_shows_by_category_shortcode');
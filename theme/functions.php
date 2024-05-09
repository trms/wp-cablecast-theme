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
				'menu-5' => __( 'Footer Menu Col-4', 'cablecast' ),
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

function url_exists($url) {
    $headers = @get_headers($url);
    return strpos($headers[0], '200') !== false;
}

function display_shows_by_category_shortcode($atts) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'category' => '', // Default category is empty
        'number'   => null, // Default number of posts is null
    ), $atts);

    // Get attributes from shortcode
    $category = sanitize_text_field($atts['category']);
    $number   = intval($atts['number']); // Ensure number is an integer

    // Initialize output variable
    $output = '';

    // Check if the URL contains the "shows" slug
    $current_url = $_SERVER['REQUEST_URI'];
    $hide_view_all_link = strpos($current_url, 'shows') !== false;

    // Construct the "View All" link URL
    $view_all_link = $hide_view_all_link ? '' : esc_url(add_query_arg('category', $category, get_post_type_archive_link('show')));

    // Query shows based on category and number of posts
    $args = array(
        'post_type' => 'show', // Custom post type name
        'tax_query' => array(
            array(
                'taxonomy' => 'category', // Taxonomy name
                'field'    => 'name',     // Query by category name
                'terms'    => $category,  // Category name from shortcode attribute
            ),
        ),
    );

    // Check if number attribute is provided
    if ($number !== null) {
        $args['posts_per_page'] = $number; // Set number of posts to retrieve
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {

        $output .= '<div class="show-list">';
        $output .= '<div class="flex justify-between items-center">';
        $output .= '<h2 class="uppercase text-3xl my-4">' . $category . '</h2>';

        // Only show link if not on a page with "shows" slug
        if (!$hide_view_all_link && !empty($view_all_link)) {
            $output .= '<a class="!text-brand-accent no-underline hover:underline my-4" href="' . $view_all_link . '">View All</a>';
        }
        
        $output .= '</div>';
        $output .= '<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">'; // 
    
		while ($query->have_posts()) {
			$query->the_post();
			$post_id = get_the_ID();
		        // Check if the rcp_user_can_access function exists and run it if so
                if (function_exists('rcp_user_can_access')) {
                    $can_access = rcp_user_can_access(get_current_user_id(), $post_id);
                } else {
                    // If the function doesn't exist, default to true (access granted)
                    $can_access = true;
                }
		
			// Begin individual show container
			$output .= '<div class="show-container relative">';  // Added a relative position for overlay purposes
		
			// Start link tag wrapping both thumbnail and title
			$output .= '<a href="' . esc_url(get_permalink()) . '" class="no-underline hover:underline">';
		
			// Thumbnail logic
			if (has_post_thumbnail()) {
				$thumbnail_html = '<img src="' . esc_url(get_the_post_thumbnail_url($post_id, 'full')) . '" alt="' . esc_attr(get_the_title()) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image">';
				$output .= '<div>' . $thumbnail_html . '</div>';
			}
		
			// Show title
			$output .= '<span class="show-title !text-brand-secondary">' . esc_html(get_the_title()) . '</span>';
		
			// End link tag
			$output .= '</a>';
		
			$output .= '</div>'; // End individual show container
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

function hide_admin_bar_from_non_admins() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'hide_admin_bar_from_non_admins');

function add_login_logout_link($items, $args) {
    if ($args->theme_location == 'menu-1') {
        if (is_user_logged_in()) {
            $link = '<li class="menu-item btn primary-button"><a href="' . esc_url(site_url('/register/your-membership/')) . '" class="button-style">My Membership</a></li>';
        } else {
            $link = '<li class="menu-item btn primary-button"><a href="' . esc_url(site_url('/login')) . '" class="button-style">Members Sign In</a></li>';
        }
        $items .= $link;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

function sanitize_color( $color ) {
    // Check for hex colors
    $color = sanitize_hex_color($color);
    if ( ! $color ) {
        // Check for rgba colors (simple validation)
        if ( preg_match('/^rgba\(\d+\,\s*\d+\,\s*\d+\,\s*(0|1|0?.\d+)\)$/', trim($color) ) ) {
            return $color;
        }
        return null;  // Return null if neither hex nor rgba is valid
    }
    return $color;
}


function custom_theme_colors( $wp_customize ) {
    // Add Section for Site Colors
    $wp_customize->add_section('cablecast_site_colors', array(
        'title'    => __('Site Colors', 'cablecast'),
        'priority' => 30,
    ));

    // Settings and Controls for Color Options with Defaults
    $colors = array(
        'banner_color'           => array(__('Banner Color', 'cablecast'), '#545C6E'),
        'main_background_color'       => array(__('Background Color', 'cablecast'), '#E8E8F0'),
        'gradient_color'         => array(__('Gradient Color', 'cablecast'), '#576b80'),
        'primary_button_color'   => array(__('Primary Button Color', 'cablecast'), '#2DB566'),
        'secondary_button_color' => array(__('Secondary Button Color', 'cablecast'), '#3192C8'),
        'body_button_color'      => array(__('Body Button Color', 'cablecast'), '#3192C8'),
    );

    foreach ($colors as $id => $value) {
        // Add Setting with Default Color
        $wp_customize->add_setting($id, array(
            'default'           => $value[1], // Default color value
			'sanitize_callback' => 'sanitize_color',
            'transport'         => 'refresh',
        ));

        // Add Control
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            $id,
            array(
                'label'    => $value[0], // Label
                'section'  => 'cablecast_site_colors',
                'settings' => $id,
				'capability' => 'edit_theme_options',
            )
        ));
    }
}
add_action('customize_register', 'custom_theme_colors');


function cablecast_customizer_css() {
    ?>
<style type="text/css">
.banner {
    background-color: <?php echo get_theme_mod('banner_color', '#545C6E');
    ?>;
}

#primary,
.primary {
    background-color: <?php echo get_theme_mod('main_background_color', '#E8E8F0');
    ?>;
}

.gradient {
    background-image: linear-gradient(<?php echo get_theme_mod('gradient_color', '#576b80'); ?>, <?php echo get_theme_mod('background_color', '#ffffff'); ?>);
}

.primary-button {
    background-color: <?php echo get_theme_mod('primary_button_color', '#2DB566');
    ?>;
}

.secondary-button {
    background-color: <?php echo get_theme_mod('secondary_button_color', '#3192C8');
    ?>;
}

.body-button {
    background-color: <?php echo get_theme_mod('body_button_color', '#3192C8');
    ?>;
}
</style>
<?php
}
add_action('wp_head', 'cablecast_customizer_css');
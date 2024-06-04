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

function search_shows_callback() {
    $searchTerm = $_POST['searchTerm'];

    // Query shows based on search term
    $args = array(
        'post_type'      => 'show', // Custom post type name
        's'              => $searchTerm,
        'posts_per_page' => -1 // Retrieve all matching posts
    );

    $query = new WP_Query($args);

    // Initialize output variable
    $output = '';

    // Render thumbnails of matching shows
    if ($query->have_posts()) {
        $output .= '<div class="show-list mt-8">';
        $output .= '<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">'; 

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Begin individual show container
            $output .= '<div class="show-container relative">';

            // Start link tag wrapping both thumbnail and title
            $output .= '<a href="' . esc_url(get_permalink()) . '" class="no-underline hover:underline">';

			// Thumbnail logic
			if (has_post_thumbnail()) {
				$thumbnail_html = '<img src="' . esc_url(get_the_post_thumbnail_url($post_id, 'full')) . '" alt="' . esc_attr(get_the_title()) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image">';
				$output .= '<div>' . $thumbnail_html . '</div>';
			} else {
				// If no thumbnail is available, use the placeholder image
				$placeholder_url = get_template_directory_uri() . '/thumbnail_placeholder.png'; // Adjust the path as needed
				$output .= '<img src="' . $placeholder_url . '" alt="Thumbnail Placeholder" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" >';
			}

            // Show title
            $output .= '<span class="show-title !text-brand-secondary break-words">' . esc_html(get_the_title()) . '</span>';

            // End link tag
            $output .= '</a>';

            $output .= '</div>'; // End individual show container
        }

        $output .= '</div>'; // Close the grid container
        $output .= '</div>'; // Close the show-list container
    } else {
        // No shows found
        $output .= '<p class="mt-4">No shows found.</p>';
    }

    // Output the HTML
    echo $output;

    // Reset post data
    wp_reset_postdata();

    // Ensure that no further processing is performed
    wp_die();
}
add_action('wp_ajax_search_shows', 'search_shows_callback');
add_action('wp_ajax_nopriv_search_shows', 'search_shows_callback');



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
        $output .= '<h2 class="uppercase text-2xl my-4">' . $category . '</h2>';

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
			} else {
				// If no thumbnail is available, use the placeholder image
				$placeholder_url = get_template_directory_uri() . '/thumbnail_placeholder.png'; // Adjust the path as needed
				$output .= '<img src="' . $placeholder_url . '" alt="Thumbnail Placeholder" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" >';
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
        $output .= '<p class="mt-4">No shows found in the ' . $category . ' category.</p>';
    }

    return $output;
}

// Register the shortcode
add_shortcode('display_shows_by_category', 'display_shows_by_category_shortcode');

function load_categories_callback() {
    // Get the page number from the AJAX request
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    // Get all categories
    $categories = get_categories(array(
        'taxonomy'   => 'category',
        'hide_empty' => false, // Include categories with no posts
    ));
    
    // Paginate categories
    $posts_per_page = 10;
    $total_categories = count($categories);
    $total_pages = ceil($total_categories / $posts_per_page);
    $offset = ($paged - 1) * $posts_per_page;

    // Output categories
    ob_start();
    echo '<div id="categories">';
    // Loop through each category and display shortcode for each
    for ($i = $offset; $i < min($offset + $posts_per_page, $total_categories); $i++) {
        // Construct the shortcode with the dynamic category value
        $shortcode = '[display_shows_by_category category="' . $categories[$i]->name . '"]';
        // Output the shortcode
        echo do_shortcode($shortcode);
    }
    echo '</div>';
    $categories_html = ob_get_clean();

    // Output pagination buttons
    ob_start();
    if ($total_pages > 1) {
        echo '<div class="pagination flex justify-center my-4">';
        if ($paged > 1) {
            echo '<a href="#" data-page="' . ($paged - 1) . '" class="button prev px-2 py-1 mx-1 bg-gray-200 hover:bg-gray-300">Previous</a>';
        }
        // Display all page links
        for ($i = 1; $i <= $total_pages; $i++) {
            $current_page_class = ($paged == $i) ? 'bg-white text-black border border-slate-300 shadow-xl' : 'bg-gray-200 hover:bg-gray-300';
            echo '<a href="#" data-page="' . $i . '" class="button ' . $current_page_class . ' px-2 py-1 mx-1">' . $i . '</a>';
        }
        if ($paged < $total_pages) {
            echo '<a href="#" data-page="' . ($paged + 1) . '" class="button next px-2 py-1 mx-1 bg-gray-200 hover:bg-gray-300">Next</a>';
        }
        echo '</div>';
    }
    $pagination_html = ob_get_clean();

    // Return the response as JSON
    wp_send_json_success(array(
        'categories' => $categories_html,
        'pagination' => $pagination_html,
    ));
}
add_action('wp_ajax_load_categories', 'load_categories_callback');
add_action('wp_ajax_nopriv_load_categories', 'load_categories_callback');




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
    /* background-color: <?php echo get_theme_mod('main_background_color', '#E8E8F0');
    ?>; */
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

function my_theme_enqueue_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

add_post_type_support( 'page', 'excerpt' );


// extends number of custom field names in drop down -----

function customfield_limit_increase( $limit ) {
    $limit = 200;
    return $limit;
  }
  add_filter( 'postmeta_form_limit', 'customfield_limit_increase' );

// ------  end extend
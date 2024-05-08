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
		
			$can_access = rcp_user_can_access(get_current_user_id(), $post_id);
		
			// Begin individual show container
			$output .= '<div class="show-container relative">';  // Added a relative position for overlay purposes
		
			// Thumbnail and overlay logic
			if (has_post_thumbnail()) {
				$thumbnail_html = '<img src="' . esc_url(get_the_post_thumbnail_url($post_id, 'full')) . '" alt="' . esc_attr(get_the_title()) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image">';
		
				if (!$can_access) {
					$thumbnail_html = '
					<div class="relative inline-block">' . $thumbnail_html . '
						<div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-70 text-white flex items-center justify-center opacity-100 flex-col text-[11px]">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4 w-4">
								<path fill="#ffffff" d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/>
							</svg>
							<span class="text-white no-underline my-2">This content is for members only!</span>
							<span>Please <a class="!text-brand-main" href="/login">log in</a> to view</span>
						</div>
					</div>';
				}
		
				$output .= '<div class="' . (!$can_access ? 'restricted-link' : '') . '">' . $thumbnail_html . '</div>';
			}
		
			// Show title
			$output .= '<a class="show-title !text-brand-secondary no-underline hover:underline" href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';
		
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

function modify_show_content($content) {
    if (is_singular('show') && in_the_loop() && is_main_query()) {
        ob_start(); // Start output buffering
            //VIDEO PLAYER
            $video_iframe = get_post_meta(get_the_ID(), 'cablecast_vod_embed', true);
            if ($video_iframe) {
                echo '<div class="embed-responsive">';
                echo $video_iframe;
                echo '</div>';
            }
            
            // SHOW TITLE 
            the_title('<h1 class="text-3xl mt-8">', '</h1>');
            
            // CUSTOM FIELDS
			 // Fetch the options from the WordPress options table where settings are stored
			 $options = get_option('shows_options');

			 // Fetch the list of all custom fields you might want to show
			 $custom_fields = get_custom_fields_for_shows();
		 
			 // Iterate through each custom field
			 foreach ($custom_fields as $field) {
				 // Check if this field is enabled in the settings
				 if (!empty($options[$field])) {
					 // Fetch the value of this custom field from the current post
					 $value = get_post_meta(get_the_ID(), $field, true);
		 
					 // If the value exists, display it
					 if (!empty($value)) {
						 echo '<p>' . esc_html($value) . '</p>';
					 }
				 }
			 }
        
        $new_content = ob_get_clean(); // Get the buffer and clean it
        return $new_content;
    }
    
    return $content; // Return the unmodified content for other post types
}

add_filter('the_content', 'modify_show_content');


// CUSTOM FIELDS SETTINGS 
function get_custom_fields_for_shows() {
    global $wpdb;
    $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'show' AND post_status = 'publish'");

    $meta_keys = [];
    foreach ($post_ids as $post_id) {
        $post_meta = get_post_meta($post_id);
        foreach ($post_meta as $key => $value) {
            if (!in_array($key, $meta_keys)) {
                $meta_keys[] = $key;
            }
        }
    }
    
    return $meta_keys;
}

function shows_settings_init() {
    // Register a new setting for "shows" page
    register_setting('shows', 'shows_options');

    // Register a new section in the "shows" page
    add_settings_section(
        'shows_custom_fields_section',
        'Custom Fields Display Settings',
        'shows_custom_fields_section_cb',
        'shows'
    );

    // Register each custom field control
    $custom_fields = get_custom_fields_for_shows(); // Assume this function fetches your fields
    foreach ($custom_fields as $field) {
        add_settings_field(
            'shows_field_' . $field, // Unique ID of the field
            $field, // Title of the field
            'shows_custom_field_cb', // Callback for field HTML
            'shows',
            'shows_custom_fields_section',
            [
                'label_for' => 'shows_field_' . $field,
                'class' => 'shows_row',
                'shows_custom_field_name' => $field,
            ]
        );
    }
}

function shows_custom_fields_section_cb() {
    echo '<p>Select the custom fields you want to display on the frontend.</p>';
}

function shows_custom_field_cb($args) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('shows_options');
    $field_name = $args['shows_custom_field_name'];
    $checked = isset($options[$field_name]) ? checked(1, $options[$field_name], false) : '';
    ?>
<input type="checkbox" id="<?php echo esc_attr($args['label_for']); ?>"
    name="shows_options[<?php echo esc_attr($field_name); ?>]" value="1" <?php echo $checked; ?>>
<?php
}




add_action('admin_init', 'shows_settings_init');
function shows_options_sub_menu() {
    add_submenu_page(
        'edit.php?post_type=show',  // Parent slug
        'Shows Settings',           // Page title
        'Settings',            // Menu title
        'manage_options',           // Capability
        'shows-settings',           // Menu slug
        'shows_options_page_html'   // Callback function
    );
}

add_action('admin_menu', 'shows_options_sub_menu');


function shows_options_page_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages
    settings_errors('shows_messages');
    ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
            // output security fields for the registered setting "shows"
            settings_fields('shows');
            // output setting sections and their fields
            do_settings_sections('shows');
            // output save settings button
            submit_button('Save Settings');
            ?>
    </form>
</div>
<?php
}
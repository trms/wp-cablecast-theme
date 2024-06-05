<?php
get_header();
?>

<div class="entry-content h-full min-h-screen" id="primary">
    <div id="spinner" class="spinner" style="display: none;"></div>

    <?php
    // Check if the category parameter is set in the URL
    if (isset($_GET['category'])) {
        // Get the value of the category parameter from the URL
        $category = sanitize_text_field($_GET['category']); // Sanitize the input
        // Construct the shortcode with the category parameter
        $shortcode = '[display_shows_by_category category="' . esc_attr($category) . '"]';
        // Output the shortcode
        echo do_shortcode($shortcode);
    } else {
        // Display the search input if no category parameter is set
        ?>
    <div class="search-container w-full text-center">
        <h2 class="page-title text-center">SHOWS</h2>
        <input type="text" id="show-search" class="w-3/4 border border-gray-400 my-0 mx-auto p-2"
            placeholder="Search shows">
    </div>
    <div id="show-thumbnails"></div>
    <div id="categories-container">
        <?php
        
            // Check if neither category nor search term is present
            if (!isset($_GET['category']) && !isset($_POST['searchTerm'])) {
                // Get all categories
                $categories = get_categories(array(
                    'taxonomy'   => 'category',
                    'hide_empty' => false, // Include categories with no posts
                ));

                // Paginate categories
                $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
                $posts_per_page = 10;
                $total_categories = count($categories);
                $total_pages = ceil($total_categories / $posts_per_page);
                $offset = ($paged - 1) * $posts_per_page;

                echo '<div id="categories">';
                // Loop through each category and display shortcode for each
                for ($i = $offset; $i < min($offset + $posts_per_page, $total_categories); $i++) {
                    // Construct the shortcode with the dynamic category value
                    $shortcode = '[display_shows_by_category category="' . esc_attr($categories[$i]->name) . '"]';
                    // Output the shortcode
                    echo do_shortcode($shortcode);
                }
                echo '</div>';

                // Output pagination buttons
                if ($total_pages > 1) {
                    echo '<div class="pagination flex justify-center my-10">';
                    if ($paged > 1) {
                        echo '<a href="#" data-page="' . ($paged - 1) . '" class="button prev px-2 py-1 mx-1 bg-gray-200 hover:bg-gray-300">Previous</a>';
                    }
                    // Display all page links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $current_page_class = ($paged == $i) ? 'bg-white text-black border border-gray-300' : 'bg-gray-200 hover:bg-gray-300';
                        echo '<a href="#" data-page="' . $i . '" class="button ' . $current_page_class . ' px-2 py-1 mx-1">' . $i . '</a>';
                    }
                    if ($paged < $total_pages) {
                        echo '<a href="#" data-page="' . ($paged + 1) . '" class="button next px-2 py-1 mx-1 bg-gray-200 hover:bg-gray-300">Next</a>';
                    }
                    echo '</div>';
                }
            }
            ?>
    </div>
    <?php
    }
    ?>
</div>

<?php
get_footer();
?>

<script>
jQuery(document).ready(function($) {
    var xhr; // Variable to hold the AJAX request

    $('#show-search').on('input', function() {
        var searchTerm = $(this).val();

        // If the search term is empty, reload the page
        if (searchTerm === '') {
            location.reload();
            return;
        }

        // Cancel the previous AJAX request if it's still running
        if (xhr && xhr.readyState !== 4) {
            xhr.abort();
        }

        // Show the spinner
        $('#spinner').show();

        // Empty the container where shows are displayed
        $('#show-thumbnails').empty();
        $('#categories-container').empty();

        // Perform AJAX request to retrieve matching shows
        xhr = $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'search_shows',
                searchTerm: searchTerm
            },
            success: function(response) {
                $('#show-thumbnails').html(response);
                $('#spinner')
                    .hide(); // Hide the spinner once the AJAX request is successful
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#spinner').hide(); // Hide the spinner in case of an error
            }
        });
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).data('page');

        // Show the spinner
        $('#spinner').show();

        // Perform AJAX request to load categories
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_categories',
                page: page
            },
            success: function(response) {
                if (response.success) {
                    $('#categories-container').html(response.data.categories + response.data
                        .pagination);
                }
                $('#spinner')
                    .hide(); // Hide the spinner once the AJAX request is successful
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#spinner').hide(); // Hide the spinner in case of an error
            }
        });
    });
});
</script>
<?php
get_header();
?>
<div class="entry-content p-2 h-full min-h-screen" id="primary">
    <div id="spinner" class="spinner" style="display: none;"></div>
    <?php
    // Check if the category parameter is set in the URL
    if (isset($_GET['category'])) {
        // Get the value of the category parameter from the URL
        $category = $_GET['category'];
        // Construct the shortcode with the category parameter
        $shortcode = '[display_shows_by_category category="' . $category . '"]';
        // Output the shortcode
        echo do_shortcode($shortcode);
    } else {
        // Display the search input if no category parameter is set
        ?>
    <div class="search-container w-full text-center">
        <h1 class="text-center text-3xl font-bold my-4">Shows</h1>
        <input type="text" id="show-search" class="w-3/4 my-0 mx-auto p-2" placeholder="Search shows">
        <div id="show-thumbnails"></div>
    </div>
    <div id="categories">
        <?php
        // Check if the spinner is not visible and neither category nor search term is present
        if (!isset($_GET['category']) && !isset($_POST['searchTerm'])) {
            // Get all categories
            $categories = get_categories(array(
                'taxonomy'   => 'category',
                'hide_empty' => false, // Include categories with no posts
            ));
            // Loop through each category and display shortcode for each
            foreach ($categories as $cat) {
                // Construct the shortcode with the dynamic category value
                $shortcode = '[display_shows_by_category category="' . $cat->name . '"]';
                // Output the shortcode
                echo do_shortcode($shortcode);
            }
        }
    }
    ?>
    </div>
</div>

<?php
get_footer();
?>


<script>
jQuery(document).ready(function($) {
    var xhr; // Variable to hold the AJAX request

    $('#show-search').on('input', function() {
        var searchTerm = $(this).val();

        // Cancel the previous AJAX request if it's still running
        if (xhr && xhr.readyState !== 4) {
            xhr.abort();
        }

        // Show the spinner
        $('#spinner').show();

        // Empty the container where shows are displayed
        $('#show-thumbnails').empty();
        $('#categories').empty();

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
});
</script>
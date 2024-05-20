<?php
get_header();
?>
<div class="entry-content p-2 h-full" id="primary">
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
    <?php
        // Get all categories if no category parameter is set
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
    ?>
</div>

<?php
get_footer();
?>


<script>
jQuery(document).ready(function($) {
    $('#show-search').on('input', function() {
        var searchTerm = $(this).val();

        // Perform AJAX request to retrieve matching shows
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'search_shows',
                searchTerm: searchTerm
            },
            success: function(response) {
                $('#show-thumbnails').html(response);
            }
        });
    });
});
</script>
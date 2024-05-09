<?php ?>
<div>
    <?php
get_header();

// Check if the category parameter is set in the URL
if (isset($_GET['category'])) {
    // Get the value of the category parameter from the URL
    $category = $_GET['category'];
} else {
    // Default category value if the parameter is not set
    $category = "Instructional"; // You can set any default category here
}

// Construct the shortcode with the dynamic category value
$shortcode = '[display_shows_by_category category="' . $category . '"]';

?>
    <div class="entry-content p-2 h-screen" id="primary">
        <?php 
    // Output the shortcode with do_shortcode function
    echo do_shortcode($shortcode);
    ?>
    </div>
</div>
<?php
get_footer();
?>
</div>

<?php 
$post_id = get_the_ID();
$description = get_post_meta($post->ID, 'Program Description', true);

echo '<div class="mt-4">' . esc_html($description) . '</div>';

echo '<div>' . get_post_meta($post_id, 'cablecast_show_comments', true) . '</div>';

// Buttons to download the agenda and video
$agendaDownload = true;
$videoDownload = true;
echo '<div class="py-5 flex">';
if ($agendaDownload) { ?>
    <a href="#" class="w-full sm:w-auto text-center rounded secondary-button px-4 py-2 mr-3 text-xs font-semibold text-white shadow-sm">Download Agenda</a>
<?php }
if ($videoDownload) { ?>
    <a href="#" class="w-full sm:w-auto text-center rounded secondary-button px-4 py-2 text-xs font-semibold text-white shadow-sm">Download Video</a>
<?php }
echo '</div>';


// Flex container for custom fields in two columns
if ($agendaDownload) {
    echo '<div>';
} else {
    echo '<div class="sm:flex justify-between">';
}
$fields = [
    'cablecast_producer_name' => 'Producer',
    'cablecast_category_name' => 'Category',
    'cablecast_project_name' => 'Project',
];

// Retrieve and format the TRT field
$trt = get_post_meta($post_id, 'cablecast_show_trt', true);
$trtFormatted = $trt ? gmdate("H:i:s", $trt) : '';

// Get the event date from post meta
$eventDate = get_post_meta($post_id, 'cablecast_show_event_date', true);

// Parse the date string using DateTime class
$date = new DateTime($eventDate);

// Format the date to your desired format'
$formattedDate = $date->format('m-d-Y');


// If TRT is available, add to fields array at the desired position
if ($trtFormatted) {
    $fields = ['cablecast_show_trt' => 'Length'] + $fields;
}

$col1 = array_slice($fields, 0, 2, true);  // First half of fields
$col2 = array_slice($fields, 2, null, true); // Second half of fields

// Column 1
echo '<div class="flex-1 mr-4">';
foreach ($col1 as $key => $label) {
    $value = get_post_meta($post_id, $key, true);
    if ($key == 'cablecast_show_trt') {
        $value = $trtFormatted; // Use formatted time for TRT
    }
    if ($value) {
        echo '<div class="mb-2"><span class="font-bold pr-2">' . $label . ': </span>' . $value . '</div>';
    }
}
if ($eventDate) {
    echo '<div class="mb-2"><span class="font-bold pr-2">Event Date: </span>' . $formattedDate . '</div>';
}
echo '</div>';

// Column 2
echo '<div class="flex-1">';
foreach ($col2 as $key => $label) {
    $value = get_post_meta($post_id, $key, true);
    if ($value) {
        echo '<div class="mb-2"><span class="font-bold pr-2">' . $label . ': </span>' . $value . '</div>';
    }
}
echo '</div>';

echo '</div>';

echo '</div>';
// end flex container
?>

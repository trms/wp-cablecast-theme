<?php
/**
 * The template for displaying all single shows
 *
 * @package cablecast
 */
?>
<div>
    <?php get_header(); ?>
    <main id="main">
        <article class="page-info-container single-show-page-container">
            <?php while (have_posts()) : the_post(); ?>
            <a href="/shows" class="link-color hover:underline block mb-3">« Back to Shows</a>
            <div class="flex flex-row gap-4">

                <div class="agenda-left hidden md:block grow">
                <?php get_template_part('template-parts/content/show-agenda'); ?>
                </div>

                <div class="video-right max-w-full md:max-w-lg">
                    <div <?php post_class(); ?>>
                        <?php
                        get_template_part('template-parts/content/show-video');

                        the_title('<h2 class="text-3xl font-bold mt-8 mb-4 heading-text-color">', '</h2>'); ?>
                        
                        <!-- Tabs start -->
                        <div class="show-tabs">
                            <!-- Code to turn tabs into a drop down
                            <div class="sm:hidden">
                                <label for="tabs" class="sr-only">Select a tab</label>
                            
                                <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" onchange="showTabContent(this.value)">
                                    <option value="details">Details</option>
                                    <option value="chapters">Chapters</option>
                                    <option value="agenda">Agenda</option>
                                </select>
                            </div> -->
                            <div class="block"> <!-- Use if using dropdown tabs for mobile: <div class="hidden sm:block"> -->
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex" aria-label="Tabs">
                                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                                        <a href="javascript:void(0);" id="tab-details" class="grow text-center tab-link whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" onclick="showTabContent('details')">Details</a>
                                        <a href="javascript:void(0);" id="tab-chapters" class="grow text-center tab-link whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" onclick="showTabContent('chapters')">Chapters</a>
                                        <a href="javascript:void(0);" id="tab-agenda" class="grow text-center tab-link whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 block md:hidden" onclick="showTabContent('agenda')">Agenda</a>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <!-- Tab content start -->
                        <div id="tab-content-details" class="tab-content">
                            <?php get_template_part('template-parts/content/show-detail'); ?>
                        </div>
                        <div id="tab-content-chapters" class="tab-content hidden">
                            <?php get_template_part('template-parts/content/show-chapters'); ?>
                        </div>
                        <div class="block md:hidden">
                        <div id="tab-content-agenda" class="tab-content hidden">
                            <?php get_template_part('template-parts/content/show-agenda'); ?>
                        </div>
                        </div>
                        <!-- Tab content end -->
                    </div>
                </div>
                
            </div>
            <?php endwhile; ?>
        </article>
    </main>
    <?php get_footer(); ?>
</div>

<!-- javascript for the tabs -->
<script>
function showTabContent(tab) {
    // Hide all tab content
    var tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(function(content) {
        content.classList.add('hidden');
    });

    // Remove active class from all tabs
    var tabLinks = document.querySelectorAll('.tab-link');
    tabLinks.forEach(function(link) {
        link.classList.remove('tab-border-color', 'link-color');
        link.classList.add('text-gray-500', 'hover:border-gray-300', 'hover:text-gray-700');
    });

    // Show the selected tab content
    document.getElementById('tab-content-' + tab).classList.remove('hidden');

    // Add active class to the selected tab
    document.getElementById('tab-' + tab).classList.add('tab-border-color', 'link-color');
    document.getElementById('tab-' + tab).classList.remove('text-gray-500', 'hover:border-gray-300', 'hover:text-gray-700');
}

// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTabContent('details');
});
</script>


<?php
/* Template Name: Our Clinic */
get_header();
?>

<section class="clearfix py-5">
    <div class="container">
        <h1 class="mb-4">Our Clinics</h1>
        <div class="clinic-layout">
            <div class="clinic-sidebar">
                <input type="text" id="clinicSearch" class="clinic-search-input" placeholder="Search clinics by name, address..." autocomplete="off">
                <div id="clinicList"></div>
            </div>
            <div class="clinic-map-wrap">
                <div id="clinicMap"></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

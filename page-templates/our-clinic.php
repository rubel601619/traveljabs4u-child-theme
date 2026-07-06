<?php
/* Template Name: Our Clinic */
get_header();
?>

<style>
    .heac-bg{
        background:radial-gradient(circle at 85% 55%, rgba(14, 138, 203, 0.08), transparent 30%),
    linear-gradient(135deg, #f8fcff 0%, #eef9fb 100%)
    }
    .custom-badge{
        background-color: #e8f8ef;
        color: #078743;
    }
</style>

<section class="clearfix heac-bg py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="text-start">
                    <span class="d-inline-block px-2 py-1 custom-badge rounded-pill small">
                        <i class="fa-solid fa-check"></i>
                        UK’s Trusted Travel Health Directory
                    </span>
                    <h1 class="fw-bold text-dark my-3">Find Travel <span style="color: #08a64f"> Vaccination <br> Clinics</span> Near You</h1>
                    <p>
                        Search trusted pharmacies and clinics offering travel vaccinations, malaria tablets, and expert travel health advice.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/client-map.png" class="w-100" style="max-width: 430px;" alt="Our Clinic">
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6"></div>
        </div>
    </div>
</section>

<section class="clearfix py-5">
    <div class="container">
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

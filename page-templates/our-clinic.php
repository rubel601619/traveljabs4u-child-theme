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
    .clinic-search-wrap {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }
    .clinic-search-wrap .clinic-search-input {
        flex: 1;
        margin-bottom: 0px;
    }
    .clinic-search-btn {
        display: none;
        padding: 12px 18px;
        background: #0073aa;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        transition: background 0.2s;
    }
    .clinic-search-btn:hover {
        background: #005a8c;
    }
    @media (max-width: 991px) {
        .clinic-search-btn {
            display: block;
        }
    }
    .clinic-info{
        text-align: left;
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
    </div>
</section>

<section class="clearfix py-5">
    <div class="container">
        <div class="clinic-layout">
            <div class="clinic-sidebar">
                <div class="clinic-search-wrap">
                    <input type="text" id="clinicSearch" class="clinic-search-input" placeholder="Search clinics by name, address..." autocomplete="off">
                    <button type="button" id="clinicSearchBtn" class="clinic-search-btn">Submit</button>
                </div>
                <div id="clinicList"></div>
            </div>
            <div class="clinic-map-wrap">
                <div id="clinicMap"></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

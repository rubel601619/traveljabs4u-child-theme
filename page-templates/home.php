<?php /* Template Name: Home */ get_header();?>

<style>
	.is-search-input{
		display: block;
		width: 100%;
		padding: 0.5rem;
		font-size: 1rem;
		border: 1px solid #ccc;
		&:focus {
			outline: none;
			border-color: #0073aa;
		}
	}
	ul.is-search-results {
		background: white;
		max-height: 250px;
		overflow-y: auto;
		padding: 1rem 0;
		margin: 0;
		list-style: none;
		a{
			display: block;
			padding: 0.5rem 1rem;
			text-decoration: none;
			color: #333;
			&:hover {
				background: #f0f0f0;
			}
		}
	}
	.heroBanner{
		height: auto !important;
		min-height: 550px;
	}
	a.custom-booking-link{
		background: #7ecb2a;
		color: #fff;
		padding: 12px 25px;
		border-radius: 5px;
		text-decoration: none;
		font-weight: bold;
		transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
		&:hover{
			background: #3871c1 !important;
			color: #fff;
			span{
				color: #fff;
			}
		}
	}
	.serviceColumn{
		height: 100%;
	}
	@media(min-width: 992px){
		.serviceColumns{
			margin-top: -40px;
		}
	}
	.text-theme-secondary{
		color: #7ecb2a;
	}
</style>

<span class="homePage">
	<div class="heroBanner vert-mid" style="background: url('<?php the_field("banner_image_fallback"); ?>');"  data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<video class="video" muted="muted" loop="loop" autoplay="autoplay" playsinline id="bannerVideo">
			<source src="<?php the_field("banner_video"); ?>" type="video/mp4">
		</video>
		<div class="heroContent py-5">
			<div class="fs-1"><strong><?php the_field('banner_title'); ?></strong></div>
            <div class="search-container mt-4">
                <div class="search-container-title">
                    <?php the_field('banner_content'); ?>
                </div>
				<div class="search" id="searchDestination">
					<!-- <div v-if="loading" class="search-loading">
						Loading destinations...
					</div> -->

					<input :disabled="loading" type="search" v-model="searchQuery" class="is-search-input"
							:placeholder="loading ? 'Loading...' : placeholderText" autocomplete="off">

					<p v-if="errorMessage" class="search-error">{{ errorMessage }}</p>

					<!-- TEMPORARY DEBUG PANEL — remove once fixed -->
					<!-- <div style="background:#111;color:#0f0;font-family:monospace;font-size:12px;padding:10px;margin-top:10px;">
						<div>loading: {{ loading }}</div>
						<div>initialLoadSuccess: {{ initialLoadSuccess }}</div>
						<div>errorMessage: {{ errorMessage || '(none)' }}</div>
						<div>allDestinations.length: {{ allDestinations.length }}</div>
						<div>searchQuery: "{{ searchQuery }}"</div>
						<div>localMatches.length: {{ localMatches.length }}</div>
						<div>usingRemote: {{ usingRemote }}</div>
						<div>remoteResults.length: {{ remoteResults.length }}</div>
						<div>displayList.length: {{ displayList.length }}</div>
					</div> -->

					<ul v-if="initialLoadSuccess && searchQuery.trim().length > 0" class="is-search-results">
						<li v-for="item in displayList" :key="item.id" class="is-search-result">
							<a :href="item.link" class="is-search-result-link">
								<span class="is-search-result-title">{{ item.title }}</span>
							</a>
						</li>
						<li v-if="!loading && !remoteLoading && displayList.length === 0" class="is-search-no-results text-dark">
							No destinations found.
						</li>
						<li v-if="remoteLoading" class="is-search-loading text-dark">Searching…</li>
					</ul>
				</div>
            </div>
			<p class="pt-5 d-lg-none">
				<a href="<?php echo esc_url( home_url( '/travel-vaccinations-near-me/' ) ); ?>" class="custom-booking-link">
					<span>BOOK VACCINATIONS</span>
				</a>
			</p>
		</div>
	</div>
	<section class="nopad">
		<div class="container">
			<div class="row serviceColumns" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
				<div class="col-lg-4 col-sm-12 p-0 p-lg-2">

						<div class="text-center col1 serviceColumn">
							<div class="icon mb-4">
								<?php the_field('icon_1'); ?>
							</div>
							<?php the_field('service_1'); ?>
						</div>

				</div>
				<div class="col-lg-4 col-sm-12 p-0 p-lg-2">

						<div class="text-center col2 serviceColumn">
							<div class="icon mb-4">
								<?php the_field('icon_2'); ?>
							</div>
							<?php the_field('service_2'); ?>
						</div>

				</div>
				<div class="col-lg-4 col-sm-12 p-0 p-lg-2">

						<div class="text-center col1 serviceColumn">
							<div class="icon mb-4">
								<?php the_field('icon_3'); ?>
							</div>
							<?php the_field('service_3'); ?>
						</div>

				</div>
			</div>
		</div>
	</section>

	<section class="cleearfix py-5" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="container py-lg-5">
			<div class="row g-3 align-items-center">
				<div class="col-md-6">
					<h1><span class="fs-4 text-theme-secondary">Travel Vaccinations &amp; Travel</span><br> Health Clinics in the UK</h1>
					<p class="mt-4 mb-5">Find a trusted clinic near you, check the vaccines recommended for your destination, and book a travel health appointment online.</p>

					<div class="d-flex gap-3">
						<a href="<?php echo esc_url(home_url('/our-clinics/'));?>" class="custom-button-outline-secondary">Find a Clinic Near You</a>
						<a href="<?php echo esc_url(home_url('/travel-vaccinations-by-destination/'));?>" class="custom-button-primary">Check Vaccines by Destination</a>
					</div>
				</div>
				<div class="col-md-6">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/travel-vaccinations-travel-health-clinics-in-the-uk.webp' ); ?>"
						alt="Travel Vaccinations Travel Health Clinics in the UK"
						class="w-100 mx-auto d-block"
						style="max-width: 500px;"
					>
				</div>
			</div>
		</div>
	</section>
	
	
	<section>
		<div class="container marg-40" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
			<div class="title-header center-title-header text-center">
				<?php the_field('review_title'); ?>
			</div>

			<?php
            $reviews_code = get_field('reviews_shortcode');
            echo do_shortcode($reviews_code);
            ?>
		</div>
	</section>


	<section class="cleearfix py-5" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="container py-lg-5">
			<div class="row g-3 align-items-center">
				
				<div class="col-md-6">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/travel-vaccination-made-simple.jpg' ); ?>"
						alt="Travel Vaccinations Made Simple"
						class="w-100 mx-auto d-block"
						style="max-width: 500px;"
					>
				</div>
				<div class="col-md-6">
					<h2 class="custom-title">Travel Vaccinations Made Simple</h2>
					<p>Travel vaccinations help protect you against diseases that are common in many parts of the world but rare in the UK, such as typhoid, hepatitis A, yellow fever and rabies. The vaccines that may be advised depend on where you are going, how long you are staying, what you will be doing and your medical history. TravelJabs4U helps you check the recommended vaccines for your destination, compare prices and book an appointment at a trusted travel health clinic near you.</p>
					<p>It is best to seek travel-health advice at least four to six weeks before departure, as some vaccines are given as a course over several weeks or need time to take full effect. If you are travelling sooner, it is still worth contacting a travel-health professional, as useful advice, vaccination or other preventive measures may still be available.</p>
				</div>
			</div>
		</div>
	</section>



	<section class="cleearfix py-5" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="container py-lg-5">
			<div class="row g-3 align-items-center">
				
				<div class="col-md-6 text-start">
					<h2 class="custom-title">Check Vaccines by Destination</h2>
					<p>Every country carries different health risks. Choose your destination to see the vaccines that may be recommended or required before you travel, along with malaria advice and other travel health guidance.</p>
					<ul class="text-start">
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-india-4/' ) ); ?>" class="text-dark">India</a></li>
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-thailand/' ) ); ?>" class="text-dark">Thailand</a></li>
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-vietnam/' ) ); ?>" class="text-dark">Vietnam</a></li>
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-indonesia/' ) ); ?>" class="text-dark">Indonesia</a></li>
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-egypt/' ) ); ?>" class="text-dark">Egypt</a></li>
						<li><a href="<?php echo esc_url( home_url( '/destination/travel-vaccinations-for-china/' ) ); ?>" class="text-dark">China</a></li>
					</ul>
					<p>
						<a href="<?php echo esc_url( home_url( '/travel-vaccinations-by-destination/' ) ); ?>">
							View all destinations &rarr;
						</a>
					</p>
					

				</div>
				<div class="col-md-6">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/travel-vaccinations-travel-health-clinics-in-the-uk.webp' ); ?>"
						alt="Travel Vaccinations Travel Health Clinics in the UK"
						class="w-100 mx-auto d-block"
						style="max-width: 500px;"
					>
				</div>
			</div>
		</div>
	</section>
	
	
	<?php if (get_field('enable_destinations_section')) { ?>
		<section class="pt-6 pb-5 bg-white">
			<div class="container">
				<div class="row" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
					<?php if (get_field('destinations_search_title')) { ?>
						<div class="col-12">
							<div class="title-header center-title-header text-center">
								<h2 class="title text-center"><?php echo get_field('destinations_search_title');?></h2>
							</div>
						</div>
					<?php } ?>
					<?php if (get_field('destinations_search_form')) { ?>
						<div class="search col-12 col-lg-7 mx-auto <?php if (get_field('destinations_search_content')) { ?>mb-5<?php }?>">
							<?php echo do_shortcode(get_field('destinations_search_form'));?>
						</div>
					<?php } ?>
					<?php if (get_field('destinations_search_content')) { ?>
						<div class="col-12">
							<?php echo get_field('destinations_search_content');?>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php if (get_field('enable_destinations_section')) {
		get_template_part('template-parts/section','destinations');
	} ?>

	<section class="marg-40">
		<div class="container">
			<div class="row" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
				<div class="col-lg-6 col-sm-12 order-md-1 order-2">
					<?php the_field('about_content'); ?>
					<?php
					  $link = get_field('about_link');
					  $url = $link['url'];
					  $title = $link['title'];
					?>
					<a class="btn1" href="<?= $url ?>"><?= $title ?></a>
					<br/>
					<br/>
				</div>
				<div class="col-lg-6 col-sm-12 order-md-2 order-1 mb-md-4">
					<img src="<?php the_field('about_image'); ?>">
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial-section">
		<div class="testimonials">
			<div class="orangecol">
				<img id="largeBackground" src="<?php the_field('background_image'); ?>" data-aos="fade-up" data-aos-duration="700" data-aos-offset="0">
				<div class="testimonial-content-sec" data-aos="fade-up" data-aos-duration="700" data-aos-offset="0">
					<div class="row">
						<?php the_field('testimonials_content'); ?>
					</div>
					<div class="testimonial">
						<div class="row">
							<div class="icon">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<div class="col-lg-9 col-sm-12">
								<?php the_field('testimonial_1'); ?>
							</div>
						</div>
					</div>
					<div class="testimonial">
						<div class="row">
							<div class="icon">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<div class="col-lg-9 col-sm-12">
								<?php the_field('testimonial_2'); ?>
							</div>
						</div>
					</div>
					<div class="testimonial">
						<div class="row">
							<div class="icon">
								<i class="fa-solid fa-quote-left"></i>
							</div>
							<div class="col-lg-9 col-sm-12">
								<?php the_field('testimonial_3'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cleearfix py-5 bg-light" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="container py-lg-5">
			<div class="row g-3 justify-content-center">
				
				<div class="col-lg-6 text-center">
					<h2 class="custom-title">Find a Travel Clinic Near You</h2>
					<p class="mt-3 mb-4">TravelJabs4U lists trusted travel vaccination clinics and travel health services across the UK. Browse clinics to check the vaccines they offer, view opening details and book your appointment.</p>
					<p>
						<a href="<?php echo esc_url( home_url( '/our-clinics/' ) ); ?>" class="custom-button-primary">
							Browse All Clinics
						</a>
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="cleearfix py-5 custom-gradient" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="container py-lg-5">
			<div class="row g-3 justify-content-center">
				
				<div class="col-lg-8 text-start">
					<h2 class="custom-title">Common Travel Vaccines</h2>
					<p>Depending on your trip, the travel vaccines that may be discussed include:</p>
					<ul class="d-grid gap-3 text-start">
						<li><strong>Hepatitis A</strong> — linked to contaminated food and water; often considered for destinations outside Western Europe, North America and Australasia.</li>
						<li><strong>Typhoid</strong> — often considered for travel to South Asia, Africa and parts of South America.</li>
						<li><strong>Yellow Fever</strong> — a certificate may be required for entry to, or from, certain countries in Africa and South America; only given at registered yellow fever centres.</li>
						<li><strong>Rabies</strong> — may be considered for longer trips, rural travel or likely contact with animals.</li>
						<li><strong>Hepatitis B</strong> — may be considered for longer stays and higher-risk activities.</li>
						<li><strong>Cholera</strong> — usually considered only in specific circumstances, such as humanitarian or disaster-relief travel.</li>
						<li><strong>Tetanus, Diphtheria &amp; Polio</strong> — a booster is often reviewed before travel.</li>
						<li><strong>Japanese Encephalitis</strong> — may be considered for longer or rural travel in parts of Asia.</li>
					</ul>
					<p>Your clinic will confirm which vaccines are appropriate for you based on your destination, itinerary and health history.</p>

					<h2 class="custom-title my-4">How It Works</h2>
					<ol class="d-grid gap-3">
						<li><strong>Check your destination</strong> — see the vaccines that may be recommended or required for the countries you are visiting.</li>
						<li><strong>Find a clinic</strong> — browse trusted travel health clinics and view prices.</li>
						<li><strong>Book your appointment</strong> — arrange your travel health consultation, ideally at least four to six weeks before you travel.</li>
					</ol>

					<hr>

					<h2 class="custom-title mb-4">Frequently Asked Questions</h2>
					<div class="accordion" id="faqsection">
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									<span>When should I get my travel vaccinations?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqsection">
							<div class="accordion-body">
								  <p>Try to seek travel-health advice at least four to six weeks before departure. Some vaccines require several doses or need time to provide protection. If you are travelling sooner, contact a travel-health professional because useful advice, vaccination or other preventive measures may still be available.</p>
							</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									<span>How much do travel vaccinations cost in the UK?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									 <p>Prices vary by vaccine and clinic. Some vaccines are available free on the NHS, while others are private and charged per dose. You can compare prices using the TravelJabs4U <a href="<?php echo esc_url( home_url( '/travel-vaccinations-prices/' ) ); ?>">travel vaccination price guide</a> before you book.</p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
									<span>Which travel vaccines do I need?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									  <p>It depends on your destination, the length and type of your trip, and your medical history. Check the relevant destination page for the vaccines that may be recommended or required, then confirm with a travel-health professional.</p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
									<span>Which travel vaccines are free on the NHS?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									  <p>Some travel vaccines are usually free on the NHS, including hepatitis A, typhoid, cholera, and polio (given as part of the combined tetanus, diphtheria and polio vaccine). Others, such as yellow fever, rabies, hepatitis B and Japanese encephalitis, are normally private and charged for.</p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
									<span>Do I need malaria tablets?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									<p>Not every traveller needs antimalarial tablets. The need depends on the regions you are visiting, your itinerary and your health history, so it is assessed during a travel-health consultation alongside advice on avoiding mosquito bites.</p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
									<span>How long do travel vaccinations last?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									  <p>It depends on the vaccine. Some provide protection for a year or two, others for ten years or longer, and a few require booster doses. Your clinic can confirm how long your vaccines last and whether a booster is due.</p>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
									<span>Where can I get travel jabs near me?</span>
									<span>
										<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#222"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
									</span>
								</button>
							</h3>
							<div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#faqsection">
								<div class="accordion-body">
									<p>Use the TravelJabs4U <a href="<?php echo esc_url( home_url( '/our-clinics/' ) ); ?>">clinic finder</a> to locate trusted travel vaccination clinics across the UK, check the vaccines they offer and book an appointment.</p>

								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<section class="marg-40" data-aos="fade-up" data-aos-duration="500" data-aos-offset="0">
		<div class="title-header center-title-header text-center">
			<?php the_field('blog_content'); ?>
		</div>
		<div class="container">
			<div class="row justify-content-center">
				<?php
				  
					$args = array(
					   'post_type' => 'post',
					   'posts_per_page' => '3'
					 );
					 
					$the_query = new WP_Query( $args );
					
					// The Loop
					if ( $the_query->have_posts() ) {
					  while ( $the_query->have_posts() ) {
						$the_query->the_post();?>
						   <div class="col-lg-4 col-md-6 col-sm-12">
							   <div class="blogTile">
								   <div class="featured-img">
									   <a href="<?php the_permalink()?>">
									   <?php
										the_post_thumbnail();
										?>
									   </a>
								   </div>
								   
								   <div class="blog-content">
									   <?php
										  the_title('<a class="blogLink" href="'. get_the_permalink() .'"><h3>', '</h3></a>');
										  the_excerpt();
									   ?>
									   <br/>
									   <a class="blogLink" href="<?php the_permalink(); ?>">
										   Read More <i class="fa fa-angle-double-right"></i>
									   </a>
								   </div>
							   </div>
						   </div>
						<?php } ?>
					  <?php } else {
					  echo '<div class="col-lg-12"><h2 style="text-align: center;">No posts are available right now. Please check back later!</h2></div>';
				   }
				   /* Restore original Post Data */
				   wp_reset_postdata();
				  
				  ?>
			</div>
		</div>
	</section>
</span>

<script src="https://cdn.jsdelivr.net/npm/axios@1.18.1/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.5.39/dist/vue.global.min.js"></script>


<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      loading: false,
      remoteLoading: false,
      errorMessage: '',
      initialLoadSuccess: false,
      placeholderText: 'Start typing your destination...',
      searchQuery: '',
      allDestinations: [],
      remoteResults: [],
      usingRemote: false,
      debounceTimer: null,
      abortController: null,
      remoteCache: new Map(),
      minChars: 2,
      localMatchThreshold: 3,
	  apiUrl: '/wp-json/wp/v2/destination',
    }
  },

  computed: {
    localMatches() {
      const query = this.searchQuery.trim().toLowerCase();
      if (!query) return [];
      const matches = this.allDestinations.filter(item => item.titleLower.includes(query));
      console.log(`[localMatches] query="${query}" -> ${matches.length} matches out of ${this.allDestinations.length} total`);
      return matches;
    },

    displayList() {
      return this.usingRemote ? this.remoteResults : this.localMatches;
    },
  },

  watch: {
    searchQuery() {
      clearTimeout(this.debounceTimer);

      if (this.abortController) {
        this.abortController.abort();
        this.abortController = null;
      }
      this.remoteLoading = false;

      const query = this.searchQuery.trim();

      if (query.length < this.minChars) {
        this.usingRemote = false;
        this.remoteResults = [];
        return;
      }

      this.usingRemote = false;

      this.debounceTimer = setTimeout(() => {
        console.log(`[watcher] localMatches.length=${this.localMatches.length}, threshold=${this.localMatchThreshold}`);
        if (this.localMatches.length < this.localMatchThreshold) {
          console.log('[watcher] falling back to remote search');
          this.searchRemote(query);
        }
      }, 300);
    },
  },

  methods: {
    async loadAllDestinations() {
      this.loading = true;
      this.errorMessage = '';
      this.initialLoadSuccess = false;

      const perPage = 100;
      let page = 1;
      let totalPages = 1;
      const results = [];

      try {
        do {
          console.log(`[loadAllDestinations] fetching page ${page}`);
          const response = await axios.get(
            this.apiUrl,
            {
              params: {
                _fields: 'id,title,link',
                per_page: perPage,
                page: page,
                orderby: 'title',
                order: 'asc',
              },
            }
          );

          console.log(`[loadAllDestinations] page ${page} returned ${response.data.length} items`);
          console.log('[loadAllDestinations] response headers:', response.headers);

          results.push(...response.data.map(item => ({
            id: item.id,
            title: item.title.rendered,
            titleLower: item.title.rendered.toLowerCase(),
            link: item.link,
          })));

          totalPages = parseInt(response.headers['x-wp-totalpages'], 10) || 1;
          console.log(`[loadAllDestinations] totalPages header = ${response.headers['x-wp-totalpages']}, parsed = ${totalPages}`);
          page++;
        } while (page <= totalPages);

        console.log(`[loadAllDestinations] DONE — total loaded: ${results.length}`);
        console.log('[loadAllDestinations] sample titles:', results.slice(0, 5).map(r => r.title));

        this.allDestinations = results;
        this.initialLoadSuccess = true;
      } catch (error) {
        console.error('[loadAllDestinations] FAILED:', error);
        this.errorMessage = 'Could not load destinations. Please refresh and try again.';
        this.initialLoadSuccess = false;
      } finally {
        this.loading = false;
      }
    },

    async searchRemote(query) {
      if (this.remoteCache.has(query)) {
        if (this.searchQuery.trim() === query) {
          this.remoteResults = this.remoteCache.get(query);
          this.usingRemote = true;
        }
        return;
      }

      if (this.abortController) {
        this.abortController.abort();
      }
      this.abortController = new AbortController();

      this.remoteLoading = true;
      this.errorMessage = '';

      try {
        const response = await axios.get(
          this.apiUrl,
          {
            params: {
              search: query,
              _fields: 'id,title,link',
              per_page: 10,
              orderby: 'relevance',
            },
            signal: this.abortController.signal,
          }
        );

        console.log(`[searchRemote] query="${query}" -> ${response.data.length} remote results`);

        if (this.searchQuery.trim() !== query) return;

        const results = response.data.map(item => ({
          id: item.id,
          title: item.title.rendered,
          link: item.link,
        }));

        this.remoteResults = results;
        this.remoteCache.set(query, results);
        this.usingRemote = true;
      } catch (error) {
        if (axios.isCancel(error) || error.code === 'ERR_CANCELED') return;
        if (this.searchQuery.trim() !== query) return;

        console.error('[searchRemote] FAILED:', error);
        this.remoteResults = [];
        this.usingRemote = true;
        this.errorMessage = 'Something went wrong while searching. Please try again.';
      } finally {
        this.remoteLoading = false;
      }
    },
  },

  mounted() {
    this.loadAllDestinations();
  },

}).mount('#searchDestination');
</script>
<?php get_footer();?>
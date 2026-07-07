<?php get_header(); ?>

<style>
	h2, h3,h4,h5,h6{
		font-weight: 500 !important;
		color: #212629 !important;
	}
	ul{
		text-align: left !important;
	}
	.clinic-link{
		color: #444 !important;
		:hover{
			color: #7ecb2a !important;
		}
	}
</style>

<section class="pageBanner vert-mid" style="background-image: url('<?= get_the_post_thumbnail_url(); ?>')">
	<div class="container">
		<h1 class="pageBannerTitle"><?php the_title(); ?></h1>
		<?php
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
		}
		?>
	</div>
</section>

<section class="clearfix py-5" style="background-color: #F8FAFC;">
	<div class="container py-lg-4">
		<div class="row g-lg-5">
			<div class="col-lg-8">
				<?php 
				if ( ! empty( get_the_content() ) ) : ?>
					<div class="mb-4">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>
				<?php
					$lat = get_field( 'clinic_latitude' );
					$lng = get_field( 'clinic_longitude' );
				?>
				<?php if ( $lat && $lng ) : ?>
					<div class="bg-white p-3">
						<div class="fs-5 mb-3 fw-bold"><i class="fa-solid fa-map"></i> Location</div>
						<iframe
							width="100%"
							height="400"
							style="border:0;border-radius:8px;"
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							src="https://maps.google.com/maps?q=<?php echo esc_attr( $lat ); ?>,<?php echo esc_attr( $lng ); ?>&z=15&output=embed">
						</iframe>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-4">
				<div class="bg-white p-3 border">
					<div class="fs-5 mb-3"><i class="fa-sharp fa-solid fa-location-dot"></i> Address</div>
					<p><?php the_field( 'clinic_address' ); ?></p>
					<?php if ( get_field( 'clinic_postcode' ) ) : ?>
						<p class="mb-0"><strong>Post Code :</strong> <?php the_field( 'clinic_postcode' ); ?></p>
					<?php endif; ?>
					<?php if ( get_field( 'clinic_phone' ) ) : ?>
						<p class="mb-0 mt-2"><i class="fa-solid fa-phone"></i> <a href="tel:<?php the_field( 'clinic_phone' ); ?>"><?php the_field( 'clinic_phone' ); ?></a></p>
					<?php endif; ?>

				</div>
				<div class="bg-white p-3 border mt-4">
					<div class="fs-5 mb-3"><i class="fa-sharp fa-solid fa-location-dot"></i> Others Clinics</div>
					<ul class="ps-4 m-0" style="max-height: 400px; overflow-y: auto;">
						<?php
						$the_query = new WP_Query( [
							'post_type'      => 'clinic',
							'posts_per_page' => -1,
							'post__not_in'   => [ get_the_ID() ],
							'orderby'        => 'title',
							'order'          => 'ASC',
						] );

						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
								?>
								<li><a href="<?php the_permalink(); ?>" class="text-decoration-none text-link clinic-link"><?php the_title(); ?></a></li>
								<?php
							}
						}
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-8">
				
				<hr>
				<div class="row">
					
					<div class="col-lg-6">
						
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

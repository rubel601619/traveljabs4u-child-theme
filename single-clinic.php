<?php get_header(); ?>

<style>
	h2, h3,h4,h5,h6{
		font-weight: 500 !important;
		color: #212629 !important;
	}
	ul{
		text-align: left !important;
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

<section class="single-post-section single-branch-content pb-5 mb-5 pt-5 mt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12 branchPage">
				<?php the_content(); ?>
				<hr>
				<div class="row">
					<div class="col-lg-6">
						<h3><i class="fa-sharp fa-solid fa-location-dot"></i> Address</h3>
						<p><?php the_field( 'clinic_address' ); ?></p>
						<?php if ( get_field( 'clinic_postcode' ) ) : ?>
							<p><?php the_field( 'clinic_postcode' ); ?></p>
						<?php endif; ?>
				</div>
					<div class="col-lg-6">
						<?php
						$lat = get_field( 'clinic_latitude' );
						$lng = get_field( 'clinic_longitude' );
						if ( $lat && $lng ) :
						?>
						<h3><i class="fa-solid fa-map"></i> Location</h3>
						<iframe
							width="100%"
							height="300"
							style="border:0;border-radius:8px;"
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							src="https://maps.google.com/maps?q=<?php echo esc_attr( $lat ); ?>,<?php echo esc_attr( $lng ); ?>&z=15&output=embed">
						</iframe>
						<?php endif; ?>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 sidebar">
				<h3>Other Clinics</h3>
				<ul class="vaccinationList">
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
							<li><a href="<?php the_permalink(); ?>"><?php the_title( '<h4>', '</h4>' ); ?></a></li>
							<?php
						}
					}
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

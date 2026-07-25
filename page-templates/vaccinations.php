<?php /* Template Name: Vaccinations */ get_header();?>

<?php get_header(); ?>
<section class="pageBanner vert-mid" style="background-image: url('<?= get_the_post_thumbnail_url(); ?>')">
	<div class="container">
		<h1 class="pageBannerTitle"><?php the_title(); ?></h1>
		<?php
		if ( function_exists('yoast_breadcrumb') ) {
		  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		}
		?>
	</div>
</section>
<section class="vaccination-listings mb-5 pb-5 pt-5" style="background: #f5f5f5;">
	<div class="container py-lg-5">
		<div class="row g-3 g-lg-4 g-xxl-5">
			<?php
			  
				$args = array(
				   'post_type' => 'vaccination',
				   'posts_per_page' => '15',
				   'order' => 'DESC'
				 );
				 
				$the_query = new WP_Query( $args );
				
				// The Loop
				if ( $the_query->have_posts() ) {
				  while ( $the_query->have_posts() ) {
					$the_query->the_post();?>
					   <div class="col-md-6 col-lg-4">
					   	  <A href="<?php echo esc_url( get_permalink());?>" class="text-decoration-none text-dark vaccination-link bg-white">
							<div class="ratio ratio-16x9">
							<div class="bg-light overflow-hidden">
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="h-100 w-100 rounded-0" style="object-fit: cover;">  	
							</div>
							</div>
							<div class="p-3">
								<h2 class="fs-5 fw-semibold line-clamp-2"><?php the_title();?></h2>
								<p class="line-clamp-2 m-0 text-dark">
									<?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?>
								</p>
							</div>
						  </A>
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
<?php get_footer(); ?>
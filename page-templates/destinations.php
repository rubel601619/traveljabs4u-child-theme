<?php /* Template Name: Destinations */ get_header();?>

<?php get_header(); ?>
<style>
	
	.custom-box {
		--pr-color: #7ecb2a;
		--pr-color-hover: #3871c1;
		--transition-speed: 0.3s;
		position: relative;
		background: #fff;
		border: 1px solid #eaeaea;
		border-radius: 10px;
		overflow: hidden;
		height: 100%;
		box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--pr-color);
		transition: all var(--transition-speed) ease-in-out;
		.feature-image {
			aspect-ratio: 9/12;
			background: #e0e0e0;
			img{
				height: 100%;
				width: 100%;
				object-fit: cover;
				transition: all var(--transition-speed) ease-in-out;
			}
		}
		.post-title {
			position: absolute;
			left: 0;
			right: 0;
			background: rgba(0, 0, 0, 0.7);
			color: #fff;
			padding: 10px;
			margin: 0;
			text-align: left;
			transition: all var(--transition-speed) ease-in-out;
			a{
				 display: -webkit-box;
				-webkit-line-clamp: 2; /* Show only 2 lines */
				-webkit-box-orient: vertical;
				overflow: hidden;
				text-overflow: ellipsis;
				line-height: 1.5;
				min-height: calc(1.5em * 2);
				max-height: calc(1.5em * 2);
				text-align: left;
				transition: color var(--transition-speed) ease-in-out;

				&:hover {
					color: var(--pr-color) !important;
				}
			}
		}
	}
	@media (hover: hover) {

		.custom-box {
			.post-title{
				bottom: -200px;
				&:hover a{
					color: var(--pr-color) !important;
				}
			}
			&:hover {
				box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--pr-color-hover), 0 0 10px var(--pr-color-hover);
				.feature-image img {
					transform: scale(1.1) rotate(5deg);
				}
				.post-title{
					bottom: 0;
				}
			}
		}
	}

	@media (hover: none) and (pointer: coarse) {
		.custom-box {
			.post-title{
				bottom: 0;
			}
		}
	}
</style>

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





<section class="clearfix py-5">
	<div class="container py-lg-4">
		<div class="row g-3">
			<?php
			  
				$args = array(
				   'post_type' => 'destination',
				   'post_status' => 'publish',
				   'posts_per_page' => '30',
				   'orderby' => 'title',
				   'order' => 'ASC',
				   'paged'          => $paged,
				 );
				 
				$the_query = new WP_Query( $args );
				
				// The Loop
				if ( $the_query->have_posts() ) {
				  while ( $the_query->have_posts() ) {
					$the_query->the_post();?>
					   <div class="col-6 col-md-3 col-lg-4 col-xl-2">
						   <div class="custom-box">
								<div class="feature-image">
									<?php if(has_post_thumbnail()): ?>
										<?php the_post_thumbnail(); ?>
									<?php else: ?>
									<img src="<?=get_placeholder_image()?>" alt="<?php the_title(); ?>">
									<?php endif; ?>
								</div>
								<?php if(get_the_title()): ?>
									<div class="post-title">
										<h3 class="fw-normal m-0">
											<?php the_title('<a href="' . esc_url(get_the_permalink()) . '" class="text-white text-decoration-none fs-6">', '</a>'); ?>
										</h3>
									</div>
								<?php endif; ?>
						   </div>
					   </div>
					<?php } ?>
				  <?php } else {
				  echo '<div class="col-lg-12"><h2 style="text-align: center;">No posts are available right now. Please check back later!</h2></div>';
			   }

				wp_reset_postdata();
			  
			  ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
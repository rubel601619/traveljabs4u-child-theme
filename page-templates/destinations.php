<?php /* Template Name: Destinations */ ?>
<?php get_header(); ?>
<?php
$paged  = get_query_var( 'paged', 1 );
$search = isset( $_GET['destination_search'] ) ? sanitize_text_field( $_GET['destination_search'] ) : '';

$args = [
    'post_type'      => 'destination',
    'post_status'    => 'publish',
    'posts_per_page' => 30,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'paged'          => $paged,
];
if ( $search ) {
    $args['s'] = $search;
}

$the_query = new WP_Query( $args );
?>
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
	}
	.custom-box .feature-image {
		aspect-ratio: 9/12;
		background: #e0e0e0;
	}
	.custom-box .feature-image img {
		height: 100%;
		width: 100%;
		object-fit: cover;
		transition: all var(--transition-speed) ease-in-out;
	}
	.custom-box .post-title {
		position: absolute;
		left: 0;
		right: 0;
		background: rgba(0, 0, 0, 0.7);
		color: #fff;
		padding: 10px;
		margin: 0;
		text-align: left;
		transition: all var(--transition-speed) ease-in-out;
	}
	.custom-box .post-title a {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-overflow: ellipsis;
		line-height: 1.5;
		min-height: calc(1.5em * 2);
		max-height: calc(1.5em * 2);
		text-align: left;
		transition: color var(--transition-speed) ease-in-out;
	}
	.custom-box .post-title a:hover {
		color: var(--pr-color) !important;
	}
	@media (hover: hover) {
		.custom-box .post-title {
			bottom: -200px;
		}
		.custom-box .post-title:hover a {
			color: var(--pr-color) !important;
		}
		.custom-box:hover {
			box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--pr-color-hover), 0 0 10px var(--pr-color-hover);
		}
		.custom-box:hover .feature-image img {
			transform: scale(1.1) rotate(5deg);
		}
		.custom-box:hover .post-title {
			bottom: 0;
		}
	}
	@media (hover: none) and (pointer: coarse) {
		.custom-box .post-title {
			bottom: 0;
		}
	}

	.form-bg{
		background: linear-gradient(45deg, #dcefd8 0%, #dbeafc 100%);
		transition: background 0.3s ease-in-out;
	}
	.form-bg:has(input:focus) {
		background: linear-gradient(45deg, #dcefd8 0%, #dbeafc 50%);
	}
	.destination-search-wrap {
		margin-bottom: 1.5rem;
	}
	.destination-search-form {
		display: flex;
		max-width: 500px;
		max-width: 500px;
		margin-inline: auto;
		background: white;
		border-radius: 10px;
		padding: 4px;
		border: 2px solid #7ecb2a;
	}
	.destination-search-form:has(input:focus) {
		border-color: #3871c1;
	}
	.destination-search-form input {
		flex: 1;
		padding: 10px 14px;
		border: none;
		box-shadow: none;
		border-radius: 6px;
		font-size: 14px;
	}
	.destination-search-form input:focus {
		outline: none;
	}
	.destination-search-form button {
		padding: 10px 20px;
		background: #7ecb2a;
		color: #fff;
		border: none;
		border-radius: 6px;
		font-size: 14px;
		cursor: pointer;
		transition: background 0.2s;
	}
	.destination-search-form button:hover {
		background: #3871c1;
	}
	.destination-clear-btn {
		display: inline-block;
		padding: 10px 17px;
		color: #666;
		text-decoration: none;
		font-size: 14px;
	}
	.destination-clear-btn:hover {
		color: #c00;
	}
	.destination-pagination {
		margin-top: 2rem;
	}
	.destination-pagination ul {
		justify-content: center;
	}
	.destination-pagination ul .page-numbers {
		position: relative;
		display: block;
		padding: 6px 12px;
		margin-left: -1px;
		line-height: 1.5;
		color: #7ecb2a;
		background: #fff;
		border: 1px solid #dee2e6;
		text-decoration: none;
	}
	.destination-pagination ul .page-numbers.current {
		z-index: 3;
		color: #fff;
		background: #7ecb2a;
		border-color: #7ecb2a;
	}
	.destination-pagination ul .page-numbers:hover:not(.current) {
		color: #3871c1;
		background: #e9ecef;
		border-color: #dee2e6;
	}
	.destination-result-count {
		font-size: 14px;
		color: #666;
		margin-bottom: 0.5rem;
	}
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
                    <h1 class="fw-bold text-dark my-3">What Travel <span style="color: #08a64f">Vaccines</span><br> Do I <span style="color: #08a64f">Need?</span></h1>
                    <p>
                        Find out exactly which travel vaccines and jabs you need for your trip. Explore the most popular destinations to see the recommended vaccinations and health advice, then book your appointment at a travel clinic near you.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/client-map.png" class="w-100" style="max-width: 430px;" alt="Our Clinic">
            </div>
        </div>
    </div>
</section>

<section class="clearfix form-bg">
	<div class="destination-search-wrap py-4 px-3 rounded-3">
		<form class="destination-search-form" method="get" action="">
			<input type="text" name="destination_search" value="<?php echo esc_attr( $search ); ?>" placeholder="Search destinations..." autocomplete="off">
			
			<?php if ( $search ) : ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="destination-clear-btn"><i class="fa-solid fa-times"></i></a>
			<?php endif; ?>

			<button type="submit"><i class="fa-solid fa-search"></i> Search</button>
			
		</form>
	</div>
</section>

<section class="clearfix py-5">
	<div class="container">

		<?php if ( $search ) : ?>
			<p class="destination-result-count mb-3">
				<?php printf( __( 'Showing %d result(s) for "%s"', 'textdomain' ), $the_query->found_posts, esc_html( $search ) ); ?>
			</p>
		<?php endif; ?>

		<div class="row g-3">
			<?php
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?>
					<div class="col-6 col-md-3 col-lg-4 col-xl-2">
						<div class="custom-box">
							<div class="feature-image">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail(); ?>
								<?php else : ?>
									<img src="<?= get_placeholder_image() ?>" alt="<?php the_title(); ?>">
								<?php endif; ?>
							</div>
							<?php if ( get_the_title() ) : ?>
								<div class="post-title">
									<h3 class="fw-normal m-0">
										<?php the_title( '<a href="' . esc_url( get_the_permalink() ) . '" class="text-white text-decoration-none fs-6">', '</a>' ); ?>
									</h3>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php
				}
			} else {
				echo '<div class="col-lg-12"><h2 style="text-align: center;">' . ( $search ? 'No destinations found for "' . esc_html( $search ) . '".' : 'No posts are available right now. Please check back later!' ) . '</h2></div>';
			}
			wp_reset_postdata();
			?>
		</div>

		<?php if ( $the_query->max_num_pages > 1 ) : ?>
			<div class="destination-pagination">
				<?php
				$big = 999999999;
				$pagination_args = [
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, $paged ),
					'total'     => $the_query->max_num_pages,
					'prev_text' => '&laquo; Prev',
					'next_text' => 'Next &raquo;',
					'type'      => 'list',
				];
				if ( $search ) {
					$pagination_args['add_args'] = [ 'destination_search' => $search ];
				}
				$links = paginate_links( $pagination_args );
				echo str_replace(
					[ '<ul class=\'page-numbers\'', "<li><span class='page-numbers current'", "<li><a class='page-numbers'", "<li><span class='page-numbers dots'" ],
					[ '<ul class="pagination"', "<li class='page-item active'><span class='page-link'", "<li class='page-item'><a class='page-link'", "<li class='page-item disabled'><span class='page-link'" ],
					$links
				);
				?>
			</div>
		<?php endif; ?>

	</div>
</section>

<script>
jQuery(document).ready(function ($) {
	var searchInput = $('input[name="destination_search"]');
	var form = searchInput.closest('form');

	searchInput.on('input', function () {
		var val = $(this).val().trim();
		if (val === '') {
			form.find('.destination-clear-btn').remove();
		}
	});
});
</script>

<?php get_footer(); ?>

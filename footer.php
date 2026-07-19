	<footer class="sec-padding">
	  <div class="container">
		  <div class="row">
			  <div class="col-lg-4 col-md-6 col-sm-12">
				  <?php echo get_custom_logo(); ?>
				  <?php if(get_theme_mod('footer_content')): ?>
				  <?php echo wpautop(get_theme_mod('footer_content')) ?>
				  <?php endif; ?>
			  </div>
			  <div class="col-lg-4 col-md-6 col-sm-12">
				  <h3>Partner With Us</h3>
				  <?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
			  </div>
              <?php if (has_nav_menu('footer-menu-2')) { ?>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                      <h3>Branches</h3>
                      <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-2' ) ); ?>
                  </div>
              <?php } ?>
			  <div class="col-lg-4 col-md-6 col-sm-12">
				  <h3>Contact Us</h3>
				  <?php if(get_theme_mod('phone_number')): ?>
				  <p><i class="fa-solid fa-phone"></i> <a href="tel:<?php echo get_theme_mod('phone_number') ?>"><?php echo get_theme_mod('phone_number') ?></a></p>
				  <?php endif; ?>
				  <?php if(get_theme_mod('email_address')): ?>
				  <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo get_theme_mod('email_address') ?>"><?php echo get_theme_mod('email_address') ?></a></p>
				  <?php endif; ?>
				  <?php if(get_theme_mod('address')): ?>
				  <p><i class="fa-sharp fa-solid fa-location-dot"></i> <?php echo get_theme_mod('address') ?></p>
				  <?php endif; ?>
                  <?php if(get_theme_mod('footer_image')): ?>
                      <a href="<?php echo esc_url(get_theme_mod('footer_image_link')); ?>" target="_blank">
                          <img src="<?php echo esc_url(get_theme_mod('footer_image')); ?>" alt="Footer Image" style="height: 145px; width: auto;">
                      </a>
                  <?php endif; ?>
			  </div>
		  </div>
	  </div>
	  <div class="footerCopyright">
			<div class="container">
				&copy; Copyright <?php echo date('Y');?> <?= get_bloginfo( 'name' ); ?> | Website built by <a style="color: var(--main-color)" href="https://yuma-technology.co.uk/" target="_blank">Yuma Technology</a>
			</div>
	  </div>
	</footer>
	<?php wp_footer(); ?>

  </body>
</html>
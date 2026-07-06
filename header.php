<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php wp_head(); ?>
		<meta name="google-site-verification" content="JugJJxK_Zjpk_xZ2KK2AjyRheMOn0UJ9KCze9QyKh1g" />
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<header>
			<div class="topBar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-8 text-left top-contact">
                            <a href="<?php echo get_theme_mod('facebook_link') ?>"><i class="fa-brands fa-facebook"></i></a>
                            <a href="<?php echo get_theme_mod('instagram_link') ?>"><i class="fa-brands fa-instagram"></i></a>
							<a href="mailto:<?php echo get_theme_mod('email_address') ?>"><i class="fa-solid fa-envelope"></i> <?php echo get_theme_mod('email_address') ?></a>
						</div>
						<div class="col-lg-6 col-4 text-right">
							<?php if(get_theme_mod('top_bar_button_title')): ?>
							<a class="top-bar-btn" href="<?=get_theme_mod('top_bar_button_link') ? get_theme_mod('top_bar_button_link') : '#'?>"><?=get_theme_mod('top_bar_button_title') ?: 'Click Here'?></a>
							<?php endif; ?>
<!--                            --><?php //if(get_theme_mod('top_bar_button_title_2')): ?>
<!--							<a class="top-bar-btn m-3" href="--><?php //=get_theme_mod('top_bar_button_link_2') ? get_theme_mod('top_bar_button_link_2') : '#'?><!--">--><?php //=get_theme_mod('top_bar_button_title_2') ?: 'Click Here'?><!--</a>-->
<!--							--><?php //endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-12 vert-mid hori-mid logo-col">
						<?php echo get_custom_logo(); ?>
					</div>
					<div class="col-lg-9 col-sm-12 main-menu-box menu-col">
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
					</div>
				</div>
			</div>
		</header>
<?php
/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author		Zlatko Gantchev
 * @package		The Bootstrap
 * @since		1.0 - 05.02.2012
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<?php tha_head_top(); ?>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<title><?php wp_title( '&laquo;', true, 'right' ); ?></title>
		
		<?php tha_head_bottom(); ?>
		<?php wp_head(); ?>
	</head>
	
	<body>
		<div class="container">
			<div id="page" class="row">
				<div id="before-header" class="span12">
					<div id="before-header-menu">
						<a href="<?php append_website_URL(''); ?>" class="before-header-menu-item" target="_blank">
							advertise</a>
						<a href="<?php append_website_URL(''); ?>" class="before-header-menu-item" target="_blank">
							get listed</a>
						<a href="<?php append_website_URL('admin'); ?>" class="before-header-menu-item" target="_blank">
							client portal</a>
					</div>
					<div id="before-header-icons">
						<a href="http://facebook.com" target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a>
						<a href="http://twitter.com" target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a>
						<a href="https://plus.google.com" target="_blank"><i class="fa fa-google-plus-square fa-lg"></i></a>
						<a href="http://linkedin.com" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a>
					</div>
				</div>

				<header id="branding" role="banner" >
					<?php tha_header_top();
						wp_nav_menu( array(
							'container'			=>	'nav',
							'container_class'	=>	'subnav clearfix',
							'theme_location'	=>	'header-menu',
							'menu_class'		=>	'nav nav-pills pull-right',
							'depth'				=>	3,
							'fallback_cb'		=>	false,
							'walker'			=>	new The_Bootstrap_Nav_Walker,
						) );
					?>
					
					<div id="header-content" class="row-fluid">
						<div class="span3">
							<?php if ( get_header_image() ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php header_image(); ?>" width="227px" height="88px" alt="" />
							</a>
							<?php endif; ?>
						</div>
						<div class="span9 LB-ad">
							hello world!!!!
							<a href="http://www.appleby.on.ca/" target="_blank">
								<img src="http://parentory.ca/deploy/wp-content/uploads/2015/01/generic-school-LB.jpg">
							</a>
						</div>
					</div>
					<br />

					<nav id="access" role="navigation" class="col-md-12">
						<h3 class="assistive-text"><?php _e( 'Main menu', 'the-bootstrap' ); ?></h3>
						<div class="skip-link">
							<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'the-bootstrap' ); ?>"><?php _e( 'Skip to primary content', 'the-bootstrap' ); ?></a>
						</div>
						<div class="skip-link">
							<a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'the-bootstrap' ); ?>"><?php _e( 'Skip to secondary content', 'the-bootstrap' ); ?></a>
						</div>
						<?php if ( has_nav_menu( 'primary' ) OR the_bootstrap_options()->navbar_site_name OR the_bootstrap_options()->navbar_searchform ) : ?>
						<div <?php the_bootstrap_navbar_class(); ?>>
							<div class="navbar-inner">
								<div class="container">
									<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
									<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</a>
									<?php if ( the_bootstrap_options()->navbar_site_name ) : ?>
										<span class="brand"><?php bloginfo( 'name' ); ?></span>
									<?php endif;?>
									<div class="nav-collapse">
										<?php wp_nav_menu( array(
											'theme_location'	=>	'primary',
											'menu_class'		=>	'nav',
											'depth'				=>	3,
											'fallback_cb'		=>	false,
											'walker'			=>	new The_Bootstrap_Nav_Walker,
										) ); 
											//my_navbar_search();
										if ( the_bootstrap_options()->navbar_searchform ) : ?>
											<form id="search-form" 
													class="navbar-search pull-right" 
													method="post" 
													action="<?php append_website_URL('school-search-results/'); ?>">
												<div id="simpleSearch">
													<input name="search-type" type="hidden" value="header-search">
													<input name="search-query" class="search-field" placeholder="Search">
													<input type="submit" value="" class="searchButton">
												</div>
											</form>
										<?php endif; ?>
								    </div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</nav><!-- #access -->
					<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<nav id="breadcrumb" class="breadcrumb">', '</nav>' );
					}
					tha_header_bottom(); ?>
				</header><!-- #branding --><?php
				

/* End of file header.php */
/* Location: ./wp-content/themes/the-bootstrap/header.php */
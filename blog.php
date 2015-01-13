<?php

/*
Template Name: Blog
*/

get_header(); ?>

<div id="main-image" class="row-fluid">
	<img src="http://test.parentory.ca/wp-content/uploads/2014/05/blog.jpg">
</div>

<div class="container-fluid">

	<div class="container-fluid">
		

		<div class="row-fluid">
			<!-- school content -->
			<div class="span8">
				<?php 
				//blog posts won't show up without this, but WP says it's bad to use..
				query_posts('post_type=post')

				?>

				<?php 
				
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( '/partials/content', get_post_format() );
					}
					the_bootstrap_content_nav( 'nav-below' );
				}
				else {
					get_template_part( '/partials/content', 'not-found' );
				}
			
				?>
			</div>

			<!-- school sidebar -->
			<div id="school-sidebar" class="span4">
				<div id="form-title" class="arial-narrow">
					FEATURED BLOG POSTS
				</div>
				
				<div id="sidebar-form" class="sidebar-featured-posts">
					<ul>
						<?php
							$wp_posts = get_posts();
							for ($i=0; $i<4; $i++){
								$post = $wp_posts[$i];

								echo "<li class='entry-title'><a href='" . get_permalink( $post->ID ) . "' target='_new'>" . $post->post_title . "</a></li>";
							}
						?>
					</ul>
				</div>

				<div id="sidebar-mailing-list">
					<!-- Begin MailChimp Signup Form -->
					<form action="//parentory.us8.list-manage.com/subscribe/post?u=8b02a22e6a6660bd127d248ca&amp;id=2999a224dd" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div id="mc_embed_signup" class="sidebar-mc-embed-signup">
							<div class="sidebar-mail-list-title">JOIN OUR MAILING LIST</div>

							<div class="sidebar-mail-list-text">
								Subscribe and keep up to date with the latest happenings!
							</div>

							<div class="sidebar-mc-field-group">
								<input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First Name">
							</div>
							<div class="sidebar-mc-field-group">
								<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
							</div>

							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;"><input type="text" name="b_8b02a22e6a6660bd127d248ca_2999a224dd" tabindex="-1" value=""></div>
							<div class="clear"><input type="submit" value="JOIN TODAY" name="subscribe" id="sidebar-mc-embedded-subscribe"></div>
						</div>
					</form>
					<!--End mc_embed_signup-->
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();

/* End of file blog.php */
/* Location: ./wp-content/themes/the-bootstrap-child/blog.php */
?>
<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Zlatko Gantchev
 * @package		Parentory
 * @since		1.0.0 - 05.01.2014
 */

get_header(); ?>

<div id="main-image" class="row-fluid">
	<img src="http://parentory.ca/deploy/wp-content/uploads/2014/07/main_image.png">
</div>

<div id="feature-images" class="row-fluid">
	<div class="span4">
		<a href="<?php append_website_URL('advanced-search/'); ?>">
			<img src="http://parentory.ca/deploy/wp-content/uploads/2014/06/mini_image1.png" class="feature-images-item">
		</a>
	</div>
	<div class="span4">
		<a href="<?php append_website_URL('advanced-search/?show=advanced'); ?>">
			<img src="http://parentory.ca/deploy/wp-content/uploads/2014/06/mini_image2.png" class="feature-images-item">
		</a>
	</div>
	<div class="span4">
		<a href="<?php append_website_URL('advanced-search/?show=focused'); ?>">
			<img src="http://parentory.ca/deploy/wp-content/uploads/2014/06/mini_image3.png" class="feature-images-item">
		</a>
	</div>
</div>


<section id="primary" class="span12 home-page-blog-posts">
	<h2>Latest Blog Posts</h2>
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
		
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
	
		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap-child/index.php */
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

<div id="main-image" class="row-fluid home-page-search-background"><!--div id="main-image" class="row-fluid"-->
	<div class="home-page-search-container">
		<form id="search-form" method="post" action="<?php append_website_URL('school-search-results/'); ?>">
			<div class="span5">
				<input type="text" name="address" placeholder="Enter City or Address Here" />
			</div>
			<div class="span4">
				<select name="province">
					<option value="All Provinces">All States/Provinces</option>
					<option value="Alberta">Alberta</option>
					<option value="British Columbia">British Columbia</option>
					<option value="Manitoba">Manitoba</option>
					<option value="New Brunswick">New Brunswick</option>
					<option value="Newfoundland Labrador">Newfoundland and Labrador</option>
					<option value="Nova Scotia">Nova Scotia</option>
					<option value="Ontario">Ontario</option>
					<option value="Prince Edward Island">Prince Edward Island</option>
					<option value="Quebec">Quebec</option>
					<option value="Saskatchewan">Saskatchewan</option>
					<option value="Northwest Territories">Northwest Territories</option>
					<option value="Nunavut">Nunavut</option>
					<option value="Yukon">Yukon</option>
				</select>
			</div>
			<div class="span2">
				<input type="submit" name="submit" class="submitButton" value="Find Schools">
			</div>
		</form>
	</div>
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
<?php
/*
Template Name: Blog
*/

get_header(); ?>
<div id="main-image" class="row-fluid">
		<img src="http://localhost/wordpress/wp-content/uploads/2014/05/blog.jpg">
</div>

<section id="primary" class="span12">
	
	<div id="content" role="main">


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
	</div><!-- #content -->
	
</section><!-- #primary -->


<?php
get_footer();


/* End of file blog.php */
/* Location: ./wp-content/themes/the-bootstrap-child/blog.php */
?>
<?php

/*
 * The template for displaying Search Results pages.
 *
 */


get_header(); ?>
<div id="main-image" class="row-fluid">
		<img src="http://test.parentory.ca/wp-content/uploads/2014/12/advanced-search-splash.jpg">
</div>


<section id="primary" class="span12">
	
	<div id="content" role="main" class="container-fluid">
		
		<?php

			// check if there's posts to be shown
			if ( have_posts() ) {
			    // begin The Loop
				while ( have_posts() ) { 
					// iterate the post index within The Loop
					the_post();

					// get the current school id - used for finding mega data
					$school_id = get_the_id();
					?>

					<div id="school-archive-entry" class="row">
						<!-- display school image -->
						<div class="span2" width="100px" height="100px">
							<?php the_post_thumbnail(); ?>
						</div>
						<!-- display school title & info -->
						<div class="span5">
							<div id="school-title-archive" class="entry-title">
								<a href="<?php the_permalink( $school_id ); ?>">
									<?php the_title(); ?>
								</a>
							</div>
							<?php the_excerpt(); ?>
						</div>
						<!-- display school age & price info -->
						<div class="span4">
							<u>Age Group:</u><br />
							<?php echo get_post_meta( $school_id, 'school-age-group', true ); ?>
							<br />
							<u>Price:</u><br />
							<?php echo get_post_meta( $school_id, 'school-annual-tuition', true ); ?>
						</div>
					</div>

					<?php
				}
			} else {
				//no posts found
				echo "<h2>Sorry, no schools found for the search: '" . get_query_var('s') . "'</h2>";
			}

			//Restore original Post Data
			wp_reset_postdata();
		?>

	</div><!-- #content -->
	
</section><!-- #primary -->



<?php

get_footer();


/* Location: ./wp-content/themes/the-bootstrap/search.php */
?>
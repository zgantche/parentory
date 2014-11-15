<?php
/** 
 * Template Name: Schools
 * school.php
 *
 * The Template for displaying all single school posts.
 *
 * @author		Zlatko Gantchev
 * @package		Parentory
 * @since		1.0.0 - 05.02.2014
 */

get_header(); ?>
<div id="main-image" class="row">
	<img src="http://test.parentory.ca/wp-content/uploads/2014/05/montessori-schools.jpg">
</div>


<section id="primary" class="span12">
	
	<div id="content" role="main" class="container">

	<?php
		// set up the query
		$args = array( 'post_type' => 'school', 'posts_per_page' => 10, 'orderby' => 'title', 'order' => 'ASC' );
		$the_query = new WP_Query( $args );

		// check if there's posts to be shown
		if ( $the_query->have_posts() ) {
		    // begin The Loop
			while ( $the_query->have_posts() ) { 
				// iterate the post index within The Loop
				$the_query->the_post();

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
			//no posts found, TODO: put placeholder stuff here
		}

		//Restore original Post Data
		wp_reset_postdata();
	?>


	</div><!-- #content -->
	
</section><!-- #primary -->


<?php
get_footer();


/* End of file schools.php */
/* Location: ./wp-content/themes/the-bootstrap-child/shools.php */
?>
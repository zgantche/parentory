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
	
	<div id="content" role="main" class="container-fluid">
		<div id="school-listings-filter" class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h2>Find a Location Near You</h2>
					Enter preferred location to search through schools:
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12"></div>
			</div>

			<form id="search-form" method="post" action="<?php append_website_URL('school-search-results/'); ?>">
			<input name="search-type" type="hidden" value="directory-page-search">

			<div class="row-fluid">

					<div class="span1"></div>
					<div class="span4">
						City: <input type="text" name="address" placeholder="Enter City or Address Here">
					</div>
					<div class="span6">
						State/Province:
						<select name="province">
							<option value="all">All</option>
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
			</div>

			<div class="row-fluid">
				<div id="archive-filter-button-field" class="span12">
					<input type="submit" name="submit" class="submitButton" value="Search">
				</div>
			</div>

			</form>

			<div class="row-fluid">
				<div id="archive-filter-bottom" class="span12">
					<a href="<?php append_website_URL('advanced-search/'); ?>">Advanced Search</a>
				</div>
			</div>
		</div>
		
		<?php
			// protect against arbitrary paged values
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

			// set up the query
			$args = array( 'post_type' => 'school', 'posts_per_page' => 7, 'orderby' => 'title', 'order' => 'ASC', 'paged' => $paged);
			$the_query = new WP_Query( $args );
			$first_post = true;

			// check if there's posts to be shown
			if ( $the_query->have_posts() ) {
			    // begin The Loop
				while ( $the_query->have_posts() ) {
					// iterate the post index within The Loop
					$the_query->the_post();

					// get the current school id - used for finding mega data
					$school_id = get_the_id();

					// omit row divider for the first post
					if ( $first_post )
						$first_post = false;
					else
						echo "<hr>";
					?>

					<div id="school-archive-entry" class="row-fluid">
						<!-- display school image -->
						<div class="span2 archive-school-logo">
							<a class="read-more" target="_new" href="<?php the_permalink( $school_id ); ?>">
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'archive-school-logo' ) ); ?>
							</a>

						</div>
						<!-- display school title & info -->
						<div class="span5">
							<div id="school-title-archive" class="entry-title">
								<a target="_new" href="<?php the_permalink( $school_id ); ?>">
									<?php the_title(); ?>
								</a>
							</div>
							<div>
								<i>
								<?php get_school_address( $school_id, array('street-address', 'city', 'province', 'postal-code') ); ?>
								</i>
							</div>
							<div class="school-excerpt">
								<?php the_excerpt(); ?>
								<a class="read-more" target="_new" href="<?php the_permalink( $school_id ); ?>"><i>(learn more)</i></a>
							</div>
						</div>
						<!-- display school age & price info -->
						<div class="span5">
							<span class="archive-school-data-box">
								<div><b>Grades</b></div>
								<?php echo get_post_meta( $school_id, 'school-grades', true ); ?>
							</span>
							<span class="archive-school-data-box">
								<div><b>Tuition</b></div>
								<?php echo get_post_meta( $school_id, 'school-annual-tuition', true ); ?>
							</span>
							<span class="archive-school-data-box">
								<div><b>School Type</b></div>
								<?php echo get_post_meta( $school_id, 'school-type', true ); ?>
							</span>
							<span class="archive-school-data-box">
								<div><b>Class Size</b></div>
								<?php echo get_post_meta( $school_id, 'school-class-size', true ); ?>
							</span>
						</div>
					</div>

					<?php
				}
			} else {
				//no posts found, TODO: put placeholder stuff here
			}
		?>

		<center id="school-archive-bottom">
		<?php
			$big = 999999999; // need an unlikely integer

			// separate results into distinct pages
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $the_query->max_num_pages
			) );



			//Restore original Post Data
			wp_reset_postdata();
		?>
		</center>

	</div><!-- #content -->
	
</section><!-- #primary -->


<?php
get_footer();


/* End of file schools.php */
/* Location: ./wp-content/themes/the-bootstrap-child/shools.php */
?>
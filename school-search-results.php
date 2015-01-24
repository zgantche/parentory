<?php

/*
 *
 * Template Name: School Search Results
 *
 */

session_start(); //begin a php session
get_header(); ?>
<div id="main-image" class="row-fluid">
	<img src="http://test.parentory.ca/wp-content/uploads/2015/01/search-results-splash.jpg">
</div>


<section id="primary" class="span12">
	
	<div id="school-results-content" role="main" class="container-fluid">

		<?php
			$first_post = true;
			$pageid = 1;

			// determine what to do; different types of searching, or pagination
			if ( isset($_GET['pageid']) )
				$pageid = (int)$_GET['pageid'];
			// perform SQL Query, store result in php session
			elseif ( isset($_GET['city']) )
				$_SESSION['search_result_school_ids'] = get_search_results('city-search');
			elseif ( isset($_GET['type']) )
				$_SESSION['search_result_school_ids'] = get_search_results('type-search');
			elseif ( isset($_POST['search-type']) ) {
				echo "Searching, search type: " . $_POST['search-type'];
				$_SESSION['search_result_school_ids'] = get_search_results($_POST['search-type']);
			}
			else
				echo "Search Type is not set!"; // error

			// check if there are posts to be shown
			if ( isset($_SESSION['search_result_school_ids']) && !empty($_SESSION['search_result_school_ids']) ) {
				// determine the number of schools to show
				$school_ids = paginate_school_results($_SESSION['search_result_school_ids'], $pageid);

			    // begin The Loop
				foreach ( $school_ids as $post_id )
				{	
					$post = get_post($post_id);
					setup_postdata( $post );

					// get the current school id - used for finding meta data
					$school_id = get_the_id();

					// omit row divider for the first post
					if ( $first_post )
						$first_post = false;
					else
						echo "<hr />";
					?>

					<div id="school-archive-entry" class="row-fluid">
						<!-- display school image -->
						<div class="span2 archive-school-logo">
							<a class="read-more" target="_blank" href="<?php the_permalink( $school_id ); ?>">
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'archive-school-logo' ) ); ?>
							</a>

						</div>
						<!-- display school title & info -->
						<div class="span5">
							<div id="school-title-archive" class="entry-title">
								<a target="_blank" href="<?php the_permalink( $school_id ); ?>">
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
								<a class="read-more" target="_blank" href="<?php the_permalink( $school_id ); ?>"><i>(learn more)</i></a>
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
				if ( isset($_SESSION['search_result_school_ids']) && isset($_POST['search-type']) )
					switch ($_POST['search-type']) {
						case "header-search":
							echo '<h2 class="error">Sorry, no schools were found matching the search: "' . $_POST['search-query'] . '"</h2>'; 
							break;
						case "directory-page-search":
							echo '<h2 class="error">Sorry, no schools were found matching the search: "' 
									. $_POST['address'] . ', ' 
									. $_POST['province'] . '"</h2>'; 
							break;
						case "advanced-search":
							echo '<h2 class="error">Sorry, no schools were found matching your search.</h2>';
							break;
						}
				else if ( isset($_GET['city']) )
					echo '<h2 class="error">Sorry, no schools were found matching the search: "' . $_GET['city'] . '"</h2>';
				else if ( isset($_GET['type']) )
					echo '<h2 class="error">Sorry, no schools were found matching the search: "' . $_GET['type'] . '"</h2>';
				else
					echo '<h2 class="error">Sorry, there seems to be an error. Please go back to our home page, and try again.</h2>';
			}

			print_page_numbers($pageid, count($_SESSION['search_result_school_ids']));
		?>

	</div><!-- #content -->
	
</section><!-- #primary -->



<?php

get_footer();


/* Location: ./wp-content/themes/the-bootstrap/search.php */
?>
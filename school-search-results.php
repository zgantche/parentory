<?php

/*
 *
 * Template Name: School Search Results
 *
 */

session_start(); //begin a php session
get_header(); ?>
<style type="text/css">
	#map-canvas {
		height: 300px;
		margin: 20px 0;
	}
</style>

<?php

	// -- Refresh Session Variables: --
	// determine what to do; different types of searching, or pagination
	if ( isset($_GET['pageid']) )
		$pageid = (int)$_GET['pageid'];
	// perform SQL Query, store result in php session
	elseif ( isset($_GET['city']) )
		$_SESSION['search_result_school_ids'] = get_search_results('city-search');
	elseif ( isset($_GET['type']) )
		$_SESSION['search_result_school_ids'] = get_search_results('type-search');
	elseif ( isset($_POST['search-type']) ) {
		//echo "Searching, search type: " . $_POST['search-type'];
		$_SESSION['search_result_school_ids'] = get_search_results($_POST['search-type']);
	}
	else
		echo "Search Type is not set!"; // error
	
	// -- Calculate Center of Map --
	$latitude_sum = 0;
	$longitude_sum = 0;
	$num_latitudes = 0;
	$num_longitudes = 0;

	if (count($_SESSION['search_result_school_ids']) >= 1) {
		foreach ($_SESSION['search_result_school_ids'] as $school_id) {
			$latitude = get_post_meta( $school_id, 'school-latitude', true );
			$longitude = get_post_meta( $school_id, 'school-longitude', true );

			if (!empty($latitude)){
				$latitude_sum += $latitude;
				$num_latitudes++;
			}

			if (!empty($longitude)){
				$longitude_sum += $longitude;
				$num_longitudes++;
			}
		}
	}

	//check if it's possible to calculate average, if not set center coordinates to Toronto
	if ($num_latitudes != 0 && $num_longitudes != 0){
		$avg_latitude = $latitude_sum/$num_latitudes;
		$avg_longitude = $longitude_sum/$num_longitudes;
	}
	else{
		$avg_latitude = 43.700;
		$avg_longitude = -79.400;
	}
?>

<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYGh2dJ3nL8r1RibL5knf67j8zTcJBZQ8">
</script>
<script type="text/javascript">
	function initialize() {
		var mapOptions = {
				<?php 
					echo "center: { lat: {$avg_latitude}, lng: {$avg_longitude} },"; 
					echo "zoom: 9"
				?>
			};

		var myMap = new google.maps.Map(document.getElementById('map-canvas'),
	    	mapOptions);

		var infoWindow = new google.maps.InfoWindow({
			content: 'Placeholder Content'
		});


		<?php
			// loop through search results and add them as markers on the map
			if (count($_SESSION['search_result_school_ids']) >= 1) {
				foreach ($_SESSION['search_result_school_ids'] as $school_id) {
					$latitude = get_post_meta( $school_id, 'school-latitude', true );
					$longitude = get_post_meta( $school_id, 'school-longitude', true );
					$school_title = get_the_title($school_id);

					//each school's marker & info_window variables
					$marker_var = str_replace(array(' '), array('_'), strtolower($school_title));
					$info_window_var = $marker_var . "_info";
					$info_window_content = "<div>Into Content goes HERE!</div>";

					if ( !empty($latitude) && !empty($longitude) ){
						//define and place map marker
						print "\r\n var {$marker_var} = new google.maps.Marker({
									map: myMap,
									position: { lat: {$latitude}, lng: {$longitude} },
									title: '{$marker_var}'
								});";

						//add click listener to display info box on each
						echo "google.maps.event.addListener({$marker_var}, 'click', function() {
								infoWindow.setContent('{$info_window_content}');
								infoWindow.open(myMap, {$marker_var});
								});";
					}
				}
			}
		?>
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="main-image" class="row-fluid">
	<img src="http://parentory.ca/deploy/wp-content/uploads/2015/01/search-results-splash.jpg">
</div>


<section id="primary" class="span12">
	
	<div id="school-results-content" role="main" class="container-fluid">
		<div class="row-fluid">
			<div id="map-canvas" clas="span12"></div>
			<?php

				$url_prefix = "https://maps.googleapis.com/maps/api/geocode/xml?address=";
				$apiKey = "AIzaSyAYGh2dJ3nL8r1RibL5knf67j8zTcJBZQ8";
				$address = "261 Buena Vista Rd, Ottawa, Ontario, K1M 0V9";
				$address = urlencode( $address );

				$url = $url_prefix . $address . "&key=" . $apiKey;

				$file_content = file_get_contents( $url );

				if( $file_content === false )
					return "Could not get XML File content!";
				/*
				else{
					$xml = new SimpleXMLElement( $file_content );
					
					echo "latitude: " . $xml->result->geometry->location->lat;
					echo ", longitude: " . $xml->result->geometry->location->lng;
					echo ", avg_latitude: {$avg_latitude}, avg_longitude: {$avg_longitude}";
				}
				*/
			?>
		</div>
		
		<?php
			$first_post = true;
			$pageid = 1;


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
								<?php echo get_school_address( $school_id, array('street-address', 'city', 'province', 'postal-code') ); ?>
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
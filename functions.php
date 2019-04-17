<?php

include 'functions_search-queries.php';
include 'functions_backend-ui.php';


// This theme uses wp_nav_menu() in two locations.
register_nav_menus( array(
	'footer-2' => __('Footer Menu 2', 'the-bootstrap-child'),
	'footer-3' => __('Footer Menu 3', 'the-bootstrap-child')
) );


/**
 * Adds The Bootstrap navbar classes
 *
 * @author	Zlatko
 * @since	15.04.2014
 *
 * @return	void
 */
function the_bootstrap_navbar_class() {
	echo 'class="navbar"';
}

/**
 * Print a menu's title
 *
 * @author	Zlatko
 * @since	15.04.2014
 *
 * @return	void
 */
function get_menu_title() {
	$menu_location = 'header';
	$menu_locations = get_nav_menu_locations();
	$menu_object = (isset($menu_locations[$menu_location]) ? wp_get_nav_menu_object($menu_locations[$menu_location]) : null);
	$menu_name = (isset($menu_object->name) ? $menu_object->name : '');

	echo esc_html($menu_name);
}


/**
 * Returns or echoes searchform mark up, specifically for the navbar.
 * (originally the_bootstrap_navbar_searchform)
 *
 * @author	Zlatko Gantchev
 * @since	07.30.2014
 *
 * @param	bool	$echo	Optional - whether to echo the form
 *
 * @return	void
 */
function my_navbar_search( $echo = true ) {
	$searchform = '	<form id="searchform" class="navbar-search pull-right" method="get" action="' . esc_url( home_url( '/' ) ) . '">
						<div id="simpleSearch">
							<label for="s" class="assistive-text hidden">' . __( 'Search', 'the-bootstrap' ) . '</label>
							<input type="search" class="search-field" name="s" id="s" placeholder="' . esc_attr__( 'Search', 'the-bootstrap' ) . '" />
							<input type="submit" value="" class="searchButton" />
						</div>
					</form>';

	if ( $echo )
		echo $searchform;

	return $searchform;
}



/**
 * Change excerpt length to be 20 char
 *
 * @author	Zlatko
 * @since	02.05.2014
 *
 * @return	void
 */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/**
 * Nullify "Read More" message; will be defined in schools.php
 *
 * @author	Zlatko
 * @since	12.19.2014
 *
 * @return	void
 */
function new_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more', 999 );


/**
 * Modifies custom post interaction messages
 *
 * @author	Zlatko
 * @since	29.04.2014
 *
 * @return	$messages - modified array of messages
 */
function my_updated_messages_school( $messages ) {
	global $post, $post_ID;
	$messages['school'] = array(
		0 => '',
		1 => sprintf( __('School updated. <a href="%s">View school</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('School updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('School restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('School record published. <a href="%s">View school</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('School record saved.'),
		8 => sprintf( __('School submitted. <a target="_blank" href="%s">Preview school</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('School scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview school</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('School draft updated. <a target="_blank" href="%s">Preview School</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages_school' );


/**
 * Creates a "Schools" custom post type
 *
 * @author	Zlatko
 * @since	29.04.2014
 *
 * @return	void
 */
function my_custom_post_school() {

	$labels = array(
		'name'               => _x( 'Schools', 'post type general name' ),
		'singular_name'      => _x( 'School', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'school' ),
		'add_new_item'       => __( 'Add New School' ),
		'edit_item'          => __( 'Edit School' ),
		'new_item'           => __( 'New School' ),
		'all_items'          => __( 'All Schools' ),
		'view_item'          => __( 'View School' ),
		'search_items'       => __( 'Search Schools' ),
		'not_found'          => __( 'No schools found' ),
		'not_found_in_trash' => __( 'No schools found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Schools'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our schools and school specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
	);

	register_post_type( 'school', $args );
	flush_rewrite_rules();
}


/**
 * Register Custom Taxonomies
 *
 * @author	Zlatko
 * @since	08.12.2014
 *
 * @return	void
 *
 */
function school_taxonomies_init() {
	// define arrays containing custom taxonomies
	$taxonomies = array(
		'school-type',
		'additional-services',
		'additional-criteria',
		'academic-features',
		'arts',
		'language-and-social-sciences',
		'science-and-technology',
		'athletics',
		'clubs',
		'school-assistance',
		'special-support',
		'religious-focus' );

	$taxonomies_names = array (
		'School Type',
		'Additional Services',
		'Additional Criteria',
		'Academic Features',
		'Arts',
		'Language And Social Sciences',
		'Science And Technology',
		'Athletics',
		'Clubs',
		'School Assistance',
		'Special Support',
		'Religious Focus' );

	//define all taxonomies
	foreach (array_combine($taxonomies, $taxonomies_names) as $taxonomy => $taxonomy_name) {
		register_taxonomy(
			$taxonomy,
			'school',
			array(
				'label' => __( $taxonomy_name ),
				'rewrite' => array( 'slug' => $taxonomy ),
				'show_ui' => false
			)
		);
	}

}


function school_insert_taxonomy_terms() {
	/* --- register taxonomy terms --- */

	//School Type
	wp_insert_term('Standard Private School', 'school-type');
	wp_insert_term('Montessori School', 'school-type');
	wp_insert_term('Religious Private School', 'school-type');
	wp_insert_term('AP School', 'school-type');
	wp_insert_term('IB School', 'school-type');
	wp_insert_term('Day Care', 'school-type');

	//Additional Services
	wp_insert_term('Before-school care', 'additional-services');
	wp_insert_term('After-school care', 'additional-services');
	wp_insert_term('After-school care', 'additional-services');
	wp_insert_term('Lunch program', 'additional-services');
	wp_insert_term('Transportation', 'additional-services');

	//Additional Criteria
	wp_insert_term('All boys', 'additional-criteria');
	wp_insert_term('All girls', 'additional-criteria');
	wp_insert_term('Boarding', 'additional-criteria');
	wp_insert_term('Co-Ed', 'additional-criteria');

	// Academic Features
	wp_insert_term('AP Courses', 'academic-features');
	wp_insert_term('Exchange Programs', 'academic-features');
	wp_insert_term('IB Program', 'academic-features');
	wp_insert_term('IB Middle Years Program', 'academic-features');
	wp_insert_term('IB Primary Years Program', 'academic-features');
	wp_insert_term('French Immersion', 'academic-features');
	wp_insert_term('Gifted Program', 'academic-features');
	wp_insert_term('Montessori Toddlers', 'academic-features');
	wp_insert_term('Montessori Casa', 'academic-features');
	wp_insert_term('Montessori Elementary', 'academic-features');
	wp_insert_term('Montessori Junior High', 'academic-features');
	wp_insert_term('Summer School', 'academic-features');

	// Arts
	wp_insert_term('Band', 'arts');
	wp_insert_term('Choir', 'arts');
	wp_insert_term('Music Theatre', 'arts');
	wp_insert_term('Vocal', 'arts');

	// Languages and Social Sciences
	wp_insert_term('Italian', 'language-and-social-sciences');
	wp_insert_term('ESL', 'language-and-social-sciences');
	wp_insert_term('Politics', 'language-and-social-sciences');
	wp_insert_term('Cantonese', 'language-and-social-sciences');
	wp_insert_term('Spanish', 'language-and-social-sciences');
	wp_insert_term('Religion', 'language-and-social-sciences');
	wp_insert_term('French', 'language-and-social-sciences');
	wp_insert_term('Geography', 'language-and-social-sciences');
	wp_insert_term('German', 'language-and-social-sciences');
	wp_insert_term('History', 'language-and-social-sciences');

	// Science and Technology
	wp_insert_term('Anatomy', 'science-and-technology');
	wp_insert_term('Biology', 'science-and-technology');
	wp_insert_term('Chemistry', 'science-and-technology');
	wp_insert_term('Ecology', 'science-and-technology');
	wp_insert_term('Physics', 'science-and-technology');
	wp_insert_term('Physiology', 'science-and-technology');
	wp_insert_term('Psychology', 'science-and-technology');
	wp_insert_term('Computer Science', 'science-and-technology');
	wp_insert_term('Robotics', 'science-and-technology');
	wp_insert_term('Web & App Design', 'science-and-technology');

	// Athletics
	wp_insert_term('Archery', 'athletics');
	wp_insert_term('Badminton', 'athletics');
	wp_insert_term('Baseball', 'athletics');
	wp_insert_term('Basketball', 'athletics');
	wp_insert_term('Cheerleading', 'athletics');
	wp_insert_term('Equestrian', 'athletics');
	wp_insert_term('Fencing', 'athletics');
	wp_insert_term('Football', 'athletics');
	wp_insert_term('Golf', 'athletics');
	wp_insert_term('Gymnastics', 'athletics');
	wp_insert_term('Hockey', 'athletics');
	wp_insert_term('Martial Arts', 'athletics');
	wp_insert_term('Mountain Biking', 'athletics');
	wp_insert_term('Rowing', 'athletics');
	wp_insert_term('Rugby', 'athletics');
	wp_insert_term('Skating', 'athletics');
	wp_insert_term('Snowboarding', 'athletics');
	wp_insert_term('Soccer', 'athletics');
	wp_insert_term('Squash', 'athletics');
	wp_insert_term('Swimming', 'athletics');
	wp_insert_term('Tennis', 'athletics');
	wp_insert_term('Track & Field', 'athletics');
	wp_insert_term('Volleyball', 'athletics');
	wp_insert_term('Weightlifting', 'athletics');
	wp_insert_term('Wrestling', 'athletics');
	wp_insert_term('Yoga', 'athletics');

	// Clubs
	wp_insert_term('Business Club', 'clubs');
	wp_insert_term('Chess Club', 'clubs');
	wp_insert_term('Debate Club', 'clubs');
	wp_insert_term('Environment Club', 'clubs');
	wp_insert_term('IT Club', 'clubs');
	wp_insert_term('Math Club', 'clubs');
	wp_insert_term('Robotics Club', 'clubs');
	wp_insert_term('School Newspaper', 'clubs');
	wp_insert_term('Student Council', 'clubs');
	wp_insert_term('Yearbook Club', 'clubs');

	// School Assistance
	wp_insert_term('Before School Program', 'school-assistance');
	wp_insert_term('Lunch Program', 'school-assistance');
	wp_insert_term('After School Program', 'school-assistance');
	wp_insert_term('Half Day Kindergarden', 'school-assistance');
	wp_insert_term('Full Day Kindergarden', 'school-assistance');
	wp_insert_term('One on One Lessons', 'school-assistance');
	wp_insert_term('Transportation', 'school-assistance');

	// Special Support
	wp_insert_term('ADD/ADHD', 'special-support');
	wp_insert_term('Asperger Disorder', 'special-support');
	wp_insert_term('Autism', 'special-support');
	wp_insert_term('Behavioral', 'special-support');
	wp_insert_term('Down Syndrome', 'special-support');
	wp_insert_term('Dyslexia', 'special-support');
	wp_insert_term('Special Needs Assistance', 'special-support');
	wp_insert_term('Physical Disability Assistance', 'special-support');

	// Religious Focus
	wp_insert_term('Buddhist', 'religious-focus');
	wp_insert_term('Catholic', 'religious-focus');
	wp_insert_term('Christian', 'religious-focus');
	wp_insert_term('Hindu', 'religious-focus');
	wp_insert_term('Jewish', 'religious-focus');
	wp_insert_term('Muslim', 'religious-focus');

}

/**
 * Initiate Custom Post, Custom Taxonomies, and populate Taxonomies in order
 *
 * @author	Zlatko
 * @since	04.10.2014
 *
 * @return	void
 */
function initialization_order(){
	my_custom_post_school();
	school_taxonomies_init();
	school_insert_taxonomy_terms();
}
add_action( 'init', 'initialization_order' );


/**
 * Perform Validation of form entry fields
 *
 * @author	Zlatko
 * @since	07.05.2014
 *
 * @return	void
 */
function validate_form($school_id) {

	//reset error message to empty
	$formError = "";

	//set up email-related variables
	$email_address = $_POST["email"];
	$subject = $_POST["subject"];
	$message = $_POST["message"];

	//validate email address
	if ( !is_email($email_address) ) {
		$formError = "Email not valid";
		return;
	}

	//check if Subject field is empty
	if ( empty($subject) ) {
		$formError = "Subject is required";
		return;
	}

	//check if Message field is empty
	if ( empty($message) ) {
		$formError = "Message is required";
		return;
	}
	echo "SUCCESS!";

	//echo htmlspecialchars($_SERVER['REQUEST_URI']);
}


/**
 * Perform Validation of form entry fields, and send email out
 *
 * @author	Zlatko
 * @since	07.05.2014
 *
 * @return	void
 */
function email_school($school_id) {
	$email_address = $_POST["email"];

	//send email to school
	//get_post_meta( $school_id, 'school-street-address', true );
	//mail("webmaster@example.com", sanitize_text_field($subject), sanitize_text_field($message), "From: $from\n");

	//confirmation message

	return $email_address;
}


//*==================================================== < CUSTOM FUNCTIONS > =====================================================================*//

/**
 * Render the taxonomies within the Advanced Search page
 *
 * @author	Zlatko
 * @since	12.15.2014
 *
 * @return	void
 */

//array of header titles
//array of taxonomy names
/*array of pairs:
	(tax group name) & (array of taxonomy names)
*/
function render_advanced_search_taxonomies($groupNames, $groupMembers) {
	// check the two arrays are of equal length
	if ( count($groupNames) == count($groupMembers) )
		// loop through taxonomy groups
		for ($i=0; $i<count($groupNames); $i++){
			$taxGroup = new ArrayObject(array());

			// append member tax's to current tax group
			foreach ($groupMembers[$i] as $current_taxonomy)
				$taxGroup->append(get_taxonomy($current_taxonomy));

			advanced_search_render_single_taxonomy($groupNames[$i], $taxGroup);

			unset($taxGroup);
		}
	else
		echo "Error: arrays groupNames and groupMembers are different lengths!";
}
function advanced_search_render_single_taxonomy($taxonomy_group_name, $taxonomy_group){

	//print taxonomy group as divider, if it exists
	if ($taxonomy_group_name != '')
		echo "<div class='row-fluid'><div class='span12'><h4 class='advanced-search-divider'>" . $taxonomy_group_name . "</h4></div></div>";

	foreach ( $taxonomy_group as $taxonomy ) {
		//print the taxonomy name
		echo "<div class='row-fluid'><div class='span12 advanced-search-taxonomy'><b>" . $taxonomy->label . ":</b></div></div>";

		$rowCounter = 0;

		$terms = get_terms($taxonomy->name, 'hide_empty=0');

		echo "<div class='row-fluid'>"; // --- initial row
		foreach ( $terms as $term ){
			//print HTML for new row
			if ($rowCounter == 4){
				echo "</div><div class='row-fluid'>";
				$rowCounter = 0;
			}

			//print taxonomy term
			echo "<div class='span3'><input id='"
				. $term->slug . "' name='"
				. $taxonomy->name . "[]' value='"
				. $term->slug . "' type='checkbox'><label for='"
				. $term->slug . "'>" . $term->name . "</label></div>";

			$rowCounter++;
		}
		echo "</div>"; // --- close final row
	}
}

/**
 * Append Local Website URL to create address leading to desired page
 *
 * @author	Zlatko
 * @since	12.16.2014
 *
 * @return	void
 */
function append_website_URL($page_address){
	$home_url = substr($_SERVER['SCRIPT_NAME'], 0, -9);
	echo 'http://' . $_SERVER['HTTP_HOST'] . $home_url . $page_address;
}

/**
 * Return Local Website URL to create address leading to desired page as String
 *
 * @author	Zlatko
 * @since	01.06.2015
 *
 * @return	A string containing $page_address appenede to the website's URL
 */
function get_website_URL($page_address){
	$home_url = substr($_SERVER['SCRIPT_NAME'], 0, -9);
	return 'http://' . $_SERVER['HTTP_HOST'] . $home_url . $page_address;
}


/**
 * Render one of three school information meta data:
 *	1. grades
 *	2. tuition
 *	3. class-size
 *
 * @author	Zlatko
 * @since	01.27.2015
 *
 * @return	void
 */
function render_school_info($school_id, $info_type){

	//grab min & max values
	$min_value = get_post_meta( $school_id, "school-{$info_type}-min", true );
	$max_value = get_post_meta( $school_id, "school-{$info_type}-max", true );


	//print min & max values
	if ( $min_value != "N/A" && $min_value != ""){

		//add currency, if number is monetary
		if ($info_type == "annual-tuition"){
			$min_value = "$" . number_format($min_value);
			$max_value = "$" . number_format($max_value);
		}

		echo $min_value;

		if ( $max_value != "N/A" && $max_value != "")
			echo " to {$max_value}";
	}
	else
		echo "N/A";
}

/**
 * Render desired school's type(s)
 *
 * @author	Zlatko
 * @since	01.27.2015
 *
 * @return	void
 */
function render_school_type($school_id){
	//get all taxonomy terms
	$taxonomy_terms = get_terms('school-type', array( 'hide_empty' => false ));

	$first_term = true;
	//render taxonomy terms within meta box
	foreach($taxonomy_terms as $current_term){
		if (has_term($current_term->name, 'school-type', $school_id)){
			if ($first_term){
				$first_term = false;
				echo $current_term->name;
			}
			else
				echo ", " . $current_term->name;
		}
	}

	//print N/A if no school-type terms were found
	if ($first_term)
		echo "N/A";
}


/**
 * Break down all search results into a results array of appropriate page size
 *
 * @author	Zlatko
 * @since	01.06.2015
 *
 * @return	Array of school ID's proportional to desired page size
 */
function paginate_school_results($all_school_ids, $current_page){
	$schools_per_page = 7;
	$school_ids = null;

	$offset = ($current_page - 1)*$schools_per_page;
	$limit = $offset + $schools_per_page;

	//populate $shool_ids to be returned
	for ($offset; $offset<$limit; $offset++)
		if (isset($all_school_ids[$offset]))
			$school_ids[] = $all_school_ids[$offset];

	return $school_ids;
}

/**
 * Print page numbers, under search results, linking to different search result pages
 *
 * @author	Zlatko
 * @since	01.06.2015
 *
 * @return	void
 */
function print_page_numbers($current_page, $results_num){
	$schools_per_page = 7;

 	if ($results_num <= $schools_per_page){
 		//don't print anything
	}
	else{
		echo "<center id='school-archive-bottom'>";

		$total_pages = ceil($results_num / $schools_per_page);

		//print "previous" link
		if ($current_page !== 1){
			$result_page_url = "school-search-results/?pageid=" . ($current_page-1);
			echo "<a class='next page-numbers' href='" . get_website_URL($result_page_url) . "'>« Previous</a> ";
		}

		//print page numbers
		for ($i=1; $i<=$total_pages; $i++){
			$result_page_url = "school-search-results/?pageid=" . $i;

			if ($i == $current_page)
				echo "<span class='page-numbers current'>" . $i . "</span> ";
			else
				echo "<a class='page-numbers' href='" . get_website_URL($result_page_url) . "'>" . $i . "</a> ";
		}

		//print "next" link
		if ($current_page != $total_pages){
			$result_page_url = "school-search-results/?pageid=" . ($current_page+1);
			echo "<a class='next page-numbers' href='" . get_website_URL($result_page_url) . "'>Next »</a>";
		}

		echo "</center>";
	}
}

//*==================================================== < /CUSTOM FUNCTIONS > =====================================================================*//

?>
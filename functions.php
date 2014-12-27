<?php

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

	// Academic Features
	wp_insert_term('AP Courses', 'academic-features');
	wp_insert_term('Eschange Programs', 'academic-features');
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
	wp_insert_term('Test', 'arts');

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



//*===================================================================================================================================================*//
//*-------------------------------------------------------- < SCHOOL UI CODE > -----------------------------------------------------------------------*//
//*===================================================================================================================================================*//

/* -- work in progress, disable "Add New" button if current Author has 1 ACTIVE School Post --
// hide "add new" on wp-admin menu
function hd_add_box() {
	if ( !current_user_can('edit_others_posts') && count_user_posts( get_current_user_id() >= 1 ) )
		echo "cannot post any new schools";
	else
		echo "can post 1 new school";	
	global $submenu;
	unset($submenu['edit.php?post_type=yourcustomposttype'][10]);
}

// hide "add new" button on edit page
function hd_add_buttons() {
	global $pagenow;
	if(is_admin()){
		if($pagenow == 'edit.php' && $_GET['post_type'] == 'yourcustomposttype'){
			echo '.add-new-h2{display: none;}';
		}
	}
}
add_action('admin_menu', 'hd_add_box');
add_action('admin_head','hd_add_buttons');
*/


/**
 * Removes unnecessary default metaboxes from Schools Post Type
 *
 * @author	Zlatko
 * @since	17.09.2014
 *
 * @return	void
 */
function my_remove_meta_boxes() {
  //Remove Excerpt Metabox
  remove_meta_box( 'postexcerpt', 'school', 'normal' );

  //Remove Comments Metabox
  //remove_meta_box('commentsdiv', 'school', 'normal');
  //remove_meta_box( 'commentstatusdiv', 'school', 'normal' );

  //Remove Account Type Metabox if user is not Admin -- NOT TESTED!!!
  if ( !current_user_can( 'manage_options' ) ) {
    remove_action( 'media_buttons', 'media_buttons' );
  }

  /*
  if (!is_admin()){
  	remove_meta_box( 'account_type', 'school', 'normal' );
  }
  */
}


/**
 * Defines all custom school META BOXES within each School post
 *
 * Meta Boxes so far:
 * 		- Contact Info
 *		- School Info
 * 		- Acount Type
 *
 * @author	Zlatko
 * @since	26.11.2014
 *
 * @return	void
 */
function school_meta_boxes() {
	//remove unnecessary metaboxes
	my_remove_meta_boxes();

	add_meta_box(
		'contact_info_box',
		__( 'Contact Information'),
		'contact_info_box_content',
		'school',
		'normal',
		'high'
	);

	add_meta_box(
		'school_info_box',
		__( 'School Information'),
		'school_info_box_content',
		'school',
		'normal',
		'low'
	);

    /*------------------ Taxonomy Meta Boxes ------------------*/
    
	add_meta_box(
		'academic-features',
		__( 'Academic Features'),
		'academic_features_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'arts',
		__( 'Arts'),
		'arts_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'language-and-social-sciences',
		__( 'Languages and Social Sciences'),
		'languages_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'science-and-technology',
		__( 'Science and Technology'),
		'science_and_technology_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'athletics',
		__( 'Athletics'),
		'athletics_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'clubs',
		__( 'Clubs'),
		'clubs_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'school-assistance',
		__( 'School Assistance'),
		'school_assistance_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'special-support',
		__( 'Special Support'),
		'special_support_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'religious-focus',
		__( 'Religious Focus'),
		'religious_focus_box_content',
		'school',
		'side',
		'low'
	);


	/*-----------------------------------------------------------*/
}
add_action( 'add_meta_boxes', 'school_meta_boxes' );


/**
 * Defines "Contact Information" META BOX CONTENT
 *
 * @author	Zlatko
 * @since	14.11.2014
 *
 * @return	void
 *
 * address, website, phone number
 */
function contact_info_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'contact_info_box_content_nonce' );
	// determine of current user is Author
	?>
	<table cellspacing="20px">
		<tr>
			<td>
				<label for="school-street-address">Street Address:</label><br />
				<input type="text" id="school-street-address" name="school-street-address" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-street-address', true ) ); ?>" />
			</td>
			<td>
				<label for="school-city">City:</label><br />
				<input type="text" id="school-city" name="school-city" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-city', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-province">Province:</label><br />
				<input type="text" id="school-province" name="school-province" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-province', true ) ); ?>" />
			</td>
			<td>
				<label for="school-postal-code">Postal Code:</label><br />
				<input type="text" id="school-postal-code" name="school-postal-code" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-postal-code', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-phone-number">Phone Number:</label><br />
				<input type="text" id="school-phone-number" name="school-phone-number" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-phone-number', true ) ); ?>" />
			</td>
			<td>
				<label for="school-email-address">Email Address:</label><br />
				<input type="text" id="school-email-address" name="school-email-address" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-email-address', true ) ); ?>" />
			</td>
			<td>
				<label for="school-website">Website:</label><br />
				<input type="text" id="school-website" name="school-website" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-website', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-facebook-page">Facebook Page URL:</label><br />
				<input type="text" id="school-facebook-page" name="school-facebook-page" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-facebook-page', true ) ); ?>" />
			</td>
		</tr>
	</table>
	
	<br />
<?php
}

/**
 * Defines "School Information" META BOX CONTENT
 *
 * @author	Zlatko
 * @since	19.12.2014
 *
 * @return	void
 *
 * school type, school grades, annual tuition cost, class size
 */
function school_info_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'school_info_box_content_nonce' );
	?>

	<table cellspacing="20px">
		<tr>
			<td colspan="2">
				<label for="school-type">School Type:</label><br />
				<input type="text" id="school-type" name="school-type" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-type', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-grades">School Grades:</label><br />
				<input type="text" id="school-grades" name="school-grades" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-grades', true ) ); ?>" />
			</td>
			<td>
				<label for="school-class-size">Class Size:</label><br />
				<input type="text" id="school-class-size" name="school-class-size" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-class-size', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-annual-tuition">Annual Tuition:</label><br />
				<input type="text" id="school-annual-tuition" name="school-annual-tuition" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-annual-tuition', true ) ); ?>" />
			</td>
		</tr>
	</table>
	
<?php
}

/**
 * The 9 Functions below define all custom Taxonomies' META BOX CONTENT
 *
 * @author	Zlatko
 * @since	21.12.2014
 *
 * @return	void
 *
 */
function academic_features_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'academic_features_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "academic-features", "Academic Features taxonomy doesn't exist!");
}
function arts_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'arts_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "arts", "Arts taxonomy doesn't exist!");
}
function languages_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'languages_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "language-and-social-sciences", "Languages taxonomy doesn't exist!");
}
function science_and_technology_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'science_and_technology_box_content_nonce' );
	render_taxonomy_terms( $post, "science-and-technology", "Science and Technology taxonomy doesn't exist!");
}
function athletics_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'athletics_box_content_nonce' );
	render_taxonomy_terms( $post, "athletics", "Athletics taxonomy doesn't exist!");
}
function clubs_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'clubs_box_content_nonce' );
	render_taxonomy_terms( $post, "clubs", "Clubs taxonomy doesn't exist!");
}
function school_assistance_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'school_assistance_box_content_nonce' );
	render_taxonomy_terms( $post, "school-assistance", "School Assistance taxonomy doesn't exist!");
}
function special_support_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'special_support_box_content_nonce' );
	render_taxonomy_terms( $post, "special-support", "Special Support taxonomy doesn't exist!");
}
function religious_focus_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'religious_focus_box_content_nonce' );
	render_taxonomy_terms( $post, "religious-focus", "Religious Focus taxonomy doesn't exist!");
}
/**
 * Renders Taxonomies' META BOX CONTENT
 *
 * @author	Zlatko
 * @since	09.12.2014
 *
 * @return	void
 *
 */
function render_taxonomy_terms( $post, $taxonomy, $error_msg ){
    if ( taxonomy_exists($taxonomy) ){
	    // store taxonomy terms in array
	    $taxonomy_terms = get_terms($taxonomy, array( 'hide_empty' => false ));

		//render taxonomy terms within meta box
		foreach($taxonomy_terms as $current_term){
			echo "<input type='checkbox' id='" . $current_term->slug . "' name='" . $current_term->slug;

			//check if the school has the current term
			if (has_term($current_term->name, $taxonomy))
				echo "' checked>";
			else
				echo "'>";

			echo "<label for='" . $current_term->slug . "'>" . $current_term->name . "</label><br />";
		}
    }
    else
		echo "Languages taxonomy doesn't exist!"; //error message
}


/**
 * Defines custom instance for Attachments plugin, as per template
 *
 * @author	Zlatko
 * @since	04.11.2014
 *
 * @return	void
 *
 */
function my_pictures( $attachments )
{
  $fields         = array(
    array(
      'name'      => 'title',                         // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Title', 'pictures' ),       // label to display
      'default'   => 'title',                         // default value upon selection
    ),
  );

  $args = array(
    // title of the meta box (string)
    'label'         => 'My Pictures',

    // all post types to utilize (string|array)
    'post_type'     => array( 'school' ),

    // meta box position (string) (normal, side or advanced)
    'position'      => 'normal',

    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit

    // include a note within the meta box (string)
    'note'          => 'Attach pictures here!',

    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,

    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Attach Images', 'pictures' ),

    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Attach', 'pictures' ),

    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',

    // fields array
    'fields'        => $fields,
  );

  $attachments->register( 'my_pictures', $args ); // unique instance name
}
add_action( 'attachments_register', 'my_pictures' );

add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance


//*===================================================================================================================================================*//
//*------------------------------------------------------- </ SCHOOL UI CODE > -----------------------------------------------------------------------*//
//*===================================================================================================================================================*//




/**
 * Handle SUBMITTED Meta Box content
 *
 * @author	Zlatko
 * @since	26.11.2014
 *
 * @return	void
 */
function custom_meta_box_save( $post_id ) {
	
	// stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify nonce before continuing
	if ( !wp_verify_nonce( $_POST['school_info_box_content_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	// check if user has permissions to edit post & page
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
	}

	
	//----------- update school taxonomies -----------//
	foreach (get_taxonomies(array('public' => true, '_builtin' => false)) as $current_taxonomy) {

		//create empty taxonomy terms array
		$school_taxonomy_terms = array();

		//check if current taxonomy term's checkbox is checked
		foreach ( get_terms($current_taxonomy, array('hide_empty' => false)) as $current_term ) {
			if ( isset( $_POST[$current_term->slug] ) )
				array_push($school_taxonomy_terms, $current_term->name);
		}

		//call custom post terms function
		wp_set_object_terms( $post_id, $school_taxonomy_terms, $current_taxonomy, false );
	}

	
	//----------- update school meta keys, if necessary -----------//
	foreach (array(
					'school-street-address',
					'school-city',
					'school-province',
					'school-postal-code',
					'school-website', 
					'school-phone-number', 
					'school-email-address',
					'school-facebook-page',
					'school-type', 
					'school-grades', 
					'school-class-size', 
					'school-annual-tuition') as $meta_key)
	{
		//current meta value
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		//get new meta data
		$new_meta_value = ( isset( $_POST[$meta_key] ) ? sanitize_text_field( $_POST[$meta_key] ) : '' );
		
		//If there is no new meta value but an old value exists, delete it
		if ( '' == $new_meta_value && isset($meta_value) )
			delete_post_meta( $post_id, $meta_key, $meta_value );
		//else, add or update the meta value
		else
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	}
}
add_action( 'save_post', 'custom_meta_box_save' );


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
 * @since	12.15.2012
 *
 * @return	void
 */
function render_advanced_search_taxonomies() {
	//target only custom taxonomies
	$args = array('public'   => true, '_builtin' => false);
	$operator = 'and';

	//return objects
	$output = 'objects';

	$taxonomies = get_taxonomies( $args, $output, $operator );

	//groups for taxonomies
	$features = new ArrayObject(array());
	$courses = new ArrayObject(array());
	$athleticsAndClubs = new ArrayObject(array());

	//group taxonomies
	foreach ( $taxonomies as $taxonomy ) {
		if ( $taxonomy->name == "academic-features")
			$features->append($taxonomy);
		elseif ($taxonomy->name == "arts" ||
				$taxonomy->name == "language-and-social-sciences" ||
				$taxonomy->name == "science-and-technology")
			$courses->append($taxonomy);
		else
			$athleticsAndClubs->append($taxonomy);
	}

	//render all Features
	advanced_search_render_single_taxonomy("", $features);
	//render all Courses
	advanced_search_render_single_taxonomy("Courses", $courses);
	//render all Athletics and Clubs
	advanced_search_render_single_taxonomy("Athletics and Clubs", $athleticsAndClubs);
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
 * @since	12.16.2012
 *
 * @return	void
 */
function append_website_URL($page_address){
	$home_url = substr($_SERVER['SCRIPT_NAME'], 0, -9);
	echo 'http://' . $_SERVER['HTTP_HOST'] . $home_url . $page_address;
}

/**
 * Print out a school's address information, according to requests
 *	> $args = 'street-address', 'city', 'province', 'postal-code'
 *
 * @author	Zlatko
 * @since	12.19.2012
 *
 * @return	void
 */
function get_school_address ($school_id, $args){
	$comma = false;
	$address = "";

	//loop through
	for ($i=0; $i < count($args); $i++) {
		//add comma if not first entry
		if ($comma)
			$address .= ", ";
		else
			$comma = true;
		
		switch ($args[$i]) {
			case "street-address":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-street-address', true ) );
				$comma = true; break;
			case "city":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-city', true ) );
				$comma = true; break;
			case "province":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-province', true ) );
				$comma = true; break;
			case "postal-code":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-postal-code', true ) );
				$comma = true; break;
			default:
				$comma = false;
		}
	}

	echo $address;
}


function get_search_results($search_terms, $search_type){
	global $wpdb;

	// break search query into an array
	$terms_array = explode(' ', $search_terms);
	$terms_array_length = count($terms_array) - 1;

	// begin SELECT statement; INNER JOIN with taxonomy terms; WHERE posts are 'school' AND 'published'
	$sql = "SELECT SQL_CALC_FOUND_ROWS wp_posts.ID FROM wp_posts 
				INNER JOIN 
					wp_postmeta ON wp_posts.ID = wp_postmeta.post_id 
				INNER JOIN 
					wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id 
				INNER JOIN 
					wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
				INNER JOIN 
					wp_terms ON wp_terms.term_id = wp_term_taxonomy.term_id 
			WHERE wp_posts.post_type IN ('school') AND wp_posts.post_status = 'publish'";
	
	// AND ( (post.title LIKE '%word1%' OR post.title LIKE '%word2%')
	$sql .= " AND ( ( ";

		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_posts.post_title LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}

	//  OR ( post.term LIKE '%word1%' OR post.term LIKE '%word2%' )
	$sql .= " ) OR ( ";

		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_terms.name LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}

	//  OR ( post.term LIKE '%word1%' OR post.term LIKE '%word2%' )
	$sql .= " ) OR ( ";

		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_postmeta.meta_value LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}

	// ) GROUP BY post.id ORDER BY post.date
	$sql .= " ) ) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 10";

	//echo $sql;
	$search_results = $wpdb->get_col( $sql );
	//var_dump($search_results);

	// if header-search

	// if advanced-search

	// if filtered-search

	return $search_results;
}
//*==================================================== < /CUSTOM FUNCTIONS > =====================================================================*//

?>

<?php

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
		'school-type',
		__('School Type'),
		'school_type_taxonomy_box_content',
		'school',
		'side',
		'low'
	);

	add_meta_box(
		'additional-services',
		__('Additional Services'),
		'additional_services_taxonomy_box_content',
		'school',
		'side',
		'low'
	);

	add_meta_box(
		'additional-criteria',
		__('Additional Criteria'),
		'additional_criteria_taxonomy_box_content',
		'school',
		'side',
		'low'
	);

	add_meta_box(
		'academic-features',
		__('Academic Features'),
		'academic_features_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'arts',
		__('Arts'),
		'arts_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'language-and-social-sciences',
		__('Languages and Social Sciences'),
		'languages_taxonomy_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'science-and-technology',
		__('Science and Technology'),
		'science_and_technology_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'athletics',
		__('Athletics'),
		'athletics_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'clubs',
		__('Clubs'),
		'clubs_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'school-assistance',
		__('School Assistance'),
		'school_assistance_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'special-support',
		__('Special Support'),
		'special_support_box_content',
		'school',
		'side',
		'low'
	);
	add_meta_box(
		'religious-focus',
		__('Religious Focus'),
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
				<?php
					$lat = get_post_meta( $post->ID, 'school-latitude', true );
					$lng = get_post_meta( $post->ID, 'school-longitude', true );
					
					if ( !empty($lat) && !empty($lng) )
						echo "<div><b>Latitude:</b> {$lat}, <b>Longitude:</b> {$lng}</div>";
					else
						echo "<b>Latitude and Longitude values can't be located.</b>";
				?>
			</td>
		</tr>
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
				<label for="school-postal-code">Postal Code:</label><br />
				<input type="text" id="school-postal-code" name="school-postal-code" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-postal-code', true ) ); ?>" />
			</td>
			<td>
				<label for="school-province">Province:</label><br />
				<select name="school-province">
				<?php
					$provinces = array(
							"",
							"Alberta",
							"British Columbia",
							"Manitoba",
							"New Brunswick",
							"Newfoundland Labrador",
							"Nova Scotia",
							"Ontario",
							"Prince Edward Island",
							"Quebec",
							"Saskatchewan",
							"Northwest Territories",
							"Nunavut",
							"Yukon"
						);
					foreach ($provinces as $province){
						echo "<option value='" . $province . "'";
						if ( esc_attr( get_post_meta( $post->ID, 'school-province', true )) == $province)
							echo " selected='selected'";
						echo ">" . $province . "</option>";
					}
				?>
				</select>
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
		</tr>
		<tr>
			<td colspan="2">
				<label for="school-website">Website:</label><br />
				http://<input type="text" id="school-website" name="school-website" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-website', true ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label for="school-facebook-page">Facebook Page URL:</label><br />
				http://www.facebook.com/<input type="text" id="school-facebook-page" name="school-facebook-page" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-facebook-page', true ) ); ?>" />
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
			<td>
				<label>School Grades:</label><br />
				<select id="school-grades-min" name="school-grades-min">
				<?php 
					for ($i=0; $i<13; $i++){
						if ($i == 0)
							$number = "N/A";
						else
							$number = $i;

						echo "<option value='" . $number . "'";
						if ( get_post_meta( $post->ID, 'school-grades-min', true ) == $i )
							echo "selected='selected'";
						echo ">" . $number . "</option>";
					}
				?>
				</select> - to - 
				<select id="school-grades-max" name="school-grades-max">
				<?php
					for ($i=0; $i<=13; $i++){
						if ($i == 0)
							$number = "N/A";
						else if ($i == 13)
							$number = "12+";
						else
							$number = $i;

						echo "<option value='" . $number . "'";
						if ( get_post_meta( $post->ID, 'school-grades-max', true ) == $i )
							echo "selected='selected'";
						echo ">" . $number . "</option>";
					}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Class Size:</label><br />
				<select id="school-class-size-min" name="school-class-size-min">
				<?php 
					for ($i=0; $i<=21; $i++){
						if ($i == 0)
							$number = "N/A";
						else if ($i == 21)
							$number = "21+";
						else
							$number = $i;

						echo "<option value='" . $number . "'";
						if ( get_post_meta( $post->ID, 'school-class-size-min', true ) == $i )
							echo "selected='selected'";
						echo ">" . $number . "</option>";
					}
				?>
				</select> - to - 
				<select id="school-class-size-max" name="school-class-size-max">
				<?php 
					for ($i=0; $i<=21; $i++){
						if ($i == 0)
							$number = "N/A";
						else if ($i == 21)
							$number = "21+";
						else
							$number = $i;

						echo "<option value='" . $number . "'";
						if ( get_post_meta( $post->ID, 'school-class-size-max', true ) == $i )
							echo "selected='selected'";
						echo ">" . $number . "</option>";
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="school-annual-tuition">Annual Tuition (numbers only):</label><br />
				$<input type="text" size="10" id="school-annual-tuition-min" name="school-annual-tuition-min" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-annual-tuition-min', true ) ); ?>" /> - to - 
				$<input type="text" size="10" id="school-annual-tuition-max" name="school-annual-tuition-max" value="<?php echo esc_attr( get_post_meta( $post->ID, 'school-annual-tuition-max', true ) ); ?>" />
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
function school_type_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'school_type_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "school-type", "School Type taxonomy doesn't exist!");
}
function additional_services_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'additional_services_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "additional-services", "Additional Services taxonomy doesn't exist!");
}
function additional_criteria_taxonomy_box_content( $post ) {
	// insert hidden nonce form field
	wp_nonce_field( plugin_basename( __FILE__ ), 'additional_criteria_taxonomy_box_content_nonce' );
	render_taxonomy_terms( $post, "additional-criteria", "Additional Criteria taxonomy doesn't exist!");
}
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
 * Print out a school's address information, according to requests
 *	> $args = 'street-address', 'city', 'province', 'postal-code'
 *
 * @author	Zlatko
 * @since	01.06.2015
 *
 * @return	String $address
 */
function get_school_address($school_id, $args){
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
				break;
			case "city":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-city', true ) );
				break;
			case "province":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-province', true ) );
				break;
			case "postal-code":
				$address .= sanitize_text_field( get_post_meta( $school_id, 'school-postal-code', true ) );
				break;
		}
	}

	return $address;
}


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


	//----------- update latitude & longitude values -----------//

	//retrieve minimum address info
	$streetAddress = get_post_meta( $post->ID, 'street-address', true );
	$city = get_post_meta( $post->ID, 'school-city', true );
	$province = get_post_meta( $post->ID, 'province', true );
	$postalCode = get_post_meta( $post->ID, 'postal-code', true );

	//only perform geocode if minimum address info exists
	if ( !empty($streetAddress) && !empty($city) && !empty($province) ){
		//define URL variables
		$url_prefix = "https://maps.googleapis.com/maps/api/geocode/xml?address=";
		$apiKey = "AIzaSyAYGh2dJ3nL8r1RibL5knf67j8zTcJBZQ8";
		$address = get_school_address( $post_id, array('street-address', 'city', 'province', 'postal-code') );
		$address = urlencode( $address );

		$url = $url_prefix . $address . "&key=" . $apiKey;

		//call Google geocoding API for XML file
		$file_content = file_get_contents( $url );

		//parse through XML file and update lat/lng coordinates
		if( $file_content === false )
			;//return "Could not get XML File content!";
		else {
			$xml = new SimpleXMLElement( $file_content );
			
			$latitude = (String)$xml->result->geometry->location->lat;
			$longitude = (String)$xml->result->geometry->location->lng;

			if ( isset($latitude) )
				update_post_meta( $post_id, 'school-latitude', $latitude );
			else
				update_post_meta( $post_id, 'school-latitude', null );

			if ( isset($longitude) )
				update_post_meta( $post_id, 'school-longitude', $longitude );
			else
				update_post_meta( $post_id, 'school-longitude', null );

		}
	}
	else{
		//nullify lat & lng values if there's insufficient info
		update_post_meta( $post_id, 'school-latitude', null );
		update_post_meta( $post_id, 'school-longitude', null );
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
					'school-annual-tuition',
					'school-class-size-min',
					'school-class-size-max',
					'school-grades-min',
					'school-grades-max',
					'school-annual-tuition-min',
					'school-annual-tuition-max') as $meta_key)
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
?>
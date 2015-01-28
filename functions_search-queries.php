<?php

// if header-search
function header_search_query($search_terms){
	global $wpdb;

	// break search query into an array
	$terms_array = explode(' ', $search_terms);
	$terms_array_length = count($terms_array) - 1;

	// begin SELECT statement; INNER JOIN with post meta; WHERE posts are 'school' AND 'published'
	$sql = "SELECT 		wp_posts.ID 
			FROM 		wp_posts 
			INNER JOIN 	wp_postmeta 
						ON wp_posts.ID = wp_postmeta.post_id 
			WHERE 		wp_posts.post_type IN ('school') 
			AND 		wp_posts.post_status =  'publish'";
	
	// AND ( (post.title LIKE '%word1%' OR post.title LIKE '%word2%')
	$sql .= " AND (";

		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_posts.post_title LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}

	//  OR ( post meta LIKE '%word1%' OR post meta LIKE '%word2%' )
	$sql .= " OR  ";

		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_postmeta.meta_value LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}
	
	// UNION 
	// SELECT taxonomy terms
	$sql .= ")
			UNION 
			SELECT wp_term_relationships.object_id FROM wp_term_relationships 
			INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
			INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id 
			WHERE ";

	//  WHERE ( taxonomy.term LIKE '%word1%' OR taxonomy.term LIKE '%word2%' )
		for ($i = 0; $i <= $terms_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_terms.name LIKE '%%%s%%'", $terms_array[$i]);

			if ($i !== $terms_array_length){
				$sql .= " OR ";
			}
		}

	// GROUP BY post.id ORDER BY post.date
	//$sql .= " GROUP BY wp_term_relationships.object_id ORDER BY wp_posts.post_title";

	return $sql;
}

// for $search_type = directory-page-search
function directory_page_search_query($address, $province){
	global $wpdb;
	$sql = "";

	// determine if query needs to group results
	if ( !empty($address) && $province !== "All Provinces" )
		$groupResults = true;
	else
		$groupResults = false;
	
	if ($groupResults){
		$sql .= "SELECT 	G.ID
				 FROM		(";
	}
	
	$sql .= "SELECT 	wp_posts.ID 
			FROM 		wp_posts 
			INNER JOIN 	wp_postmeta 
						ON wp_posts.ID = wp_postmeta.post_id 
			WHERE 		wp_posts.post_type IN ('school') 
			AND 		wp_posts.post_status = 'publish' ";
	
	// if Province was input, search for Province
	if ( $province !== "All Provinces" ){
		$sql .= $wpdb->prepare("AND (
									wp_postmeta.meta_key = 'school-province' AND
									wp_postmeta.meta_value = '%s'
									)", $province);
	}
	// else both address and Province are empty, return all Schools
	else if (empty($address))
		$sql .= "GROUP BY wp_posts.ID";

	// only include if Address was input
	if ( !empty($address) ){
		// break passed address into an array
		$address_array = explode(' ', $address);
		$address_array_length = count($address_array) - 1;

		if ($groupResults)
			$sql .= " OR (";
		else
			$sql .= " AND (";

		for ($i = 0; $i <= $address_array_length; $i++){
			// sanitize input!!
			$sql .= $wpdb->prepare("wp_postmeta.meta_value LIKE '%%%s%%'", $address_array[$i]);

			if ($i !== $address_array_length){
				$sql .= " OR ";
			}
		}

		$sql .= ")";
	}

	// group resulting set, if need be
	if ($groupResults)
		$sql .= "			) as G
				GROUP BY	G.ID
				HAVING 		Count(*) >= 2";

	return $sql;
}

function get_adv_search_dropdown_query($grades, $tuition, $class_size){
	$count = 1;
	$sql = "";

	if ($grades != "all" || $tuition != "all" || $class_size != "all")
	{

		if ( $grades != "all" && $grades != "Nursery" && $grades != "Preschool" && $grades != "Kindergarten" ){
			switch ($grades) {
				case "Elementary":
					$grades_min = 1; $grades_max = 5; break;
				case "Middle":
					$grades_min = 6; $grades_max = 8; break;
				case "High":
					$grades_min = 9; $grades_max = 12; break;
				case "UniPrep":
					$grades_min = 12; $grades_max = 99; break;
			}

			$sql = "SELECT		GRADES.post_id
					FROM		(
								SELECT wp_postmeta.post_id, wp_postmeta.meta_value
								FROM wp_postmeta
								WHERE wp_postmeta.meta_key
								IN ('school-grades-min',  'school-grades-max')
								) AS GRADES
					GROUP BY	GRADES.post_id";

			$sql .= " HAVING (" . $grades_min . " BETWEEN MIN(GRADES.meta_value) AND MAX(GRADES.meta_value))";
			if ($grades_max != 99)
				$sql .= " OR (" . $grades_max . " BETWEEN MIN(GRADES.meta_value) AND MAX(GRADES.meta_value))";
		}

		if ($tuition != "all"){
			switch ($tuition) {
				case "5000":
					$tuition_min = 0; $tuition_max = 5000; break;
				case "10000":
					$tuition_min = 5000; $tuition_max = 10000; break;
				case "15000":
					$tuition_min = 10000; $tuition_max = 15000; break;
				case "20000":
					$tuition_min = 15000; $tuition_max = 20000; break;
				case "20000plus":
					$tuition_min = 20000; $tuition_max = 99; break;
			}

			$sql = "SELECT		TUITION.post_id
					FROM		(
								SELECT wp_postmeta.post_id, wp_postmeta.meta_value
								FROM wp_postmeta
								WHERE wp_postmeta.meta_key
								IN ('school-annual-tuition-min',  'school-annual-tuition-max')
								) AS TUITION
					GROUP BY	TUITION.post_id";

			$sql .= " HAVING (" . $tuition_min . " BETWEEN MIN(TUITION.meta_value) AND MAX(TUITION.meta_value))";
			if ($tuition_max != 99)
				$sql .= " OR (" . $tuition_max . " BETWEEN MIN(TUITION.meta_value) AND MAX(TUITION.meta_value))";
		}

		if ($class_size != "all"){
			switch ($class_size) {
				case "10":
					$class_min = 1; $class_max = 10; break;
				case "15":
					$class_min = 11; $class_max = 15; break;
				case "20":
					$class_min = 16; $class_max = 20; break;
				case "20plus":
					$class_min = 20; $class_max = 99; break;
			}

			$sql = "SELECT		CLASS.post_id
					FROM		(
								SELECT wp_postmeta.post_id, wp_postmeta.meta_value
								FROM wp_postmeta
								WHERE wp_postmeta.meta_key
								IN ('school-class-size-min',  'school-class-size-max')
								) AS CLASS
					GROUP BY	CLASS.post_id";

			$sql .= " HAVING (" . $class_min . " BETWEEN MIN(CLASS.meta_value) AND MAX(CLASS.meta_value))";
			if ($class_max != 99)
				$sql .= " OR (" . $class_max . " BETWEEN MIN(CLASS.meta_value) AND MAX(CLASS.meta_value))";
		}
		/*
		$sql .= "			) as G3
					GROUP BY	G3.post_id
					HAVING 		Count(*) >= " . $count;

		*/

		if ($sql == "")
			//generic query returning no results
			return "SELECT ID FROM wp_posts WHERE false";
		else
			return $sql;
	}
	else
		return false;
	
}

function get_adv_search_checkbox_query(){
	//get all custom taxonomies
	$taxonomies = get_taxonomies( array('public'   => true, '_builtin' => false), 'objects', 'and' );

	//check if any checkboxes are selected
	$selected = false;
	foreach ( $taxonomies as $taxonomy )
		if(!empty($_POST[$taxonomy->name]))
			$selected = true;

	//if selected checkboxes exist, return taxonomy query
	if ( $selected ){
		//instantiate the beginning of the query
		$tax_query = "SELECT 	G2.object_id
					  FROM		(
						SELECT 		wp_term_relationships.object_id
						FROM 		wp_term_relationships 
						INNER JOIN 	wp_term_taxonomy 
									ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
						INNER JOIN 	wp_terms 
									ON wp_term_taxonomy.term_id = wp_terms.term_id
						WHERE		wp_terms.slug IN (";

		$total_checked_terms = 0;
		//check all taxonomies, by name, for values
		foreach ( $taxonomies as $taxonomy )
			if(!empty($_POST[$taxonomy->name])){
				foreach($_POST[$taxonomy->name] as $checked_term){
					echo $checked_term . " - ";
					$tax_query .= "'" . $checked_term . "'";

					// check for last element
					if ( $checked_term !== end($_POST[$taxonomy->name]) )
						$tax_query .= ", ";
				}
				$total_checked_terms += count($_POST[$taxonomy->name]);
			}
		echo "Total checked boxes: " . $total_checked_terms;
		
		$tax_query .= ")) as G2
				GROUP BY	G2.object_id
				HAVING 		Count(*) = " . $total_checked_terms;

		return $tax_query;
	}
	else
	//else, return false
		return false;
}

// for $search_type = advanced-search
function advanced_search_query(){
	$add_prov_query = "";
	$dropdown_query = "";
	$checkbox_query = "";

	//get query for Address & Province fields
	$add_prov_query = directory_page_search_query($_POST['address'], $_POST['province']);
	
	//get query for dropdown ranges, if any
	$dropdown_query = get_adv_search_dropdown_query($_POST['grades'], $_POST['tuition'], $_POST['classSize']);

	//get query for Taxonomy checkboxes, if any
	$checkbox_query = get_adv_search_checkbox_query();
	
	//join all partial queries
	$sql = "";

	/*if ($add_prov_query !== "" && $range_query !== "" && $checkbox_query !== "")
		$sql = "SELECT result1.ID FROM (" . $add_prov_query . ") AS result1 
				INNER JOIN (" . $dropdown_query . ") AS result2 ON result1.ID = result2.post_id
				INNER JOIN (" . $checkbox_query . ") AS result3 ON result1.ID = result3.object_id";
	else if ($add_prov_query !== "" && $dropdown_query !== "")
		$sql = "SELECT result1.ID FROM (" . $add_prov_query . ") AS result1 
				INNER JOIN (" . $dropdown_query . ") AS result2 ON result1.ID = result2.post_id";
	else if ($add_prov_query !== "" && $checkbox_query !== "")
		$sql = "SELECT result1.ID FROM (" . $add_prov_query . ") AS result1 
				INNER JOIN (" . $checkbox_query . ") AS result3 ON result1.ID = result3.object_id";
	*/
	
	if ($dropdown_query !== false )
		$sql = $dropdown_query;
	else if ($checkbox_query !== false)
		$sql = $checkbox_query;
	else
		$sql = $add_prov_query;

	return $sql;
}

// FOR footer City Search
function city_search_query($city){
	$sql = "SELECT 		wp_postmeta.post_id
			FROM 		wp_postmeta
			INNER JOIN 	wp_posts 
						ON wp_postmeta.post_id = wp_posts.ID
			WHERE 		wp_posts.post_type IN ('school') 
					AND wp_posts.post_status = 'publish' 
					AND wp_postmeta.meta_key = 'school-city'
					AND wp_postmeta.meta_value = '{$city}'";
	
	return $sql;
}
// FOR footer Type Search
function type_search_query($type){
	if ($type == "SpecialNeeds")
		$sql = "SELECT DISTINCT	wp_term_relationships.object_id
				FROM 			wp_term_relationships 
				INNER JOIN 		wp_term_taxonomy 
								ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
				INNER JOIN 		wp_terms 
								ON wp_term_taxonomy.term_id = wp_terms.term_id 
				WHERE 			wp_terms.slug IN ('addadhd', 
											  'asperger-disorder', 
											  'autism', 
											  'behavioral', 
											  'down-syndrome', 
											  'dyslexia', 
											  'physical-disability-assistance', 
											  'special-needs-assistance')";
	else
		$sql = "SELECT 		wp_term_relationships.object_id
				FROM 		wp_term_relationships 
				INNER JOIN 	wp_term_taxonomy 
							ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
				INNER JOIN 	wp_terms 
							ON wp_term_taxonomy.term_id = wp_terms.term_id 
				WHERE 		wp_terms.slug = '{$type}'";
	
	return $sql;
}

/**
 * Call correct function to create SQL query, then run query.
 *
 * @author	Zlatko
 * @since	01.06.2015
 *
 * @return	Array of school ID's proportional to desired page size
 */
function get_search_results($search_type){
	global $wpdb;

	// call appropriate function to create SQL query for database
	switch ($search_type) {
		case "header-search":
			$sql_query = header_search_query($_POST['search-query']); break;
		case "directory-page-search":
			$sql_query = directory_page_search_query($_POST['address'], $_POST['province']); break;
		case "advanced-search":
			$sql_query = advanced_search_query(); break;
		case "city-search":
			$sql_query = city_search_query($_GET['city']); break;
		case "type-search":
			$sql_query = type_search_query($_GET['type']); break;
	}
	
	/**** For Debugging - add "echo" to end of $search_type to show SQL query on screen ****/
	if ( substr($search_type, -4) == "echo" ){
		switch ($search_type) {
			case "header-search-echo":
				$sql_query = header_search_query($_POST['search-query']); break;
			case "directory-page-search-echo":
				$sql_query = directory_page_search_query($_POST['address'], $_POST['province']); break;
			case "advanced-search-echo":
				$sql_query = advanced_search_query(); break;
		}
		echo $sql_query;
	}

	// query database
	$search_results = $wpdb->get_col( $sql_query );

	if ( isset($search_results) )
		return $search_results;
	else
		return "Error";
}

?>
<?php

/*

Template Name: Advanced Search

*/



get_header(); ?>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

	<div id="main-image" class="row-fluid">
		<img src="http://parentory.ca/deploy/wp-content/uploads/2014/12/advanced-search-splash.jpg">
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		//hide or reveal all search options accordingly
		var GET = <?php echo json_encode($_GET); ?>;

		if (GET["show"] == "advanced"){
			$("#focused-search-options").hide();
		}
		else if (GET["show"] == "focused"){
			$("#advanced-search-options").hide();
		}
		else {
			$("#advanced-search-options").hide();
			$("#focused-search-options").hide();
		}

		//click funcionality to hide/show search options
		$('#advanced-search-heading').click(function(){
			$('#advanced-search-options').slideToggle('fast');
		});
		$('#focused-search-heading').click(function(){
			$('#focused-search-options').slideToggle('fast');
		});

	});
	</script>

	<form id="search-form" method="post" action="<?php append_website_URL('school-search-results/'); ?>">
	<input name="search-type" type="hidden" value="advanced-search">

	<section id="primary" class="span12">
		<div id="content" role="main" class="container-fluid advanced-search">
			<div id="advanced-search-general" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div id="search-header" class="span12">
						<h4>Search Criteria</h4>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span2 search-input-label">
						State/Province:
					</div>
					<div class="span3 search-input">
						<select name="province">
							<option value="All Provinces">All</option>
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
					<div class="span3 search-input-label">
						City/Address:
					</div>
					<div class="span4 search-input">
						<input type="text" name="address" placeholder="Enter City or Postal Code Here">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span2 search-input-label">
						Grades:
					</div>
					<div class="span3 search-input">
						<select name="grades" class="advanced-search-text">
							<option value="all">All</option>
							<option value="Nursery">Nursery/Toddler</option>
							<option value="Preschool">Preschool (2.5 to 4 yrs)</option>
							<option value="Kindergarten">Kindergarten (5 to 6 yrs)</option>
							<option value="Elementary">Elementary Schools (Gr. 1~5)</option>
							<option value="Middle">Middle Schools (Gr. 6~8)</option>
							<option value="High">High Schools (Gr. 9~12)</option>
							<option value="UniPrep">Univ. Prep. (Gr. 12+)</option>
						</select>
					</div>
					<div class="span3 search-input-label">
						Annual Tuition Cost:
					</div>
					<div class="span4 search-input">
						<select name="tuition">
							<option value="all">All</option>
							<option value="5000">$0-$5,000</option>
							<option value="10000">$5,000-$10,000</option>
							<option value="15000">$10,000-$15,000</option>
							<option value="20000">$15,000-$20,000</option>
							<option value="20000plus">$20,000+</option>
						</select>
					</div>
				</div>
				<?php
					render_advanced_search_taxonomies( array(""), array(array("school-type")) );
				?>
			</div>
			<div id="advanced-search-heading" class="row-fluid collapsible-div-heading">
				<div class="span12 collapsible-div-title">
					<h4>Advanced Search</h4><span>+</span>
				</div>
			</div>
			<div id="advanced-search-options" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div class="span2 search-input-label">
						Class Size:
					</div>
					<div class="span10">
						<select name="classSize">
							<option value="all">All</option>
							<option value="10">1-10</option>
							<option value="15">11-15</option>
							<option value="20">16-20</option>
							<option value="20plus">20+</option>
						</select>
					</div>
				</div>
				<?php
					$groupMembers = array(
						array('additional-services', 'additional-criteria')
					);

					render_advanced_search_taxonomies(array(""), $groupMembers);
				?>
			</div>
			<div id="focused-search-heading" class="row-fluid collapsible-div-heading">
				<div class="span12 collapsible-div-title">
					<h4>Focused Search</h4><span>+</span>
				</div>
			</div>
			<div id="focused-search-options" class="container-fluid search-options-field">
				<?php
					$groupNames = array(
						"",
						"Courses",
						"Athletics and Clubs"
					);
					$groupMembers = array(
						array('academic-features'),
						array('arts', 'language-and-social-sciences', 'science-and-technology'),
						array('athletics', 'clubs', 'school-assistance', 'special-support', 'religious-focus')
					);

					render_advanced_search_taxonomies($groupNames, $groupMembers);
				?>
			</div>
			<div class="container-fluid search-options-field">
				<div class="row-fluid">
					<div id="focused-search-button-field" class="span12">
						<input type="submit" name="submit" class="submitButton" value="Search">
					</div>
				</div>
			</div>
		</div>
	</form>

	</section>



<?php

//get_sidebar();

get_footer();


/* Location: ./wp-content/themes/the-bootstrap/advanced-search.php */

?>
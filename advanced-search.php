<?php

/*

Template Name: Advanced Search

*/



get_header(); ?>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

	<div id="main-image" class="row-fluid">
		<img src="http://test.parentory.ca/wp-content/uploads/2014/12/advanced-search-splash.jpg">
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
						<select class="advanced-search-text">
							<option value="all">All</option>
							<option value="AB">Alberta</option>
							<option value="BC">British Columbia</option>
							<option value="MB">Manitoba</option>
							<option value="NB">New Brunswick</option>
							<option value="NL">Newfoundland and Labrador</option>
							<option value="NS">Nova Scotia</option>
							<option value="ON">Ontario</option>
							<option value="PE">Prince Edward Island</option>
							<option value="QC">Quebec</option>
							<option value="SK">Saskatchewan</option>
							<option value="NT">Northwest Territories</option>
							<option value="NU">Nunavut</option>
							<option value="YT">Yukon</option>
						</select>
					</div>
					<div class="span3 search-input-label">
						Address:
					</div>
					<div class="span4 search-input">
						<input type="text">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span2 search-input-label">
						Age:
					</div>
					<div class="span3 search-input">
						<select class="advanced-search-text">
							<option value="all">All</option>
							<option value="5">0-5</option>
							<option value="10">5-10</option>
							<option value="15">10-15</option>
							<option value="15plus">15+</option>
						</select>
					</div>
					<div class="span3 search-input-label">
						Annual Tuition Cost:
					</div>
					<div class="span4 search-input">
						<select>
							<option value="all">All</option>
							<option value="5000">$0-$5,000</option>
							<option value="10000">$5,000-$10,000</option>
							<option value="15000">$10,000-$15,000</option>
							<option value="20000">$15,000-$20,000</option>
							<option value="20000plus">$20,000+</option>
						</select>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 advanced-search-taxonomy">
						<b>School Type</b>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<input id="all-schools" type="checkbox"><label for="all-schools">All</label>
					</div>
					<div class="span3">
						<input id="standard-private" type="checkbox"><label for="standard-private">Standard Private School</label>
					</div>
					<div class="span3">
						<input id="montessori" type="checkbox"><label for="montessori">Montessori School</label>
					</div>
					<div class="span3">
						<input id="religious-private" type="checkbox"><label for="religious-private">Religious Private School</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<input id="ap-schools" type="checkbox"><label for="ap-schools">AP School</label>
					</div>
					<div class="span3">
						<input id="ib-private" type="checkbox"><label for="ib-private">IB School</label>
					</div>
					<div class="span3">
						<input id="day-care" type="checkbox"><label for="day-care">Day Care</label>
					</div>
				</div>
			</div>
			<div id="advanced-search-heading" class="row-fluid search-collapsible-heading">
				<div class="span12 search-heading-text">
					<h4>Advanced Search</h4><span>+</span>
				</div>
			</div>
			<div id="advanced-search-options" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div class="span2 search-input-label">
						Class Size:
					</div>
					<div class="span10">
						<select>
							<option value="all">All</option>
							<option value="10">1-10</option>
							<option value="15">11-15</option>
							<option value="20">16-20</option>
							<option value="20plus">20+</option>
						</select>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 advanced-search-taxonomy">
						<b>Additional Services:</b>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<input id="all-schools" type="checkbox"><label for="all-schools">All</label>
					</div>
					<div class="span3">
						<input id="standard-private" type="checkbox"><label for="standard-private">Standard Private School</label>
					</div>
					<div class="span3">
						<input id="montessori" type="checkbox"><label for="montessori">Montessori School</label>
					</div>
					<div class="span3">
						<input id="religious-private" type="checkbox"><label for="religious-private">Religious Private School</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 advanced-search-taxonomy">
						<b>Additional Criteria:</b>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<input id="all-boys" type="checkbox"><label for="all-boys">All Boys</label>
					</div>
					<div class="span3">
						<input id="all-girls" type="checkbox"><label for="all-girls">All Girls</label>
					</div>
					<div class="span3">
						<input id="boarding" type="checkbox"><label for="boarding">Boarding</label>
					</div>
					<div class="span3">
						<input id="co-ed" type="checkbox"><label for="co-ed">Co-ed</label>
					</div>
				</div>
			</div>
			<div id="focused-search-heading" class="row-fluid search-collapsible-heading">
				<div class="span12 search-heading-text">
					<h4>Focused Search</h4><span>+</span>
				</div>
			</div>
			<div id="focused-search-options" class="container-fluid search-options-field">
				<?php 
					render_advanced_search_taxonomies();
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

	</section>



<?php

//get_sidebar();

get_footer();


/* Location: ./wp-content/themes/the-bootstrap/advanced-search.php */

?>
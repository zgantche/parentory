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
		// hide all search options initially
		// -> TODO: add logic deciding which should using input info, POST?
		$("#advanced-search-options").hide();
		$("#focused-search-options").hide();

		// click funcionality to hide/show search options
		$('#advanced-search-heading').click(function(){
			$('#advanced-search-options').slideToggle('fast');
		});
		$('#focused-search-heading').click(function(){
			$('#focused-search-options').slideToggle('fast');
		});
		
	});
	</script>

	<section id="primary" class="span12">
		<div id="content" role="main" class="container-fluid">
			<div id="advanced-search-general" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div class="span12" style="margin-bottom:10px;" >
						<h4>General Information</h4>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span2 input-label">
						Address:
					</div>
					<div class="span3">
						<input type="text">
					</div>
					<div class="span3 input-label">
						State/Province:
					</div>
					<div class="span4">
						<select>
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
				</div>
				<div class="row-fluid">
					<div class="span2 input-label">
						Age:
					</div>
					<div class="span3">
						<select>
							<option value="all">All</option>
							<option value="5">0-5</option>
							<option value="10">5-10</option>
							<option value="15">10-15</option>
							<option value="15plus">15+</option>
						</select>
					</div>
					<div class="span3 input-label">
						Annual Tuition Cost:
					</div>
					<div class="span4">
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
					<div class="span12">
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
			<div id="advanced-search-heading" class="row-fluid search-collapsable-heading">
				<div class="span12">
					<h4>Advanced Search</h4>
				</div>
			</div>
			<div id="advanced-search-options" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div class="span2 input-label">
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
					<div class="span12">
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
			</div>
			<div id="focused-search-heading" class="row-fluid search-collapsable-heading">
				<div class="span12">
					<h4>Focused Search</h4>
				</div>
			</div>
			<div id="focused-search-options" class="container-fluid search-options-field">
				<div class="row-fluid">
					<div class="span2 input-label">
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
					<div class="span12">
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
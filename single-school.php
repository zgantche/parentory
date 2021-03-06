<?php
/** single-school.php
 *
 * The Template for displaying all single school posts.
 *
 * @author		Zlatko Gantchev
 * @package		Parentory
 * @since		1.0.0 - 05.02.2014
 */

get_header(); ?>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.css" rel="stylesheet"> <!-- 3 KB -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.js"></script> <!-- 16 KB -->

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		/*----- jQuery Validation Code -----*/
		$("#sidebar-form").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			},
			messages: {
				email: {
					required: "Please enter your email address",
					email: "Please enter a valid email address"
				},
				subject: {
					required: "Please enter a subject"
				},
				message: {
					required: "Please enter your message"
				}
			}
		});

		/*----- Collapsible Divs Code -----*/

		//hide all divs on page load
		//$("#pictures-content").hide();
		$("#comments-content").hide();

		//click funcionality to hide/show search options
		$('#map-heading').click(function(){
			$('#map-content').slideToggle('fast');
		});
		$('#pictures-heading').click(function(){
			$('#pictures-content').slideToggle('fast');
		});
		$('#comments-heading').click(function(){
			$('#comments-content').slideToggle('fast');
		});

	});
	</script>

	<!-- Facebook SDK for JavaScript -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=103655746363992&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>


	<div id="main-image" class="row-fluid">
		<img src="http://parentory.ca/deploy/wp-content/uploads/2014/05/montessori-schools.jpg">
	</div>


	<?php
		//save the post id
		$school_id = get_the_id();
		$school_object = get_post($school_id);
	?>


	<div id="single-school-content" class="container-fluid">

		<div class="row-fluid">
			<!-- school content -->
			<div class="span8">

				<div class="row-fluid">
					<div id="school-title">
						<?php echo $school_object->post_title; ?>
					</div>
				</div>
				<div class="row-fluid">
					<div id="school-address">
						<?php get_school_address( $school_id, array('street-address', 'city', 'province', 'postal-code') ); ?>
					</div>
				</div>

				<!-- image & info -->
				<div class="row-fluid">
					<!-- school main image -->
					<div id="school-thumbnail-holder" class="span4">
						<span class="vertical-align-helper"></span>
						<?php
							$default_attr = array(
								'class' => "school-thumbnail",
								'maxheight' => "160"
							);

							the_post_thumbnail( "full", $default_attr );
						?>
					</div>

					<!-- school content -->
					<div id="school-info" class="span8">
						<div class="school-info-criteria"><b>Grades:</b></div>
						<div class="school-info-data">
							<?php render_school_info($school_id, 'grades') ?>
						</div>
						<br />
						<div class="school-info-criteria"><b>Class Size:</b></div>
						<div class="school-info-data">
							<?php render_school_info($school_id, 'class-size') ?>
						</div>
						<br />
						<div class="school-info-criteria"><b>School Type:</b>
							<?php render_school_type($school_id) ?>
						</div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-type', true ) ); ?></div>
						<br />
						<div class="school-info-criteria"><b>Annual Tuition:</b></div>
						<div class="school-info-data">
							<?php render_school_info($school_id, 'annual-tuition') ?>
						</div>
						<br />
						<div class="school-info-criteria"><b>Phone Number:</b></div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-phone-number', true ) ); ?></div>
						<br />
						<div class="school-info-criteria"><b>Website:</b></div>
						<div class="school-info-data"><a href="<?php echo sanitize_text_field( get_post_meta( $school_id, 'school-website', true ) ); ?>" target="_blank">
								<?php echo sanitize_text_field( get_post_meta( $school_id, 'school-website', true ) ); ?>
							</a>
						</div>
					</div>
				</div>



				<div class="row-fluid">
					<!-- school article description -->
					<div id="school-description" class="span12">
						<?php echo $school_object->post_content; ?>
					</div>
				</div>
				<div class="row-fluid">
					<div id="school-tags" class="span12">
						<div id="map-heading" class="row-fluid collapsible-div-heading">
							<div class="span12 collapsible-div-title">
								<h4>Map</h4><span>+</span>
							</div>
						</div>
						<div id="map-content" class="container-fluid search-options-field">
							<iframe src="https://www.google.com/maps/embed/v1/place?key=<?=getenv('MAPSKEE')?>&q=
									<?php
										$school_info_title = str_replace(" ", "+", sanitize_text_field( $school_object->post_title ));
										$school_info_address = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-street-address', true ) ));
										$school_info_city = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-city', true ) ));
										$school_info_province = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-province', true ) ));
										$school_info_postal = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-postal-code', true ) ));

										$school_info = $school_info_title . "," . $school_info_address . "," . $school_info_city . "," . $school_info_province. "," . $school_info_postal;

										echo $school_info;
									?>"
								width="100%" height="500" frameborder="0" style="border:0"></iframe>
						</div>
						<div id="pictures-heading" class="row-fluid collapsible-div-heading">
							<div class="span12 collapsible-div-title">
								<h4>Pictures</h4><span>+</span>
							</div>
						</div>
						<div id="pictures-content" class="container-fluid search-options-field" hidden>
							<div class="fotorama" data-width="100%" data-maxheight="500px" data-fit="cover" data-nav="thumbs" data-navposition="top">
							<?php
								// retrieve all Attachments for the 'pictures' instance of current post
								// 	->url(); ->total(); ->image( 'thumbnail' );
								$pictures = new Attachments( 'my_pictures', $school_id );

								if ( $pictures->exist() ) :
									while ( $pic = $pictures->get() ) : ?>
										<a href=" <?php echo $pictures->url(); ?> "> <?php echo $pictures->image( 'thumbnail' ); ?> </a>
							<?php 	endwhile;
								else :
									echo "No pictures!";
								endif; ?>

							</div>
						</div>
						<div id="comments-heading" class="row-fluid collapsible-div-heading">
							<div class="span12 collapsible-div-title">
								<h4>Comments</h4><span>+</span>
							</div>
						</div>
						<div id="comments-content" class="container-fluid search-options-field">
							<?php comments_template(); ?>
						</div>

					</div>
				</div>

			</div>


			<!-- school sidebar -->
			<div id="school-sidebar" class="span4">

				<div class="row-fluid">
					<div id="form-title" class="arial-narrow">
						CONTACT THIS SCHOOL
					</div>

					<?php
						//handle single-page form submission
						if ($_SERVER["REQUEST_METHOD"] == "POST") {
							$email_address = email_school($school_id);
						}
					?>

					<form id="sidebar-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" novalidate>
						<input type="text" class="formElement" name="email"
							value="<?php echo (isset ($email_address) ? $email_address : ""); ?>"
							placeholder="Enter Email Address">
						<br />

						<input type="text" class="formElement" name="subject"
							value="<?php echo (isset($subject) ? $subject : ""); ?>"
							placeholder="Enter Subject">
						<br />

						<textarea name="message" class="formElement" rows="5" cols="40"
							placeholder="Your Message"><?php echo (isset($message) ? $message : "");?></textarea>
						<br />

						<input type="submit" name="submit" class="submitButton" value="Submit">
					</form>
				</div>

				<div id="ad-bigBox1" class="row-fluid" style="padding-bottom:30px;">
					<a href="http://www.gilesschool.ca" target="_blank">
						<img src="http://parentory.ca/deploy/wp-content/uploads/2015/01/generic-school-BB.jpg">
					</a>
				</div>

				<div class="row-fluid">
					<div class="fb-like-box" data-href="<?php echo get_post_meta( $school_id, 'school-facebook-page', true ); ?>" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
				</div>

			</div>
		</div>
	</div>

<?php get_footer();

/* End of file single-school.php */
/* Location: ./wp-content/themes/the-bootstrap-child/single-school.php */
?>
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
		$("#contactForm").validate({
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

		/*----- Interactive Tabs Code -----*/
		$('ul.tabs li').click(function(){
			var tab_id = $(this).attr('data-tab');

			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');

			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
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
		<img src="http://test.parentory.ca/wp-content/uploads/2014/05/montessori-schools.jpg">
	</div>


	<?php
		//save the post id
		$school_id = get_the_id();
		$school_object = get_post($school_id);
	?>


	<div class="container-fluid">
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

		<div class="row-fluid">
			<!-- school content -->
			<div class="span8">
			
		
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
						<div class="school-info-data"><?php echo get_post_meta( $school_id, 'school-grades', true ); ?></div>

						<div class="school-info-criteria"><b>Class Size:</b></div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-class-size', true ) ); ?></div>

						<div class="school-info-criteria"><b>School Type:</b></div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-type', true ) ); ?></div>

						<div class="school-info-criteria"><b>Annual Tuition:</b></div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-annual-tuition', true ) ); ?></div>

						<div class="school-info-criteria"><b>Phone Number:</b></div>
						<div class="school-info-data"><?php echo sanitize_text_field( get_post_meta( $school_id, 'school-phone-number', true ) ); ?></div>

						<div class="school-info-criteria"><b>Website:</b></div>
						<div class="school-info-data"><a href="<?php echo sanitize_text_field( get_post_meta( $school_id, 'school-website', true ) ); ?>" target="_new">
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
					<div id="school-tabs" class="span12">

						<ul class="tabs">
							<li class="tab-link current" data-tab="tab-1">Map</li>
							<li class="tab-link" data-tab="tab-2">Pictures</li>
							<li class="tab-link" data-tab="tab-3">Comments</li>
						</ul>

						<div id="tab-1" class="tab-content current">

							<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAj9z8VXVzdTEoJTNTw7MZHzud9XMMfGEM&
									q=
									<?php 
										$school_info_title = str_replace(" ", "+", sanitize_text_field( $school_object->post_title ));
										$school_info_address = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-address', true ) ));
										$school_info_city = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-city', true ) ));
										$school_info_post = str_replace(" ", "+", sanitize_text_field( get_post_meta( $school_id, 'school-postal-code', true ) ));

										$school_info = $school_info_title . "," . $school_info_address . "," . $school_info_city . "," . $school_info_post;

										echo $school_info;
									?>" 
								width="100%" height="500" frameborder="0" style="border:0"></iframe>

						</div>
						<div id="tab-2" class="tab-content">

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
						<div id="tab-3" class="tab-content">

							<?php comments_template(); ?>


						</div>

					</div>
				</div>
				
			</div>


			<!-- school sidebar -->
			<div id="school-sidebar" class="span4">
				<div id="form-title" class="arial-narrow">
					CONTACT THIS SCHOOL
				</div>

				<?php
					//handle single-page form submission
					if ($_SERVER["REQUEST_METHOD"] == "POST") {
						$email_address = email_school($school_id);
					}
				?>
				
				<form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" novalidate>
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
				
				<div class="fb-like-box" data-href="<?php echo get_post_meta( $school_id, 'school-facebook-page', true ); ?>" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>

			</div>
		</div>
	</div>

<?php get_footer();

/* End of file single-school.php */
/* Location: ./wp-content/themes/the-bootstrap-child/single-school.php */
?>
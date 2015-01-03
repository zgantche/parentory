<?php
/** footer.php
 *
 * @author		Zlatko Gantchev
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */
				tha_footer_before(); ?>
				<footer id="colophon" role="contentinfo" class="span12">
					<?php tha_footer_top(); ?>
					<div id="page-footer" class="clearfix">
						<div class="span3">
							<div class="footer-title">SCHOOLS BY CITY</div>
							<ul class="footer-nav">
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=toronto'); ?>">Toronto</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=montreal'); ?>">Montreal</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=vancouver'); ?>">Vancouver</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=calgary'); ?>">Calgary</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=ottawa'); ?>">Ottawa</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=mississauga'); ?>">Mississauga</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?city=oakville'); ?>">Oakville</a>
								</li>
							</ul>
						</div>
						<div class="span3">
							<div class="footer-title">SCHOOLS BY TYPE</div>
							<ul class="footer-nav">
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=boarding'); ?>">Boarding</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=montessori'); ?>">Montessori</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=special+needs'); ?>">Special Needs</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=faith-based'); ?>">Faith-based</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=all-girls'); ?>">All-girls</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=all-boys'); ?>">All-boys</a>
								</li>
								<li>
									<a href="<?php append_website_URL('school-search-results/?type=coed'); ?>">Coed</a>
								</li>
							</ul>
						</div>
						<div class="span3">
							<div class="footer-title">MENU OPTIONS</div>
							<ul class="footer-nav">
								<li>
									<a href="<?php append_website_URL(''); ?>">Home</a>
								</li>
								<li>
									<a href="<?php append_website_URL('blog/'); ?>">Blog</a>
								</li>
								<li>
									<a href="<?php append_website_URL('directory/'); ?>">Schools Listings</a>
								</li>
								<li>
									<a href="<?php append_website_URL('directory/'); ?>">Basic Search</a>
								</li>
								<li>
									<a href="<?php append_website_URL('advanced-search/'); ?>">Advanced Search</a>
								</li>
								<li>
									<a href="<?php append_website_URL('about/'); ?>">About Us</a>
								</li>
								<li>
									<a href="<?php append_website_URL('about/'); ?>">Contact Us</a>
								</li>
							</ul>
						</div>
						<div class="span3">

							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
								<form action="//parentory.us8.list-manage.com/subscribe/post?u=8b02a22e6a6660bd127d248ca&amp;id=2999a224dd" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<div class="footer-title">JOIN MAILING LIST</div>

									<div class="mc-field-group">
										<input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First Name">
									</div>
									<div class="mc-field-group">
										<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
									</div>

									<div id="mce-responses" class="clear">
										<div class="response" id="mce-error-response" style="display:none"></div>
										<div class="response" id="mce-success-response" style="display:none"></div>
									</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
									<div style="position: absolute; left: -5000px;"><input type="text" name="b_8b02a22e6a6660bd127d248ca_2999a224dd" tabindex="-1" value=""></div>
									<div class="clear"><input type="submit" value="SUBSCRIBE" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
								</form>
							</div>
							<!--End mc_embed_signup-->

						</div>

						
					</div><!-- #page-footer .well .clearfix -->
					<?php tha_footer_bottom(); ?>
				</footer><!-- #colophon -->
				<?php tha_footer_after(); ?>
			</div><!-- #page -->
		</div><!-- .container -->
	<?php wp_footer(); ?>
	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/the-bootstrap/footer.php */
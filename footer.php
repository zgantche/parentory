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
							<div class="footer-title">LOREM IPSIUM</div>
							<?php wp_nav_menu( array(
								'theme_location'	=>	'footer-menu',
								'menu_class'		=>	'footer-nav',
								) );
							?>
						</div>
						<div class="span3">
							<div class="footer-title">LOREM IPSIUM</div>
							<?php wp_nav_menu( array( 'theme_location' => 'footer-2', 'menu_class' => 'footer-nav footer-menu-items',) ); ?>
						</div>
						<div class="span3">
							<div class="footer-title">LOREM IPSIUM</div>
							<?php wp_nav_menu( array( 'theme_location' => 'footer-3', 'menu_class' => 'footer-nav footer-menu-items',) ); ?>
						</div>
						<div class="span3">

							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
								<form action="//parentory.us8.list-manage.com/subscribe/post?u=8b02a22e6a6660bd127d248ca&amp;id=2999a224dd" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<div class="footer-title">JOIN MAILING LIST</div>

									<div class="mc-field-group">
										<input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First Name">
									</div>

									<!--div class="mc-field-group">
										<input type="text" value="" name="LNAME" class="" id="mce-LNAME" placeholder="Last Name">
									</div-->
									
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
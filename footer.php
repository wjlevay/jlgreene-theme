			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => '',                              // remove nav container
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
        				'after' => '',                                  // after the menu
        				'link_before' => '',                            // before each link
        				'link_after' => '',                             // after each link
        				'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

					<?php // small logo ?>
					<a href="<?php echo home_url(); ?>" rel="nofollow"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/library/images/jlgreene-logo.png"></a>

					<?php // contact info ?>
					<p class="address">146 Central Park West · Suite 1E<br />
						New York NY 10023 · <a href="tel:+12126881550">(212) 688–1550</a><br />
					<a href="mailto:letters@jlgreene.org">letters@JLGreene.org</a></p>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->

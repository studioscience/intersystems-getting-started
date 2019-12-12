<?php
/**
 * Template for displaying the footer
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/*
				 * A sidebar in the footer? Yep. You can customize
				 * your footer with three columns of widgets.
				 */
			if ( ! is_404() ) {
				get_sidebar( 'footer' );
			}
			?>

			<div id="site-generator">
				<?php do_action( 'twentyeleven_credits' ); ?>
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
				?>
				<!-- <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyeleven' ) ); ?>" class="imprint" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyeleven' ); ?>"> -->
					<!-- <?php printf( __( 'Proudly powered by %s', 'twentyeleven' ), 'WordPress' ); ?> -->
				<!-- </a> -->
				<!-- <div class="nav-block right">
					<ul class="social-icon list-inline">
						<li>Stay Connected: </li>
						<li><a href="https://www.facebook.com/InterSystemsDev/" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="https://www.linkedin.com/company/intersystems-developer-community/" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
						<li><a href="https://twitter.com/intersystemsdev" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="https://t.me/intersystemsdev" class="social"><i class="fa fa-telegram" aria-hidden="true"></i></a></li>
						<li><a href="https://www.youtube.com/c/InterSystemsDevelopers" class="social"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
					</ul>
				</div> -->
				<div class="nav-block left">
					<ul>
						<!-- <li style="vertical-align:middle"><img src="/wp-content/uploads/2019/08/isc-logo.png" style="width:9px;"></li> -->
						<li>© 2019 InterSystems Corporation, Cambridge, MA. </li>
						<li><a href="http://www.intersystems.com/noticesterms-conditions/" target="_blank">Notices/Terms & Conditions</a></li>
						<li>All Rights Reserved.</li>
						<li><a href="http://www.intersystems.com/privacy-policy/" target="_blank">Privacy Statement</a></li>
						<li><a href="https://www.intersystems.com/guarantee/">Guarantee</a></li>
						<li><a href="https://www.intersystems.com/section-508/">Section&nbsp;508</a></li>
					</ul>
				</div>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

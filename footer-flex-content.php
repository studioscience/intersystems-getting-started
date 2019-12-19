<?php
/**
 * Template for displaying the footer for Flexible Content
 */

$legal_copy = get_field('legal_copy', 'options');

?>


	<footer class="footer-flex-content">
		<div class="row">
			<div class="col-xs-12 col-sm-7">
				<div class="footer-text">© <?php echo date("Y"); ?> InterSystems Corporation, Cambridge, MA. All rights reserved.</div>
			</div>
			<div class="col-xs-12 col-sm-5">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'container'      => false,
							'depth'          => 1,
							'menu_class'     => 'footer-menu',
							'items_wrap'     => '<ul class="%2$s">%3$s</ul>'
						)
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-7">
				<div class="footer-legal">
					<?php if($legal_copy) :
						echo $legal_copy;
					endif; ?>
				</div>
			</div>
		</div>

	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

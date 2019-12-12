<?php
/**
 * Template Name: Sidebar Template
 *
 * Description: A Page Template that adds a sidebar to pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
		<script src="https://admin.mobilecoach.com/widgets/f1a7139556517957b5235bad870778a25a1fcee0af4a089317359aa63f64857b/loader.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

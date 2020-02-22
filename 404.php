<?php
/**
 * Template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header('flex-content'); ; ?>

	<div class="flex-content">
		
		<article id="post-0" class="post error404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentyeleven' ); ?></h1>
			</header>

			<div class="entry-content">
				<h3>The page you are trying to reach does not exist, or has been moved.</h3>
				<h3>Please go to the home page and use the menus to find what you are looking for.</h3>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

	</div><!-- #primary -->

<?php get_footer('flex-content'); ?>

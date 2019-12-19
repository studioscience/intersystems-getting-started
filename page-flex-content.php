<?php
/**
 * Template Name: Flexible Content
 */

$breadcrumbs = get_field( "breadcrumbs" );
$page_title = get_field( "page_title" );
$completion_time = get_field( "completion_time" );
$time = get_field( "time" );
$sidebar = get_field( "sidebar" );
$sidebar_menu = get_field( "sidebar_menu" );

$has_sidebar = $sidebar && $sidebar_menu ? 'has-flexible-sidebar' : 'no-flexible-sidebar';

get_header('flex-content'); 

?>

<div class="flex-content <?php echo $has_sidebar; ?>">

	<?php if($breadcrumbs) : ?>
		<section class="flex-content__breadcrumbs">
			<?php if ( function_exists('yoast_breadcrumb') ) {
				  yoast_breadcrumb( '<div class="flex-content__breadcrumbs__list">','</div>' );
			} ?>
		</section>
	<?php endif; ?>

	<?php if($page_title) : ?>
		<section class="flex-content__page-title">
			<h1><?php the_title(); ?></h1>
			<?php if($completion_time && $time) : ?>
				<div class="completion-time">
					<div class="icon">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/time.svg" />
					</div>
					<div class="time">
						<?php echo $time; ?>
					</div>
				</div>
			<?php endif; ?>
		</section>	
	<?php endif; ?>	

	<?php if($sidebar && $sidebar_menu) : ?>
		<section class="flex-content__sidebar">
			<div class="flex-content__sidebar__title">Page Contents</div>
			<div class="flex-content__sidebar__title-mobile">Page Contents</div>
			<?php if($sidebar_menu) : ?>
				<ul class="flex-content__sidebar__links">
					<?php $i = 0; ?>
					<?php foreach($sidebar_menu as $link) : 
						$active = $i === 0 ? 'class="active"' : '';
						?>
						<li <?php echo $active; ?>><a href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a></li>
						<?php $i++; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			</ul>
		</section>
	<?php endif; ?>	

	<?php

	if( have_rows('flexible_content') ):

		while ( have_rows('flexible_content') ) : the_row();

			get_template_part( 'templates/modules/' . get_row_layout() . '', 'none' );

		endwhile;

	endif;

	while ( have_posts() ) :
		the_post();
		?>

		<?php the_content(); ?>

	<?php endwhile; // end of the loop. ?>

</div><!-- .flex-content -->

<?php get_footer('flex-content'); ?>

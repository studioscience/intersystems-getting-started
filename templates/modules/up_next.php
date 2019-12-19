<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$title = get_sub_field('title');
$secondary_title = get_sub_field('secondary_title');
$category = get_sub_field('category');
$time = get_sub_field('time');
$text = get_sub_field('text');
$link = get_sub_field('link');

?>

<section class="up-next <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

		<?php if($title) : ?>
			<div class="up-next__title"><?php echo $title; ?></div>
		<?php endif; ?>

		<?php if($secondary_title) : ?>
			<div class="up-next__secondary-title"><?php echo $secondary_title; ?></div>
		<?php endif; ?>

		<?php if($time) : ?>
			<div class="up-next__time">
				<?php if($category) : ?>
					<div class="up-next__category"><?php echo $category; ?></div>
				<?php endif; ?>
				<div class="completion-time">
					<div class="icon">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/time.svg" />
					</div>
					<div class="time">
						<?php echo $time; ?>
					</div>
				</div>
			</div>		
		<?php endif; ?>	

		<?php if($text) : ?>
			<div class="up-next__text"><?php echo $text; ?></div>
		<?php endif; ?>	

		<?php if($link) : ?>
			<div class="up-next__ink">
				<a class="isc_btn" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
			</div>
		<?php endif; ?>	


</section>
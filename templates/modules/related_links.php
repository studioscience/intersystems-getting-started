<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$title = get_sub_field('title');
$links = get_sub_field('links');

?>

<section class="related-links <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

		<?php if($title) : ?>
			<div class="related-links__title"><?php echo $title; ?></div>
		<?php endif; ?>	

		<?php if($links) : ?>
			<div class="related-links__links">
				<?php foreach($links as $link) : ?>
					<a href="<?php echo $link['link']['url']; ?>" target="<?php echo $link['link']['target']; ?>" class="related-links__link">
						<?php if($link['link']['title']) : ?>
							<div class="related-links__link__title"><?php echo $link['link']['title']; ?></div>
						<?php endif; ?>
						<?php if($link['text']) : ?>
							<div class="related-links__link__text"><?php echo $link['text']; ?></div>
						<?php endif; ?>
						<?php if($link['time']) : ?>
							<div class="completion-time">
								<div class="icon">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/time.svg" />
								</div>
								<div class="time">
									<?php echo $link['time']; ?>
								</div>
							</div>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

</section>
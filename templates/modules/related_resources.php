<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$title = get_sub_field('title');
$resources = get_sub_field('resources');

?>

<section class="related-resources <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

		<?php if($title) : ?>
			<div class="related-resources__title"><?php echo $title; ?></div>
		<?php endif; ?>	

		<?php if($resources) : ?>
			<div class="related-resources__resources">
				<?php foreach($resources as $resource) : ?>
					<a href="<?php echo $resource['link']['url']; ?>" target="<?php echo $resource['link']['target']; ?>" class="related-resources__resource">
						<?php if($resource['link']['title']) : ?>
							<div class="related-resources__resource__title"><?php echo $resource['link']['title']; ?></div>
						<?php endif; ?>
						<?php if($resource['text']) : ?>
							<div class="related-resources__resource__text"><?php echo $resource['text']; ?></div>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

</section>
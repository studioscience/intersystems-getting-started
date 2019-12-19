<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$boxes = get_sub_field('boxes');

?>

<section class="featured-boxes <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<?php if($boxes) : ?>
		<div class="row">
			<?php foreach($boxes as $box) : ?>
				<div class="col-xs-12 col-sm-4">
					<div class="box">
						<?php if($box['title']) : ?>
							<div class="box__title"><?php echo $box['title']; ?></div>
						<?php endif; ?>	
						<?php if($box['text']) : ?>
							<div class="box__text"><?php echo $box['text']; ?></div>
						<?php endif; ?>	
						<?php if($box['link']) : ?>
							<div class="box__link">
								<a class="isc_link" href="<?php echo $box['link']['url']; ?>" target="<?php echo $box['link']['target']; ?>"><?php echo $box['link']['title']; ?></a>
							</div>
						<?php endif; ?>	
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>	

</section>		
<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$items = get_sub_field('items');

?>

<section class="featured-items <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<?php if($items) : ?>
		<div class="row">
			<?php foreach($items as $item) : ?>
				<div class="col-xs-12 col-sm-4">
					<div class="item">
						<?php if($item['image']) : 
							$img = isc_get_attachment($item['image']);
							?>
							<div class="item__img">
								<img src="<?php echo $img['src']; ?>" srcset="<?php echo $img['srcset']; ?>" alt="<?php echo $img['alt']; ?>">
							</div>
						<?php endif; ?>
						<?php if($item['title']) : ?>
							<div class="item__title"><?php echo $item['title']; ?></div>
						<?php endif; ?>	
						<?php if($item['text']) : ?>
							<div class="item__text"><?php echo $item['text']; ?></div>
						<?php endif; ?>	
						<?php if($item['link']) : ?>
							<div class="item__link">
								<a class="isc_link" href="<?php echo $item['link']['url']; ?>" target="<?php echo $item['link']['target']; ?>"><?php echo $item['link']['title']; ?></a>
							</div>
						<?php endif; ?>	
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>	

</section>		
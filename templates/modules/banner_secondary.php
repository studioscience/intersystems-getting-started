<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$background_image = isc_get_attachment(get_sub_field('background_image'));
$text_max_width = get_sub_field('text_max_width') ? 'style="max-width: ' . get_sub_field('text_max_width') . 'px;"' : '';
$text = get_sub_field('text');


?>

<section class="banner-secondary <?php echo $section_id; ?>">>

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<?php if($background_image) : ?>
		<div class="banner-secondary__background" style="background-image: url(<?php echo $background_image['src']; ?>);"></div>
	<?php endif; ?>

	<?php if($text) : ?>
		<div class="banner-secondary__text" <?php echo $text_max_width; ?>>
			<?php echo $text; ?>
		</div>
	<?php endif; ?>

</section>		
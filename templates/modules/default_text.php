<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$text = get_sub_field('text');

?>

<section class="default-text <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<?php if($text) : ?>
		<div class="default-text__text">
			<?php echo $text; ?>
		</div>
	<?php endif; ?>	

</section>		
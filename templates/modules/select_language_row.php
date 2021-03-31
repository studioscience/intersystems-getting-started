<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$title = get_sub_field('title');
$languages = get_sub_field('languages');

?>

<section class="select-language-row <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

		<?php if($title) : ?>
			<div class="select-language-row__title h_2"><?php echo $title; ?></div>
		<?php endif; ?>	

		<?php if($languages) : ?>
			<div class="select-language-row__languages">
				<?php foreach($languages as $language) : ?>
					<div class="select-language-row__language">
						<a href="<?php echo $language['link']; ?>" class="select-language-row__language__link">
							<?php if($language['image']) : 
								$img = isc_get_attachment($language['image']);
							?>	
								<div class="select-language-row__language__image">
									<img src="<?php echo $img['src']; ?>" alt="<?php echo $img['alt']; ?>">
								</div>	
							<?php endif; ?>
							<?php if($language['name']) : ?>
								<div class="select-language-row__language__name isc_link"><?php echo $language['name']; ?></div>
							<?php endif; ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

</section>
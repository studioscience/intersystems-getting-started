<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$image = get_sub_field('image');
$title = get_sub_field('title');
$text = get_sub_field('text');
$link = get_sub_field('link');

$quotes = get_sub_field('quotes');

?>

<section class="quotes-carousel <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<div class="row middle-xs">
		<div class="col-xs-12 col-sm-6">
			<div class="column__info">
				<?php if($image) : 
					$img = isc_get_attachment($image);
					?>
					<div class="column__info__image">
						<img src="<?php echo $img['src']; ?>" srcset="<?php echo $img['srcset']; ?>" alt="<?php echo $img['alt']; ?>">
					</div>
				<?php endif; ?>
				<?php if($title) : ?>
					<div class="column__info__title"><?php echo $title; ?></div>
				<?php endif; ?>	
				<?php if($text) : ?>
					<div class="column__info__text"><?php echo $text; ?></div>
				<?php endif; ?>	
				<?php if($link) : ?>
					<div class="column__info__link">
						<a class="isc_link" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
					</div>
				<?php endif; ?>	
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="column__carousel">
				<?php if($quotes) : ?>
					<div class="owl-carousel">
						<?php foreach($quotes as $q) : ?>
							<div class="quote">
								<?php if($q['quote']) : ?>
									<div class="quote__text"><?php echo $q['quote']; ?></div>
								<?php endif; ?>
								<?php if($q['info']) : ?>
									<div class="quote__info"><?php echo $q['info']; ?></div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="progress-bar">
					<span class="progress-bar__number"></span>
					<span class="progress-bar__container">
						<span class="progress-bar__percentage"></span>
					</span>
					
				</div>
			</div>
		</div>
	</div>

</section>
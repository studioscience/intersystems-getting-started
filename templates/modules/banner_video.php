<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$background_color = get_sub_field('background_color') ? 'style="background-color: ' . get_sub_field('background_color') . ';"' : '';
$text = get_sub_field('text');
$video_id = get_sub_field('video_id');

?>

<section class="banner-video <?php echo $section_id; ?>" <?php echo $background_color; ?>>

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<?php if($text) : ?>
				<?php echo $text; ?>
			<?php endif; ?>
		</div>
		<div class="col-xs-12 col-sm-6">
			<?php if($video_id) : ?>
				<div class="video-container">
					<div class="video">
						<iframe class="vidyard_iframe" src="https://players.brightcove.net/610060920001/WZIjldXv6_default/index.html?videoId=<?php echo $video_id; ?>" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen=""></iframe>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</section>		
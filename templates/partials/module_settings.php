<?php

	$custom_padding_top_mobile = get_sub_field('custom_padding_top_mobile');
	$custom_padding_bottom_mobile = get_sub_field('custom_padding_bottom_mobile');
	$custom_margin_top_mobile = get_sub_field('custom_margin_top_mobile');
	$custom_margin_bottom_mobile = get_sub_field('custom_margin_bottom_mobile');

	$custom_padding_top = get_sub_field('custom_padding_top');
	$custom_padding_bottom = get_sub_field('custom_padding_bottom');
	$custom_margin_top = get_sub_field('custom_margin_top');
	$custom_margin_bottom = get_sub_field('custom_margin_bottom');

	$custom_max_width = get_sub_field('custom_max_width');

	$custom_mobile_styles = $custom_padding_top_mobile != NULL || $custom_padding_bottom_mobile != NULL || $custom_margin_top_mobile != NULL || $custom_margin_bottom_mobile != NULL || $custom_padding_top != NULL || $custom_padding_bottom != NULL || $custom_margin_top != NULL || $custom_margin_bottom != NULL || $custom_max_width != NULL;
	$custom_desktop_styles = $custom_padding_top != NULL || $custom_padding_bottom != NULL || $custom_margin_top != NULL || $custom_margin_bottom != NULL;
	
	if($custom_mobile_styles || $custom_desktop_styles) {
		echo '<style>';
	}	

		if($custom_mobile_styles != NULL) {
			echo '.' . $section_id . '{';
		}

		if($custom_max_width != NULL) {
			echo 'max-width: ' . $custom_max_width . 'px!important;';
			echo 'margin: 0 auto!important;';
		}

		if($custom_padding_top_mobile != NULL) {
			echo 'padding-top: ' . $custom_padding_top_mobile . 'px!important;';
		} elseif($custom_padding_top != NULL) {
			echo 'padding-top: ' . $custom_padding_top/2 . 'px!important;';
		}

		if($custom_padding_bottom_mobile != NULL) {
			echo 'padding-bottom: ' . $custom_padding_bottom_mobile . 'px!important;';
		} elseif($custom_padding_bottom != NULL) {
			echo 'padding-bottom: ' . $custom_padding_bottom/2 . 'px!important;';
		}

		if($custom_margin_top_mobile != NULL) {
			echo 'margin-top: ' . $custom_margin_top_mobile . 'px!important;';
		} elseif($custom_margin_top != NULL) {
			echo 'margin-top: ' . $custom_margin_top/2 . 'px!important;';
		}

		if($custom_margin_bottom_mobile != NULL) {
			echo 'margin-bottom: ' . $custom_margin_bottom_mobile . 'px!important;';
		} elseif($custom_margin_bottom != NULL) {
			echo 'margin-bottom: ' . $custom_margin_bottom/2 . 'px!important;';
		}

		if($custom_mobile_styles) {
			echo '}';
		}

		if($custom_desktop_styles) {
			echo '@media only screen and (min-width: 992px) { .' . $section_id . '{';
		}

			if($custom_padding_top != NULL) {
				echo 'padding-top: ' . $custom_padding_top . 'px!important;';
			}

			if($custom_padding_bottom != NULL) {
				echo 'padding-bottom: ' . $custom_padding_bottom . 'px!important;';
			}

			if($custom_margin_top != NULL) {
				echo 'margin-top: ' . $custom_margin_top . 'px!important;';
			}

			if($custom_margin_bottom != NULL) {
				echo 'margin-bottom: ' . $custom_margin_bottom . 'px!important;';
			}

		if($custom_desktop_styles) {
			echo '}}';
		}

	if($custom_mobile_styles || $custom_desktop_styles) {
		echo '</style>';
	}

	//Module ID used for Anchor tag

	$custom_module_id = get_sub_field('custom_module_id');

	if($custom_module_id) {
		echo '<span id="' . get_sub_field('custom_module_id') . '" class="anchor-tag"></span>';
	}

?>
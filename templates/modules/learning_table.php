<?php

$module_index = get_row_index();
$section_id = 'section-' . $module_index;

$title = get_sub_field('title');
$text = get_sub_field('text');
$table_headers = get_sub_field('table_headers');
$table_rows = get_sub_field('table_rows');


?>

<section class="learning-table <?php echo $section_id; ?>">

	<?php include(locate_template('/templates/partials/module_settings.php')); ?>

		<?php if($title) : ?>
			<div class="learning-table__title"><?php echo $title; ?></div>
		<?php endif; ?>	

		<?php if($text) : ?>
			<div class="learning-table__text"><?php echo $text; ?></div>
		<?php endif; ?>

		<div class="row">
			<div class="col-xs-12">
				<?php if($table_headers || $table_rows) : ?>
					<table class="learning-table__table-desktop">
						<tbody>
							<?php if($table_headers) : ?>
								<tr>
									<th></th>
									<?php foreach($table_headers as $th) : 
										$img = isc_get_attachment($th['image']);
										?>
										<th>
											<?php if($img) : ?>
												<img src="<?php echo $img['src']; ?>" alt="<?php echo $img['alt']; ?>">
											<?php endif; ?>
											<?php if($th['heading']) : ?>
												<strong><?php echo $th['heading']; ?></strong>
											<?php endif; ?>
										</th>
									<?php endforeach; ?>
								</tr>
							<?php endif; ?>
							<?php if($table_rows) : ?>
								<?php foreach($table_rows as $tr) : ?>
									<tr>
										<td><?php echo $tr['row_text'] ? $tr['row_text'] : ''; ?></td>
										<?php if($tr['row_links']) : ?>
											<?php foreach($tr['row_links'] as $rl) : ?>
												<td>
													<?php if($rl['link']) : ?>
														<a href="<?php echo $rl['link']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/circle-arrow.svg"></a>
													<?php else : ?>
														<!-- not available -->
													<?php endif; ?>
												</td>
											<?php endforeach; ?>
										<?php endif; ?>
									</tr>	
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				<?php endif; ?>

				<?php if($table_headers || $table_rows) : ?>
					<div class="learning-table__table-mobile">
						<?php if($table_headers) : ?>
							<?php $i = 0; ?>
							<?php foreach($table_headers as $th) : 
								$img = isc_get_attachment($th['image']);
								?>
								<div class="accordion-header">
									<?php if($img) : ?>
										<div class="image">
											<img src="<?php echo $img['src']; ?>" alt="<?php echo $img['alt']; ?>">
										</div>
									<?php endif; ?>
									<?php if($th['heading']) : ?>
										<strong><?php echo $th['heading']; ?></strong>
									<?php endif; ?>
								</div>
								<div class="accordion-content">
									<?php if($table_rows) : ?>
										<?php foreach($table_rows as $tr) : ?>
											<?php if($tr['row_links'][$i]['link']) : ?>
												<div class="link">
													<a href="<?php echo $tr['row_links'][$i]['link']; ?>">
														<strong><?php echo $tr['row_text']; ?></strong>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/circle-arrow.svg">
													</a>
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php $i++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>	

			</div>
		</div>

</section>
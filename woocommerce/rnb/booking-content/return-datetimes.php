<div class="date-time-picker rnb-component-wrapper">
	<?php
	global $product;
	$product_id = get_the_ID();
	$displays = redq_rental_get_settings(get_the_ID(), 'display');
	$labels = redq_rental_get_settings(get_the_ID(), 'labels', array('return_date'));
	$conditions = redq_rental_get_settings(get_the_ID(), 'conditions');
	$displays = $displays['display'];
	$labels = $labels['labels'];
	$conditions = $conditions['conditions'];
	?>
	<?php if (isset($displays['return_date']) && $displays['return_date'] !== 'closed') : ?>
		<?php
		$end_date = '';
		if (isset($_GET['datepickerrange'])) {
			$date_format = $conditions['date_format'];
			$format = 'Y-m-d';
			$exp_date = explode('-', $_GET['datepickerrange']);
			if (isset($exp_date[1])) {
				$edate = str_replace('_', '-', $exp_date[1]);
				$date = DateTime::createFromFormat($format, $edate);
				$end_date = $date->format($date_format);
			}
		}
		?>
		<h5><?php echo esc_attr($labels['return_datetime']); ?></h5>
		<span class="drop-off-date-picker">
			<i class="fas fa-calendar-alt"></i>
			<input type="text" name="dropoff_date" class="rq-form-control small" id="dropoff-date" placeholder="<?php echo esc_attr($labels['return_date']); ?>" value="<?php echo esc_attr($end_date); ?>" readonly>
		</span>
	<?php endif; ?>

	<?php if (isset($displays['return_time']) && $displays['return_time'] !== 'closed') : ?>
		<span class="drop-off-time-picker">
			<i class="fas fa-clock"></i>
			<input type="text" name="dropoff_time" id="dropoff-time" placeholder="<?php echo esc_attr($labels['return_time']); ?>" value="" readonly>
		</span>
	<?php endif; ?>
</div>

<div id="dropoff-modal-body" style="display: none;">
	<h5 class="drop-modal-title"><?php echo esc_attr($labels['return_datetime']); ?></h5>
	<div id="drop-mobile-datepicker"></div>
	<span id="drop-cal-close-btn">
		<i class="fas fa-times"></i>
	</span>
	<button type="button" id="drop-cal-submit-btn">
		<i class="fa fa-check-circle"></i>
		<?php echo esc_html__('Submit', 'cartsy'); ?>
	</button>
</div>
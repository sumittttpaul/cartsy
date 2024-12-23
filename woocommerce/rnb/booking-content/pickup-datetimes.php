<div class="date-time-picker rnb-component-wrapper">
	<?php
	$displays = redq_rental_get_settings(get_the_ID(), 'display');
	$labels = redq_rental_get_settings(get_the_ID(), 'labels', array('pickup_date'));
	$conditions = redq_rental_get_settings(get_the_ID(), 'conditions');
	$displays = $displays['display'];
	$labels = $labels['labels'];
	$conditions = $conditions['conditions'];
	?>

	<?php if (isset($displays['pickup_date']) && $displays['pickup_date'] !== 'closed') : ?>
		<?php
		$start_date = '';
		if (isset($_GET['datepickerrange'])) {
			$date_format = $conditions['date_format'];
			$format = 'Y-m-d';
			$exp_date = explode('-', $_GET['datepickerrange']);
			if (isset($exp_date[0])) {
				$pdate = str_replace('_', '-', $exp_date[0]);
				$date = DateTime::createFromFormat($format, $pdate);
				$start_date = $date->format($date_format);
			}
		}
		?>
		<h5><?php echo esc_attr($labels['pickup_datetime']); ?></h5>
		<span class="pick-up-date-picker">
			<i class="fas fa-calendar-alt"></i>
			<input type="text" name="pickup_date" class="rq-form-control small" id="pickup-date" placeholder="<?php echo esc_attr($labels['pickup_date']); ?>" value="<?php echo esc_attr($start_date); ?>" readonly>
		</span>
	<?php endif; ?>

	<?php if (isset($displays['pickup_time']) && $displays['pickup_time'] !== 'closed') : ?>
		<span class="pick-up-time-picker">
			<i class="fas fa-clock"></i>
			<input type="text" name="pickup_time" id="pickup-time" placeholder="<?php echo esc_attr($labels['pickup_time']); ?>" value="" readonly>
		</span>
	<?php endif; ?>
</div>

<div id="pickup-modal-body" style="display: none;">
	<h5 class="pick-modal-title"><?php echo esc_attr($labels['pickup_datetime']); ?></h5>
	<div id="mobile-datepicker"></div>
	<span id="cal-close-btn">
		<i class="fas fa-times"></i>
	</span>
	<button type="button" id="cal-submit-btn">
		<i class="fas fa-check-circle"></i>
		<?php echo esc_html__('Submit', 'cartsy'); ?>
	</button>
</div>
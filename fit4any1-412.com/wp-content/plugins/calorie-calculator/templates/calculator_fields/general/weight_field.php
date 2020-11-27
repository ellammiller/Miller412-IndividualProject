<?php if($unit == 'usunit'): ?>
<div class="full_width calcalpro_tooltip">
	<span class="calcalpro_tooltiptext">Please enter your weight (Pounds)</span>
    <!-- <label for="calorie_calculator_weight"><?php //esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label> -->
	<input type="number" min="0" step="any" name="calorie_calculator_weight" id="calorie_calculator_weight" class="calorie_calculator_weight" 
			placeholder="<?php esc_attr_e('Weight (eg. 165 Pounds)', 'zubaer-calorie-calculator'); ?>">	
</div>
<?php elseif($unit == 'metricunit'): ?>

	<div class="full_width calcalpro_tooltip">
		<span class="calcalpro_tooltiptext">Please enter your weight (Kg)</span>
	    <!-- <label for="calorie_calculator_weight"><?php //esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label> -->
		<input type="number" min="0" step="any" name="calorie_calculator_weight" id="calorie_calculator_weight" class="calorie_calculator_weight" 
				placeholder="<?php esc_attr_e('Weight (eg. 68 Kilograms)', 'zubaer-calorie-calculator'); ?>">	
	</div>

<?php endif; ?>	
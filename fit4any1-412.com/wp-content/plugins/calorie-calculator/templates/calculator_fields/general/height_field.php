<?php if($unit == 'usunit'): ?>
<div class="full_width">
    <!-- <label for="calorie_calculator_height_feet"><?php //esc_html_e('Height:', 'zubaer-calorie-calculator') ?></label> -->
    <div class="height_feet_inch full_width calcalpro_tooltip">
    	<span class="calcalpro_tooltiptext">Please enter your height</span>
		<input type="number" min="0" max="10" step="any" name="calorie_calculator_height_feet" class="calorie_calculator_height_feet" 
				placeholder="<?php esc_attr_e('Height (eg. 5 Feet)', 'zubaer-calorie-calculator'); ?>">
		
		<input type="number" min="0" max="12" step="any" name="calorie_calculator_height_inch" class="calorie_calculator_height_inch" id="calorie_calculator_height_inch" 
				placeholder="<?php esc_attr_e('Height (eg. 8 Inch)', 'zubaer-calorie-calculator'); ?>">
	</div>
</div>

<?php elseif($unit == 'metricunit'): ?>

	<div class="full_width calcalpro_tooltip">
		<span class="calcalpro_tooltiptext">Please enter your height</span>
	    <!-- <label for="calorie_calculator_height"><?php //esc_html_e('Height:', 'zubaer-calorie-calculator') ?></label> -->
		<input type="number" min="0" step="any" name="calorie_calculator_height" class="calorie_calculator_height" 
				placeholder="<?php esc_attr_e('Height (eg. 180 Centimeters)', 'zubaer-calorie-calculator'); ?>"> 
	</div>

<?php endif; ?>	
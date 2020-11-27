<?php if($unit == 'usunit'): ?>
<div>
    <label for="calorie_calculator_weight"><?php esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label>
	<input type="number" min="0" step="any" name="calorie_calculator_weight" id="calorie_calculator_weight" class="calorie_calculator_weight" 
			placeholder="<?php esc_attr_e('165 Pounds', 'zubaer-calorie-calculator'); ?>">	
</div>
<?php elseif($unit == 'metricunit'): ?>

	<div>
	    <label for="calorie_calculator_weight"><?php esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label>
		<input type="number" min="0" step="any" name="calorie_calculator_weight" id="calorie_calculator_weight" class="calorie_calculator_weight" 
				placeholder="<?php esc_attr_e('68 Kilograms', 'zubaer-calorie-calculator'); ?>">	
	</div>

<?php endif; ?>	
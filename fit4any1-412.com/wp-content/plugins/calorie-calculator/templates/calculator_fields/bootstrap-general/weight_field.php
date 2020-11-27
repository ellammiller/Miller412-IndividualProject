<?php if($unit == 'usunit'): ?>
<div class="form-group">
    <label for="calorie_calculator_weight"><?php esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label>
	<input type="number" min="0" step="any" name="calorie_calculator_weight" id="calorie_calculator_weight" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Example: 165 Pounds', 'zubaer-calorie-calculator'); ?>" class="form-control"
			placeholder="<?php esc_attr_e('165 Pounds', 'zubaer-calorie-calculator'); ?>">	
</div>

<?php elseif($unit == 'metricunit'): ?>

<div class="form-group">
    <label for="calorie_calculator_weight"><?php esc_html_e('Weight:', 'zubaer-calorie-calculator') ?></label>
	<input type="number" min="0" step="any" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Example: 68 Kilograms', 'zubaer-calorie-calculator'); ?>" name="calorie_calculator_weight" class="form-control" 
			placeholder="<?php esc_attr_e('68 Kilograms', 'zubaer-calorie-calculator'); ?>">	
</div>

<?php endif; ?>
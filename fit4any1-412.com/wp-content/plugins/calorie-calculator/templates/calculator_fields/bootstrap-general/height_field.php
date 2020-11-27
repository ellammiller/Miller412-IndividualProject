
<?php if($unit == 'usunit'): ?>

<div class="form-group">
    <label for="calorie_calculator_height_feet"><?php esc_html_e('Height:', 'zubaer-calorie-calculator') ?></label>

    <div class="row">

	    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<input type="number" min="0" max="10" step="any" name="calorie_calculator_height_feet" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Example: 5 feet', 'zubaer-calorie-calculator'); ?>" class="form-control" 
					placeholder="<?php esc_attr_e('5 Feet', 'zubaer-calorie-calculator'); ?>">
		</div>			

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<input type="number" min="0" max="12" step="any" name="calorie_calculator_height_inch" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Example: 8 inches', 'zubaer-calorie-calculator'); ?>" class="form-control" id="calorie_calculator_height_inch" 
					placeholder="<?php esc_attr_e('8 Inch', 'zubaer-calorie-calculator'); ?>">
		</div>		

	</div>	
	
</div>

<?php elseif($unit == 'metricunit'): ?>

<div class="form-group">
    <label for="calorie_calculator_height"><?php esc_html_e('Height:', 'zubaer-calorie-calculator') ?></label>
	<input type="number" min="0" step="any" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Example: 180 Centemeters', 'zubaer-calorie-calculator'); ?>" name="calorie_calculator_height" class="form-control" 
			placeholder="<?php esc_attr_e('180 Centimeters', 'zubaer-calorie-calculator'); ?>"> 
</div>

<?php endif; ?>

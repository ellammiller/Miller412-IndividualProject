<div class="full_width"> 
	
	<?php $uniqifier = rand(); ?>

	<div class="gender_field_wrapper full_width calcalpro_tooltip">
		<span class="calcalpro_tooltiptext">Please enter your gender</span>
		<input type="radio" name="calorie_calculator_gender" value="male" id="calorie_calculator_gender_male_<?php echo $uniqifier; ?>" class="calorie_calculator_male" checked> 
		<label for="calorie_calculator_gender_male_<?php echo $uniqifier; ?>"><?php esc_html_e('Male', 'zubaer-calorie-calculator') ?></label>
		<input type="radio" name="calorie_calculator_gender" value="female" id="calorie_calculator_gender_female_<?php echo $uniqifier; ?>" class="calorie_calculator_female"> 
		<label for="calorie_calculator_gender_female_<?php echo $uniqifier; ?>"><?php esc_html_e('Female', 'zubaer-calorie-calculator') ?></label>

	</div>

</div>

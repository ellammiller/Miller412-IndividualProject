<div class="full_width calcalpro_tooltip">
	<span class="calcalpro_tooltiptext">Please select an activity level</span>
	<!-- <label for="calorie_calculator_activity"><?php //esc_html_e('Activity:', 'zubaer-calorie-calculator') ?> </label>	 -->	
	<select id="calorie_calculator_activity" name="calorie_calculator_activity" class="calcalpro-custom-select calorie_calculator_activity" placeholder="Your Activity Level">
		<option value="1"><?php esc_html_e('Basal Metabolic Rate (BMR)', 'zubaer-calorie-calculator') ?></option>
		<option value="1.2"><?php esc_html_e('Sedentary - little or no exercise', 'zubaer-calorie-calculator') ?></option>
		<option value="1.375" selected><?php esc_html_e('Lightly Active - exercise/sports 1-3 times/week', 'zubaer-calorie-calculator') ?></option>
		<option value="1.55"><?php esc_html_e('Moderatetely Active - exercise/sports 3-5 times/week', 'zubaer-calorie-calculator') ?></option>
		<option value="1.725"><?php esc_html_e('Very Active - hard exercise/sports 6-7 times/week', 'zubaer-calorie-calculator') ?></option>
		<option value="1.9"><?php esc_html_e('Extra Active - very hard exercise/sports or physical job', 'zubaer-calorie-calculator') ?></option>
	</select>	
</div>
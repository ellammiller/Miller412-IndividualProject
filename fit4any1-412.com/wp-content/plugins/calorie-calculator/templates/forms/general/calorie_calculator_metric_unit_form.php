<form action="" method="post" class="calorie_calculator_form_metric_units calorie_calculator_form" name="calorie_calculator_form_metric_units">

	<input type="hidden" name="unit" value="metric_unit">
	<input type="hidden" name="template" value="general">
  
	<?php $object->calcalpro->get_calculator_field('age', 'general'); ?>
	<?php $object->calcalpro->get_calculator_field('gender', 'general'); ?>
	<?php $object->calcalpro->get_calculator_field('height', 'general', array('unit' => 'metricunit')); ?>
	<?php $object->calcalpro->get_calculator_field('weight', 'general', array('unit' => 'metricunit')); ?>
	<?php $object->calcalpro->get_calculator_field('activity', 'general'); ?>

	<?php if($options['show_name_field'] == 'true'): ?>

  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$first_name = is_user_logged_in()? $current_user->first_name : '';
  			$last_name = is_user_logged_in()? $current_user->last_name : '';
  		?>
		
		<?php if( $options['show_firstname_only'] == 'true' ): ?>

			<?php $object->calcalpro->get_calculator_field('firstname', 'general', array('first_name' => $first_name)); ?>

		<?php else: ?>

			<?php $object->calcalpro->get_calculator_field('fullname', 'general', array('first_name' => $first_name, 'last_name' => $last_name)); ?>

		<?php endif; ?>

	<?php endif; ?>


	<?php if($options['show_email_field'] == 'true'): ?>

  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$user_email = is_user_logged_in()? $current_user->user_email : '';
  		?>

		<?php $object->calcalpro->get_calculator_field('email', 'general', array('user_email' => $user_email)); ?>
	<?php endif; ?>

	<?php wp_nonce_field( 'calorie_calculator_form_nonce_field', 'calorie_calculator_form_nonce_field_action' ); ?>

	<div class="full_width">
		
		<?php $object->calcalpro->get_calculator_field('submit', 'general', array('object' => $object)); ?>
		<?php $object->calcalpro->get_calculator_field('clear_form', 'general'); ?>

	</div>

</form>
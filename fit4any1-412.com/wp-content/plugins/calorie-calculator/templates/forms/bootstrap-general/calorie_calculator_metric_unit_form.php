<form action="" method="post" class="calorie_calculator_form_metric_units calorie_calculator_form" name="calorie_calculator_form_metric_units">
    
	<input type="hidden" name="unit" value="metric_unit">
	<input type="hidden" name="template" value="bootstrap-general">

	<?php $object->calcalpro->get_calculator_field('age', 'bootstrap-general'); ?>
	<?php $object->calcalpro->get_calculator_field('gender', 'bootstrap-general'); ?>
	<?php $object->calcalpro->get_calculator_field('height', 'bootstrap-general', array('unit' => 'metricunit')); ?>
	<?php $object->calcalpro->get_calculator_field('weight', 'bootstrap-general', array('unit' => 'metricunit')); ?>
	<?php $object->calcalpro->get_calculator_field('activity', 'bootstrap-general'); ?>	

	
	<?php if($options['show_name_field'] == 'true'): ?>

  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$first_name = is_user_logged_in()? $current_user->user_firstname : '';
  			$last_name = is_user_logged_in()? $current_user->user_lastname : '';
  		?>
		
		<?php if( $options['show_firstname_only'] == 'true' ): ?>

			<?php $object->calcalpro->get_calculator_field('firstname', 'bootstrap-general', array('first_name' => $first_name)); ?>

		<?php else: ?>
			
			<?php $object->calcalpro->get_calculator_field('fullname', 'bootstrap-general', array('first_name' => $first_name, 'last_name' => $last_name)); ?>

		<?php endif; ?>

	<?php endif; ?>

	<?php if($options['show_email_field'] == 'true'): ?>
  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$user_email = is_user_logged_in()? $current_user->user_email : '';
  		?>

		<?php $object->calcalpro->get_calculator_field('email', 'bootstrap-general', array('user_email' => $user_email)); ?>

	<?php endif; ?>

	<?php wp_nonce_field( 'calorie_calculator_form_nonce_field', 'calorie_calculator_form_nonce_field_action' ); ?>

	<?php $object->calcalpro->get_calculator_field('submit', 'bootstrap-general'); ?>

</form>
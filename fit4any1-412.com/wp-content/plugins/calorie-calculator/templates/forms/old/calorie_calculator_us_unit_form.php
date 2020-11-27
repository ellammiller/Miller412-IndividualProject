<form action="" method="post" class="calorie_calculator_form_us_units calorie_calculator_form" name="calorie_calculator_form_us_units">

	<input type="hidden" name="unit" value="us_unit">
	<input type="hidden" name="template" value="old">

	<?php $object->calcalpro->get_calculator_field('age', 'old'); ?>
	<?php $object->calcalpro->get_calculator_field('gender', 'old'); ?>
	<?php $object->calcalpro->get_calculator_field('height', 'old', array('unit' => 'usunit')); ?>
	<?php $object->calcalpro->get_calculator_field('weight', 'old', array('unit' => 'usunit')); ?>
	<?php $object->calcalpro->get_calculator_field('activity', 'old'); ?>

	<?php if($options['show_name_field'] == 'true'): ?>

  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$first_name = is_user_logged_in()? $current_user->first_name : '';
  			$last_name = is_user_logged_in()? $current_user->last_name : '';
  		?>
		
		<?php if( $options['show_firstname_only'] == 'true' ): ?>

			<?php $object->calcalpro->get_calculator_field('firstname', 'old', array('first_name' => $first_name)); ?>

		<?php else: ?>

			<?php $object->calcalpro->get_calculator_field('fullname', 'old', array('first_name' => $first_name, 'last_name' => $last_name)); ?>

		<?php endif; ?>

	<?php endif; ?>

	<?php if($options['show_email_field'] == 'true'): ?>

  		<?php
  			global $current_user;
      		wp_get_current_user();
  			$user_email = is_user_logged_in()? $current_user->user_email : '';
  		?>

		<?php $object->calcalpro->get_calculator_field('email', 'old', array('user_email' => $user_email)); ?>
	<?php endif; ?>


	<?php wp_nonce_field( 'calorie_calculator_form_nonce_field', 'calorie_calculator_form_nonce_field_action' ); ?>

	<?php $object->calcalpro->get_calculator_field('submit', 'old'); ?>

</form>
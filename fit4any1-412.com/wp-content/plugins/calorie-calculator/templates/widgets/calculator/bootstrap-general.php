<div class="calcalpro_wrapper calorie_calculator_bootstrap">

  <?php if( $instance['unit'] == 'both' ): ?>

  <ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#usunit_<?php echo $calcalpro_widget->number; ?>">US Units</a></li>
    <li><a data-toggle="tab" href="#metricunit_<?php echo $calcalpro_widget->number; ?>">Metric Units</a></li>
  </ul>

  <?php endif; ?>


  <div class="tab-content">

  	<?php if( $instance['unit'] == 'both' || $instance['unit'] == 'usunit' ) : ?>

    <div id="usunit_<?php echo $calcalpro_widget->number; ?>" class="tab-pane fade in active">

      <div class="calorie_calculator_us_show_errors"></div>

		  <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_us_unit', 'bootstrap-general', array('object' => $calcalpro_widget, 'options' => $instance)); ?>

    </div>

	<?php endif; ?>

    
	<?php if( $instance['unit'] == 'both' || $instance['unit'] == 'metricunit' ): ?>

    <div id="metricunit_<?php echo $calcalpro_widget->number; ?>" class="<?php if($instance['unit'] == 'both') { echo 'tab-pane fade'; } ?>">

      <div class="calorie_calculator_metric_show_errors"></div>

		  <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_metric_unit', 'bootstrap-general', array('object' => $calcalpro_widget, 'options' => $instance)); ?>

    </div>

    <?php endif ?>

  </div>

  <div class="calorie_calculator_result"></div>

  
</div>
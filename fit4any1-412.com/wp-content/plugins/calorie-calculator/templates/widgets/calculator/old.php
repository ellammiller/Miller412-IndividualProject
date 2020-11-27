<div class="calcalpro_wrapper calorie_calculator_tabs calorie_calculator_old">

  <?php if( $instance['unit'] == 'both' ): ?>   
  <ul>
    <li><a href="#tabs-1_<?php echo $calcalpro_widget->number; ?>"><?php esc_html_e('US Units', 'zubaer-calorie-calculator') ?></a></li>
    <li><a href="#tabs-2_<?php echo $calcalpro_widget->number; ?>"><?php esc_html_e('Metric Units', 'zubaer-calorie-calculator') ?></a></li>
  </ul>
  <?php endif; ?>

  <?php if( $instance['unit'] == 'both' || $instance['unit'] == 'usunit' ) : ?>

  <div id="tabs-1_<?php echo $calcalpro_widget->number; ?>">

  <div class="calorie_calculator_us_show_errors"></div>

    <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_us_unit', 'old', array('object' => $calcalpro_widget, 'options' => $instance)); ?>

  </div>

  <?php endif; ?>

  <?php if( $instance['unit'] == 'both' || $instance['unit'] == 'metricunit' ): ?>

  <div id="tabs-2_<?php echo $calcalpro_widget->number; ?>">

  <div class="calorie_calculator_metric_show_errors"></div> 

      <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_metric_unit', 'old', array('object' => $calcalpro_widget, 'options' => $instance)); ?>
  

  </div>

  <?php endif; ?>


  <div class="calorie_calculator_result"></div> 


</div>
<div class="calcalpro_wrapper calorie_calculator_general">
  <?php $is_both_units = false; ?>

  <?php if( $instance['unit'] == 'both' ): $is_both_units = true; ?>		

  <ul class="tab_header_container">
    <li class="calcal_tab_triggerer left_tab calcal_tab_active">
      <a href="#tabs-1_<?php echo $calcalpro_widget->number; ?>" class="usunit"><?php esc_html_e('US Units', 'zubaer-calorie-calculator') ?></a>
    </li>
    <li class="calcal_tab_triggerer right_tab">
      <a href="#tabs-2_<?php echo $calcalpro_widget->number; ?>" class="metricunit"><?php esc_html_e('Metric Units', 'zubaer-calorie-calculator') ?></a>
    </li>
    <span class="switch-left-to-right"></span>
  </ul>

  <?php endif; ?>

<div class="calcalpro_body_wrapper">

  <?php if( $instance['unit'] == 'both' || $instance['unit'] == 'usunit' ) : ?>

    <div id="tabs-1_<?php echo $calcalpro_widget->number; ?>" class="calcal_tab <?php echo ($is_both_units) ? 'both_units' : ''; ?> calcal_tab_open">

      <div class="calorie_calculator_us_show_errors"></div>

      <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_us_unit', 'general', array('object' => $calcalpro_widget, 'options' => $instance, 'uniqifier' => $calcalpro_widget->number)); ?>

    </div>

    <?php endif; ?>

    <?php if( $instance['unit'] == 'both' || $instance['unit'] == 'metricunit' ): ?>

    <div id="tabs-2_<?php echo $calcalpro_widget->number; ?>" class="<?php echo ($is_both_units) ? 'both_units' : ''; ?> calcal_tab">

      <div class="calorie_calculator_metric_show_errors"></div>	

      <?php $calcalpro_widget->calcalpro->include_form('calorie_calculator_metric_unit', 'general', array('object' => $calcalpro_widget, 'options' => $instance, 'uniqifier' => $calcalpro_widget->number)); ?>
    

    </div>

  <?php endif; ?>


    <div class="calorie_calculator_result" style="display: none;"></div>	


  </div>
</div>

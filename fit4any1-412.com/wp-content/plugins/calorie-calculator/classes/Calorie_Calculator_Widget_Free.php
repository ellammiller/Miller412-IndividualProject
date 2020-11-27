<?php 
/**
 * Calorie Calculator Widget Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly 
}

if(!class_exists('Calorie_Calculator_Widget_Free')) {

	/**
	 * Calorie Calculator Widget Class
	 */
	class Calorie_Calculator_Widget_Free extends WP_Widget { 

		protected static $did_script = false;
		public $calcalpro;
		public $frontend_template;
	
		public function __construct() {

			parent::__construct(

				'zubaer-calorie-calculator', // Base ID
				esc_html__( 'Calorie Calculator Pro - Calculator', 'zubaer-calorie-calculator' ), // Name
				array( 'description' => esc_html__( 'This Calorie Calculator can be used to estimate the amount of calories you need to consume a day to maintain or improve your health condition.', 'zubaer-calorie-calculator' ), ) // Args
			);
			
			global $calcalpro;

			$this->calcalpro = $calcalpro;	


			// Add shortcode support for widgets (to use shortcode directly in a text widget just like as in an editor)
    		add_filter('widget_text', 'do_shortcode');
		}


		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {

			$this->enqueue_scripts($instance); 

			// outputs the content of the widget 		

			if( isset($args['before_widget']) ) {
				echo $args['before_widget'];
			}
			
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}

			?>


			<?php 

				$passed_variables = array(

					'instance' => $instance,
					'calcalpro_widget' => $this

				);

				$this->frontend_template = ( !empty( $instance['frontend_template'] ) ) ? $instance['frontend_template'] : 'general';

			?>

			


			<?php 

				$this->calcalpro->include_widget_template('calculator', $this->frontend_template, $passed_variables);
			?>


			<?php

			if( isset($args['after_widget']) ) {
				echo $args['after_widget'];
			}

			return $this;

		}
		/**
		 * Enqueue widget scripts
		 * @return void
		 */
		public function enqueue_scripts($instance) { 

			//var_dump(is_active_widget(false, false, $this->id_base, true));


			if(!self::$did_script && is_active_widget(false, false, $this->id_base, true)) { 

				$instance = $this->get_widget_instance();
				
				$template = isset($instance['frontend_template']) ? $instance['frontend_template'] : 'general';


				if($template == 'general') {

					wp_enqueue_style( 'calorie-calculator-stylesheet-general' );		

				} elseif($template =='bootstrap-general') {

					wp_enqueue_style( 'calorie-calculator-stylesheet-bootstrap' );

				} else {

					wp_enqueue_style( 'calorie-calculator-jquery-ui-css' );
					wp_enqueue_style( 'calorie-calculator-stylesheet-old' );
					wp_enqueue_script( 'jquery-ui-tabs' );

				}

				$this->calcalpro->enqueue_common_scripts_and_styles();

			    self::$did_script = true;

    		} 


			
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {

			//var_dump($instance);

			
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Calorie Calculator Pro', 'zubaer-calorie-calculator' );
			$unit = ! empty( $instance['unit'] ) ? $instance['unit'] : 'both';
			$frontend_template = isset($instance['frontend_template']) ? $instance['frontend_template'] : 'general';
			$show_name_field = isset($instance['show_name_field']) ? $instance['show_name_field'] : true;
			$show_firstname_only = isset($instance['show_firstname_only']) ? $instance['show_firstname_only'] : false;
			$show_email_field = isset($instance['show_email_field']) ? $instance['show_email_field'] : true;

			?>

			<!-- Title -->
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'zubaer-calorie-calculator' ); ?></label> 
			  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr_e( $title, 'zubaer-calorie-calculator' ); ?>">
			</p>

			<!-- Select Unit -->
		    <p>
		      <label for="<?php echo $this->get_field_id('unit'); ?>"><?php esc_html_e('Select Unit:', 'zubaer-calorie-calculator'); ?> 
		        <select class='widefat' id="<?php echo $this->get_field_id('unit'); ?>"
		                name="<?php echo $this->get_field_name('unit'); ?>" type="text">

		          <option value='both'<?php echo ($unit=='both')?'selected':''; ?>>
		            <?php esc_html_e('Both US and Metric Units', 'zubaer-calorie-calculator'); ?>
		          </option>      
		          <option value='usunit'<?php echo ($unit=='usunit')?'selected':''; ?>>
		            <?php esc_html_e('US Units', 'zubaer-calorie-calculator'); ?>
		          </option>
		          <option value='metricunit'<?php echo ($unit=='metricunit')?'selected':''; ?>>
		            <?php esc_html_e('Metric Units', 'zubaer-calorie-calculator'); ?>
		          </option> 

		        </select>                
		      </label>
		    </p>

			<!-- Frontend Styling -->
		    <p>
		      <label for="<?php echo $this->get_field_id('frontend_template'); ?>"><?php esc_html_e('Select a Template:', 'zubaer-calorie-calculator'); ?> 
		      	<span class="description"><i><?php _e('(<b>General</b>\' template is recommended. You can select Twitter Bootstrap General, if you theme supports Twitter Bootstrap.)', 'zubaer-calorie-calculator');?>.</i></span>
		        <select class='widefat' id="<?php echo $this->get_field_id('frontend_template'); ?>"
		                name="<?php echo $this->get_field_name('frontend_template'); ?>" type="text">

		          <option value='general' <?php echo ($frontend_template=='general')?'selected':''; ?> >
		            <?php esc_html_e('General Template', 'zubaer-calorie-calculator'); ?>
		          </option>      
		          <option value='bootstrap-general' <?php echo ($frontend_template=='bootstrap-general')?'selected':''; ?> >
		            <?php esc_html_e('Twitter Bootstrap General Template', 'zubaer-calorie-calculator'); ?>
		          </option>
		          <option value='old' <?php echo ($frontend_template=='old')?'selected':''; ?> >
		            <?php esc_html_e('Classic/Old Template', 'zubaer-calorie-calculator'); ?>
		          </option> 

		        </select>                
		      </label>
		    </p>


			<p>
			    <?php $checked = (!isset($instance['show_name_field'])) ? true : $instance['show_name_field']; ?>
			    <input class="checkbox" type="checkbox" <?php checked( $checked ); ?> id="<?php echo $this->get_field_id( 'show_name_field' ); ?>" name="<?php echo $this->get_field_name( 'show_name_field' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'show_name_field' ); ?>">
			    	<?php _e('Show "<b>Name Field</b>" so that you can save their name in the Log.', 'zubaer-calorie-calculator'); ?> 
			    	<span class="description"><i><?php _e('This is a required field, if you want to save form submissions to the database or add user to a Mailchimp list.', 'zubaer-calorie-calculator');?>.</i></span>
			    </label>
			    
			</p>

			<p>
			    <?php $checked = (!isset($instance['show_firstname_only'])) ? false : $instance['show_firstname_only']; ?>
			    <input class="checkbox" type="checkbox" <?php checked( $checked ); ?> id="<?php echo $this->get_field_id( 'show_firstname_only' ); ?>" name="<?php echo $this->get_field_name( 'show_firstname_only' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'show_firstname_only' ); ?>">
			    	<?php _e('Show only user\'s <b>First Name</b>.', 'zubaer-calorie-calculator'); ?> 
			    	<span class="description"><i><?php _e('This is an optional field. Enable it to save only user\'s First Name', 'zubaer-calorie-calculator');?>.</i></span>
			    </label>
			    
			</p>


			<p>
			    <?php $checked = (!isset($instance['show_email_field'])) ? true : $instance['show_email_field']; ?>
			    <input class="checkbox" type="checkbox" <?php checked( $checked ); ?> id="<?php echo $this->get_field_id( 'show_email_field' ); ?>" name="<?php echo $this->get_field_name( 'show_email_field' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'show_email_field' ); ?>">
			    	<?php _e('Show "<b>Email Field</b>" so that user can provide his/her email address.', 'zubaer-calorie-calculator'); ?> 
			    	<span class="description"><i><?php _e('This is a required field, if you want to save form submissions to the database or add user to a Mailchimp list.', 'zubaer-calorie-calculator');?>.</i></span>
			    </label>
			    
			</p>


		    <!-- Show Body Fat Percentage Field -->

			<p>
			    <input class="checkbox" disabled type="checkbox" id="hide_body_fat_field" name="hide_body_fat_field" /> 
			    <label for="hide_body_fat_field">
			    	<?php _e('Show <b>body fat percentage</b> to adjust the calculation according to users body fat percentage. field', 'zubaer-calorie-calculator'); ?>
			    </label>
			    <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>	

		    <!-- Send Email Notification on Calculator Usage -->
			<p>
			    <input disabled class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'send_to_email' ); ?>" name="<?php echo $this->get_field_name( 'send_to_email' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'send_to_email' ); ?>">
			    	<?php _e('"<b>Send an Email containing user data</b>" when someone uses this calculator.', 'zubaer-calorie-calculator');?>
			    </label>
				<a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>

		    <!-- Show Send to Email Button -->
			<p>
			    <input disabled class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'send_to_email' ); ?>" name="<?php echo $this->get_field_name( 'send_to_email' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'send_to_email' ); ?>">
			    	<?php _e('Show "<b>Send to Email</b>" Button to allow user get the result via email.', 'zubaer-calorie-calculator');?>
			    </label>
				<a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>

		    <!-- Show Download as PDF Button -->

			<p>

			    <input disabled class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'download_as_pdf' ); ?>" name="<?php echo $this->get_field_name( 'download_as_pdf' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'download_as_pdf' ); ?>">
			    	<?php _e('Show "<b>Download as PDF</b>" Button to allow user download the result as a PDF file.', 'zubaer-calorie-calculator'); ?> 
			    </label>
			    <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>


		    <!-- Enable Mailchimp Subscription -->

			<p>
			    <input disabled class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'enable_subscription' ); ?>" name="<?php echo $this->get_field_name( 'enable_subscription' ); ?>" /> 
			    <label for="<?php echo $this->get_field_id( 'enable_subscription' ); ?>">
			    	<?php _e('Show "<b>Automatic Mailchimp Subscription</b>" Button to subscribe use to a Mailchimp list instantly.', 'zubaer-calorie-calculator'); ?> 
			    </label>
			    <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>



		    <!-- Show Food Calorie Table -->

			<p>
			    <input class="checkbox" disabled type="checkbox" id="food_calorie_table" name="food_calorie_table" /> 
			    <label for="food_calorie_table">
			    	<?php _e('Show a table of <b>calories in common foods</b> after this calculator', 'zubaer-calorie-calculator'); ?>
			    </label>
			    <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>	

		    <!-- Show Calorie Buring Rate Table -->

			<p>
			    <input class="checkbox" disabled type="checkbox" id="calorie_burning_rate_table" name="calorie_burning_rate_table" /> 
			    <label for="calorie_burning_rate_table">
			    	<?php _e('Show a table of <b>calore burning rates</b> by common exercises after this calculator', 'zubaer-calorie-calculator'); ?>
			    </label>
			    <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Upgrade to Pro</a>
			</p>

			<p>
				<b>Pro version includes all above features with flexibe <i>Shortcode</i> and AJAX powered interface. See all <a target="_blank" style="color:green" href="http://zubaer.com/wordpress/downloads/calorie-calculator-pro/">Pro version features</a></b>
			</p>


			<?php 

		}

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) { 

			$this->widget_instance_array = $old_instance;

			// to access $instance from calorie_widget_instance function
			// calorie_widget_instance($instance, 'update');
			// processes widget options to be saved
			
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['unit'] = ( ! empty( $new_instance['unit'] ) ) ? strip_tags( $new_instance['unit'] ) : '';
			$instance['frontend_template'] = ( ! empty( $new_instance['frontend_template'] ) ) ? $new_instance['frontend_template'] : 'general';
			$instance['show_name_field'] = ( !empty($new_instance['show_name_field']) ) ? true : false;
			$instance['show_firstname_only'] = ( !empty($new_instance['show_firstname_only']) ) ? true : false;
			$instance['show_email_field'] = ( !empty($new_instance['show_email_field']) ) ? true : false;

			return $instance;


		} 

		/**
		 * Get widget instance
		 * @return array [Array of widget options]
		 */
		public function get_widget_instance() {

			$widget_options_all = get_option($this->option_name);
	  		$options = $widget_options_all[ $this->number ];

	  		return $options;

		}


	}

}


/**
 * Register widget with widgets_init hook.
 */
add_action( 'widgets_init', function(){
	register_widget( 'Calorie_Calculator_Widget_Free' );
});
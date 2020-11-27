<?php
/*
Plugin Name: Calorie Calculator Free
Plugin URI: https://zubaer.com/wordpress/calorie-calculator-pro/
Description: The Calorie Calculator can be used to estimate the calories you need to consume each day. This calculator can also provide some simple guideline if you want to gain or lose weight. Use the "metric units" tab if you are more comfortable with the international standard metric units.
Author: Md. Zubaer Ahammed
Text Domain: zubaer-calorie-calculator
Version: 3.2.8
Author URI: http://zubaer.com
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly 
}

if ( ! class_exists( 'Zubaer_Calorie_Calculator_Free' ) ) {

	/**
	 * Zubaer_Calorie_Calculator_Free is the main class of the plugin.
	 */

	class Zubaer_Calorie_Calculator_Free { 

		/**
		 * Translation Object to pass to JavaScript
		 */
		
		public $frontend_template = '';
		public $plugin_url;
		public $plugin_dir;
		public $plugin_version;
		public $calorie_translation_array;
		public $plugin_text_domain;
		public $plugin_name;
		public static $calcalpro_table;

	    /**
	     * Holds the values to be used in the fields callbacks
	     */
	    private $options;

	    /**
	     * Custom Post Types argument setup
	     */
	    private $food_calorie_args;
	    public $calorie_burning_args;
	    public $args;
	    public $labels;

		/**
		 * Constructor Function
		 */
		
		public function __construct() {

			//var_dump('Hola');

			//$this->define_contants();
			self::define_contants();

			$this->plugin_version = PLUGIN_VERSION;
			$this->plugin_name = PLUGIN_NAME;
			$this->plugin_text_domain = PLUGIN_TEXT_DOMAIN;
			$this->calorie_translation_array = self::get_translation_array();

	    	$this->plugin_url = plugin_dir_url( __FILE__ );
	    	$this->plugin_dir = plugin_dir_path( __FILE__ );


	    	global $wpdb;
			self::$calcalpro_table = $wpdb->prefix.'zubaer_calorei_calculator';


			$this->includes();


			add_action( 'init', array(&$this, 'calorie_calculator_load_textdomain') );

			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'add_action_links') );
			add_filter( 'plugin_row_meta', array( &$this, 'add_plugin_row_meta' ), 10, 2 );

//			//start session
//			add_action('init', array(&$this, 'myStartSession'), 1);
//			//destroy session on logout
//			add_action('wp_logout', array(&$this, 'myEndSession'));
//			//destroy session on login
//			add_action('wp_login', array(&$this, 'myEndSession'));

			if(is_admin()) {

				//plugin menu and page
				add_action( 'admin_menu', array( &$this, 'add_plugin_menu'));
				
	        	//calorie calculator custom post types and flush rewrite rules
				add_action( 'init', array( &$this, 'register_custom_post_types' ) );
				//add_action( 'after_switch_theme', array( &$this, 'my_rewrite_flush' ) );

				add_filter( 'manage_calculator_log_posts_columns', array( &$this, 'set_custom_edit_calculator_log_columns') ); 
				add_action( 'manage_calculator_log_posts_custom_column', array(&$this, 'custom_calculator_log_column'), 10, 2 );
				//Enable search for calculator_log custom columns.
				add_filter( 'posts_where', array( &$this, 'calculator_log_search_where') );
				add_filter( 'posts_join', array( &$this, 'scalculator_log_search_join') );


			}


		}




	    /**
	     * Defining constants
	     */
	    public static function define_contants() {

	    	require_once('config.php');

	    }



	    public function is_ajax_call() {

			if (defined('DOING_AJAX') && DOING_AJAX) { 

				return true;

			}

			return false;

	    }


	    public static function get_translation_array() {

	    	$calorie_translation_array = array(
	    		'sending_email' => __( 'Sending Email...', 'zubaer-calorie-calculator' ),
	    		'send_me_an_email' => __( 'Send me an Email!', 'zubaer-calorie-calculator' ),
	    		'sorry_email_cannot_be_sent' => __( 'Sorry! Email cannot be sent right now!', 'zubaer-calorie-calculator' ),
	    		'downloading' => __( 'Downloading...', 'zubaer-calorie-calculator' ),
	    		'processing_download' => __( 'Processing download...', 'zubaer-calorie-calculator' ),
	    		'download_as_pdf' => __( 'Download as PDF', 'zubaer-calorie-calculator' ),
	    		'something_went_wrong' => __( 'Sorry! Something went wrong!', 'zubaer-calorie-calculator' ),
	    		'please_fill_up_all_fields' => __( 'Please Fill up all of the fields!', 'zubaer-calorie-calculator' ),
	    		'bmr' => __( 'BMR', 'zubaer-calorie-calculator' ),
	    		'calories_per_day' => __( 'Calories/day', 'zubaer-calorie-calculator' ),
	    		'you_need' => __( 'You need', 'zubaer-calorie-calculator' ),
	    		'calories_to_maintain_weight' => __( 'Calories/day to maintain your weight.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_loose_1lb_per_week' => __( 'Calories/day to lose 1 lb per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_loose_2lb_per_week' => __( 'Calories/day to lose 2 lb per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_gain_1lb_per_week' => __( 'Calories/day to gain 1 lb per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_gain_2lb_per_week' => __( 'Calories/day to gain 2 lb per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_loose_point_5kg_per_week' => __( 'Calories/day to lose 0.5 kg per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_loose_1kg_per_week' => __( 'Calories/day to lose 1 kg per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_gain_point_5kg_per_week' => __( 'Calories/day to gain 0.5 kg per week.', 'zubaer-calorie-calculator' ),
	    		'calories_per_day_to_gain_1kg_per_week' => __( 'Calories/day to gain 1 kg per week.', 'zubaer-calorie-calculator' ),
	    		'no_foods_to_show' => __( 'No foods to show', 'zubaer-calorie-calculator' ),
	    		'show' => __( 'Show', 'zubaer-calorie-calculator' ),
	    		'search_food' => __( 'Search food...', 'zubaer-calorie-calculator' ),
	    		'no_exercises_to_show' => __( 'No exercises to show', 'zubaer-calorie-calculator' ),
	    		'search_exercise' => __( 'Search exercise...', 'zubaer-calorie-calculator' )
	    	);

	    	return $calorie_translation_array;


	    }

        /**
         * Start Function how to add core files used in admin and theme
         */
        
        public function includes() {
		
        	require_once( 'classes/Calcalpro_Ajax_Free.php' );
        	
        	require_once( 'classes/Calorie_Calculator_Widget_Free.php' );
     	      	

        	if(is_admin() && $this->is_calcalpro_allowed_admin_page()) {
        		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
        	}


        	if(!is_admin()) {
        		add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_frontend_scripts') );
        	}


        }

        public function is_calcalpro_allowed_admin_page() {

			if(is_admin()) {

        		if( isset($_GET['page']) ) {
        			if( $_GET['page'] == 'calorie-calculator/calorie-calculator.php' ) {
        				return true;
        			}
        		} else if( isset($_GET['post_type']) ) {
        			if( $_GET['post_type'] == 'calculator_log' ) {
        				return true;
        			}
        		}


        	}

        	return false;

        }


        /**
         * Enqueue common scripts and styles
         * @return void
         */
        public function enqueue_common_scripts_and_styles() {

        	$calorie_translation_array = $this->calorie_translation_array;

        	$version = $this->plugin_version;

			wp_enqueue_script( 'calorie-calculator-javascript', plugins_url( 'js/calorie_calculator.js', __FILE__ ), array('jquery'), $version );

			//Localize Scripts
	        wp_localize_script( 'calorie-calculator-javascript', 'ajax_send_or_download_details', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	        wp_localize_script( 'calorie-calculator-javascript', 'translation_array', $calorie_translation_array );	
			wp_localize_script( 'calorie-calculator-javascript', 'calcalpro_settings', array( 'debug_mode' => $this->get_constant(DEBUG_MODE) ) );

        }


        /**
         * Enqueue Admin scripts
         * @return void
         */
        public function enqueue_admin_scripts() {

        	$calorie_translation_array = $this->calorie_translation_array;

        	$version = $this->plugin_version;

        	wp_register_style('calorie-calculator-jquery-ui-css', plugins_url( 'lib/jqueryui/base/jquery-ui.css', __FILE__ ), array(), $version);
        	wp_enqueue_style( 'calorie-calculator-stylesheet-old', plugins_url( 'css/calorie_calculator_old.css', __FILE__ ), array('calorie-calculator-jquery-ui-css'), $version );

            if(is_rtl()) {
                wp_enqueue_style( 'calorie-calculator-stylesheet-general', plugins_url( 'css/calorie_calculator_general-rtl.css', __FILE__ ), array(), $version );
            } else {
                wp_enqueue_style( 'calorie-calculator-stylesheet-general', plugins_url( 'css/calorie_calculator_general.css', __FILE__ ), array(), $version );
            }

        	wp_enqueue_script( 'calorie-calculator-javascript', plugins_url( 'js/calorie_calculator.js', __FILE__ ), array('jquery', 'jquery-ui-tabs'), $version );

			//Localize Scripts
	        wp_localize_script( 'calorie-calculator-javascript', 'ajax_send_or_download_details', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	        wp_localize_script( 'calorie-calculator-javascript', 'translation_array', $calorie_translation_array );	
			wp_localize_script( 'calorie-calculator-javascript', 'calcalpro_settings', array( 'debug_mode' => $this->get_constant(DEBUG_MODE) ) );


        }


        public function does_post_has_widget($widget_base) {

        	global $post;

        	$widget = is_active_widget( false, false, $widget_base, true );

			if( is_a( $post, 'WP_Post' ) && !empty($widget) ) {
				return true;
			} 

			return false;

        }

        public function does_post_has_any_calcalpro_widget() {

        	$widgets_array = array(
        		'zubaer-calorie-calculator',
        		'zubaer-calorie-calculator-foods-table',
        		'zubaer-calorie-calculator-calorie-burning-rate'
        	);

        	foreach ($widgets_array as $widget_base) {
        		if( $this->does_post_has_widget($widget_base) ) {
        			return true;
        		}
        	}

        	return false;        	

        }


        public function register_frontend_scripts() {

        	$version = $this->plugin_version;

			wp_register_style('calorie-calculator-jquery-ui-css', plugins_url( 'lib/jqueryui/base/jquery-ui.css', __FILE__ ), array(), $version);

			wp_register_style( 'calorie-calculator-stylesheet-old', plugins_url( 'css/calorie_calculator_old.css', __FILE__ ), array('calorie-calculator-jquery-ui-css'), $version );

            if(is_rtl()) {
                wp_enqueue_style( 'calorie-calculator-stylesheet-general', plugins_url( 'css/calorie_calculator_general-rtl.css', __FILE__ ), array(), $version );
            } else {
                wp_enqueue_style( 'calorie-calculator-stylesheet-general', plugins_url( 'css/calorie_calculator_general.css', __FILE__ ), array(), $version );
            }

			wp_register_style( 'calorie-calculator-stylesheet-bootstrap', plugins_url( 'css/calorie_calculator_bootstrap.css', __FILE__ ), array(), $version );

        }


        /**
         * Enqueue Admin scripts
         * @return void
         */
        public function enqueue_frontend_scripts() {

			if( $this->does_post_has_any_calcalpro_widget() ) { 

				//Register Scripts
				$this->register_frontend_scripts();

			}	

        }


        /**
         * Fetch and return version of the current plugin in backend or admin only.
         *
         * @return	string	version of this plugin
         */
        public static function get_plugin_version() {

        	$plugin_data = get_plugin_data( __FILE__ );
        	return $plugin_data['Version'];

        }

        /**
         * Get plugin data in the backend.
         * @return array
         */
        public static function get_plugin_data() {
        	return get_plugin_data(__FILE__);
        }

		/**
		 * Load plugin textdomain.
		 */
		public function calorie_calculator_load_textdomain() {
			load_plugin_textdomain( 'zubaer-calorie-calculator', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
		}

		/**
		 * start the session
		 */
		public function myStartSession() {
			if(!session_id()) {
				session_start();
			}
		}

		/**
		 * destroy session
		 */
		public function myEndSession() {
			session_destroy ();
		}


        /**
         * Start Function regarding how to Create plugin Directory
         */
        public static function plugin_dir() {
        	
        	return plugin_dir_path( __FILE__ );
        }



        /**
         * Add Plugin Menu
         */

        public function add_plugin_menu() {
        	add_menu_page (
		        __('Calorie Calculator Options', 'zubaer-calorie-calculator'), // page title 
		        __('Calorie Calculator', 'zubaer-calorie-calculator'), // menu title
		        'manage_options', // capability
		        'calorie-calculator/calorie-calculator.php',  // menu-slug
		        array($this, 'plugin_menu_page'),   // function that will render its output
		        'dashicons-carrot'   // link to the icon that will be displayed in the sidebar
		        //$position,    // position of the menu option
		        );
        }

        public function get_constant($name) {

        	if(defined($name)) {
        		return $name;
        	}

        	$calcalpro = Zubaer_Calorie_Calculator_Free::define_contants();

        	return $name;

        }

        /**
         * [get_common_varialbles_array_for_templates description]
         * @return array [description]
         */
        public function get_common_varialbles_array_for_admin_templates() {

        	if( $this instanceof Zubaer_Calorie_Calculator_Free ) {
        		$calcalpro = $this;
        	} else {
        		$calcalpro = new Zubaer_Calorie_Calculator_Free;
        	}

        	$common_variables = array(

        		'calcalpro' => $calcalpro

        	);   

        	return $common_variables;     	

        }

        public function get_common_varialbles_array_for_frontend_templates() {

        	if( $this instanceof Zubaer_Calorie_Calculator_Free ) {
        		$calcalpro = $this;
        	} else {
        		$calcalpro = new Zubaer_Calorie_Calculator_Free;
        	}

        	$common_variables = array(

        		'calcalpro' => $calcalpro

        	);   

        	return $common_variables;     	

        }

        /**
         * [include_admin_template description]
         * @param  [type] $template_file_name [description]
         * @param  array  $passed_variables   [description]
         * @return String                    [description]
         */
        public function include_admin_template($template_file_name, $passed_variables = array()) {

        	$passed_variables = array_merge($passed_variables, $this->get_common_varialbles_array_for_admin_templates());

        	extract($passed_variables);

			include(ADMIN_TABS_DIR.'/'.$template_file_name.'.php');

        }

        /**
         * [include_admin_template description]
         * @param  [type] $template_file_name [description]
         * @param  array  $passed_variables   [description]
         * @return String                    [description]
         */
        public function include_form($form_name, $template_name, $passed_variables = array()) {

        	extract($passed_variables);

			include(FORMS_TEMPLATE_DIR.'/'.$template_name.'/'.$form_name.'_form.php');

        }

        /**
         * Get Calorie Calculator Field
         * @param  [type] $field_name       [description]
         * @param  string $template_type    [description]
         * @param  array  $passed_variables [description]
         * @return String                   [description]
         */
        public function get_calculator_field($field_name, $template_type = 'general', $passed_variables = array()) {

        	extract($passed_variables);

			include(CALCULATOR_FIELDS_DIR.'/'.$template_type.'/'.$field_name.'_field.php');

        }


        public function include_widget_template($widget_name, $template_file_name, $passed_variables = array()) {

        	$passed_variables = array_merge($passed_variables, $this->get_common_varialbles_array_for_frontend_templates());

        	extract($passed_variables);

        	$file = WIDGET_TEMPLATE_DIR.'/'.$widget_name.'/'.$template_file_name.'.php';

        	if(file_exists(stream_resolve_include_path($file))) {
        		include($file);
        	}

        }

        public function calculator_log_page_url() {

        	return admin_url('edit.php?post_type=calculator_log');

        }

		public function add_action_links ( $links ) {
			$mylinks = array(
				 '<a target="_blank" style="color:green; font-weight: bold;" href="'.esc_url( $this->get_constant(PRO_VERSION_URL) ).'">Upgrade to Pro</a>',
				 '<br/><a target="_blank" style="color:green; font-weight: bold;" href="'.esc_url( $this->calculator_log_page_url() ).'">Calculator Logs</a>',
			);
			return array_merge( $links, $mylinks );
		}

		public function add_plugin_row_meta( $links, $file ) {    
		    if ( plugin_basename( __FILE__ ) == $file ) {
		        $row_meta = array(
		          'pro-version-features'    => '<a href="' . esc_url( $this->get_constant(PRO_VERSION_URL) ) . '" target="_blank" aria-label="' . esc_attr__( 'Pro Version Features', 'zubaer-calorie-calculator' ) . '" style="color:green; font-weight:bold">' . esc_html__( 'Pro Version Features', 'zubaer-calorie-calculator' ) . '</a>'
		        );
		 
		        return array_merge( $links, $row_meta );
		    }
		    return (array) $links;
		}


		/**
		 * Add Plugin Menu page
		 */
		public function plugin_menu_page() {
			?>

			<div class="wrap">

				<?php settings_errors(); ?> 


				<?php

				if( isset( $_GET[ 'tab' ] ) ) {  
					$active_tab = $_GET[ 'tab' ];  
				} else {
					$active_tab = 'setup_widgets';
				}


		        //var_dump($active_tab);


				if($active_tab == 'food_calorie') {

					$this->options = get_option('food_calorie_options');

				} else {

					$this->options = get_option('calorie_burning_options'); 
				}

		        //var_dump($this->options);

				?>

				<h2 class="nav-tab-wrapper">
                    <a href="?page=calorie-calculator/calorie-calculator.php&tab=setup_widgets" class="nav-tab <?php echo $active_tab == 'setup_widgets' ? 'nav-tab-active' : ''; ?>"><?php _e('Set Up Widgets', 'zubaer-calorie-calculator'); ?></a>
                    <a href="?page=calorie-calculator/calorie-calculator.php&tab=food_calorie" class="nav-tab <?php echo $active_tab == 'food_calorie' ? 'nav-tab-active' : ''; ?>"><?php _e('Calorie in Foods', 'zubaer-calorie-calculator'); ?></a>
					<a href="?page=calorie-calculator/calorie-calculator.php&tab=calorie_burning" class="nav-tab <?php echo $active_tab == 'calorie_burning' ? 'nav-tab-active' : ''; ?>"><?php _e('Calorie Burning by Exercises', 'zubaer-calorie-calculator' ); ?></a>  
					<a href="?page=calorie-calculator/calorie-calculator.php&tab=import_export" class="nav-tab <?php echo $active_tab == 'import_export' ? 'nav-tab-active' : ''; ?>"><?php _e('Import/Export', 'zubaer-calorie-calculator'); ?></a> 
					<a href="?page=calorie-calculator/calorie-calculator.php&tab=mailchimp" class="nav-tab <?php echo $active_tab == 'mailchimp' ? 'nav-tab-active' : ''; ?>"><?php _e('Mailchimp', 'zubaer-calorie-calculator'); ?></a>

					<a href="?page=calorie-calculator/calorie-calculator.php&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>"><?php _e('License', 'zubaer-calorie-calculator'); ?></a> 

					<a href="?page=calorie-calculator/calorie-calculator.php&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php _e('Shortcodes', 'zubaer-calorie-calculator'); ?></a> 

					<a href="?page=calorie-calculator/calorie-calculator.php&tab=about_calorie_calculator" class="nav-tab <?php echo $active_tab == 'about_calorie_calculator' ? 'nav-tab-active' : ''; ?>"><?php _e('About', 'zubaer-calorie-calculator'); ?></a> 
				</h2> 

				<form method="post" action="options.php">

                    <?php if( $active_tab == 'setup_widgets' ): ?>

                        <?php $this->include_admin_template('setup_widgets'); ?>

                    <?php endif; ?>

					<?php if( $active_tab == 'shortcodes' ): ?>

						<?php $this->include_admin_template('upgrade-to-pro'); ?>

					<?php endif; ?>

					<?php if( $active_tab == 'mailchimp' ): ?>

						<?php $this->include_admin_template('upgrade-to-pro'); ?>

					<?php endif; ?>

					<?php if( $active_tab == 'license' ): ?>

						<?php $this->include_admin_template('upgrade-to-pro'); ?>

					<?php endif; ?>


					<?php if( $active_tab == 'about_calorie_calculator' ): ?>
						
						<?php $this->include_admin_template('about_calorie_calculator'); ?>

					<?php endif; ?>

					<?php if( $active_tab == 'food_calorie' ): ?>  
							
         				<?php $this->include_admin_template('upgrade-to-pro'); ?>

					<?php endif; ?> 

					<?php if( $active_tab == 'calorie_burning' ): ?>
						
						<?php $this->include_admin_template('upgrade-to-pro'); ?>

					<?php endif; ?>



				</form>


				<!-- Export/Import Options start here --> 

				<?php if( $active_tab == 'import_export' ): ?>

					<?php $this->include_admin_template('upgrade-to-pro'); ?>

				<?php endif; ?> 

			</div>

			<?php
		}


		/* ----------------------------------------------------------------------------- */
		/* Setting Sections And Fields */
		/* ----------------------------------------------------------------------------- */ 

		/**
		 * Initialize plugin options
		 * @return void.
		 */
		public function initialize_plugin_options() {  

			//Food Calorie Settings 

			register_setting(
		        'food_calorie_options_group', // Option group
		        'food_calorie_options', // Option name
		        array( $this, 'sanitize' ) // Sanitize
	        );

			add_settings_section(
		        'setting_section_id', // ID
		        __('Calorie in Different Foods Section', 'zubaer-calorie-calculator'), // Title
		        array( $this, 'print_section_info' ), // Callback
		        'food-calorie-page' // Page
	        );  

		    //Calorie Burning Settings

			register_setting(
	            'calorie_burning_options_group', // Option group
	            'calorie_burning_options', // Option name
	            array( $this, 'sanitize_2' ) // Sanitize
	        );

			add_settings_section(
	            'setting_section_id_2', // ID
	            __('Calorie Burning by Exercises Section', 'zubaer-calorie-calculator'), // Title
	            array( $this, 'print_section_info_2' ), // Callback
	            'calorie-burning-page' // Page
	        );  


		} // function sandbox_initialize_theme_options




	    /**
	     * Sanitize each setting field as needed
	     *
	     * @param array $input Contains all settings fields as array keys
	     */
	    public function sanitize( $input )
	    {

	    	$new_input = array();
	    	if( isset( $input['id_number'] ) )
	    		$new_input['id_number'] = absint( $input['id_number'] );

	    	if( isset( $input['title'] ) )
	    		$new_input['title'] = sanitize_text_field( $input['title'] );

	    	return $new_input;

	    }


	    /**
	     * Sanitize each setting field as needed
	     *
	     * @param array $input Contains all settings fields as array keys
	     */
	    public function sanitize_2( $input )
	    {

	    	$new_input = array();

	    	if( isset( $input['id_number_2'] ) )
	    		$new_input['id_number_2'] = absint( $input['id_number_2'] );

	    	if( isset( $input['title_2'] ) )
	    		$new_input['title_2'] = sanitize_text_field( $input['title_2'] );


	    	return $new_input;
	    }

	    /** 
	     * Print the Section text
	     */
	    public function print_section_info()
	    {
	        //print 'Enter your settings below:';
	    }

	    /** 
	     * Print the Section text
	     */
	    public function print_section_info_2()
	    {
	        //print 'Enter your settings below 2:';
	    }

	    public function register_custom_post_types() {

	    	$this->calculator_uses_log();

	    }

	    public function my_rewrite_flush() {

	    	flush_rewrite_rules();

	    }



		/**
		 * Register Calorie Foods Post Type
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		public function calculator_uses_log() {
			$labels = array(
				'name'               => _x( 'Calculator Logs', 'calculator-logs general name', 'zubaer-calorie-calculator' ),
				'singular_name'      => _x( 'Calculator Log', 'calculator-logs singular name', 'zubaer-calorie-calculator' ),
				'menu_name'          => _x( 'Calorie Calculator Logs', 'admin menu', 'zubaer-calorie-calculator' ),
				'name_admin_bar'     => _x( 'Calculator in Food', 'add new on admin bar', 'zubaer-calorie-calculator' ),
				'add_new'            => _x( 'Add New', 'calculator_log', 'zubaer-calorie-calculator' ),
				'add_new_item'       => __( 'Add New Calculator Log', 'zubaer-calorie-calculator' ),
				'new_item'           => __( 'New Calculator Log', 'zubaer-calorie-calculator' ),
				'edit_item'          => __( 'Edit Calculator Log', 'zubaer-calorie-calculator' ),
				'view_item'          => __( 'View Calculator Logs', 'zubaer-calorie-calculator' ),
				'all_items'          => __( 'All Calculator Logs', 'zubaer-calorie-calculator' ),
				'search_items'       => __( 'Search Calculator Logs', 'zubaer-calorie-calculator' ),
				'parent_item_colon'  => __( 'Parent Calculator Logs:', 'zubaer-calorie-calculator' ),
				'not_found'          => __( 'No Calculator Logs found.', 'zubaer-calorie-calculator' ),
				'not_found_in_trash' => __( 'No Calculator Logs found in Trash.', 'zubaer-calorie-calculator' )
				);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Calculator Logs or Calculator Uses Logs.', 'zubaer-calorie-calculator' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'calculator_log' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'			 => 'dashicons-carrot',	
				'supports'           => array( 'title', 'custom-fields' )
				);

			register_post_type( 'calculator_log', $args );

		}



		public function set_custom_edit_calculator_log_columns($columns) {
		    unset( $columns['title'] );
		    $columns['name'] = __( 'Name', 'zubaer-calorie-calculator' );
		    $columns['email'] = __( 'Email', 'zubaer-calorie-calculator' );
		    $columns['age'] = __( 'Age', 'zubaer-calorie-calculator' );
		    $columns['unit'] = __( 'Unit', 'zubaer-calorie-calculator' );
		    $columns['height'] = __( 'Height', 'zubaer-calorie-calculator' );
		    $columns['weight'] = __( 'Weight', 'zubaer-calorie-calculator' );
		    $columns['activity_factor'] = __( 'Activity Factor', 'zubaer-calorie-calculator' );
		    $columns['bmr'] = __( 'BMR', 'zubaer-calorie-calculator' );

		    return $columns;
		}
		

		public function custom_calculator_log_column( $column, $post_id ) {
		    switch ( $column ) {

		        case 'name' :
		        	$first_name = get_post_meta( $post_id, 'first_name', true );
		        	$last_name = get_post_meta( $post_id, 'last_name', true );
		        	$full_name = $first_name.' '.$last_name; 
		            echo $full_name;

		            break;

		        case 'email' :
	        		$email = get_post_meta($post_id, 'email', true);
	        		echo '<a href="mailto:'.$email.'">'.$email.'</a>';

	        		break;

		        case 'age' :
	        		$age = get_post_meta($post_id, 'age', true);
	        		echo $age;
	        		
	        		break;

		        case 'unit' :
	        		$unit = get_post_meta($post_id, 'unit', true);
	        		echo $unit;
	        		
	        		break;

		        case 'height' :
	        		$height = get_post_meta($post_id, 'height', true);
	        		echo $height.' cm';
	        		
	        		break;

		        case 'weight' :
	        		$weight = get_post_meta($post_id, 'weight', true);
	        		echo $weight.' Pounds';
	        		
	        		break;

		        case 'activity_factor' :
	        		$activity_factor = get_post_meta($post_id, 'activity_factor', true);
	        		echo $activity_factor;
	        		
	        		break;

		        case 'bmr' :
	        		$bmr = get_post_meta($post_id, 'bmr', true);
	        		echo $bmr;
	        		
	        		break;

		    }
		}

		/**
		 * Enable search for calculator_log search
		 * @param  [type] $join [description]
		 * @return [type]       [description]
		 */
		public function scalculator_log_search_join ( $join ) {
		    global $pagenow, $wpdb;

		    // I want the filter only when performing a search on edit page of Custom Post Type named "calculator_log".
		    if ( is_admin() && 'edit.php' === $pagenow && 'calculator_log' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {    
		        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		    }
		    return $join;
		}

		/**
		 * Enale search for calculator_log search.
		 * @param  [type] $where [description]
		 * @return [type]        [description]
		 */
		public function calculator_log_search_where( $where ) {
		    global $pagenow, $wpdb;

		    // I want the filter only when performing a search on edit page of Custom Post Type named "calculator_log".
		    if ( is_admin() && 'edit.php' === $pagenow && 'calculator_log' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
		        $where = preg_replace(
		            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
		            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
		    }
		    return $where;
		}


	    /**
	     * Start Function regarding how to Activate the plugin
	     */
	    public static function activate() {

			$calcalpro_path = 'calorie-calculator-pro/calorie-calculator-pro.php';
			
			//var_dump(is_plugin_active( $calcalpro_path )); die();

			if ( is_plugin_active( $calcalpro_path ) ) {

				$class = 'calcalpro-no-license-key notice notice-error';
				$message = __( 'This Free Version wasn\'t Activated as <b>Calorie Calculator Pro</b> is active!', 'zubaer-calorie-calculator' );

				printf( '<div class="%1$s"><p style="font-size: 1.5em;">%2$s</p></div>', esc_attr( $class ), $message ); 
	    		
				//Adding @ before will prevent XDebug output
        		@trigger_error(__('Plugin wasn\'t Activated as <b>Calorie Calculator Pro</b> is active! If you really need to use this Free version, <b>Deactivate the Pro Version first</b>.', 'zubaer-calorie-calculator'), E_USER_ERROR);

	    	}



		}


	    /**
	     * Start Function how to DeActivate the plugin
	     */
	    static function deactivate() {
	    	//do something on plugin deactivation.
	    }



    }		

}

/**
 *
 * @Create Object of class To run construct and Activate Plugin
 */

if ( class_exists( 'Zubaer_Calorie_Calculator_Free' ) ) {

	$calcalpro = new Zubaer_Calorie_Calculator_Free();


	global $calcalpro;

	$Calcalpro_Ajax_Free = new Calcalpro_Ajax_Free($calcalpro);


	register_activation_hook( __FILE__, array( 'Zubaer_Calorie_Calculator_Free', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'Zubaer_Calorie_Calculator_Free', 'deactivate' ) );
}
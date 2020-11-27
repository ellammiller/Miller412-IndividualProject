<?php
/**
 * VW Fitness Gym Theme Customizer
 *
 * @package VW Fitness Gym
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_fitness_gym_custom_controls() {

    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_fitness_gym_custom_controls' );

function vw_fitness_gym_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'inc/customize-homepage/class-customize-homepage.php' );

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'vw_fitness_gym_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'vw_fitness_gym_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$VWFitnessGymParentPanel = new VW_Fitness_Gym_WP_Customize_Panel( $wp_customize, 'vw_fitness_gym_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => 'VW Settings',
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'vw_fitness_gym_left_right', array(
    	'title'      => __( 'General Settings', 'vw-fitness-gym' ),
		'panel' => 'vw_fitness_gym_panel_id'
	) );

	$wp_customize->add_setting('vw_fitness_gym_width_option',array(
        'default' => __('Full Width','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Fitness_Gym_Image_Radio_Control($wp_customize, 'vw_fitness_gym_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-fitness-gym'),
        'description' => __('Here you can change the width layout of Website.','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_left_right',
        'choices' => array(
            'Full Width' => get_template_directory_uri().'/assets/images/full-width.png',
            'Wide Width' => get_template_directory_uri().'/assets/images/wide-width.png',
            'Boxed' => get_template_directory_uri().'/assets/images/boxed-width.png',
    ))));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_fitness_gym_theme_options',array(
        'default' => __('Right Sidebar','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'	        
	) );
	$wp_customize->add_control('vw_fitness_gym_theme_options', array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-fitness-gym'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-fitness-gym'),
            'Right Sidebar' => __('Right Sidebar','vw-fitness-gym'),
            'One Column' => __('One Column','vw-fitness-gym'),
            'Three Columns' => __('Three Columns','vw-fitness-gym'),
            'Four Columns' => __('Four Columns','vw-fitness-gym'),
            'Grid Layout' => __('Grid Layout','vw-fitness-gym')
        ),
	));

	$wp_customize->add_setting('vw_fitness_gym_page_layout',array(
        'default' => __('One Column','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control('vw_fitness_gym_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-fitness-gym'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-fitness-gym'),
            'Right Sidebar' => __('Right Sidebar','vw-fitness-gym'),
            'One Column' => __('One Column','vw-fitness-gym')
        ),
	) );

	//Pre-Loader
	$wp_customize->add_setting( 'vw_fitness_gym_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','vw-fitness-gym' ),
        'section' => 'vw_fitness_gym_left_right'
    )));

	$wp_customize->add_setting('vw_fitness_gym_loader_icon',array(
        'default' => __('Two Way','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control('vw_fitness_gym_loader_icon',array(
        'type' => 'select',
        'label' => __('Pre-Loader Type','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_left_right',
        'choices' => array(
            'Two Way' => __('Two Way','vw-fitness-gym'),
            'Dots' => __('Dots','vw-fitness-gym'),
            'Rotate' => __('Rotate','vw-fitness-gym')
        ),
	) );

	//Topbar
	$wp_customize->add_section( 'vw_fitness_gym_topbar', array(
    	'title'      => __( 'Topbar Settings', 'vw-fitness-gym' ),
		'panel' => 'vw_fitness_gym_panel_id'
	) );

	//Sticky Header
	$wp_customize->add_setting( 'vw_fitness_gym_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','vw-fitness-gym' ),
        'section' => 'vw_fitness_gym_topbar'
    )));

    $wp_customize->add_setting('vw_fitness_gym_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_search_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_search_hide_show',array(
      'label' => esc_html__( 'Show / Hide Search','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_topbar'
    )));

    $wp_customize->add_setting('vw_fitness_gym_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_search_font_size',array(
		'label'	=> __('Search Font Size','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_search_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_search_padding_top_bottom',array(
		'label'	=> __('Search Padding Top Bottom','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_search_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_search_padding_left_right',array(
		'label'	=> __('Search Padding Left Right','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_search_border_radius', array(
		'default'              => "",
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_search_border_radius', array(
		'label'       => esc_html__( 'Search Border Radius','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_topbar',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_phone_number', array( 
		'selector' => '#topbar .call-info', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_phone_number', 
	));

    $wp_customize->add_setting('vw_fitness_gym_phone_no_icon',array(
		'default'	=> 'fas fa-phone',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Fitness_Gym_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_fitness_gym_phone_no_icon',array(
		'label'	=> __('Add Phone Icon','vw-fitness-gym'),
		'transport' => 'refresh',
		'section'	=> 'vw_fitness_gym_topbar',
		'setting'	=> 'vw_fitness_gym_phone_no_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_fitness_gym_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_phone_number'
	));
	$wp_customize->add_control('vw_fitness_gym_phone_number',array(
		'label'	=> __('Add Phone Number','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '+789 456 1230', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_email_icon',array(
		'default'	=> 'fas fa-envelope-open',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Fitness_Gym_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_fitness_gym_email_icon',array(
		'label'	=> __('Add Email Icon','vw-fitness-gym'),
		'transport' => 'refresh',
		'section'	=> 'vw_fitness_gym_topbar',
		'setting'	=> 'vw_fitness_gym_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_fitness_gym_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_email'
	));
	$wp_customize->add_control('vw_fitness_gym_email_address',array(
		'label'	=> __('Add Email Address','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'example@123.com', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_topbar',
		'type'=> 'text'
	));
    
	//Slider
	$wp_customize->add_section( 'vw_fitness_gym_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'vw-fitness-gym' ),
		'panel' => 'vw_fitness_gym_panel_id'
	) );

	$wp_customize->add_setting( 'vw_fitness_gym_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_fitness_gym_slider_hide_show',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_slider_hide_show',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'vw_fitness_gym_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_fitness_gym_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'vw_fitness_gym_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'vw-fitness-gym' ),
			'description' => __('Slider image size (1500 x 650)','vw-fitness-gym'),
			'section'  => 'vw_fitness_gym_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('vw_fitness_gym_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_slidersettings',
		'type'=> 'text'
	));

	//content layout
	$wp_customize->add_setting('vw_fitness_gym_slider_content_option',array(
        'default' => __('Left','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Fitness_Gym_Image_Radio_Control($wp_customize, 'vw_fitness_gym_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_slidersettings',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/slider-content1.png',
            'Center' => get_template_directory_uri().'/assets/images/slider-content2.png',
            'Right' => get_template_directory_uri().'/assets/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_fitness_gym_slider_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_fitness_gym_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('vw_fitness_gym_slider_opacity_color',array(
      'default'              => 0.2,
      'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));

	$wp_customize->add_control( 'vw_fitness_gym_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','vw-fitness-gym' ),
	'section'     => 'vw_fitness_gym_slidersettings',
	'type'        => 'select',
	'settings'    => 'vw_fitness_gym_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','vw-fitness-gym'),
      '0.1' =>  esc_attr('0.1','vw-fitness-gym'),
      '0.2' =>  esc_attr('0.2','vw-fitness-gym'),
      '0.3' =>  esc_attr('0.3','vw-fitness-gym'),
      '0.4' =>  esc_attr('0.4','vw-fitness-gym'),
      '0.5' =>  esc_attr('0.5','vw-fitness-gym'),
      '0.6' =>  esc_attr('0.6','vw-fitness-gym'),
      '0.7' =>  esc_attr('0.7','vw-fitness-gym'),
      '0.8' =>  esc_attr('0.8','vw-fitness-gym'),
      '0.9' =>  esc_attr('0.9','vw-fitness-gym')
	),
	));

	//Slider height
	$wp_customize->add_setting('vw_fitness_gym_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_slider_height',array(
		'label'	=> __('Slider Height','vw-fitness-gym'),
		'description'	=> __('Specify the slider height (px).','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_slider_speed', array(
		'default'  => 3000,
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_float'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','vw-fitness-gym'),
		'section' => 'vw_fitness_gym_slidersettings',
		'type'  => 'number',
	) );
    
	//About Us section
	$wp_customize->add_section( 'vw_fitness_gym_about_section' , array(
    	'title'      => __( 'About us Settings', 'vw-fitness-gym' ),
		'priority'   => null,
		'panel' => 'vw_fitness_gym_panel_id'
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_fitness_gym_section_title', array( 
		'selector' => '#about-us h2', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_section_title',
	));

	$wp_customize->add_setting('vw_fitness_gym_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_section_title',array(
		'label'	=> __('Add Section Title','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'ABOUT US', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_about_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_sectio_sub_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_sectio_sub_title',array(
		'label'	=> __('Add Section Sub Title','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'WELCOME TO THE FITNESS', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_about_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_about_image',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
       'vw_fitness_gym_about_image',
       array(
       'label' => __('Section Image','vw-fitness-gym'),
       'section' => 'vw_fitness_gym_about_section',
       'settings' => 'vw_fitness_gym_about_image',
    )));

    $categories = get_categories();
	$cat_post = array();
	$cat_post[]= 'select';
	$i = 0;	
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('vw_fitness_gym_services',array(
		'default'	=> 'select',
		'sanitize_callback' => 'vw_fitness_gym_sanitize_choices',
	));
	$wp_customize->add_control('vw_fitness_gym_services',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display services','vw-fitness-gym'),
		'description' => __('Image Size (70 x 70)','vw-fitness-gym'),
		'section' => 'vw_fitness_gym_about_section',
	));

	//Services excerpt
	$wp_customize->add_setting( 'vw_fitness_gym_services_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_services_excerpt_number', array(
		'label'       => esc_html__( 'Services Excerpt length','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_about_section',
		'type'        => 'range',
		'settings'    => 'vw_fitness_gym_services_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog Post
	$wp_customize->add_panel( $VWFitnessGymParentPanel );

	$BlogPostParentPanel = new VW_Fitness_Gym_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'vw-fitness-gym' ),
		'panel' => 'vw_fitness_gym_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_fitness_gym_post_settings', array(
		'title' => __( 'Post Settings', 'vw-fitness-gym' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_toggle_postdate', 
	));

	$wp_customize->add_setting( 'vw_fitness_gym_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','vw-fitness-gym' ),
        'section' => 'vw_fitness_gym_post_settings'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_toggle_author',array(
		'label' => esc_html__( 'Author','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_post_settings'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_toggle_comments',array(
		'label' => esc_html__( 'Comments','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_post_settings'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_toggle_tags', array(
		'label' => esc_html__( 'Tags','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_post_settings'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_fitness_gym_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('vw_fitness_gym_blog_layout_option',array(
        'default' => __('Default','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Fitness_Gym_Image_Radio_Control($wp_customize, 'vw_fitness_gym_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_post_settings',
        'choices' => array(
            'Default' => get_template_directory_uri().'/assets/images/blog-layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/blog-layout2.png',
            'Left' => get_template_directory_uri().'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('vw_fitness_gym_excerpt_settings',array(
        'default' => __('Excerpt','vw-fitness-gym'),
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control('vw_fitness_gym_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_post_settings',
        'choices' => array(
        	'Content' => __('Content','vw-fitness-gym'),
            'Excerpt' => __('Excerpt','vw-fitness-gym'),
            'No Content' => __('No Content','vw-fitness-gym')
        ),
	) );

	$wp_customize->add_setting('vw_fitness_gym_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_post_settings'
    )));

	$wp_customize->add_setting( 'vw_fitness_gym_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'vw_fitness_gym_sanitize_choices'
    ));
    $wp_customize->add_control( 'vw_fitness_gym_blog_pagination_type', array(
        'section' => 'vw_fitness_gym_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'vw-fitness-gym' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'vw-fitness-gym' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'vw-fitness-gym' ),
    )));

    // Button Settings
	$wp_customize->add_section( 'vw_fitness_gym_button_settings', array(
		'title' => __( 'Button Settings', 'vw-fitness-gym' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('vw_fitness_gym_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_button_text', 
	));

    $wp_customize->add_setting('vw_fitness_gym_button_text',array(
		'default'=> 'READ MORE',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_button_text',array(
		'label'	=> __('Add Button Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'vw_fitness_gym_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'vw-fitness-gym' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_related_post_title', 
	));

    $wp_customize->add_setting( 'vw_fitness_gym_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_related_post',array(
		'label' => esc_html__( 'Related Post','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_fitness_gym_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_related_post_title',array(
		'label'	=> __('Add Related Post Title','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_fitness_gym_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_float'
	));
	$wp_customize->add_control('vw_fitness_gym_related_posts_count',array(
		'label'	=> __('Add Related Post Count','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_related_posts_settings',
		'type'=> 'number'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'vw_fitness_gym_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'vw-fitness-gym' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting( 'vw_fitness_gym_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Post Navigation','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('vw_fitness_gym_single_blog_prev_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_single_blog_next_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_single_blog_settings',
		'type'=> 'text'
	));

    //404 Page Setting
	$wp_customize->add_section('vw_fitness_gym_404_page',array(
		'title'	=> __('404 Page Settings','vw-fitness-gym'),
		'panel' => 'vw_fitness_gym_panel_id',
	));	

	$wp_customize->add_setting('vw_fitness_gym_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_fitness_gym_404_page_title',array(
		'label'	=> __('Add Title','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_fitness_gym_404_page_content',array(
		'label'	=> __('Add Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_404_page_button_text',array(
		'label'	=> __('Add Button Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_404_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('vw_fitness_gym_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','vw-fitness-gym'),
		'panel' => 'vw_fitness_gym_panel_id',
	));	

	$wp_customize->add_setting('vw_fitness_gym_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_social_icon_padding',array(
		'label'	=> __('Icon Padding','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_social_icon_width',array(
		'label'	=> __('Icon Width','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_social_icon_height',array(
		'label'	=> __('Icon Height','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_fitness_gym_responsive_media',array(
		'title'	=> __('Responsive Media','vw-fitness-gym'),
		'panel' => 'vw_fitness_gym_panel_id',
	));

    $wp_customize->add_setting( 'vw_fitness_gym_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_responsive_media'
    )));

	$wp_customize->add_setting( 'vw_fitness_gym_metabox_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_metabox_hide_show',array(
      'label' => esc_html__( 'Show / Hide Metabox','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_fitness_gym_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-fitness-gym' ),
      'section' => 'vw_fitness_gym_responsive_media'
    )));

    $wp_customize->add_setting('vw_fitness_gym_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Fitness_Gym_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_fitness_gym_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','vw-fitness-gym'),
		'transport' => 'refresh',
		'section'	=> 'vw_fitness_gym_responsive_media',
		'setting'	=> 'vw_fitness_gym_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_fitness_gym_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Fitness_Gym_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_fitness_gym_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','vw-fitness-gym'),
		'transport' => 'refresh',
		'section'	=> 'vw_fitness_gym_responsive_media',
		'setting'	=> 'vw_fitness_gym_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	//Content Creation
	$wp_customize->add_section( 'vw_fitness_gym_content_section' , array(
    	'title' => __( 'Customize Home Page Settings', 'vw-fitness-gym' ),
		'priority' => null,
		'panel' => 'vw_fitness_gym_panel_id'
	) );

	$wp_customize->add_setting('vw_fitness_gym_content_creation_main_control', array(
		'sanitize_callback' => 'esc_html',
	) );

	$homepage= get_option( 'page_on_front' );

	$wp_customize->add_control(	new VW_Fitness_Gym_Content_Creation( $wp_customize, 'vw_fitness_gym_content_creation_main_control', array(
		'options' => array(
			esc_html__( 'First select static page in homepage setting for front page.Below given edit button is to customize Home Page. Just click on the edit option, add whatever elements you want to include in the homepage, save the changes and you are good to go.','vw-fitness-gym' ),
		),
		'section' => 'vw_fitness_gym_content_section',
		'button_url'  => admin_url( 'post.php?post='.$homepage.'&action=edit'),
		'button_text' => esc_html__( 'Edit', 'vw-fitness-gym' ),
	) ) );

	//Footer Text
	$wp_customize->add_section('vw_fitness_gym_footer',array(
		'title'	=> __('Footer Settings','vw-fitness-gym'),
		'panel' => 'vw_fitness_gym_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_footer_text', array( 
		'selector' => '#footer-2 .copyright p', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_footer_text', 
	));
	
	$wp_customize->add_setting('vw_fitness_gym_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_fitness_gym_footer_text',array(
		'label'	=> __('Copyright Text','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('vw_fitness_gym_copyright_alingment',array(
        'default' => __('center','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Fitness_Gym_Image_Radio_Control($wp_customize, 'vw_fitness_gym_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_footer',
        'settings' => 'vw_fitness_gym_copyright_alingment',
        'choices' => array(
            'left' => get_template_directory_uri().'/assets/images/copyright1.png',
            'center' => get_template_directory_uri().'/assets/images/copyright2.png',
            'right' => get_template_directory_uri().'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('vw_fitness_gym_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','vw-fitness-gym' ),
      	'section' => 'vw_fitness_gym_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_fitness_gym_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'vw_fitness_gym_customize_partial_vw_fitness_gym_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('vw_fitness_gym_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Fitness_Gym_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_fitness_gym_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','vw-fitness-gym'),
		'transport' => 'refresh',
		'section'	=> 'vw_fitness_gym_footer',
		'setting'	=> 'vw_fitness_gym_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_fitness_gym_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_scroll_to_top_width',array(
		'label'	=> __('Icon Width','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_scroll_to_top_height',array(
		'label'	=> __('Icon Height','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_fitness_gym_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_fitness_gym_scroll_top_alignment',array(
        'default' => __('Right','vw-fitness-gym'),
        'sanitize_callback' => 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Fitness_Gym_Image_Radio_Control($wp_customize, 'vw_fitness_gym_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-fitness-gym'),
        'section' => 'vw_fitness_gym_footer',
        'settings' => 'vw_fitness_gym_scroll_top_alignment',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/layout2.png',
            'Right' => get_template_directory_uri().'/assets/images/layout3.png'
    ))));

    //Woocommerce settings
	$wp_customize->add_section('vw_fitness_gym_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'vw-fitness-gym'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_fitness_gym_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_woocommerce_section'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_fitness_gym_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_fitness_gym_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Fitness_Gym_Toggle_Switch_Custom_Control( $wp_customize, 'vw_fitness_gym_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','vw-fitness-gym' ),
		'section' => 'vw_fitness_gym_woocommerce_section'
    )));

    //Products per page
    $wp_customize->add_setting('vw_fitness_gym_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_float'
	));
	$wp_customize->add_control('vw_fitness_gym_products_per_page',array(
		'label'	=> __('Products Per Page','vw-fitness-gym'),
		'description' => __('Display on shop page','vw-fitness-gym'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'vw_fitness_gym_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('vw_fitness_gym_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_fitness_gym_sanitize_choices'
	));
	$wp_customize->add_control('vw_fitness_gym_products_per_row',array(
		'label'	=> __('Products Per Row','vw-fitness-gym'),
		'description' => __('Display on shop page','vw-fitness-gym'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'vw_fitness_gym_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('vw_fitness_gym_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_fitness_gym_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_fitness_gym_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','vw-fitness-gym'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-fitness-gym'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-fitness-gym' ),
        ),
		'section'=> 'vw_fitness_gym_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'vw_fitness_gym_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'vw_fitness_gym_products_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_fitness_gym_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_fitness_gym_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','vw-fitness-gym' ),
		'section'     => 'vw_fitness_gym_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Fitness_Gym_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Fitness_Gym_WP_Customize_Section' );
}

add_action( 'customize_register', 'vw_fitness_gym_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Fitness_Gym_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_fitness_gym_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Fitness_Gym_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'vw_fitness_gym_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function vw_fitness_gym_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_fitness_gym_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Fitness_Gym_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Fitness_Gym_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Fitness_Gym_Customize_Section_Pro($manager,'example_1',array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW FITNESS GYM', 'vw-fitness-gym' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-fitness-gym' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/fitness-gym-wordpress-theme/'),
		)));

		$manager->add_section(new VW_Fitness_Gym_Customize_Section_Pro($manager,'example_2',array(
			'priority'	=> 1,
			'title'    => esc_html__( 'DOCUMENATATION', 'vw-fitness-gym' ),
			'pro_text' => esc_html__( 'DOCS',  'vw-fitness-gym' ),
			'pro_url'  => admin_url( 'themes.php?page=vw_fitness_gym_guide' )
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-fitness-gym-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-fitness-gym-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Fitness_Gym_Customize::get_instance();
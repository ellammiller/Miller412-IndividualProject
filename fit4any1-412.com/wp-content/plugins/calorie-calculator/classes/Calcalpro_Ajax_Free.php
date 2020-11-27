<?php 
/**
 * Ajax Function Will be registered here
 */

class Calcalpro_Ajax_Free extends Zubaer_Calorie_Calculator_Free {

	public $calcalpro;

	public function __construct($calcalpro) {

		$this->calcalpro = $calcalpro;

		$functions = array(
			array( 'name' => 'create_new_form_submission_entry', 'type' => 'both' )
		);

		foreach ($functions as $function) {

			if( $function['type'] == 'priv' ) {
				add_action( 'wp_ajax_'.$function['name'], array($this, $function['name']) );
			} else if( $function['type'] == 'nopriv' ) {
				add_action( 'wp_ajax_nopriv_'.$function['name'], array($this, $function['name']) );
			} else { //both
				add_action( 'wp_ajax_'.$function['name'], array($this, $function['name']) );
				add_action( 'wp_ajax_nopriv_'.$function['name'], array($this, $function['name']) );
			}

		}
		
	}



	public function save_calcalpro_options() {

		global $wpdb;

		$options = $_POST['options'];

		$table_name = Zubaer_Calorie_Calculator_Free::$calcalpro_table;

		foreach ($options as $option_name => $option_value) {

			$res = $this->save_calcalpro_option($option_name, $option_value, $wpdb);

		}

		if($res) {
			echo 'success';
		}
	
		die();


	}


	/**
	 * Create a new entry to the Database when form is submitted.
	 */

	public function create_new_form_submission_entry() {

		$nonce = $_POST['nonce'];

		$formData = $_POST['formData'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$height = $_POST['height'];
		$weight = $_POST['weight'];
		$user_email = $_POST['user_email'];
		$activity_factor = $_POST['activity_factor'];
		$BMR = $_POST['BMR'];
		$first_name = $formData['first_name'];
		$last_name = $formData['last_name'];
		$unit = $_POST['unit'];

		//var_dump($formData);


		if ( !wp_verify_nonce( $nonce, "calorie_calculator_form_nonce_field")) {
			exit("Wrong nonce. Are you sure in your heart that you are not trying to spam!!!");
		}


		if(!empty($first_name) || !empty($age) || !empty($gender) || !empty($height) || !empty($weight) || !empty($activity_factor) || !empty($BMR) || !empty($user_email)) {

			//var_dump($first_name);
			//var_dump($user_email);
			//var_dump($BMR);
			//var_dump($age);

			//create an entry

			$name = $first_name.' '.$last_name;

			// Create post object
			$calculator_log = array(

				'post_title'    => wp_strip_all_tags( $name ),
				'post_status'   => 'publish',
				'post_type'	  => 'calculator_log',
				'meta_input'	  => array(

					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $user_email,
					'age' => $age,
					'gender' => $gender,
					'height' => $height,
					'weight' => $weight,
					'activity_factor' => $activity_factor,
					'bmr' => $BMR,
					'unit' => $unit

					)		
				);

			// Insert the post into the database
			
			$post_id = wp_insert_post( $calculator_log, true );


		}

		die();

	}

	/**
	 * Send as Email
	 * @return string [cofirmation of email sent or not.]
	 */

	function send_as_email() {

		$nonce = $_POST['formdata']['send_to_email_nonce_field'];
		$user_email = $_POST['formdata']['send_to_email_input'];
		$calculator_result = $_POST['calculator_result'];

		if ( !wp_verify_nonce( $nonce, "send_to_email_action")) {
			exit("Wrong nonce. Are you sure that you are not trying to spam!");
		}

		$email_body = '';
		$email_body .= 'Hello there,<br/>';
		$email_body .= 'Here is the Calorie Calculator Result which you can follow to achieve your expected health status.';
		$email_body .= $calculator_result;
		$email_body .= 'Best regards,<br/>';
		$email_body .= get_bloginfo('name');

		$to = $user_email;
		$subject = 'Calorie Calculator Details';
		$body = $email_body;
		$headers[] = 'Content-Type: text/html';
		$headers[] = 'charset=UTF-8';
		$headers[] = 'From: '. get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>';
		// $headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
		// $headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address

		$email_is_sent = wp_mail( $to, $subject, $body, $headers );


		$results = '';

		if($email_is_sent) {

			$results = '<span class="success">'. __('Email has been sent successfully!', 'zubaer-calorie-calculator') .'</span>';

		} else {

			$results = '<span class="error">'. __('Sorry! Email cannot be sent at this monent!', 'zubaer-calorie-calculator') .'</span>';

		}


		die($results);
	}


	/**
	 * Download as PDF
	 *
	 * @return string [text and link to the generated pdf file.]
	 */


	function download_as_pdf() {

		$nonce = $_POST['formdata']['download_as_pdf_nonce_field'];
		$captcha_code = $_POST['formdata']['calorie_verify_captcha'];

		//die($captcha_code .' : '.$_SESSION['calorie_captcha'] );

		if ( !wp_verify_nonce( $nonce, "download_as_pdf_action")) {
			exit("Wrong nonce. Are you sure that you are not trying to spam!");
		}

		if ( $_SESSION['calorie_captcha'] != $captcha_code ) {
	    	//http_response_code(201);
			header( 'HTTP/1.1 400 BAD REQUEST' );
			exit("Wrong captcha code. Please try again.");
		}

		$bmr = $_POST['calculator_data']['BMR'];
		$activity_factor = $_POST['calculator_data']['activity_factor'];
		$site_email = get_bloginfo('admin_email');

		//formdata 
		$person_data = $_POST['persondata'];

		$pdf = new PDF_Calorie_Calculator_Result();
		$pdf->AddPage(); 
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetY(100);
		$pdf->PersonData($person_data);
		$pdf->ResultTable($bmr, $activity_factor);
		$pdf->Ln(30);
		$message = "Please follow the result above to achieve your expected health status. If you have any questions, you can email us at the following email address:"; 
		$pdf->MultiCell(0, 15, $message);
		$pdf->SetFont('Arial', 'U', 12); 
		$pdf->SetTextColor(1, 162, 232); 

		$pdf->Write(13, $site_email, '"mailto:'. $site_email .'"');


		if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php') ;
		$wp_upload_dir = wp_upload_dir();
		$uploadedfile = trailingslashit ( $wp_upload_dir['path'] ) . 'Calorie Calculator Result'. rand() .'.pdf';

		$pdf->Output($uploadedfile, 'F');

		$attachment = array(
			'guid' => trailingslashit ($wp_upload_dir['url']) . basename( $uploadedfile ),
			'post_mime_type' => 'application/pdf',
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content' => '',
			'post_status' => 'inherit'
			);

		// Id of attachment if needed
		$attach_id = wp_insert_attachment( $attachment, $uploadedfile);

		//$pdf->Output('Calorie Calculator Result.pdf', 'F');

		die('<a target="_blank" download="Calorie Calculator Result" class="download_file_now" href="'. $attachment['guid'] .'">'. __('Click to Download', 'zubaer-calorie-calculator') .'</a>');


	}

	/**
	 * Generate Captcha
	 * @return string URL of the captcha image generated.
	 */
	function generate_captcha() {

		//$Zubaer_Calorie_Calculator_Free = new Zubaer_Calorie_Calculator_Free;
		//$captcha_builder = $Zubaer_Calorie_Calculator_Free->get_captcha_builder();
		$captcha_builder = Zubaer_Calorie_Calculator_Free::get_captcha_builder();
		$captcha_builder->build();
		$captcha_src = $captcha_builder->inline();
		$_SESSION['calorie_captcha'] = $captcha_builder->getPhrase();
		die($captcha_src);

	}

	/**
	 * Crete food calorie post
	 * @return integer ID of the created post.
	 */
	function create_food_calorie_post() {

		$food_name = $_POST['food_calorie_data']['food_name'];
		$food_amount = $_POST['food_calorie_data']['food_amount'];
		$food_calorie_amount = $_POST['food_calorie_data']['food_calorie_amount'];

		// Create post object
		$my_post = array(

			'post_title'    => wp_strip_all_tags( $food_name ),
			'post_status'   => 'publish',
			'post_type'	  => 'calorie-in-foods',
			'meta_input'	  => array(

				'_food_calorie_food_amount' => $food_amount,
				'_food_calorie_calorie_amount' => $food_calorie_amount

				)		
			);

		// Insert the post into the database
		
		$post_id = wp_insert_post( $my_post );

		//die doen't print integer. So, converting the $post_id to string is required.
		die(strval ($post_id));

	}


	/**
	 * Update food calorie post
	 * @return integer ID of the post updated.
	 */
	function update_food_calorie_post() {

		$postid = $_POST['food_calorie_data']['post_id'];
		$food_name = $_POST['food_calorie_data']['food_name'];
		$food_amount = $_POST['food_calorie_data']['food_amount'];
		$food_calorie_amount = $_POST['food_calorie_data']['food_calorie_amount'];

		// Create post object
		$my_post = array(

			'ID' 			  => $postid,
			'post_title'    => wp_strip_all_tags( $food_name ),
			'meta_input'	  => array(

				'_food_calorie_food_amount' => $food_amount,
				'_food_calorie_calorie_amount' => $food_calorie_amount

				)		
			);

		// Insert the post into the database
		
		$post_id = wp_update_post( $my_post, true );

		if(is_wp_error()) {

			die($errors = $post_id->get_error_messages());

		} else {
			//die doen't print integer. So, converting the $post_id to string is required.
			die(strval ($post_id));
		}

	}

	/**
	 * Create calorie burning post
	 * @return integer ID of the post.
	 */
	function create_calorie_burning_post() {

		$activity      = $_POST['calorie_burning_data']['activity'];
		$person_125lbs = $_POST['calorie_burning_data']['person_125lbs'];
		$person_155lbs = $_POST['calorie_burning_data']['person_155lbs'];
		$person_185lbs = $_POST['calorie_burning_data']['person_185lbs'];
		

		// Create post object
		$my_post = array(

			'post_title'    => wp_strip_all_tags( $activity ),
			'post_status'   => 'publish',
			'post_type'	  => 'calorie-burning',
			'meta_input'	  => array(

				'_person_125lbs' => $person_125lbs,
				'_person_155lbs' => $person_155lbs,
				'_person_185lbs' => $person_185lbs,

				)		
			);

		// Insert the post into the database
		
		$post_id = wp_insert_post( $my_post );

		//die doen't print integer. So, converting the $post_id to string is required.
		die(strval ($post_id));

	}
	/**
	 * Update calorie buring post
	 * @return mixed(int|wp error object) The value 0 or WP_Error on failure. The post ID on success.
	 */
	function update_calorie_burning_post() {

		$postid = $_POST['calorie_burning_data']['post_id'];
		$activity      = $_POST['calorie_burning_data']['activity'];
		$person_125lbs = $_POST['calorie_burning_data']['person_125lbs'];
		$person_155lbs = $_POST['calorie_burning_data']['person_155lbs'];
		$person_185lbs = $_POST['calorie_burning_data']['person_185lbs'];

		// Create post object
		$my_post = array(

			'ID' 			  => $postid,
			'post_title'    => wp_strip_all_tags( $activity ),
			'post_status'   => 'publish',
			'meta_input'	  => array(

				'_person_125lbs' => $person_125lbs,
				'_person_155lbs' => $person_155lbs,
				'_person_185lbs' => $person_185lbs,

				)		
			);

		// Insert the post into the database
		
		$post_id = wp_update_post( $my_post, true );

		if(is_wp_error()) {

			die($errors = $post_id->get_error_messages());

		} else {
			//die doen't print integer. So, converting the $post_id to string is required.
			die(strval ($post_id));
		}

	}
	/**
	 * Delete a post (food/activiy)
	 * @return mixed The post object (if it was deleted or moved to the trash successfully) or false (failure)
	 */
	function delete_post() {

		$postid = $_POST['post_id']; 

		//second parameter $force_delete is set to true to bypass trash.
		wp_delete_post( $postid, true );

	}
	/**
	 * Delete all foods from the database.
	 * @return string text confirmation of deletion of foods
	 */
	function delete_all_foods() {

	    //get all foods
		$args = array( 'post_type' => 'calorie-in-foods', 'posts_per_page' => -1);
		$loop = new WP_Query( $args );
	    //get all foods


		if($loop->have_posts()) {
			while($loop->have_posts()) {
				$loop->the_post();

				//second parameter $force_delete is set to true to bypass trash.
				$result = wp_delete_post( get_the_ID(), true );

			}

			if($result == false) {
				die('Sorry, something went wrong!');
			} else {
				die('Foods were deleted successfully');
			}
		} else {
			die('Seems there are no foods available!');
		}


	}
	/**
	 * Delete all activities from the database.
	 * @return string text confirmation of deletion of activities
	 */
	function delete_all_activities() {

	    //get all foods
		$args = array( 'post_type' => 'calorie-burning', 'posts_per_page' => -1 );
		$loop = new WP_Query( $args );
	    //get all foods


		if($loop->have_posts()) {
			while($loop->have_posts()) {
				$loop->the_post();

				//second parameter $force_delete is set to true to bypass trash.
				$result = wp_delete_post( get_the_ID(), true );

			}

			if($result == false) {
				die('Sorry, something went wrong!');
			} else {
				die('Activities were deleted successfully');
			}
		} else {
			die('Seems there are no activities available!');
		}


	}





}


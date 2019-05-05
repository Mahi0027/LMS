<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Elearning extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->library('upload');
		$this->load->model("Classroom_model");
	}

	 /* View Course
	 * @ GET all List
	 * @ prama Post 
	*/
	public function courses(){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('course_management');
			
			$courslist = $this->Common_model->select_info("lms_courses");
			$this->data['courses'] = $courslist;
			$this->_render_page('lms_admin/courses/index', $this->data);
		}
		 
	}
	
	/**
	 * Create a new Course
	 */
	public function addcourses()
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_course_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('course_name', str_replace(':', '', $this->lang->line('index_coursename_th')), 'required');
				$this->form_validation->set_rules('compliance_standard', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('course_name'),
						'reference_title' => $this->input->post('ref_title'),
						'objectives' =>$this->input->post('learning_objectives'),
						'seat_time' =>$this->input->post('seat_time'),
						'description'=>$this->input->post('about_course'),
						'status_id'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_courses',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Course added successfully.");						
						redirect('lmsadmin/elearning/courses', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['course_name'] = array('name' => 'course_name',
					'id' => 'course_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('course_name'),
				);
				
				$this->data['ref_title'] = array('name' => 'ref_title',
					'id' => 'ref_title',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('ref_title'),
				);
				$this->data['learning_objectives'] = array('name' => 'learning_objectives',
					'id' => 'learning_objectives',
					'class'=>'md-input',
					'value' => set_value('learning_objectives'),
				);
				
				$compliance_arr = array('1'=> 'AICC', '2'=> 'SCORM 1.2','3'=>'SCORM 2004','4'=>'Tin Can','5'=>'Proprietary');
				$this->data['compliance_standard'] = array(
					'name' => 'compliance_standard',
					'id' => 'compliance_standard',
					'options' => 	$compliance_arr,
					'data-md-selectize'=>'',
					'selected' => set_value('compliance_standard'),
				);
				
				$this->data['seat_time'] = array('name' => 'seat_time',
					'id' => 'kUI_timepicker',
					'class'=>'uk-form-width-medium',
					'type' => 'number',
					'value' => set_value('seat_time'),
				);
				
				
				$this->data['about_course'] = array('name' => 'about_course',
					'id' => 'about_course',
					'class'=>'md-input',
					'value' => set_value('about_course'),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points'),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status'),
				);
				$this->_render_page('lms_admin/courses/add', $this->data);
		}
		
		
	}
	
	
	/**
	 * Update user
	 */
	
	 public function updatecourse($id){
		if(!$this->Common_model->is_exits('lms_courses','lms_course_id',array('lms_course_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/courses', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_course_heading');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$courslist = $this->Common_model->select_info("lms_courses",array('lms_course_id'=>$id));
			$courslist = $courslist[0];
			
			// validate form input
			$this->form_validation->set_rules('course_name', str_replace(':', '', $this->lang->line('index_coursename_th')), 'required');
			$this->form_validation->set_rules('compliance_standard', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');
			$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE){
					$data_arr = array(
						'name' =>$this->input->post('course_name'),
						'reference_title' => $this->input->post('ref_title'),
						'objectives' =>$this->input->post('learning_objectives'),
						'seat_time' =>$this->input->post('seat_time'),
						'description'=>$this->input->post('about_course'),
						'status_id'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_courses',$data_arr,array('lms_course_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Course updated successfully.");						
						redirect('lmsadmin/elearning/courses', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['course_name'] = array('name' => 'course_name',
					'id' => 'course_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('course_name',$courslist['name']),
				);
				
				$this->data['ref_title'] = array('name' => 'ref_title',
					'id' => 'ref_title',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('ref_title',$courslist['reference_title']),
				);
				$this->data['learning_objectives'] = array('name' => 'learning_objectives',
					'id' => 'learning_objectives',
					'class'=>'md-input',
					'value' => set_value('learning_objectives',$courslist['objectives']),
				);
				
				$compliance_arr = array('1'=> 'AICC', '2'=> 'SCORM 1.2','3'=>'SCORM 2004','4'=>'Tin Can','5'=>'Proprietary');
				$this->data['compliance_standard'] = array(
					'name' => 'compliance_standard',
					'id' => 'compliance_standard',
					'options' => 	$compliance_arr,
					'data-md-selectize'=>'',
					'selected' => set_value('compliance_standard'),
				);
				
				$this->data['seat_time'] = array('name' => 'seat_time',
					'id' => 'kUI_timepicker',
					'class'=>'uk-form-width-medium',
					'type' => 'number',
					'value' => set_value('seat_time',$courslist['seat_time']),
				);
				
				
				$this->data['about_course'] = array('name' => 'about_course',
					'id' => 'about_course',
					'class'=>'md-input',
					'value' => set_value('about_course',$courslist['description']),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points',$courslist['cpd_points']),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status',$courslist['status_id']),
				);
				$this->data['lms_course_id'] = $courslist['lms_course_id'];
				$this->_render_page('lms_admin/courses/edit', $this->data);
		}
		
	 }
	
	
	 /* View Videos
	 * @ GET all List
	 * @ prama Post 
	*/
	public function videos(){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('video_management');
			
			$videos = $this->Common_model->select_info("lms_videos");
			$this->data['videos'] = $videos;
			$this->_render_page('lms_admin/videos/index', $this->data);
		}
		 
	}
	
	/**
	 * Create a new Video
	 */
	public function addvideo()
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_video_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('video_name', str_replace(':', '', $this->lang->line('index_videoname_th')), 'required');
				//$this->form_validation->set_rules('type', str_replace(':', '', $this->lang->line('index_type_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('def_status')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('video_name'),
						'description' => $this->input->post('description'),
						'type' =>'u',
						'url' =>$this->input->post('url'),
						'status_id'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_videos',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Video added successfully.");						
						redirect('lmsadmin/elearning/videos', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['video_name'] = array('name' => 'video_name',
					'id' => 'video_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('video_name'),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('description'),
				);
				
				
				
				
				$type = array('v'=> 'Video', 'u'=> 'URL');
				$this->data['type'] = array(
					'name' => 'type',
					'id' => 'type',
					'options' => 	$type,
					'data-md-selectize'=>'',
					'selected' => set_value('type'),
				);
				
				$this->data['url'] = array('name' => 'url',
					'id' => 'url',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('url'),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points'),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status'),
				);
				$this->_render_page('lms_admin/videos/add', $this->data);
		}
		
		
	}
	
	/**
	 * Update user
	 */
	
	 public function updatevideo($id){
		
		if(!$this->Common_model->is_exits('lms_videos','lms_video_id',array('lms_video_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/videos', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_video_heading');
		$this->data['iddd']= $id;
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$videos = $this->Common_model->select_info("lms_videos",array('lms_video_id'=>$id));
			$videos = $videos[0];
			
			
			// validate form input
				$this->form_validation->set_rules('video_name', str_replace(':', '', $this->lang->line('index_videoname_th')), 'required');
			//	$this->form_validation->set_rules('type', str_replace(':', '', $this->lang->line('index_type_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('def_status')), 'required');
				
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE){
					$data_arr = array(
						'name' =>$this->input->post('video_name'),
						'description' => $this->input->post('description'),
						'type' =>'u',
						'url' =>$this->input->post('url'),
						'status_id'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,											
					);
					
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_videos',$data_arr,array('lms_video_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Course updated successfully.");						
						redirect('lmsadmin/elearning/videos', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['video_name'] = array('name' => 'video_name',
					'id' => 'video_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('video_name',$videos['name']),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('description',$videos['description']),
				);
							
				
				$type = array('v'=> 'Video', 'u'=> 'URL');
				$this->data['type'] = array(
					'name' => 'type',
					'id' => 'type',
					'options' => 	$type,
					'data-md-selectize'=>'',
					'selected' => set_value('type',$videos['type']),
				);
				
				$this->data['url'] = array('name' => 'url',
					'id' => 'url',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('url',$videos['url']),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points',$videos['cpd_points']),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status',$videos['status_id']),
				);
				$this->data['lms_video_id'] = $videos['lms_video_id'];
				$this->_render_page('lms_admin/videos/add', $this->data);
		}
		
	 }	
	
	/**
	 * @return array A CSRF key-value pair
	 */
	
	
	
	/* View Assignment
	 * @ GET all List
	 * @ prama Post 
	*/
	public function assignments(){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('assignments_management');
			
			$assignments = $this->Common_model->select_info("lms_assignment");
			$this->data['assignments'] = $assignments;
			$this->_render_page('lms_admin/assignment/index', $this->data);
		}
		 
	}
	
	
	
	/**
	 * Create a new Assignment
	 */
	public function addassignment()
	{


		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_assignments_heading');
			
			if (isset($_POST) && !empty($_POST))
			{

				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
				$this->form_validation->set_rules('score_max', str_replace(':', '', $this->lang->line('index_max_score')), 'required');
				$this->form_validation->set_rules('passing', str_replace(':', '', $this->lang->line('assign_passing_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');

			 
				
				//for upload picture
				if(!empty($_FILES['document']['name']))
		            {
		                $config['upload_path'] = 'uploads/lms';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['document']['name'];
		                
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                
		                if($this->upload->do_upload('document'))
		                {
		                    $uploadData = $this->upload->data();
		                    $document = $uploadData['file_name'];
		                }
		                
		               		
		              }

			}
			   if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'duration ' =>$this->input->post('duration '),
						'score_max' =>$this->input->post('score_max'),
						'passing'=>$this->input->post('passing'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'instructions'=>$this->input->post('instructions'),
						'document'=>$_FILES['document']['name'],									
						'status_id'=>$this->input->post('status'),					
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_assignment',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Assignment added successfully.");						
						redirect('lmsadmin/elearning/assignments', 'refresh');
					}		
				 }
				 

				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name'),
				);
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('description'),
				);
				
				$this->data['duration'] = array('name' => 'duration',
					'id' => 'duration',
					'class'=>'uk-form-width-medium',
					'type' => 'number',
					'value' => set_value('duration'),
				);
				
				$this->data['score_max'] = array('name' => 'score_max',
					'id' => 'score_max',
					'class'=>'md-input',
					'type' => 'number',					
					'value' => set_value('score_max'),
				);
				$this->data['passing'] = array('name' => 'passing',
					'id' => 'passing',
					'class'=>'md-input',
					'type' => 'number',
					'value' => set_value('passing'),
				);
				
				$this->data['instructions'] = array('name' => 'instructions',
					'id' => 'instructions',
					'class'=>'md-input',
					'value' => set_value('instructions'),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points'),
				);
				
				$status = array
				    (
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				
				$this->data['status'] = array
				(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status'),
				);
				
				$this->data['document'] = array
				(
					'name' => 'document',
					'id' => 'document',
					'type'=>'file',
					'value' => set_value('document'),
				);
				$this->load->view('lms_admin/assignment/add', $this->data);
		}
		
		
	}
	
	
	
	
	
	
	
	/**
	 * Edit and Update Assignment
	 */
	public function updateassignment($id)
	{
		if(!$this->Common_model->is_exits('lms_assignment','lms_assignment_id',array('lms_assignment_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/assignments', 'refresh');
		}
		
		$userId = $this->ion_auth->get_user_id();
		$this->data['iddd']=$id;
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_assignments_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
				$this->form_validation->set_rules('score_max', str_replace(':', '', $this->lang->line('index_max_score')), 'required');
				$this->form_validation->set_rules('passing', str_replace(':', '', $this->lang->line('assign_passing_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_com_stand_th')), 'required');
				//for upload picture
				if(!empty($_FILES['document']['name']))
		            {
		                $config['upload_path'] = 'uploads/lms';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['document']['name'];
		                
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                
		                if($this->upload->do_upload('document'))
		                {
		                    $uploadData = $this->upload->data();
		                    $document = $uploadData['file_name'];
		                }
		                
		               		
		              }


			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'duration ' =>$this->input->post('duration '),
						'score_max' =>$this->input->post('score_max'),
						'passing'=>$this->input->post('passing'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'instructions'=>$this->input->post('instructions'),
						'document'=>$_FILES['document']['name'],												
						'status_id'=>$this->input->post('status'),					
						'updated_at'=>date('y-m-d'),
						'updated_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_assignment',$data_arr,array('lms_assignment_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Assignment updated successfully.");						
						redirect('lmsadmin/elearning/assignments', 'refresh');
					}	
					
					
				}
			}
			$assignments = $this->Common_model->select_info("lms_assignment",array('lms_assignment_id'=>$id));
			$assignments = $assignments[0];
			
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name',$assignments['name']),
				);
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('description',$assignments['description']),
				);
				
				$this->data['duration'] = array('name' => 'duration',
					'id' => 'duration',
					'class'=>'uk-form-width-medium',
					'type' => 'number',
					'value' => set_value('duration',$assignments['duration']),
				);
				
				$this->data['score_max'] = array('name' => 'score_max',
					'id' => 'score_max',
					'class'=>'md-input',
					'type' => 'number',					
					'value' => set_value('score_max',$assignments['score_max']),
				);
				$this->data['passing'] = array('name' => 'passing',
					'id' => 'passing',
					'class'=>'md-input',
					'type' => 'number',
					'value' => set_value('passing',$assignments['passing']),
				);
				
				$this->data['instructions'] = array('name' => 'instructions',
					'id' => 'instructions',
					'class'=>'md-input',
					'value' => set_value('instructions',$assignments['instructions']),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points',$assignments['cpd_points']),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status',$assignments['status_id']),
				);
				$this->data['document'] = array
				(
					'name' => 'document',
					'id' => 'document',
					'type'=>'file',
					'value' => set_value('document'),
				);
				$this->_render_page('lms_admin/assignment/add', $this->data);
		}
		
		
	}


	 /* View Reference material
	 * @ GET all List
	 * @ prama Post 
	*/
	public function reference_material(){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('reference_material');
			
			$reference_material_list = $this->Common_model->select_info("lms_reference_material");
			$this->data['reference_material_list'] = $reference_material_list;
			$this->_render_page('lms_admin/reference_material/index', $this->data);
		}
		 
	}
	
	/**
	 * Create a new Course
	 */
	public function add_reference_material()
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('add_reference_material');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_name')), 'required');
				$this->form_validation->set_rules('instructor', str_replace(':', '', $this->lang->line('index_instructor')), 'required');
				$this->form_validation->set_rules('cpd_points', str_replace(':', '', $this->lang->line('index_cpd_points')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_status')), 'required');


				//for upload picture
				if(!empty($_FILES['document']['name']))
		            {
		                $config['upload_path'] = 'uploads/lms';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['document']['name'];
		                
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                
		                if($this->upload->do_upload('document'))
		                {
		                    $uploadData = $this->upload->data();
		                    $document = $uploadData['file_name'];
		                }
		                
		               		
		              }

			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'type' =>$this->input->post('type'),
						'url' =>$this->input->post('url'),
						'document' =>$_FILES['document']['name'],
						'instructor' =>$this->input->post('instructor'),
						'status'=>$this->input->post('status'),
						'cpd_points' =>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_reference_material',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Data added successfully.");						
						redirect('lmsadmin/elearning/reference_material', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name'),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('description'),
				);

				
				$type = array('u'=> 'URL', 'd'=> 'Document');
				$this->data['type'] = array(
					'name' => 'type',
					'id' => 'val_select',
					'options' => 	$type,
					'data-md-selectize'=>'',
					'selected' =>set_value('type'),
				);

				$this->data['url'] = array('name' => 'url',
					'id' => 'url',
					'class'=>'md-input',
					'type' => 'url',
					'value' => set_value('url'),
				);

				$this->data['document'] = array('name' => 'document',
					'id' => 'document',
					'class'=>'md-input',
					'type' => 'file',
					'value' =>set_value('document'),
				);
				
				$instructor = array('press'=> 'Press', 'internet'=> 'Internet');
				$this->data['instructor'] = array(
					'name' => 'instructor',
					'id' => 'instructor',
					'options' => 	$instructor,
					'data-md-selectize'=>'',
					'selected' =>$this->form_validation->set_value('instructor'),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('cpd_points'),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => $this->form_validation->set_value('status'),
				);
				$this->_render_page('lms_admin/reference_material/add', $this->data);
		}
		
		
	}
	
	
	/**
	 * Update user
	 */
	
	 public function update_reference_material($id){
		if(!$this->Common_model->is_exits('lms_reference_material','reference_id',array('reference_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/reference_material', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_reference_material');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$reference_material_list = $this->Common_model->select_info("lms_reference_material",array('reference_id'=>$id));
			$reference_material_list = $reference_material_list[0];
			
			// validate form input
			$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_name')), 'required');
				$this->form_validation->set_rules('instructor', str_replace(':', '', $this->lang->line('index_instructor')), 'required');
				$this->form_validation->set_rules('cpd_points', str_replace(':', '', $this->lang->line('index_cpd_points')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_status')), 'required');

				//for upload picture
				if(!empty($_FILES['document']['name']))
		            {
		                $config['upload_path'] = 'uploads/lms';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['document']['name'];
		                
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                
		                if($this->upload->do_upload('document'))
		                {
		                    $uploadData = $this->upload->data();
		                    $document = $uploadData['file_name'];
		                }
		                
		               		
		              }


			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE){
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'type' =>$this->input->post('type'),
						'url' =>$this->input->post('url'),
						'document' =>$_FILES['document']['name'],
						'instructor' =>$this->input->post('instructor'),
						'status'=>$this->input->post('status'),
						'cpd_points' =>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_reference_material',$data_arr,array('reference_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "reference_material updated successfully.");						
						redirect('lmsadmin/elearning/reference_material', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name',$reference_material_list['name']),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('description',$reference_material_list['description']),
				);

				$type = array('u'=> 'URL', 'd'=> 'Document');
				$this->data['type'] = array(
					'name' => 'type',
					'id' => 'val_select',
					'options' => 	$type,
					'data-md-selectize'=>'',
					'selected' =>set_value('type',$reference_material_list['type']),
				);
				
				$this->data['url'] = array(
					'name' => 'url',
					'id' => 'urltype',
					'class'=>'md-input',
					'type' => 'text',
					'selected' => set_value('url',$reference_material_list['url']),
				);

				$this->data['document'] = array(
					'name' => 'document',
					'id' => 'doc_type',
					'class'=>'md-input',
					'type' => 'file',
					'selected' => set_value('document',$reference_material_list['document']),
				);
				
				$instructor = array('press'=> 'Press', 'internet'=> 'Internet');
				$this->data['instructor'] = array(
					'name' => 'instructor',
					'id' => 'instructor',
					'options' =>$instructor,
					'data-md-selectize'=>'',
					'selected' =>$this->form_validation->set_value('instructor',$reference_material_list['instructor']),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('cpd_points',$reference_material_list['cpd_points']),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => $this->form_validation->set_value('status',$reference_material_list['status']),
				);
				$this->data['reference_id'] = $reference_material_list['reference_id'];
				$this->_render_page('lms_admin/reference_material/add', $this->data);
		}
		
	 }


	
	
	public function _get_csrf_nonce()
	{		
		$this->load->helper('string');	
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')){
			return TRUE;
		}
			return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

//feedback

	public function feedback()
	{
		  /*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('feedback');
			
			$feedbacklist = $this->Common_model->select_info("lms_feedback");
			$this->data['feedback'] = $feedbacklist;
			 $this->load->view('lms_admin/feedback/index',$this->data);

		}
        
	}
	
	public function add_feedback()
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_feedback');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('feedback_name', str_replace(':', '', $this->lang->line('index_feedback_name')), 'required');
				$this->form_validation->set_rules('description', str_replace(':', '', $this->lang->line('feedback_description')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_feedback_status')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'feedback_name' =>$this->input->post('feedback_name'),
						'description' =>$this->input->post('description'),
						'instruction' =>$this->input->post('instruction'),
						'instructor'=>$this->input->post('instructor'),
						'status'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,					
						
												
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_feedback',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "feedback added successfully.");						
						redirect('lmsadmin/elearning/feedback', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['feedback_name'] = array('name' => 'feedback_name',
					'id' => 'feedback_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('feedback_name'),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('description'),
				);
				$this->data['instruction'] = array('name' => 'instruction',
					'id' => 'instruction',
					'class'=>'md-input',
					'value' => set_value('instruction'),
				);
				
				$compliance_arr = array('1'=> 'AICC', '2'=> 'SCORM 1.2','3'=>'SCORM 2004','4'=>'Tin Can','5'=>'Proprietary');
				$this->data['instructor'] = array(
					'name' => 'instructor',
					'id' => 'instructor',
					//'options' => 	$compliance_arr,
					'data-md-selectize'=>'',
					'selected' => set_value('instructor'),
				)	;
				
				
				
				
				
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points'),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status'),
				);
				$this->load->view('lms_admin/feedback/add', $this->data);
		}
		
	}
	public function update_feedback($id)
	{     
		$userId = $this->ion_auth->get_user_id();
		$this->data['iddd']=$id;
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{	
		      $this->data['title'] = $this->lang->line('update_feedback');		
			$feedbacklist = $this->Common_model->select_info("lms_feedback",array('lms_feedback_id'=>$id));
			$feedbacklist = $feedbacklist[0];
			
			// validate form input
			$this->form_validation->set_rules('feedback_name', str_replace(':', '', $this->lang->line('index_feedback_name')), 'required');
				$this->form_validation->set_rules('description', str_replace(':', '', $this->lang->line('feedback_description')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('index_feedback_status')), 'required');
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE){
					$data_arr = array(
						'feedback_name' =>$this->input->post('feedback_name'),
						'description' =>$this->input->post('description'),
						'instruction' =>$this->input->post('instruction'),
						'instructor'=>$this->input->post('instructor'),
						'status'=>$this->input->post('status'),
						'cpd_points'=>$this->input->post('cpd_points'),
						'created_by'=>$id,
						'updated_by'=>$id,
											
					);							
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_feedback',$data_arr,array('lms_feedback_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Course updated successfully.");						
						redirect('lmsadmin/elearning/feedback', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['feedback_name'] = array('name' => 'feedback_name',
					'id' => 'feedback_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('feedback_name',$feedbacklist['feedback_name']),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('description',$feedbacklist['description']),
				);
				$this->data['instruction'] = array('name' => 'instruction',
					'id' => 'instruction',
					'class'=>'md-input',
					'value' => set_value('instruction',$feedbacklist['instruction']),
				);
				
				$compliance_arr = array('1'=> 'AICC', '2'=> 'SCORM 1.2','3'=>'SCORM 2004','4'=>'Tin Can','5'=>'Proprietary');
				$this->data['instructor'] = array(
					'name' => 'instructor',
					'id' => 'instructor',
					//'options' => 	$compliance_arr,
					'data-md-selectize'=>'',
					'selected' => set_value('instructor',$feedbacklist['instructor']),
				);
				
				
				
				
				
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points',$feedbacklist['cpd_points']),
				);
				
				$status = array(
						'1'         => 'Active',
						'2'           => 'In Active'						
					);
				$this->data['status'] = array(
					'name' => 'status',
					'id' => 'status',
					'options' => 	$status,
					'data-md-selectize'=>'',
					'selected' => set_value('status',$feedbacklist['status']),
				);
				$this->data['lms_feedback_id'] = $feedbacklist['lms_feedback_id'];
				$this->_render_page('lms_admin/feedback/add', $this->data);
		}

	}


		/*
		build session course
	*/
	
	public function build_session_course($url){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['title'] = $this->lang->line('build_session_course');

			
			

			$this->data['url']=$url;
			//course table data
			$courses=$this->Classroom_model->buildcourse($url);
			$this->data['courses'] = $courses;
			$this->_render_page('lms_admin/training/add_courses', $this->data);
		}
		 
	}

	/*
		build session video
	*/
	
	public function build_session_video($url){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['url']=$url;

			$this->data['title'] = $this->lang->line('build_session_video');
			//video table data
			$videos=$this->Classroom_model->buildvideo($url);
			$this->data['videos'] = $videos;
			$this->_render_page('lms_admin/training/add_video', $this->data);
		}
		 
	}

	/*
		build session course
	*/
	
	public function build_session_session($url){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');


			$this->data['url']=$url;

			$this->data['title'] = $this->lang->line('build_session_session');
			
			//session data table
			$sessions=$this->Classroom_model->buildsession($url);
			$this->data['sessions'] = $sessions;
			$this->_render_page('lms_admin/training/add_session', $this->data);
		}
		 
	}

	/*
		build session assignment
	*/
	
	public function build_session_assignment($url){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['url']=$url;
			
			$this->data['title'] = $this->lang->line('build_session_assignment');
			
			//assignment table data
			$assignments=$this->Classroom_model->buildassignment($url);
			$this->data['assignments'] = $assignments;
			$this->_render_page('lms_admin/training/add_assignment', $this->data);
		}
		 
	}

	public function build_session_feedback($url){
		
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['url']=$url;
			
			$this->data['title'] = $this->lang->line('build_session_feedback');
			
			//video table data
			$feedback=$this->Classroom_model->buildfeedback($url);
			$this->data['feedback'] = $feedback;
			$this->_render_page('lms_admin/training/add_feedback', $this->data);
		}
		 
	}

	public function add_course_to_training_assign($training_id,$course_id){
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$courslist = $this->Common_model->insert_info("ims_training_assign",array('lms_training_id'=>$training_id,'lms_course_id'=>$course_id));
			if($courslist){
				$this->session->set_flashdata('message', "Course added successfully.");
			}else{
				$this->session->set_flashdata('message', "Course have not been added.");
			}
			$this->data['title'] = $this->lang->line('build_session_course');

			$this->data['url']=$training_id;
			//course table data
			$courses=$this->Classroom_model->buildcourse($training_id);
			$this->data['courses']=$courses;
			$this->_render_page('lms_admin/training/add_courses', $this->data);
		}
	}

	public function add_sessions_to_training_assign($training_id,$session_id){
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$courslist = $this->Common_model->insert_info("ims_training_assign",array('lms_training_id'=>$training_id,'lms_sessions_id'=>$session_id));
			if($courslist){
				$this->session->set_flashdata('message', "Session added successfully.");
			}else{
				$this->session->set_flashdata('message', "Session have not been added.");
			}

			$this->data['title'] = $this->lang->line('build_session_session');
			$this->data['url']=$training_id;
			
			$sessions=$this->Classroom_model->buildsession($training_id);
			$this->data['sessions'] = $sessions;
			$this->_render_page('lms_admin/training/add_session', $this->data);
		}
	}

	public function add_video_to_training_assign($training_id,$video_id){
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$courslist = $this->Common_model->insert_info("ims_training_assign",array('lms_training_id'=>$training_id,'lms_video_id'=>$video_id));
			if($courslist){
				$this->session->set_flashdata('message', "Video added successfully.");
			}else{
				$this->session->set_flashdata('message', "Video have not been added.");
			}
			$this->data['url']=$training_id;

			$this->data['title'] = $this->lang->line('build_session_video');
			
			$videos=$this->Classroom_model->buildvideo($training_id);
			$this->data['videos'] = $videos;
			$this->_render_page('lms_admin/training/add_video', $this->data);
		}
	}

	public function add_assignment_to_training_assign($training_id,$assignment_id){
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$courslist = $this->Common_model->insert_info("ims_training_assign",array('lms_training_id'=>$training_id,'lms_assignment_id'=>$assignment_id));
			if($courslist){
				$this->session->set_flashdata('message', "Assignment added successfully.");
			}else{
				$this->session->set_flashdata('message', "Assignment have not been added.");
			}

			$this->data['url']=$training_id;
			
			$this->data['title'] = $this->lang->line('build_session_assignment');
			
			//assignment table data
			$assignments=$this->Classroom_model->buildassignment($training_id);
			$this->data['assignments'] = $assignments;
			$this->_render_page('lms_admin/training/add_assignment', $this->data);
		}
	}

	public function add_feedback_to_training_assign($training_id,$feedback_id){
		/*check login by role after login*/
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$courslist = $this->Common_model->insert_info("ims_training_assign",array('lms_training_id'=>$training_id,'lms_feedback_id'=>$feedback_id));
			if($courslist){
				$this->session->set_flashdata('message', "Feedback added successfully.");
			}else{
				$this->session->set_flashdata('message', "Feedback have not been added.");
			}

			$this->data['url']=$training_id;
			
			$this->data['title'] = $this->lang->line('build_session_feedback');
			
			//video table data
			$feedback=$this->Classroom_model->buildfeedback($training_id);
			$this->data['feedback'] = $feedback;
			$this->_render_page('lms_admin/training/add_feedback', $this->data);
		}
	}






	public function feedback_question($id)
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('feedback_question');
			
			$this->data['iddd']=$id;

			$feedbackquestionlist = $this->Common_model->select_info('lms_feedback_question',array('lms_feedback_id'=>$id));
			$data['feedbackname']= $this->Common_model->select_info('lms_feedback',array('lms_feedback_id'=>$id));

			$this->data['feedbackquestion'] = $feedbackquestionlist ;
			 $this->load->view('lms_admin/feedbackquestion/index',$this->data);

		}
	}

	public function add_feedback_question($id)
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('create_question');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('question_type', str_replace(':', '', $this->lang->line('index_question_type')), 'required');
				$this->form_validation->set_rules('question_name', str_replace(':', '', $this->lang->line('index_question_name')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'question_name' =>$this->input->post('question_name'),
						'question_type' =>$this->input->post('question_type'),
						'lms_feedback_id'=>$id,
						
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_feedback_question',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "question added successfully.");						
						redirect('lmsadmin/elearning/feedback_question/'.$id, 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['question_name'] = array('name' => 'question_name',
					'id' => 'question_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('question_name'),
				);
				$questiontype =array(
		               '1'=> 'Yes/No',
		               '2'=>'Likert',
		               '3'=>'True/False',
		               '4'=>'Free Text',
		               '5'=> 'Custom'
				);
				$this->data['question_type'] = array(
					'name' => 'question_type',
					'id' => 'question_type',
					'options' => 	$questiontype,
					'data-md-selectize'=>'',
					'selected' => set_value('question_type'),
				);
				$feedbacklist= $this->Common_model->select_feedback_name('lms_feedback',array('lms_feedback_id'=>$id));
				$this->data['feedback_name']=array('name' => 'feedback_name',
					'id' => 'feedback_name',
					'options' => 	$feedbacklist,
					'data-md-selectize'=>'',
					'value' => set_value('feedback_name'),
				);
				$this->data['back_id'] = $id;
				$this->load->view('lms_admin/feedbackquestion/add', $this->data);
		}
	}
		public function update_feedback_question($id,$fid)
	{
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else if(!$this->ion_auth->is_modules('LMS')){
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		}else{			
			$this->data['title'] = $this->lang->line('update_question');
			$feedbackquestionlist = $this->Common_model->select_info("lms_feedback_question",array('lms_feedback_question_id'=>$id));
			$feedbackquestionlist = $feedbackquestionlist[0];
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('question_type', str_replace(':', '', $this->lang->line('index_question_type')), 'required');
				$this->form_validation->set_rules('question_name', str_replace(':', '', $this->lang->line('index_question_name')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'question_name' =>$this->input->post('question_name'),
						'question_type' =>$this->input->post('question_type'),
						'lms_feedback_id'=>$fid
									);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_feedback_question',$data_arr,array('lms_feedback_question_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "question added successfully.");						
						redirect('lmsadmin/elearning/feedback_question/'.$fid, 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				
				$this->data['question_name'] = array('name' => 'question_name',
					'id' => 'question_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('question_name',$feedbackquestionlist['question_name'])
				);
				$questiontype =array(
		               '1'=> 'Yes/No',
		               '2'=>'Likert',
		               '3'=>'True/False',
		               '4'=>'Free Text',
		               '5'=> 'Custom'
				);
				$this->data['question_type'] = array(
					'name' => 'question_type',
					'id' => 'question_type',
					'options' => 	$questiontype,
					'data-md-selectize'=>'',
					'selected' => set_value('question_type',$feedbackquestionlist['question_type'])
				);
				$feedbacklist= $this->Common_model->select_feedback_name('lms_feedback',array('lms_feedback_id'=>$fid));
				$this->data['feedback_name']=array('name' => 'feedback_name',
					'id' => 'feedback_name',
					'options' => 	$feedbacklist,
					'data-md-selectize'=>'',
					'selected' => set_value('feedback_name'),
				);
	
				
				$this->data['back_id'] = $fid;
				$this->load->view('lms_admin/feedbackquestion/add', $this->data);
		}
		
	}



}

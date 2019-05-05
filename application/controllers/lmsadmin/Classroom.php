<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Classroom extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model("Classroom_model");
	}

	 /* View Training Categories
	 * @ GET all List
	 * @ prama Post 
	*/
	public function trainingcategories(){
		
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
			$this->data['title'] = $this->lang->line('training_cat');
			
			$training_categories = $this->Common_model->select_info("lms_training_categories");
			$this->data['training_categories'] = $training_categories;
			$this->_render_page('lms_admin/training_categories/index', $this->data);
		}
		 
	}
	
	/**
	 * Create a new Course
	 */
	public function addtrainingcat()
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
			$this->data['title'] = $this->lang->line('create_training_cat_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
				
				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_training_cat_name_th')), 'required');
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_training_categories',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Training Category added successfully.");						
						redirect('lmsadmin/classroom/trainingcategories', 'refresh');
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
					'value' => set_value('description'),
				);				
				
				$this->_render_page('lms_admin/training_categories/add', $this->data);
		}
		
		
	}
	


	
	/**
	 * Update user
	 */
	
	 public function updatetrainingcategory($id){

		if(!$this->Common_model->is_exits('lms_training_categories','lms_training_category_id',array('lms_training_category_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/courses', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_training_cat_heading');
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
			$training_category = $this->Common_model->select_info("lms_training_categories",array('lms_training_category_id'=>$id));
			$training_category = $training_category[0];
	
			// validate form input
			$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_training_cat_name_th')), 'required');
			
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
						'description'=>$this->input->post('description'),
						'updated_at'=>date('y-m-d'),
						'updated_by'=>$userId,
											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_training_categories',$data_arr,array('lms_training_category_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Training Category updated successfully.");						
						redirect('lmsadmin/classroom/trainingcategories', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('course_name',$training_category['name']),
				);
				
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('learning_objectives',$training_category['description']),
				);
				
				
				
				
				
				$this->data['lms_training_category_id'] = $training_category['lms_training_category_id'];
				$this->_render_page('lms_admin/training_categories/add', $this->data);
		}
		
	 }
	
	
	 /* View Videos
	 * @ GET all List
	 * @ prama Post 
	*/
	public function programs(){
		
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
			$this->data['title'] = $this->lang->line('program_heading');
			
			$programs = $this->Classroom_model->getprograms();
			$this->data['programs'] = $programs;
			$this->_render_page('lms_admin/programs/index', $this->data);
		}
		 
	}
	
	/**
	 * Create a new Video
	 */
	public function addprogram()
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
			$this->data['title'] = $this->lang->line('create_program_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('lms_training_category_id', str_replace(':', '', $this->lang->line('training_cat')), 'required');
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_program_name_th')), 'required');
				$this->form_validation->set_rules('status', str_replace(':', '', $this->lang->line('def_status')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'lms_training_category_id' =>$this->input->post('lms_training_category_id'),
						'status_id'=>$this->input->post('status'),
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_programs',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Program added successfully.");						
						redirect('lmsadmin/classroom/programs', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				
				$training_cat = $this->Common_model->select_info("lms_training_categories");
				if($training_cat){
					$options = array('' => 'Select One...');
					foreach($training_cat as $row){
						$name = $row['name'];
						$id = $row['lms_training_category_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_training_category_id'] = array(
					'name' => 'lms_training_category_id',
					'id' => 'lms_training_category_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_training_category_id'),
				);
			
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
				$this->_render_page('lms_admin/programs/add', $this->data);
		}
		
		
	}
	
	/**
	 * Update user
	 */
	
	 public function updateprogram($id){
		
		if(!$this->Common_model->is_exits('lms_programs','lms_program_id',array('lms_program_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/elearning/videos', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_program_heading');
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
			$program = $this->Common_model->select_info("lms_programs",array('lms_program_id'=>$id));
			$program = $program[0];
			
			
			$this->form_validation->set_rules('lms_training_category_id', str_replace(':', '', $this->lang->line('training_cat')), 'required');
			$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_program_name_th')), 'required');
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
						'name' =>$this->input->post('name'),
						'description' => $this->input->post('description'),
						'lms_training_category_id' =>$this->input->post('lms_training_category_id'),
						'status_id'=>$this->input->post('status'),
						'updated_at'=>date('y-m-d'),
						'updated_by'=>$userId,											
					);	
					
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_programs',$data_arr,array('lms_program_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Program updated successfully.");						
						redirect('lmsadmin/classroom/programs', 'refresh');
					}	
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				
				$training_cat = $this->Common_model->select_info("lms_training_categories");
				if($training_cat){
					$options = array('' => 'Select One...');
					foreach($training_cat as $row){
						$name = $row['name'];
						$id = $row['lms_training_category_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_training_category_id'] = array(
					'name' => 'lms_training_category_id',
					'id' => 'lms_training_category_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_training_category_id',$program['lms_training_category_id']),
				);
			
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name',$program['name']),
				);
				
				$this->data['description'] = array('name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'value' => set_value('description',$program['description']),
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
					'selected' => set_value('status',$program['status_id']),
				);
				$this->data['lms_program_id'] = $program['lms_program_id'];
				$this->_render_page('lms_admin/programs/add', $this->data);
		}
		
	 }	
	
	
	  /*
		add course,session,assignment,feedback
	 */
	public function buildsessions($lms_training_id){

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

			$this->data['url']=$lms_training_id;

			$this->data['title'] = $this->lang->line('build_training_sessions');
			$training_name=$this->Common_model->select_info('lms_training',array('lms_training_id'=>$lms_training_id));
			$this->data['training_name']=$training_name[0]['name'];
			$this->data['training_id']=$lms_training_id;
			$sessions = $this->Common_model->select_info("ims_training_assign",array('lms_training_id'=>$lms_training_id));
			$this->data['sessions'] = $sessions;
			//print_r($sessions);
			//course table data
			$courses=$this->Classroom_model->getcourse($lms_training_id);
			$this->data['courses']=$courses;
			//video table data
			$video=$this->Classroom_model->getvideo($lms_training_id);
			$this->data['video']=$video;
			//assignment table data
			$assignment=$this->Classroom_model->getassignment($lms_training_id);
			$this->data['assignment']=$assignment;
			//session table data
			$session=$this->Classroom_model->getsession($lms_training_id);
			$this->data['session']=$session;
			//feedback table data
			$feedback=$this->Classroom_model->getfeedback($lms_training_id);
			$this->data['feedback']=$feedback;
			//print_r($this->data);
			$this->_render_page('lms_admin/training/build_sessions', $this->data);
		}
	}
	

	public function addbatch($lms_training_id,$lms_sessions_id)
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
			$this->data['title'] = $this->lang->line('create_batch');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('batch_name', str_replace(':', '', $this->lang->line('index_batch_name')), 'required');
				$this->form_validation->set_rules('batch_start_date', str_replace(':', '', $this->lang->line('index_batch_start_date')), 'required');
				$this->form_validation->set_rules('batch_end_date', str_replace(':', '', $this->lang->line('index_batch_end_date')), 'required');
				$this->form_validation->set_rules('batch_vanue', str_replace(':', '', $this->lang->line('index_batch_vanue')), 'required');
				$this->form_validation->set_rules('batch_vandor', str_replace(':', '', $this->lang->line('index_batch_vandor')), 'required');
				$this->form_validation->set_rules('batch_seat_limit', str_replace(':', '', $this->lang->line('index_batch_seat_limit')), 'required');
				$this->form_validation->set_rules('batch_seat_occupied', str_replace(':', '', $this->lang->line('index_batch_seat_occupied')), 'required');
				$this->form_validation->set_rules('batch_waiting_list', str_replace(':', '', $this->lang->line('index_batch_waiting_list')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'lms_training_id'=>$lms_training_id,
						'lms_sessions_id'=>$lms_sessions_id,
						'lms_batch_name' =>$this->input->post('batch_name'),
						'lms_batch_start_date' => $this->input->post('batch_start_date'),
						'lms_batch_end_date' =>$this->input->post('batch_end_date'),
						'lms_batch_vanue' =>$this->input->post('batch_vanue'),
						'lms_batch_vandor'=>$this->input->post('batch_vandor'),
						'lms_batch_instructor'=>$this->input->post('batch_instructor'),
						'lms_batch_seat_limit'=>$this->input->post('batch_seat_limit'),
						'lms_batch_seat_occupied'=>$this->input->post('batch_seat_occupied'),
						'lms_batch_waiting_list'=>$this->input->post('batch_waiting_list'),
						'created_at'=>date('y-m-d h:m:s'),
						'created_by'=>$userId,											
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_batch',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "batch added successfully.");						
						redirect('lmsadmin/classroom/show_batch/'.$lms_training_id.'/'.$lms_sessions_id);
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['batch_name'] = array('name' => 'batch_name',
					'id' => 'batch_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('batch_name'),
				);
				
				$this->data['batch_start_date'] = array('name' => 'batch_start_date',
					'id' => 'batch_start_date',
					'type' => 'date',
					'value' => $this->form_validation->set_value('batch_start_date'),
				);
				$this->data['batch_end_date'] = array('name' => 'batch_end_date',
					'id' => 'batch_end_date',
					'type'=> 'date',
					'value' => $this->form_validation->set_value('batch_end_date'),
				);

				$vanue = $this->Common_model->select_info("lms_venue");
                if($vanue){
                    $options = array('' => 'Select One...');
                    foreach($vanue as $row){
                        $name = $row['venue_name'];
                        $id = $row['lms_venue_id'];
                        $options[$id] =$name;
                    } 
                }
                $this->data['batch_vanue'] = array(
                    'name' => 'batch_vanue',
                    'id' => 'batch_vanue',
                    'data-md-selectize'=>'',
                    'options' =>    $options,       
                    'selected' => $this->form_validation->set_value('lms_venue_id'),
                );

                $vandor = $this->Common_model->select_info("lms_vendor_type");
                if($vandor){
                    $options = array('' => 'Select One...');
                    foreach($vandor as $row){
                        $name = $row['vendor_type'];
                        $id = $row['lms_vendor_type_id'];
                        $options[$id] =$name;
                    } 
                }
                $this->data['batch_vandor'] = array(
                    'name' => 'batch_vandor',
                    'id' => 'batch_vandor',
                    'data-md-selectize'=>'',
                    'options' =>    $options,       
                    'selected' => $this->form_validation->set_value('lms_vendor_type_id'),
                );

				/*$this->data['batch_vandor'] = array('name' => 'batch_vandor',
					'id' => 'batch_vandor',
					'class'=>'md-input',
					'type'=> 'text',
					'value' => $this->form_validation->set_value('batch_vandor'),
				);*/
				$this->data['batch_instructor'] = array('name' => 'batch_instructor',
					'id' => 'batch_instructor',
					'class'=>'md-input',
					'type'=> 'dropdown',
					'value' => $this->form_validation->set_value('batch_instructor'),
				);
				$this->data['batch_seat_limit'] = array('name' => 'batch_seat_limit',
					'id' => 'batch_seat_limit',
					'class'=>'md-input',
					'type'=> 'text',
					'value' => $this->form_validation->set_value('batch_seat_limit'),
				);
				$this->data['batch_seat_occupied'] = array('name' => 'batch_seat_occupied',
					'id' => 'batch_seat_occupied',
					'class'=>'md-input',
					'type'=> 'text',
					'value' => $this->form_validation->set_value('batch_seat_occupied'),
				);
				$this->data['batch_waiting_list'] = array('name' => 'batch_waiting_list',
					'id' => 'batch_waiting_list',
					'class'=>'md-input',
					'type'=> 'text',
					'value' => $this->form_validation->set_value('batch_waiting_list'),
				);
				$this->data['lms_training_id']=$lms_training_id;
				$this->data['lms_sessions_id']=$lms_sessions_id;
				
				$this->_render_page('lms_admin/training/add_batch', $this->data);
		}
			
	}

	/*
		show detail of all courses
	*/
	public function show_batch($lms_training_id,$lms_sessions_id){
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
			$this->data['title'] = $this->lang->line('batch');
			$training_id=$this->Common_model->select_info('lms_training',array('lms_training_id'=>$lms_training_id));
			$this->data['training_id']=$lms_training_id;
			$session_id=$this->Common_model->select_info('lms_sessions',array('lms_sessions_id'=>$lms_sessions_id));
			$this->data['session_id']=$session_id;
			$batch = $this->Common_model->select_info("lms_batch",array('lms_training_id'=>$lms_training_id,'lms_sessions_id'=>$lms_sessions_id));
			$this->data['batch'] = $batch;
			
			
			$user=$this->Classroom_model->select_user($lms_training_id,$lms_sessions_id);
			$this->data['user']=$user;
			
			$this->_render_page('lms_admin/training/show/show_batches', $this->data);
		}
	}

	/*
		show detail of all courses
	*/
	public function show_course($training_id,$id){
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
			$this->data['title'] = $this->lang->line('show_course');
			$this->data['training_id']=$training_id;
			$detail = $this->Common_model->select_info("lms_courses",array('lms_course_id'=>$id));
			$this->data['detail'] = $detail;
			$this->_render_page('lms_admin/training/show/show_course', $this->data);
		}
	}

	/*
		show detail of all video
	*/
	public function show_video($training_id,$id){
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
			$this->data['title'] = $this->lang->line('show_video');
			$this->data['training_id']=$training_id;
			$detail = $this->Common_model->select_info("lms_videos",array('lms_video_id'=>$id));
			$this->data['detail'] = $detail;
			$this->_render_page('lms_admin/training/show/show_video', $this->data);
		}
	}
	
	/*
		show detail of all courses
	*/
	public function show_assignment($training_id,$id){
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
			$this->data['title'] = $this->lang->line('show_assignment');
			$this->data['training_id']=$training_id;
			$detail = $this->Common_model->select_info("lms_assignment",array('lms_assignment_id'=>$id));
			$this->data['detail'] = $detail;
			$this->_render_page('lms_admin/training/show/show_assignment', $this->data);
		}
	}

	/*
		show detail of all courses
	*/
	public function show_session($training_id,$id){
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
			$this->data['title'] = $this->lang->line('show_assignment');
			$this->data['training_id']=$training_id;
			$detail = $this->Common_model->select_info("lms_sessions",array('lms_sessions_id'=>$id));
			$this->data['detail'] = $detail;
			$this->_render_page('lms_admin/training/show/show_session', $this->data);
		}
	}

	/*
		show detail of all courses
	*/
	public function show_feedback($training_id,$id){
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
			$this->data['title'] = $this->lang->line('show_feedback');
			$this->data['training_id']=$training_id;
			$detail = $this->Common_model->select_info("lms_feedback",array('lms_feedback_id'=>$id));
			$this->data['detail'] = $detail;
			$this->_render_page('lms_admin/training/show/show_feedback', $this->data);
		}
	}


	
	
	
	
	/* View Assignment
	 * @ GET all List
	 * @ prama Post 
	*/
	public function sessions(){
		
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
			$this->data['title'] = $this->lang->line('session_management');
			
			$sessions = $this->Common_model->select_info("lms_sessions");
			$this->data['sessions'] = $sessions;
			$this->_render_page('lms_admin/sessions/index', $this->data);
		}
		 
	}
	
	
	
	/** addsession
	 * Create a new addsession
	 */
	public function addsession()
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
			$this->data['title'] = $this->lang->line('create_session_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('lms_program_id', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'lms_training_category_id'=>$this->input->post('lms_training_category_id'),
						'lms_program_id' => $this->input->post('lms_program_id'),
						'objective' => $this->input->post('objective'),
						'cpd_points ' =>$this->input->post('cpd_points'),										
						'created_at'=>date('y-m-d'),
						'created_by'=>$userId,
					);
					
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_sessions',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Session added successfully.");						
						redirect('lmsadmin/classroom/sessions', 'refresh');
					}	
					
					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				
				$training = $this->Common_model->select_info("lms_training_categories");
				if($training){
					$options = array('' => 'Select One...');
					foreach($training as $row){
						$name = $row['name'];
						$id = $row['lms_training_category_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_training_category_id'] = array(
					'name' => 'lms_training_category_id',
					'id' => 'lms_training_category_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_training_category_id'),
				);

				$programs = $this->Common_model->select_info("lms_programs");
				if($programs){
					$options = array('' => 'Select One...');
					foreach($programs as $row){
						$name = $row['name'];
						$id = $row['lms_program_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_program_id'] = array(
					'name' => 'lms_program_id',
					'id' => 'lms_program_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_program_id'),
				);
				
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name'),
				);
				$this->data['objective'] = array('name' => 'objective',
					'id' => 'objective',
					'class'=>'md-input',
					'value' => set_value('objective'),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points'),
				);	
				$this->_render_page('lms_admin/sessions/add', $this->data);
		}
		
		
	}
	
	
	
	
	
	
	
	/**
	 * Edit and Update Session
	 */
	public function updatesession($id)
	{
		if(!$this->Common_model->is_exits('lms_sessions','lms_sessions_id',array('lms_sessions_id'=>$id))){
			$this->session->set_flashdata('message', "Somthing error!, Please try again");		
			redirect('lmsadmin/classroom/sessions', 'refresh');
		}
		
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
			$this->data['title'] = $this->lang->line('edit_session_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
			
				// validate form input
				$this->form_validation->set_rules('lms_program_id', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_assign_name_th')), 'required');
			
				if ($this->form_validation->run() === TRUE)
				{
					$data_arr = array(
						'name' =>$this->input->post('name'),
						'lms_training_category_id'=>$this->input->post('lms_training_category_id'),
						'lms_program_id' => $this->input->post('lms_program_id'),
						'objective' => $this->input->post('objective'),
						'cpd_points ' =>$this->input->post('cpd_points'),										
						'updated_at'=>date('y-m-d'),
						'updated_by'=>$userId,
					);			
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_sessions',$data_arr,array('lms_sessions_id'=>$id));
					if($insert_id){
						$this->session->set_flashdata('message', "Session updated successfully.");						
						redirect('lmsadmin/classroom/sessions', 'refresh');
					}	
					
					
				}
			}
			$sessions = $this->Common_model->select_info("lms_sessions",array('lms_sessions_id'=>$id));
			$sessions = $sessions[0];
			
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				
				$training = $this->Common_model->select_info("lms_training_categories");
				if($training){
					$options = array('' => 'Select One...');
					foreach($training as $row){
						$name = $row['name'];
						$id = $row['lms_training_category_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_training_category_id'] = array(
					'name' => 'lms_training_category_id',
					'id' => 'lms_training_category_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_training_category_id',$sessions['lms_training_category_id']),
				);

				$programs = $this->Common_model->select_info("lms_programs");
				if($programs){
					$options = array('' => 'Select One...');
					foreach($programs as $row){
						$name = $row['name'];
						$id = $row['lms_program_id'];
							$options[$id] =$name;
						} 
				}
				
	
				$this->data['lms_program_id'] = array(
					'name' => 'lms_program_id',
					'id' => 'lms_program_id',
					'data-md-selectize'=>'',
					'options' => 	$options,		
					'selected' => $this->form_validation->set_value('lms_program_id',$sessions['lms_program_id']),
				);
				
				$this->data['name'] = array('name' => 'name',
					'id' => 'name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name',$sessions['name']),
				);
				$this->data['objective'] = array('name' => 'objective',
					'id' => 'objective',
					'class'=>'md-input',
					'value' => set_value('objective',$sessions['objective']),
				);
				
				$this->data['cpd_points'] = array('name' => 'cpd_points',
					'id' => 'cpd_points',
					'class'=>'md-input',
					'type' => 'text',
					'value' => set_value('cpd_points',$sessions['cpd_points']),
				);	
				$this->_render_page('lms_admin/sessions/add', $this->data);
		}		
	}
	
	
	/* View Batches
	 * @ GET all List
	 * @ prama Post 
	*/
	public function batches(){
		
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
			$this->data['title'] = $this->lang->line('batches_heading');
			
			$sessions = $this->Common_model->select_info("lms_sessions");
			$this->data['sessions'] = $sessions;
			$this->_render_page('lms_admin/sessions/index', $this->data);
		}
		 
	}

	
	/*
		add training
	*/
	public function addtraining()
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
			$this->data['title'] = $this->lang->line('create_training_heading');
			
			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					show_error($this->lang->line('error_csrf'));
				}
				
				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('index_training_cat_name_th')), 'required');
				if ($this->form_validation->run() === TRUE)
				{

					$data_arr = array(
						'name' =>$this->input->post('name'),
						'reference_name' =>$this->input->post('reference_name'),
						'description' =>$this->input->post('description'),
						'start_date' =>$this->input->post('start_date'),
						'end_date' =>$this->input->post('end_date'),
						'seat_time' =>$this->input->post('seat_time'),
						'lms_training_chat' =>$this->input->post('status'),
						'lms_training_cost' =>$this->input->post('lms_training_cost'),
						'currency' =>$this->input->post('currency'),
						'trainer' =>$this->input->post('trainer'),
						'certification' =>$this->input->post('certification'),
						'rights' =>$this->input->post('rights'),
						'status_id' =>$this->input->post('status_id'),
						'type' =>$this->input->post('type'),
						'image' =>$this->input->post('image'),
						'video' =>$this->input->post('video'),
						'url' =>$this->input->post('url'),
						'documunt' =>$this->input->post('document'),
						'created_at'=>date('y-m-d'),						
						'created_by'=>$userId,
					);				
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_training',$data_arr);
					if($insert_id){
						$this->session->set_flashdata('message', "Training Category added successfully.");						
						redirect('lmsadmin/classroom/training', 'refresh');
					}					
				}
			}
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');


				$this->data['name'] = array(
					'name' => 'name',
					'id' => 'name',	
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('name'),
				);
				$this->data['reference_name'] = array(
					'name' => 'reference_name',
					'id' => 'reference_name',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('reference_name'),
				);
				$this->data['description'] = array(
					'name' => 'description',
					'id' => 'description',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('description'),
				);
				$this->data['starting_date'] = array(
					'name' => 'start_date',
					'id' => 'starting_date',
					'class'=>'md-input',
					'type' => 'date',
					'value' => $this->form_validation->set_value('starting_date'),
				);

				$this->data['ending_date'] = array(
					'name' => 'end_date',
					'id' => 'ending_date',
					'class'=>'md-input',
					'type' => 'date',
					'value' => $this->form_validation->set_value('ending_date'),
				);

				$this->data['seat_time'] = array(
					'name' => 'seat_time',
					'id' => 'seat_time',
					'class'=>'md-input',
					'type' => 'time',
					'value' => $this->form_validation->set_value('seat_time'),
				);
				
				$this->data['duration'] = array('name' => 'duration',
					'id' => 'duration',
					'class'=>'md-input',
					'value' => set_value('duration'),
				);

				$chat = array(
						'1'         => 'Active',
						'0'           => 'In Active'						
					);
				$this->data['chat'] = array(
					'name' => 'status',
					'id' => 'chat',
					'options' => 	$chat,
					'data-md-selectize'=>'',
					'selected' => set_value('chat'),
				);


				$this->data['cost'] = array(
					'name' => 'lms_training_cost',
					'id' => 'cost',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('cost'),
				);	


				$this->data['currency'] = array(
					'name' => 'currency',
					'id' => 'currency',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('currency'),
				);

				$this->data['trainer'] = array(
					'name' => 'trainer',
					'id' => 'trainer',
					'class'=>'md-input',
					'type' => 'dropdown',
					'value' => $this->form_validation->set_value('trainer'),
				);	

				$certification = array(
						'1'         => 'Active',
						'0'           => 'In Active'						
					);
				$this->data['certification'] = array(
					'name' => 'status',
					'id' => 'certification',
					'options' => 	$certification,
					'data-md-selectize'=>'',
					'selected' => set_value('certification'),
				);

				$this->data['rights'] = array(
					'name' => 'rights',
					'id' => 'rights',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('rights'),
				);	


				$status_id = array(
						'1'         => 'Active',
						'0'           => 'In Active'						
					);
				$this->data['status_id'] = array(
					'name' => 'status',
					'id' => 'status_id',
					'options' => 	$status_id,
					'data-md-selectize'=>'',
					'selected' => set_value('status_id'),
				);

								
				
				$type = array(
						'1'         => 'Images',
						'0'           => 'Videos'						
					);
				$this->data['type'] = array(
					'name' => 'type',
					'id' => 'val_select',
					'options' => 	$type,
					'data-md-selectize'=>'',
					'selected' => set_value('type'),
				);
				$this->data['image'] = array(
					'name' => 'image',
					'id' => 'image',
					'type'=>'file',
					'value' => set_value('image'),
				);
				$this->data['video'] = array(
					'name' => 'video',
					'id' => 'video',
					'type'=> 'text',
					'value' => set_value('video'),
				);

				$this->data['url'] = array(
					'name' => 'url',
					'id' => 'url',
					'class'=>'md-input',
					'type' => 'text',
					'value' => $this->form_validation->set_value('url'),
				);

				$this->data['document'] = array(
					'name' => 'document',
					'id' => 'document',
					'class'=>'md-input',
					'type' => 'file',
					'value' => $this->form_validation->set_value('document'),
				);	

				$this->_render_page('lms_admin/training/add', $this->data);
		}
		
		
	}

	public function training(){

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
			$this->data['title'] = $this->lang->line('training_heading');
			
			$training_categories = $this->Common_model->select_info("lms_training");
			$this->data['training_categories'] = $training_categories;
			$this->_render_page('lms_admin/training/index', $this->data);
		}
	}
	

	/*
		User table show
	*/
	public function show_users($lms_training_id,$lms_sessions_id,$lms_batch_id){
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
			$this->data['title'] = $this->lang->line('UserS');
			$this->data['lms_training_id']=$lms_training_id;
			$this->data['lms_sessions_id']=$lms_sessions_id;
			$this->data['lms_batch_id']=$lms_batch_id;
			
			$users = $this->Classroom_model->add_user($lms_training_id,$lms_sessions_id,$lms_batch_id);
			$this->data['users'] = $users;
			$this->_render_page('lms_admin/training/add_users', $this->data);
			//redirect('lmsadmin/classroom/show_users/'.$lms_training_id.'/'.$lms_sessions_id.'/'.$lms_batch_id);
		}
	}
	

	public function add_user_into_user_id_table($lms_training_id,$lms_sessions_id,$lms_batch_id,$user_id)
	{
		/*check login by role after login*/
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
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$admin=$this->Common_model->select_info('users',array('id'=>$userId));
			$admin_name=$admin[0]['username'];
			$user_arr=array(
				'lms_training_id'=>$lms_training_id,
				'lms_sessions_id'=>$lms_sessions_id,
				'lms_batch_id'=>$lms_batch_id,
				'id'=>$user_id,
				'created_at'=>date("l jS \of F Y"),
				'created_by'=>$admin_name
			);

			$courslist = $this->Common_model->insert_info("lms_add_user_info",$user_arr);
			if($courslist){
				$this->session->set_flashdata('message', "User added successfully.");
			}else{
				$this->session->set_flashdata('message', "User have not been added.");
			}

			
			redirect('lmsadmin/classroom/show_users/'.$lms_training_id.'/'.$lms_sessions_id.'/'.$lms_batch_id);
		}
		
	}
	/**
	 * @return array A CSRF key-value pair
	 */
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

}

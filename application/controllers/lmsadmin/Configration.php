<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Configration extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model("Classroom_model");
	}

	/* View inventory
		 * @ GET all List
		 * @ prama Post
	*/
	public function inventory() {

		/*check login by role after login*/
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('inventory_heading');

			$inventory = $this->Common_model->select_info("lms_inventory");
			$this->data['inventory'] = $inventory;
			$this->_render_page('lms_admin/inventory/index', $this->data);
		}

	}

	/**
	 * Create a new inventory
	 */
	public function addinventory() {
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['title'] = $this->lang->line('create_inventory_heading');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE) {
					show_error($this->lang->line('error_csrf'));
				}

				// validate form input
				$this->form_validation->set_rules('inventory_name', str_replace(':', '', $this->lang->line('index_training_cat_name_th')), 'required');
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'inventory_name' => $this->input->post('inventory_name'),
						'description' => $this->input->post('description'),
						'created_at' => date('y-m-d'),
						'created_by' => $userId,
					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_inventory', $data_arr);
					if ($insert_id) {
						$this->session->set_flashdata('message', "Inventory added successfully.");
						redirect('lmsadmin/configration/inventory', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['inventory_name'] = array('name' => 'inventory_name',
				'id' => 'inventory_name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('inventory_name'),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('description'),
			);

			$this->_render_page('lms_admin/inventory/add', $this->data);
		}

	}

	/**
	 * Update inventory
	 */

	public function updateinventory($id) {
		if (!$this->Common_model->is_exits('lms_inventory', 'lms_inventory_id', array('lms_inventory_id' => $id))) {
			$this->session->set_flashdata('message', "Somthing error!, Please try again");
			redirect('lmsadmin/configration/inventory', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_inventory_heading');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$inventory = $this->Common_model->select_info("lms_inventory", array('lms_inventory_id' => $id));
			$inventory = $inventory[0];

			// validate form input
			$this->form_validation->set_rules('inventory_name', str_replace(':', '', $this->lang->line('index_inventory_name_th')), 'required');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'inventory_name' => $this->input->post('inventory_name'),
						'description' => $this->input->post('description'),
						'updated_at' => date('y-m-d'),
						'updated_by' => $userId,

					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_inventory', $data_arr, array('lms_inventory_id' => $id));
					if ($insert_id) {
						$this->session->set_flashdata('message', "Inventory updated successfully.");
						redirect('lmsadmin/configration/inventory', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['inventory_name'] = array('name' => 'inventory_name',
				'id' => 'name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('inventory_name', $inventory['inventory_name']),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('learning_objectives', $inventory['description']),
			);

			$this->data['lms_inventory_id'] = $inventory['lms_inventory_id'];
			$this->_render_page('lms_admin/inventory/add', $this->data);
		}

	}

	/* View Venues
		 * @ GET all List
		 * @ prama Post
	*/
	public function venues() {

		/*check login by role after login*/
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('venues_heading');

			$venue = $this->Common_model->select_info("lms_venue");
			$this->data['venue'] = $venue;
			$this->_render_page('lms_admin/venues/index', $this->data);
		}

	}

	/**
	 * Create a new Venues
	 */
	public function addvenues() {
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['title'] = $this->lang->line('create_venues_heading');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE) {
					show_error($this->lang->line('error_csrf'));
				}

				// validate form input
				$this->form_validation->set_rules('venue_name', str_replace(':', '', $this->lang->line('v_name')), 'required');
				$this->form_validation->set_rules('seat_limit', str_replace(':', '', $this->lang->line('v_seat_limit')), 'required');
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'venue_name' => $this->input->post('venue_name'),
						'description' => $this->input->post('description'),
						'site_location' => $this->input->post('site_location'),
						'facility_type' => $this->input->post('facility_type'),
						'training_room_detail' => $this->input->post('training_room_detail'),
						'address' => $this->input->post('address'),
						'mail_id' => $this->input->post('mail_id'),
						'phone_no' => $this->input->post('phone_no'),
						'equipments_available' => $this->input->post('equipments_available'),
						'directions' => $this->input->post('directions'),
						'seat_limit' => $this->input->post('seat_limit'),
						'cost' => $this->input->post('cost'),
						'created_at' => date('y-m-d'),
						'created_by' => $userId,
					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_venue', $data_arr);
					if ($insert_id) {
						$this->session->set_flashdata('message', "Venue added successfully.");
						redirect('lmsadmin/configration/venues', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['venue_name'] = array('name' => 'venue_name',
				'id' => 'venue_name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('venue_name'),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('description'),
			);
			$this->data['site_location'] = array('name' => 'site_location',
				'id' => 'site_location',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('site_location'),
			);

			$this->data['training_room_detail'] = array('name' => 'training_room_detail',
				'id' => 'training_room_detail',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('training_room_detail'),
			);

			$this->data['address'] = array('name' => 'address',
				'id' => 'address',
				'class' => 'md-input',
				'value' => set_value('address'),
			);
			$this->data['mail_id'] = array('name' => 'mail_id',
				'id' => 'mail_id',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('mail_id'),
			);
			$this->data['phone_no'] = array('name' => 'phone_no',
				'id' => 'phone_no',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone_no'),
			);
			$this->data['equipments_available'] = array('name' => 'equipments_available',
				'id' => 'equipments_available',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('equipments_available'),
			);
			$this->data['directions'] = array('name' => 'directions',
				'id' => 'directions',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('directions'),
			);
			$this->data['seat_limit'] = array('name' => 'seat_limit',
				'id' => 'seat_limit',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('seat_limit'),
			);
			$this->data['cost'] = array('name' => 'cost',
				'id' => 'cost',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cost'),
			);

			$this->_render_page('lms_admin/venues/add', $this->data);
		}

	}

	//update veneu

	public function update_venues($id) {
		if (!$this->Common_model->is_exits('lms_venue', 'lms_venue_id', array('lms_venue_id' => $id))) {
			$this->session->set_flashdata('message', "Somthing error!, Please try again");
			redirect('lmsadmin/configration/venues', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_venues_heading');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$venues_type = $this->Common_model->select_info("lms_venue", array('lms_venue_id' => $id));
			$venues_type = $venues_type[0];

			// validate form input
			$this->form_validation->set_rules('venue_name', str_replace(':', '', $this->lang->line('v_name')), 'required');
			$this->form_validation->set_rules('seat_limit', str_replace(':', '', $this->lang->line('v_seat_limit')), 'required');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'venue_name' => $this->input->post('venue_name'),
						'description' => $this->input->post('description'),
						'site_location' => $this->input->post('site_location'),
						'facility_type' => $this->input->post('facility_type'),
						'training_room_detail' => $this->input->post('training_room_detail'),
						'address' => $this->input->post('address'),
						'mail_id' => $this->input->post('mail_id'),
						'phone_no' => $this->input->post('phone_no'),
						'equipments_available' => $this->input->post('equipments_available'),
						'directions' => $this->input->post('directions'),
						'seat_limit' => $this->input->post('seat_limit'),
						'cost' => $this->input->post('cost'),
						'updated_at' => date('y-m-d'),
						'updated_by' => $userId,

					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_venue', $data_arr, array('lms_venue_id' => $id));
					if ($insert_id) {
						$this->session->set_flashdata('message', "Venue updated successfully.");
						redirect('lmsadmin/configration/venues', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['venue_name'] = array('name' => 'venue_name',
				'id' => 'venue_name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('venue_name', $venues_type['venue_name']),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('description', $venues_type['description']),
			);
			$this->data['site_location'] = array('name' => 'site_location',
				'id' => 'site_location',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('site_location', $venues_type['site_location']),
			);

			$this->data['training_room_detail'] = array('name' => 'training_room_detail',
				'id' => 'training_room_detail',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('training_room_detail', $venues_type['training_room_detail']),
			);

			$this->data['address'] = array('name' => 'address',
				'id' => 'address',
				'class' => 'md-input',
				'value' => set_value('address', $venues_type['address']),
			);
			$this->data['mail_id'] = array('name' => 'mail_id',
				'id' => 'mail_id',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('mail_id', $venues_type['mail_id']),
			);
			$this->data['phone_no'] = array('name' => 'phone_no',
				'id' => 'phone_no',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone_no', $venues_type['phone_no']),
			);
			$this->data['equipments_available'] = array('name' => 'equipments_available',
				'id' => 'equipments_available',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('equipments_available', $venues_type['equipments_available']),
			);
			$this->data['directions'] = array('name' => 'directions',
				'id' => 'directions',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('directions', $venues_type['directions']),
			);
			$this->data['seat_limit'] = array('name' => 'seat_limit',
				'id' => 'seat_limit',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('seat_limit', $venues_type['seat_limit']),
			);
			$this->data['cost'] = array('name' => 'cost',
				'id' => 'cost',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cost', $venues_type['cost']),
			);

			$this->data['lms_venue_id'] = $venues_type['lms_venue_id'];
			$this->_render_page('lms_admin/venues/add', $this->data);
		}

	}

	/* View Vendor Type
		 * @ GET all List
		 * @ prama Post
	*/
	public function vendortype() {

		/*check login by role after login*/
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('vendortype_heading');

			$vendor_type = $this->Common_model->select_info("lms_vendor_type");
			$this->data['vendor_type'] = $vendor_type;
			$this->_render_page('lms_admin/vendortype/index', $this->data);
		}

	}

	/**
	 * Create a new Vendor Type
	 */
	public function addvendortype() {
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['title'] = $this->lang->line('create_vendortype_heading');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE) {
					show_error($this->lang->line('error_csrf'));
				}

				// validate form input
				$this->form_validation->set_rules('vendor_type', str_replace(':', '', $this->lang->line('vt_name')), 'required');
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'vendor_type' => $this->input->post('vendor_type'),
						'description' => $this->input->post('description'),
						'created_at' => date('y-m-d'),
						'created_by' => $userId,
					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_vendor_type', $data_arr);
					if ($insert_id) {
						$this->session->set_flashdata('message', "Vendor Type added successfully.");
						redirect('lmsadmin/configration/vendortype', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['vendor_type'] = array('name' => 'vendor_type',
				'id' => 'inventory_name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('vendor_type'),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('description'),
			);

			$this->_render_page('lms_admin/vendortype/add', $this->data);
		}

	}

	/**
	 * Update Vendor Type
	 */

	public function updatevendortype($id) {
		if (!$this->Common_model->is_exits('lms_vendor_type', 'lms_vendor_type_id', array('lms_vendor_type_id' => $id))) {
			$this->session->set_flashdata('message', "Somthing error!, Please try again");
			redirect('lmsadmin/configration/vendortype', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_vendortype_heading');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$vendor_type = $this->Common_model->select_info("lms_vendor_type", array('lms_vendor_type_id' => $id));
			$vendor_type = $vendor_type[0];

			// validate form input
			$this->form_validation->set_rules('vendor_type', str_replace(':', '', $this->lang->line('vt_name')), 'required');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'vendor_type' => $this->input->post('vendor_type'),
						'description' => $this->input->post('description'),
						'updated_at' => date('y-m-d'),
						'updated_by' => $userId,

					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_vendor_type', $data_arr, array('lms_vendor_type_id' => $id));
					if ($insert_id) {
						$this->session->set_flashdata('message', "Vendor Type updated successfully.");
						redirect('lmsadmin/configration/vendortype', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['vendor_type'] = array('name' => 'vendor_type',
				'id' => 'name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('vendor_type', $vendor_type['vendor_type']),
			);

			$this->data['description'] = array('name' => 'description',
				'id' => 'description',
				'class' => 'md-input',
				'value' => set_value('learning_objectives', $vendor_type['description']),
			);

			$this->data['lms_vendor_type_id'] = $vendor_type['lms_vendor_type_id'];
			$this->_render_page('lms_admin/vendortype/add', $this->data);
		}

	}

	/* View Vendors
		 * @ GET all List
		 * @ prama Post
	*/
	public function vendors() {

		/*check login by role after login*/
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['title'] = $this->lang->line('vendors_heading');

			$vendors = $this->Common_model->select_info("lms_vendors");
			$this->data['vendors'] = $vendors;
			$this->_render_page('lms_admin/vendors/index', $this->data);
		}

	}

	/**
	 * Create a new Vendor
	 */
	public function addvendors() {
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$this->data['title'] = $this->lang->line('create_vendors_heading');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE) {
					show_error($this->lang->line('error_csrf'));
				}

				// validate form input
				$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('vt_name')), 'required');
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'name' => $this->input->post('name'),
						'lms_vendor_type_id' => $this->input->post('lms_vendor_type_id'),
						'address' => $this->input->post('address'),
						'contact_person' => $this->input->post('contact_person'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'remark' => $this->input->post('remark'),
						'created_at' => date('y-m-d'),
						'created_by' => $userId,
					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->insert_info('lms_vendors', $data_arr);
					if ($insert_id) {
						$this->session->set_flashdata('message', "Vendors added successfully.");
						redirect('lmsadmin/configration/vendors', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$training_cat = $this->Common_model->select_info("lms_vendor_type");
			if ($training_cat) {
				$options = array('' => 'Select One...');
				foreach ($training_cat as $row) {
					$name = $row['vendor_type'];
					$id = $row['lms_vendor_type_id'];
					$options[$id] = $name;
				}
			}

			$this->data['lms_vendor_type_id'] = array(
				'name' => 'lms_vendor_type_id',
				'id' => 'lms_vendor_type_id',
				'data-md-selectize' => '',
				'options' => $options,
				'selected' => $this->form_validation->set_value('lms_vendor_type_id'),
			);

			$this->data['name'] = array('name' => 'name',
				'id' => 'name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);

			$this->data['address'] = array('name' => 'address',
				'id' => 'address',
				'class' => 'md-input',
				'value' => set_value('address'),
			);

			$this->data['contact_person'] = array('name' => 'contact_person',
				'id' => 'contact_person',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('contact_person'),
			);
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);

			$this->data['remark'] = array('name' => 'remark',
				'id' => 'remark',
				'class' => 'md-input',
				'value' => set_value('remark'),
			);

			$this->_render_page('lms_admin/vendors/add', $this->data);
		}

	}

	public function update_vendors($id) {
		if (!$this->Common_model->is_exits('lms_vendors', 'lms_vendors_id', array('lms_vendors_id' => $id))) {
			$this->session->set_flashdata('message', "Somthing error!, Please try again");
			redirect('lmsadmin/configration/vendors', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_vendors_heading');
		$userId = $this->ion_auth->get_user_id();
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else if (!$this->ion_auth->is_modules('LMS')) {
			// Showing error  because they must be LMS  to view this
			return show_error('You must be an administrator to view this page LMS.');
		} else {
			$vendors = $this->Common_model->select_info("lms_vendors", array('lms_vendors_id' => $id));
			$vendors = $vendors[0];

			// validate form input
			$this->form_validation->set_rules('name', str_replace(':', '', $this->lang->line('vt_name')), 'required');

			if (isset($_POST) && !empty($_POST)) {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}
				if ($this->form_validation->run() === TRUE) {
					$data_arr = array(
						'name' => $this->input->post('name'),
						'lms_vendor_type_id' => $this->input->post('lms_vendor_type_id'),
						'address' => $this->input->post('address'),
						'contact_person' => $this->input->post('contact_person'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'remark' => $this->input->post('remark'),
						'created_at' => date('y-m-d'),
						'created_by' => $userId,

					);
					$data_arr = $this->security->xss_clean($data_arr);
					$insert_id = $this->Common_model->update_info('lms_vendors', $data_arr, array('lms_vendors_id' => $id));
					if ($insert_id) {
						$this->session->set_flashdata('message', "Vendors updated successfully.");
						redirect('lmsadmin/configration/vendors', 'refresh');
					}
				}
			}
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$training_cat = $this->Common_model->select_info("lms_vendor_type");
			if ($training_cat) {
				$options = array('' => 'Select One...');
				foreach ($training_cat as $row) {
					$name = $row['vendor_type'];
					$id = $row['lms_vendor_type_id'];
					$options[$id] = $name;
				}
			}

			$this->data['lms_vendor_type_id'] = array(
				'name' => 'lms_vendor_type_id',
				'id' => 'lms_vendor_type_id',
				'data-md-selectize' => '',
				'options' => $options,
				'selected' => $this->form_validation->set_value('lms_vendor_type_id', $vendors['lms_vendor_type_id']),
			);

			$this->data['name'] = array('name' => 'name',
				'id' => 'name',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name', $vendors['name']),
			);

			$this->data['address'] = array('name' => 'address',
				'id' => 'address',
				'class' => 'md-input',
				'value' => set_value('address', $vendors['address']),
			);

			$this->data['contact_person'] = array('name' => 'contact_person',
				'id' => 'contact_person',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('contact_person', $vendors['contact_person']),
			);
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email', $vendors['email']),
			);
			$this->data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'class' => 'md-input',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone', $vendors['phone']),
			);

			$this->data['remark'] = array('name' => 'remark',
				'id' => 'remark',
				'class' => 'md-input',
				'value' => set_value('remark', $vendors['remark']),
			);

			$this->data['lms_vendors_id'] = $vendors['lms_vendors_id'];
			$this->_render_page('lms_admin/vendors/add', $this->data);
		}

	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce() {
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
	public function _valid_csrf_nonce() {
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
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
	public function _render_page($view, $data = NULL, $returnhtml = FALSE) //I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml) {
			return $view_html;
		}
	}

}

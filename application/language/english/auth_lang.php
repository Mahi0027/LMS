<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Default strings
$lang['def_status']         = 'Status';
$lang['def_action'] = 'Actions';

// Login
$lang['login_heading']         = 'Login';
$lang['login_subheading']      = 'Please login with your email/username and password below.';
$lang['login_identity_label']  = 'Email/Username:';
$lang['login_password_label']  = 'Password:';
$lang['login_remember_label']  = 'Remember Me:';
$lang['login_submit_btn']      = 'Login';
$lang['login_forgot_password'] = 'Forgot your password?';

// Index
$lang['index_heading']           = 'Users';
$lang['index_subheading']        = 'Below is a list of the users.';
$lang['index_fname_th']          = 'First Name';
$lang['index_lname_th']          = 'Last Name';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Groups';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Action';
$lang['index_active_link']       = '<i class="material-icons md-color-light-blue-600 md-24"></i>';
$lang['index_inactive_link']     = '<i class="material-icons md-color-red-300 md-24">remove_circle</i>';
$lang['index_create_user_link']  = 'Create a new user';
$lang['index_create_group_link'] = 'Create a new group';

// Deactivate User
$lang['deactivate_heading']                  = 'Deactivate User';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Yes:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Create User';
$lang['create_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['create_user_fname_label']                       = 'First Name:';
$lang['create_user_lname_label']                       = 'Last Name:';
$lang['create_user_company_label']                     = 'Company Name:';
$lang['create_user_identity_label']                    = 'Identity:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Phone:';
$lang['create_user_password_label']                    = 'Password:';
$lang['create_user_password_confirm_label']            = 'Confirm Password:';
$lang['create_user_submit_btn']                        = 'Create User';
$lang['create_user_validation_fname_label']            = 'First Name';
$lang['create_user_validation_lname_label']            = 'Last Name';
$lang['create_user_validation_identity_label']         = 'Identity';
$lang['create_user_validation_email_label']            = 'Email Address';
$lang['create_user_validation_phone_label']            = 'Phone';
$lang['create_user_validation_company_label']          = 'Company Name';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Password Confirmation';

// Edit User
$lang['edit_user_heading']                           = 'Edit User';
$lang['edit_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['edit_user_fname_label']                       = 'First Name:';
$lang['edit_user_lname_label']                       = 'Last Name:';
$lang['edit_user_company_label']                     = 'Company Name:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Phone:';
$lang['edit_user_password_label']                    = 'Password: (if changing password)';
$lang['edit_user_password_confirm_label']            = 'Confirm Password: (if changing password)';
$lang['edit_user_groups_heading']                    = 'Member of groups';
$lang['edit_user_submit_btn']                        = 'Save User';
$lang['edit_user_validation_fname_label']            = 'First Name';
$lang['edit_user_validation_lname_label']            = 'Last Name';
$lang['edit_user_validation_email_label']            = 'Email Address';
$lang['edit_user_validation_phone_label']            = 'Phone';
$lang['edit_user_validation_company_label']          = 'Company Name';
$lang['edit_user_validation_groups_label']           = 'Groups';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Password Confirmation';
$lang['edit_video_button']							 ='Edit Video';	

// Create Group
$lang['create_group_title']                  = 'Create Group';
$lang['create_group_heading']                = 'Create Group';
$lang['create_group_subheading']             = 'Please enter the group information below.';
$lang['create_group_name_label']             = 'Group Name:';
$lang['create_group_desc_label']             = 'Description:';
$lang['create_group_submit_btn']             = 'Create Group';
$lang['create_group_validation_name_label']  = 'Group Name';
$lang['create_group_validation_desc_label']  = 'Description';

// Edit Group
$lang['edit_group_title']                  = 'Edit Group';
$lang['edit_group_saved']                  = 'Group Saved';
$lang['edit_group_heading']                = 'Edit Group';
$lang['edit_group_subheading']             = 'Please enter the group information below.';
$lang['edit_group_name_label']             = 'Group Name:';
$lang['edit_group_desc_label']             = 'Description:';
$lang['edit_group_submit_btn']             = 'Save Group';
$lang['edit_group_validation_name_label']  = 'Group Name';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Change Password';
$lang['change_password_old_password_label']                    = 'Old Password:';
$lang['change_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['change_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['change_password_submit_btn']                            = 'Change';
$lang['change_password_validation_old_password_label']         = 'Old Password';
$lang['change_password_validation_new_password_label']         = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot Password';
$lang['forgot_password_subheading']              = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_identity_label'] = 'Identity';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'No record of that email address.';
$lang['forgot_password_identity_not_found']         = 'No record of that username.';

// Reset Password
$lang['reset_password_heading']                               = 'Change Password';
$lang['reset_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['reset_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['reset_password_submit_btn']                            = 'Change';
$lang['reset_password_validation_new_password_label']         = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';



// Course Index
$lang['course_management']           = 'Course Management';
$lang['index_coursename_th']          = 'Course Name';
$lang['index_refname_th']								='Reference Name';
$lang['index_objective_th']								='Objective';
$lang['index_seat_time_th']								='Seat Time';
$lang['index_description_th']							='Description';
$lang['index_status_th']								='Status';
$lang['index_cpd_point_th']								='CPD Point';
$lang['index_created_at_th']							='Created At';
$lang['index_created_by_th']							='Created By';
$lang['index_updated_at_th']							='Updated At';
$lang['index_updted_by_th']								='Updated By';	
$lang['index_com_stand_th'] = 'Compliance Standard';
$lang['index_cpd_points'] = 'CPD Points';

// Create Course
$lang['create_course_heading'] = 'Add New Course';
$lang['edit_course_heading'] = ' Edit Course';
$lang['create_ref_title'] = 'Reference Title';
$lang['create_learning_objectives'] = 'Learning Objectives';
$lang['about_course'] = 'About Course';
$lang['create_cpd_points'] = 'CPD Points';
$lang['create_cpd_points'] = 'CPD Points';

$lang['add_course_btn'] = 'Add Course';


// Course Index
$lang['video_management']           = 'Video Management';
$lang['index_videoname_th']          = 'Name';
$lang['index_desc_th'] = 'Description';
$lang['index_type_th'] = 'Type';

// Create Video
$lang['create_video_heading'] = 'Add New Video';
$lang['video_url'] = 'Video URL';


// Edit User
$lang['edit_video_heading']                           = 'Edit Video';


// Assignment Index
$lang['assignments_management']           = 'Assignments Management';


$lang['index_duration_th'] = 'Type';
$lang['index_max_score'] = 'Max Score';
// Create Assignments
$lang['create_assignments_heading'] = 'Add New Assignment';

$lang['index_assign_name_th']          = 'Name';
$lang['assign_duration_th'] = 'Duration (Days)';
$lang['assign_passing_th'] = 'Passing';
$lang['assign_instructions_th'] = 'Instructions';
$lang['document'] = 'Document';

// Assignment Index
$lang['training_cat']           = 'Training Categories';
$lang['index_training_cat_name_th']          = 'Name';

$lang['create_training_cat_heading'] = 'Add New Training Categories';
$lang['edit_training_cat_heading']   = 'Edit Training Categories';


$lang['program_heading']           = 'Program';
$lang['index_program_name_th']          = 'Name';

// Reference material Index
$lang['reference_material'] = 'Reference Material';
$lang['index_name']         = 'Name';
$lang['index_description']	= 'Description';
$lang['index_type'] 		= 'Type';
$lang['index_url'] 			= 'URL';
$lang['index_document'] 	= 'Document';
$lang['index_instructor'] 	= 'Instructor';
$lang['index_cpd_points'] 	= 'CPD Points';
$lang['index_status'] 		= 'Status';

// Add Reference material
$lang['add_reference_material'] = 'Add Reference Material';
$lang['edit_reference_material'] = 'Edit Reference Material';
$lang['url_type'] = 'url';
$lang['document'] = 'Document';


// Create Video
$lang['create_program_heading'] = 'Add New Program';


// Edit Program
$lang['edit_program_heading'] = 'Edit Program';

// Assignment Index
$lang['session_management']           = 'Session';
$lang['session_id'] = 'Session ID';
$lang['session_name'] = 'Session';
$lang['objective'] = 'Objective';

$lang['create_session_heading'] = 'Add New Session';

// Edit Session
$lang['edit_session_heading'] = 'Edit Session';

// Batches Index
$lang['batches_heading']           = 'Batches';


// Inventory Index
$lang['inventory_heading']           = 'Inventory';
$lang['index_inventory_name_th']          = 'Name';
$lang['create_inventory_heading'] = 'Add New Inventory';
$lang['edit_inventory_heading']   = 'Edit Inventory';

// Assignment Index
$lang['training_heading']           = 'Trainings';

// Venues
$lang['venues_heading']           = 'Venues';
$lang['v_name']          = 'Venue Name';
$lang['v_description']          = 'Venue Description';
$lang['v_site_location']          = 'Site Location';
$lang['v_facility_type']          = 'Facility Type';
$lang['v_internal']          = 'Internal ';
$lang['v_external']          = 'External';
$lang['v_cost']          = 'Cost';
$lang['v_seat_limit']          = 'Seat Limit';
$lang['v_trainingroom']          = 'Training Room Detail';
$lang['v_address']          = 'Address';
$lang['v_mailid']          = 'Mail ID';
$lang['v_phoneno']          = 'Phone No';
$lang['v_equ_available']          = 'Equipments Available';
$lang['v_directions']          = 'Directions';
$lang['edit_venues_heading'] = 'Edit Venue';
$lang['create_venues_heading'] = 'Add New Venues';

// Vendor Type Index
$lang['vendortype_heading']           = 'Vendor Type';
$lang['create_vendortype_heading'] = 'Add New Vendor Type';
$lang['edit_vendortype_heading']   = 'Edit Vendor Type';
$lang['vt_name']           = 'Vendor Type';

// Vendors Index
$lang['vendors_heading']           = 'Vendors';
$lang['create_vendors_heading'] = 'Add New Vendor';
$lang['edit_vendors_heading'] = 'Edit Vendor';
$lang['vendrs_name']           = 'Name';
$lang['vendrs_address']           = 'Address';
$lang['vendrs_contact_person']           = 'Contact Person';
$lang['vendrs_email']           = 'Email';
$lang['vendrs_phone']           = 'Phone No.';
$lang['vendrs_remark']           = 'Remark';

//feedback
$lang['feedback']                 ='Feedback';
$lang['feedback_question']                 ='Feedback Questions';
$lang['index_feedback_name']='Feedback Name';
$lang['index_feedback_description']='Description';
$lang['index_feedback_status']='Status';
$lang['index_feedback_instructor']='Instructor';
$lang['index_feedback_instructon']='Instructon';
$lang['index_feedback_cpd_point']='CPD Points';
$lang['index_feedback_action']='Action';
$lang['create_feedback']="Create Feedback";
$lang['index_feedback_created_at'] ='Create Date';
$lang['index_feedback_created_by'] =' Create By';
$lang['index_feedback_updated_at'] ='Updated Date';
$lang['index_feedback_updated_by'] ='Updated BY';
$lang['update_feedback'] ='Update Feedback';
$lang['index_question_select']= 'Select';
$lang['index_question_name'] ='Question';
$lang['index_question_type']= 'Question type';
$lang['index_question_action']='Action';
$lang['index_question_sequence']='Sequence';
$lang['update_question']= 'Update Question';
$lang['create_question']= 'Add Question';

//Training Index
$lang['training_curriculum_id']					='Id';
$lang['Training_curriculum_types']				='Type';
$lang['Training_curriculum_type_name']			='Name';
$lang['Training_curriculum_instructor']			='Instrcutor';
$lang['Training_curriculum_status']				='Status';
$lang['Training_curriculum_action']				='Action';

//Training add
$lang['training_add_name']						='Name';
$lang['training_reference_name']				='Reference Name';	
$lang['training_description']					='Description';
$lang['training_starting_on']					='Start on';
$lang['training_ending_on']						='Ending on';
$lang['Seat_time']								='Seat Time';
$lang['training_duration']						='Duration';
$lang['training_chat']							='Chat';
$lang['training_cost']							='Cost';
$lang['training_currency']						='Currency';
$lang['training_certification']					='Certification';
$lang['training_rights']						='Rights';
$lang['training_status_id']						='Status Id';

//role 
$lang['lms_role_id'] ='Role Id';
$lang['lms_role_name'] ='Role Name';
$lang['lms_role']='Role';
$lang['deactive']='Deactive';
$lang['active']='Active';


//Training Index
$lang['training_curriculum_id']					='Id';
$lang['Training_curriculum_types']				='Type';
$lang['Training_curriculum_type_name']			='Name';
$lang['Training_curriculum_instructor']			='Instrcutor';
$lang['Training_curriculum_status']				='Status';
$lang['Training_curriculum_action']				='Action';

//Training add
$lang['training_add_name']						='Name';
$lang['training_reference_name']				='Reference Name';	
$lang['training_description']					='Description';
$lang['training_starting_on']					='Start on';
$lang['training_ending_on']						='Ending on';
$lang['Seat_time']								='Seat Time';
$lang['training_duration']						='Duration';
$lang['training_chat']							='Chat';
$lang['training_cost']							='Cost';
$lang['training_currency']						='Currency';
$lang['training_certification']					='Certification';
$lang['training_rights']						='Rights';
$lang['training_status_id']						='Status Id';
$lang['training_type']							='Type';
$lang['training_url']							='URL';
$lang['training_document']						='Document';
$lagn['training_trainer']						='Trainer';
$lang['training_image']							='Images';
$lang['training_video']							='Videos';

//create sessions page
$lang['build_training_sessions']				='Build Sessions';
$lang['build_sessions_name']					='Name';
$lang['build_sessions_type']					='Type';
$lang['build_session_status']					='Status';
$lang['build_session_instructor']				='Instructior';
$lang['build_session_view']						='Details';
$lang['build_session_action']					='Action';
$lang['build_session_course']					='Course';
$lang['build_session_video']					='Video';
$lang['build_session_assignment']				='Assignment';
$lang['build_session_session']					='Session';
$lang['build_session_feedback']					='Feedback';
$lang['build_session_video']					='Videos';
$lang['build_session_session']					='Session';
$lang['build_session_course']					='Course';

//add table
$lang['add_description']						='Description';
$lang['add']									='Add';

$lang['show_course']							='Course';
$lang['show_video']								='Video';
$lang['index_type_th']							='Type';
$lang['index_url_th']							='URL';
$lang['show_assignment']						='Assignment';
$lang['index_duration_th']						='Duration';
$lang['index_max_score_th']						='Max Score';
$lang['index_passing_th']						="Passing";
$lang['index_instruction_th']					='Instruction';
$lang['index_instructor_th']					='Instrcutor';
$lang['index_document_th']						='Document';
$lang['show_feedback']							='Feedback';













$lang['Training_category_name']				='Training Name';

//batch table show
$lang['batch']									='Batches';
$lang['batch_training_name']					='Training Name';
$lang['batch_session_name']						='Session Name';		
$lang['batch_name']								='Batch Name';
$lang['batch_start_date']						='Starting Date';
$lang['batch_end_date']							='Ending date';
$lang['batch_vanue']							='Vanue';
$lang['batch_vandor']							='Vandor';
$lang['batch_instructor']						='Instructor';
$lang['batch_seat_limit']						='Seat Limit';
$lang['batch_seat_occupied']					='Seat Occupied';	
$lang['batch_waiting_list']						='Waiting List';
$lang['batch_created_at']						='Created At';
$lang['batch_created_by']						='Created By';
$lang['batch_updated_at']						='Updated At';
$lang['batch_updated_by']						='Updated By';




//batch add
$lang['create_batch']							='Create Batch';
$lang['batch_name']								='Batch Name';
$lang['batch_start_date']						='Start Date';
$lang['batch_end_date']							='End date';
$lang['batch_vanue']							='Vanue';
$lang['batch_vandor']							='Vandor';
$lang['batch_instructor']						='Instructor';
$lang['batch_seat_limit']						='Seat Limit';
$lang['batch_seat_occupied']					='Seat Occupied';
$lang['batch_waiting_list']						='Waiting List';	

//batch validation
$lang['index_batch_name']						='batch name';
$lang['index_batch_start_date']					='start date';
$lang['index_batch_end_date']					='end date';
$lang['index_batch_vanue']						='batch vanue';
$lang['index_batch_vandor']						='batch_vandor';
$lang['index_batch_seat_limit']					='seat limit';
$lang['index_batch_seat_occupied']				='seat occupied';
$lang['index_batch_waiting_list']				='waiting list';


//user table
$lang['UserS']									='User';
$lang['index_username_th']						='UserName';
$lnag['index_email_th']							='Email-ID';

$lang['batch_user_name']						='User';
$lang['batch_email']							='Email_ID';
$lang['batch_status']							='Status';




//api
$lang['text_rest_invalid_api_key'] = 'Invalid API key %s'; // %s is the REST API key
$lang['text_rest_invalid_credentials'] = 'Invalid credentials';
$lang['text_rest_ip_denied'] = 'IP denied';
$lang['text_rest_ip_unauthorized'] = 'IP unauthorized';
$lang['text_rest_unauthorized'] = 'Unauthorized';
$lang['text_rest_ajax_only'] = 'Only AJAX requests are allowed';
$lang['text_rest_api_key_unauthorized'] = 'This API key does not have access to the requested controller';
$lang['text_rest_api_key_permissions'] = 'This API key does not have enough permissions';
$lang['text_rest_api_key_time_limit'] = 'This API key has reached the time limit for this method';
$lang['text_rest_ip_address_time_limit'] = 'This IP Address has reached the time limit for this method';
$lang['text_rest_unknown_method'] = 'Unknown method';
$lang['text_rest_unsupported'] = 'Unsupported protocol';




//extra add
$lang['training_categories']			= 'Training Categories';

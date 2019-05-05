<?php


class Classroom_model extends CI_Model {
	
	/* Program lists
	 * 
	 */
	function getprograms()
	{
		$this->db->select('p.*,c.name as catname');
		$this->db->from("lms_programs as p");
		$this->db->join('lms_training_categories as c','c.lms_training_category_id = p.lms_training_category_id','inner');
		$query = $this->db->get();		
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}
	

	function getcourse($id){
		$this->db->select('c.*');
		$this->db->from('lms_courses as c');
		$this->db->join('ims_training_assign as a','c.lms_course_id=a.lms_course_id','inner');
		$this->db->where('a.lms_training_id',$id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}    
	function getvideo($id){
		$this->db->select('c.*');
		$this->db->from('lms_videos as c');
		$this->db->join('ims_training_assign as a','c.lms_video_id=a.lms_video_id','inner');
		$this->db->where('a.lms_training_id',$id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}   
	function getassignment($id){
		$this->db->select('c.*');
		$this->db->from('lms_assignment as c');
		$this->db->join('ims_training_assign as a','c.lms_assignment_id=a.lms_assignment_id','inner');
		$this->db->where('a.lms_training_id',$id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}   
	function getsession($id){
		$this->db->select('c.*');
		$this->db->from('lms_sessions as c');
		$this->db->join('ims_training_assign as a','c.lms_sessions_id=a.lms_sessions_id','inner');
		$this->db->where('a.lms_training_id',$id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}   
	function getfeedback($id){
		$this->db->select('c.*');
		$this->db->from('lms_feedback as c');
		$this->db->join('ims_training_assign as a','c.lms_feedback_id=a.lms_feedback_id','inner');
		$this->db->where('a.lms_training_id',$id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}


	//build sessions
	function buildcourse($id){
		$query = $this->db->query("SELECT * FROM lms_courses WHERE lms_course_id  NOT IN (SELECT c.lms_course_id FROM lms_courses as c INNER JOIN ims_training_assign as a ON c.lms_course_id=a.lms_course_id WHERE a.lms_training_id=$id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	} 
	function buildsession($id){
		$query = $this->db->query("SELECT * FROM lms_sessions WHERE lms_sessions_id  NOT IN (SELECT c.lms_sessions_id FROM lms_sessions as c INNER JOIN ims_training_assign as a ON c.lms_sessions_id=a.lms_sessions_id WHERE a.lms_training_id=$id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}  
	function buildvideo($id){
		$query = $this->db->query("SELECT * FROM lms_videos WHERE lms_video_id  NOT IN (SELECT c.lms_video_id FROM lms_videos as c INNER JOIN ims_training_assign as a ON c.lms_video_id=a.lms_video_id WHERE a.lms_training_id=$id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}    
	function buildassignment($id){
		$query = $this->db->query("SELECT * FROM lms_assignment WHERE lms_assignment_id  NOT IN (SELECT c.lms_assignment_id FROM lms_assignment as c INNER JOIN ims_training_assign as a ON c.lms_assignment_id=a.lms_assignment_id WHERE a.lms_training_id=$id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}  
	function buildfeedback($id){
		$query = $this->db->query("SELECT * FROM lms_feedback WHERE lms_feedback_id  NOT IN (SELECT c.lms_feedback_id FROM lms_feedback as c INNER JOIN ims_training_assign as a ON c.lms_feedback_id=a.lms_feedback_id WHERE a.lms_training_id=$id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}    
	//user data
	function select_user($lms_training_id,$lms_sessions_id){
		$this->db->select('u.*');
		$this->db->from('users as u');
		$this->db->join('lms_add_user_info as a','u.id=a.id','inner');
		$this->db->where('a.lms_training_id',$lms_training_id);
		$this->db->where('a.lms_sessions_id',$lms_sessions_id);
		$query=$this->db->get();
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}
	

	function add_user($lms_training_id,$lms_sessions_id,$lms_batch_id){
		$query = $this->db->query("SELECT * FROM users WHERE id  NOT IN (SELECT u.id FROM users as u INNER JOIN lms_add_user_info as i ON u.id=i.id WHERE i.lms_training_id=$lms_training_id AND i.lms_sessions_id=$lms_sessions_id AND i.lms_batch_id=$lms_batch_id)");
		return ($query->num_rows()>0)?$query->result_array():FALSE;
	}
	
}
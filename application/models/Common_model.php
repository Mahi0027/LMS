<?php 
class Common_model extends CI_Model {
    
        function select_info($table_name,$cond = array())
	{
		$this->db->select('*');
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}
	function getrow($colname,$table_name,$cond = array())
	{
		$this->db->select($colname);
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$variable = $query->row($colname);
			return $variable;    
		} else {
		    return FALSE;
		}
	}
	
	function insert_info($table_name,$data)
	{
		$this->db->insert($table_name, $data);
		return $this->db->insert_id();
	}
	function update_info($tbl_name,$data_array,$cond)
	{
		if(!empty($cond)){
			foreach ($cond as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->update($tbl_name,$data_array);
		return $this->db->affected_rows();
	}
	function update_set($tbl_name,$field,$cond){
		$this->db->set($field, $field+1, FALSE);
		if(!empty($cond)){
			foreach ($cond as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->update($tbl_name);
		return $this->db->affected_rows();
	}
	
	function insert_batch_record($table_name,$data)
	{
		$this->db->insert_batch($table_name, $data);
		return $this->db->insert_id();
	}
	
	function select_rows($table_name,$cond = array())
	{
		$this->db->select('*');
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function delete_info($table_name,$cond){
		
		if(!empty($cond)){
		    foreach ($cond as $key => $value) {
		    $this->db->where($key,$value);
		    }
		}
		$this->db->delete($table_name);
		//$this->output->enable_profiler(TRUE);
		return $this->db->affected_rows();
	}
	
	function is_exits($table_name,$field,$cond = array()){
		$this->db->select($field);
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		if ($query->num_rows() == 0 )
                {                        
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
		
	}
	   function select_feedback_name($table_name,$cond = array())
	{
		$this->db->select('feedback_name');
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}
	 function select_question($table_name,$cond = array())
	{
		$this->db->select('question_name');
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}
	 function select_question_type($table_name,$cond = array())
	{
		$this->db->select('question_type');
		$this->db->from($table_name);
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}

	function get_role_name()
	{
		$this->db->select('u.*,r.lms_role_name as role_name');
		$this->db->from("users as u");
		$this->db->join('lms_roles as r','r.lms_role_id = u.role_id','inner');
		$query = $this->db->get();		
		return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}
        
}
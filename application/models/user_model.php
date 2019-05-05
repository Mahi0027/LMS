<?php 
class Common_model extends CI_Model {
    
      function select_info($id,$cond = array()){
      	$this->db->select('*');
		$this->db->from('lms_training');
		if(!empty($cond)){ foreach ($cond as $key => $value)$this->db->where($key,$value); }
		$query = $this->db->get();
		return ($query->num_rows() > 0)?$query->result_array():FALSE;

      }
      function update($id,$data=array()){

      }
      function get_all(){

      }
        
}
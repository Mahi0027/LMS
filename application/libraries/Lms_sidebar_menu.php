<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Admin Sidebar Menu
 */
class Lms_sidebar_menu {
	
	private $ci;            // para CodeIgniter Super Global Referencias o variables globales
    private $id_menu        = 'id="menu"';
    private $class_menu        = 'class="menu_section"';
    private $class_parent    = 'class="parent"';
    private $class_last        = 'class="last"';
	
	/**
     *  Constructor
     *
     */
    function __construct()
    {
        $this->ci =& get_instance();    // get a reference to CodeIgniter.
    }
	
	/**
     * build_menu($table, $type)
     *
     * Description:
     *
     * builds the Dynaminc dropdown menu
     * $table allows for passing in a MySQL table name for different menu tables.
     * $type is for the type of menu to display ie; topmenu, mainmenu, sidebar menu
     * or a footer menu.
     *
     * @param    string    the MySQL database table name.
     * @param    string    the type of menu to display.
     * @return    string    $html_out using CodeIgniter achor tags.
     */
 
    function build_menu()
    {
		$menu = array();
		$query = $this->ci->db->query("select * from lms_privilege");
		 $html_out  = "\t".'<div '.$this->class_menu.'>'."\n";
		 $html_out .= "\t\t".'<ul>'."\n";
		 foreach ($query->result() as $row){
			$id = $row->lms_modules_id;				
			$module_name = $row->module_name;
			$display_name = $row->display_name;
			$url = base_url('/lmsadmin/').$module_name;                   
			$position = $row->position;
			$parent_id = $row->parent_id;
			$is_parent = $row->is_parent;
			$show_menu = $row->show_menu;
			{
				if ($show_menu && $parent_id == 0)   // are we allowed to see this menu?
				{
					 if ($is_parent == TRUE){
						$html_out .= "\t\t\t".'<li>'.anchor($url, '<span class="menu_icon"><img src="'.base_url('assets/lms-admin/assets/img/collaboration.png').'" alt=""></span><span class="menu_title">'.$display_name.'</span>', 'name="'.$display_name.'" id="'.$id.'" ');
					 }else{
						  $html_out .= "\t\t\t".'<li>'.anchor($url, '<span class="menu_icon"><img src="'.base_url('assets/lms-admin/assets/img/collaboration.png').'" alt=""></span><span class="menu_title">'.$display_name.'</span>', 'name="'.$display_name.'" id="'.$id.'" ');
					 }
				}
			
			}
			 $html_out .= $this->get_childs($id);
		}
		$html_out .= '</li>'."\n";
        $html_out .= "\t\t".'</ul>' . "\n";
        $html_out .= "\t".'</div>' . "\n";
 
        return $html_out;
		 
	}
	
	
	
	/**
     * get_childs($menu, $parent_id) - SEE Above Method.
     *
     * Description:
     *
     * Builds all child submenus using a recurse method call.
     *
     * @param    mixed    $id
     * @param    string    $id usuario
     * @return    mixed    $html_out if has subcats else FALSE
     */
    function get_childs($id)
    {
        $has_subcats = FALSE;
 
        $html_out  = '';
        
        $html_out .= "\t\t\t\t\t".'<ul>'."\n";
 
        // query q me ejecuta el submenu filtrando por usuario y para buscar el submenu segun el id que traigo
         $query = $this->ci->db->query("select * from lms_privilege where parent_id = $id");
 
         foreach ($query->result() as $row)
            {
                $id = $row->lms_modules_id;				
				$module_name = $row->module_name;
				$display_name = $row->display_name;
				$url = base_url('/lmsadmin/').$module_name;             
				$position = $row->position;
				$parent_id = $row->parent_id;
				$is_parent = $row->is_parent;
				$show_menu = $row->show_menu;
 
                $has_subcats = TRUE;
 
                if ($is_parent == TRUE)
                {
					$html_out .= "\t\t\t\t\t\t".'<li>'.anchor($url, $display_name, 'name="'.$display_name.'" id="'.$id.'"');
 
                }
                else
                {
                   $html_out .= "\t\t\t\t\t\t".'<li>'.anchor($url, $display_name, 'name="'.$display_name.'" id="'.$id.'" ');
                }
 
                // Recurse call to get more child submenus.
                   $html_out .= $this->get_childs($id);
        }
      $html_out .= '</li>' . "\n";
      $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
   
 
        return ($has_subcats) ? $html_out : FALSE;
 
    }
}
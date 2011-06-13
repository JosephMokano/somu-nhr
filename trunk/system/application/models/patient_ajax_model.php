<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Eye View Design CMS module Ajax Model
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   EVD CMS
 * @author    Frederico Carvalho
 * @copyright 2008 Mentes 100Limites
 * @version   0.1
*/

class patient_ajax_model extends Model 
{
	/**
	* Instanciar o CI
	*/
	public function patient_ajax_model()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function get_patientlist($chapfilterid=67) 
	{
		//Select table name
		
		//Build Search Query
		$querySearchBuild='';
		if (!empty($_POST['query'])){
		$querySearchBuild= " and  ".$_POST['qtype']." like '%".$_POST['query']."%'";  
		}
		
		$this->load->database();
		$table_name = "tbl_pat_personal";
  
		//Build contents query
		//$this->db->select('patient_id,patient_first_name,patient_factor_level,patient_factor_deficient,patient_factor_defother')->from($table_name);
   $resultQuery["main_query"]="Select patient_id,patient_first_name,patient_factor_level,
   patient_factor_deficient,patient_factor_defother from ".$table_name." where chap_id=".$chapfilterid.$querySearchBuild;
   
   $resultQuery["count_query"]="select count(patient_id) as record_count from 
      ".$table_name." where chap_id=".$chapfilterid.$querySearchBuild." order by patient_first_name,patient_last_name";
		$build_querys = $this->CI->flexigrid->build_querys($resultQuery,TRUE); 
		
		///Get contents
    $return['records'] = $this->db->query($build_querys['main_query']);
    //Get record count
    $get_record_count = $this->db->query($build_querys['count_query']);
    $row = $get_record_count->row();
    $return['record_count'] = $row->record_count; 
	
		//Return all
		return $return;
	}
	

	
}
?>
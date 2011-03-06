<?php
class mod_adminreports extends Model
{
	function mod_adminreports()
	{
		parent::Model();
		$this->load->database();
	}
	
	function get_reportresults($queryString)	{
		
		$queryResult = $this->db->query($queryString);
		return $queryResult;
	}
	
	//this function added by deepak to get total number of records in each zone... 
	function get_zone_reports()
	{
		$queryResult = $this->db->query("select a.chapter_zone,count(b.patient_id) as ct from tbl_chapters 
		a join tbl_pat_personal b on a.chapter_id=b.chap_id group by a.chapter_zone");
		return $queryResult;
	}	
	
	//to each zone information...
	function get_each_zone_info($id=0)
	{
		$queryResult = $this->db->query("select a.chapter_id,a.chapter_name,count(b.patient_id),c.cityname from tbl_chapters a
		 join tbl_city c join tbl_pat_personal b on a.chapter_id=b.chap_id where a.chapter_zone='".$id."' and c.city_id=a.chapter_city 
		 group by b.chap_id");
		return $queryResult;
	}
	
	 public function get_ajax_chapterinfo( $id =0 ) 
  	{
    $this->CI =& get_instance();
    //Select table name
        
    //Build contents query
//    $this->db->query()
    $this->db->select('a.chapter_id,a.chapter_name,count(b.patient_id) as total,c.cityname from tbl_chapters a
		 join tbl_city c join tbl_pat_personal b on a.chapter_id=b.chap_id where a.chapter_zone='.$id.' and c.city_id=a.chapter_city 
		 group by b.chap_id');
    $this->CI->flexigrid->build_query();
    
    //Get contents
    $return['records'] = $this->db->get();
    
    //Build count query
    $this->db->select('count(a.chapter_id) as record_count from tbl_chapters a
		 join tbl_city c join tbl_pat_personal b on a.chapter_id=b.chap_id where a.chapter_zone='.$id.' and c.city_id=a.chapter_city 
		 group by b.chap_id' );
    $this->CI->flexigrid->build_query(FALSE);
    $record_count = $this->db->get();
    $row = $record_count->row();
    
    //Get Record Count
    $return['record_count'] = $row->record_count;
  
    //Return all
    return $return;
  	}
  
  function get_patient_age()
  {
  	$result = $this->db->query("select SUM(IF(age < 20,1,0)) as 'under 20',SUM(IF(age BETWEEN 20 and 39,1,0))
  	 as '20 - 39',SUM(IF(age BETWEEN 40 and 59,1,0)) as '40 - 59',SUM(IF(age BETWEEN 60 and 79,1,0)) as '60 - 79',SUM(IF(age BETWEEN 80 and 99,1,0)) as '80 - 99',SUM(IF(age > 100,1,0)) as '100 plus' FROM (SELECT TIMESTAMPDIFF(year,patient_dob,current_date())
	 as age from tbl_pat_personal) as derived");
	return $result;
	
  }
	
}
?>
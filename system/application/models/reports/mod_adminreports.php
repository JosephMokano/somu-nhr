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
}
?>
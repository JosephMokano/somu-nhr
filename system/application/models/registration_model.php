<?php
class registration_model extends Model {
	function registration_model()
	{
		parent::Model();
		$this->load->database();
	}

	function insert_entry($regArray)
	{    	
		$this->db->insert('tbl_users', $regArray);
	}
	
	function validat_email($emailid)
	{
		$quryCheck="SELECT email_id FROM  tbl_users WHERE email_id='".$emailid."'";
		$qryResult = $this->db->query($quryCheck);
		if ($qryResult->num_rows()>0){
			//echo "Exists";
			return false;
		}else{
			//echo "Not Exists";
			return true;
		}
	}
}
?>
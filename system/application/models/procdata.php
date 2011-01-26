<?php
class procdata extends Model
{
	function procdata()
	{
		parent::Model();
		$this->load->database();
	}
	function get_cat_name()
	{
		$queryString="select org_id, org_name, org_type from tbl_supporting_orgs";
		$queryResult = $this->db->query($queryString);
		return $queryResult->result();
	}
	function fetch_sub_cat_id($parent_id)
	{
		$queryString="select org_id, org_namefrom tbl_supporting_orgs where org_type=".$parent_id;
		$queryResult = $this->db->query($queryString);
		return $queryResult->result();
	}
}
?>
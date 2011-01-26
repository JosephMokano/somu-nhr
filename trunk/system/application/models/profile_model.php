<?php
class profile_model extends Model{
	var profilepic_path;
	function profile_model(){
	parent::Model();
		$this->profilepic_path = realpath(APPPATH. '../prfilepic');
	}
	function pro_upload(){
		$config = array(
			'allowed_types'=>'gif|jpg|png',
			'upload_path'=> $this->profilepic_path;
		);
		$this->load->libaray('upload',$config);
	}
}
?>
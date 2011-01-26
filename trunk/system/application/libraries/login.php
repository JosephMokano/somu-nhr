<?
class login{	
	function logout()
	{
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->helper('url');
		$obj->session->sess_destroy();
		$obj->index = $obj->config->item('base_url');
		redirect($obj->index);
	}
	
	function processLogin($username,$password)
	{
		$obj =& get_instance();
		$obj->load->database();
		$obj->load->library('session');
		$obj->load->helper('url');
		$obj->index = $obj->config->item('base_url');
		
		$login=0;
		$strQuery="SELECT * FROM tbl_users where email_id='".$username."' and password='".md5($password)."' and access_id=1";
		$query = $obj->db->query($strQuery);
		$res = $query->result_array();
		
		if ($query->num_rows()>0){
			$login=1;
		}		
		
		if($login==1){	
			$query = $obj->db->query("SELECT * from tbl_users where email_id='".$username."' and access_id=1");		
			$details = $query->result_array();
			
			$username = $details[0]['username'];
			$group = $details[0]['group_id'];
			$loginname = $details[0]['email_id'];
			$obj->load->helper('date');
			//echo time();
			
			$dd=time('YYYY-MM-DD HH:MM:SS');
			$ee= unix_to_human($dd);
			$dd= date("Y-m-d H:i:s");

			// for audit login
			$eachlogindata=array(
				'user_id'=> $details[0]['user_id'],
				'log_datetime'=>$dd,
				'log_ipaddress'=>$obj->input->ip_address()
			);
			$obj->db->insert('tbl_login_audit',$eachlogindata);

			$data = array(
				   'username' =>  $username,
				   'userid' =>  $details[0]['user_id'],
				   'logged_in' =>  TRUE,
				   'loginVal' =>  1,
				   'chapter' => $details[0]['chap_id'],
				   'group'	=>  $details[0]['group_id'],
				   //'logout'	=> '<a href="homepage/loginaccess/logout"> Logout</a>'
				);
			$obj->session->set_userdata($data);
			$processval=True;
		}
		else{
			$processval=False;
		}
		return $processval;
	}
}
?>
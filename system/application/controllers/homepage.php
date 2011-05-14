<?php 
class Homepage extends Controller {

	function Homepage() {
        	parent::Controller();
	}
	function index() {	
		$this->loginscreen();
	}
	function loginscreen(){
		$this->load->helper('form');
		$logindisplay='';
		$logindisplay.='<div align="center" class="login" >';
		$formAttr=array('name'=>'login_form','id'=>'login_form');
		$logindisplay.=form_open('homepage/loginaccess',$formAttr);
		$logindisplay.='<table border="0" cellpadding="2" width="30%">';
		$logindisplay.='<tr>';
		$logindisplay.='<td colspan="2" align="center" style="color:#007D7D"><b>User login</b>';
		$logindisplay.='</td>';
		$logindisplay.='</tr>';
		
		// username
		$logindisplay.='<tr>';
		$logindisplay.='<td>';
		$logindisplay.='&nbsp;username';
		$logindisplay.='</td>';
		$logindisplay.='<td>';
		$TxtAttr=array(
			'id'=>'txtusernme',
			'name'=>'txtusernme',
			'class'=>'',
			'value'=>''
		);
		$logindisplay.=form_input($TxtAttr);
		$logindisplay.='</td>';
		$logindisplay.='</tr>';
		
		//password
		$logindisplay.='<tr>';
		$logindisplay.='<td>';
		$logindisplay.='password';
		$logindisplay.='</td>';
		$logindisplay.='<td>';
		$TxtAttr=array(
			'type'=>'password',
			'id'=>'txtpassword',
			'name'=>'txtpassword',
			'class'=>'',
			'value'=>''
		);
		$logindisplay.=form_input($TxtAttr);
		//$logindisplay.=$this->input->server('serverdet');
		$logindisplay.='</td>';
		$logindisplay.='</tr>';
		
		$logindisplay.='<tr>';
		$logindisplay.='<td colspan="2">';
		$logindisplay.='<div style="border:0px solid #000;text-align:center">';
		$attri=array(
			'name'=>'patsubmit',
			'value'=>'Login'
			);
		$logindisplay.=form_submit($attri);
		$logindisplay.='</div>';
		$logindisplay.='</td>';
		$logindisplay.='</tr>';
		
		$logindisplay.='</table>';
		
		$logindisplay.=form_close();
		$logindisplay.='</div>';
		
		$logindisplay.='<div class="leftbar">';
		//$logindisplay.='<a href="'.$this->config->item('base_url').'homepage/register">';
		//$logindisplay.='<img src="'.$this->config->item('base_url').'images/login_register.jpg" />';
		//$logindisplay.='</a>';
		//$logindisplay.='<img src="'.$this->config->item('base_url').'images/login_usenhr.jpg" />';
		$logindisplay.='<a href="'.$this->config->item('base_url').'homepage/need_assistance">';
		$logindisplay.='<img src="'.$this->config->item('base_url').'images/login_assis.jpg" />';
		$logindisplay.='</a>';
		//$logindisplay.='<img src="'.$this->config->item('base_url').'images/login_contdev.jpg" />';
		$logindisplay.='</div>';
		
		$logindisplay.='<div class="rightbar">';
		$logindisplay.='<h2>National Hemophilia Registry (India)</h2>';
		$logindisplay.='<p>NHR is a  initiative of  Hemophilia Federation(India) to  create database of  Person With Hemophilia India.  Our National hemophilia
 organizations and hemophilia treatment centres are key partners in this network. Ours is  a <b>Mixed systems</b> combining of Patient, Medical and Home Ministry registry.(WFH, National Patient Registry Guide by Bruce Evatt, MD).  
		</p>';
		$logindisplay.='</div>';
		
		$data = array(
			'footer' => 'Nhr 2009',
			'chapterName' => 'Hemophilia Society',
			'content' => $logindisplay
        	);
		$this->load->view('login',$data);
	}
	function loginaccess($checkLog=''){
		$this->load->library('login');
		
		if ($checkLog=='') {
			$username=$_POST['txtusernme'];
			$password=$_POST['txtpassword'];
			//echo $_POST['serverdet'];exit;
			$processVal = $this->login->processLogin($username,$password);
		}
		if($checkLog=='logout')
		{
			$this->login->logout();
		}
		if($processVal==TRUE)
		{
			$this->chapterdashboard();
		}
		else
		{
			$data = array(
			'footer' => 'Nhr 2010',
			'chapterName' => 'Hemophilia Society',
			'content' => '<div align="center" style="padding:10px 0px"><b>Incorrect Username and Password</b> <a href="'.$this->config->item("base_url").'">Back</a></div>'
	        	);
			$this->load->view('login',$data);
		}
	}
	function need_assistance(){
		$this->load->helper('form');
		$displayform='';
		$formAttr=array('name'=>'assistance_form','id'=>'assistance_form');
		$displayform.=form_open('homepage/send_needassis',$formAttr);

		$displayform.='<div align="center" style="padding:0px 0px;">';
		$displayform.='<table border="0" class="needassitable">';

		$displayform.='<tr>';
		$displayform.='<td colspan="2" align="center"><div class="regheading">Mail to moderators<div></td>';
		$displayform.='</tr>';

		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Name';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtname',
			'name'=>'txtname',
			'size'=>'50',
			'value'=>$this->input->post('txtname')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
	
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='E-mail id';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtemail',
			'name'=>'txtemail',
			'size'=>'50',
		
			'value'=>$this->input->post('txtemail')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Contact no';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtcontactno',
			'name'=>'txtcontactno',
			'size'=>'50',
			'value'=>$this->input->post('txtcontactno')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';

		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Chapter';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtchapter',
			'name'=>'txtchapter',
			'size'=>'50',
			'value'=>$this->input->post('txtchapter')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';

		$displayform.='<tr>';
		$displayform.='<td>Your query:</td>';
		$displayform.='<td>';
		$txtformElement=array(
			'id'=>'query',
			'name'=>'query',
			'rows'=>'10',
			'cols'=>'57',
			'value'=>'',
			'alt'=>'query' );
		$displayform.=form_textarea($txtformElement);
		$displayform.='</td>';
		$displayform.='</tr>';

		$displayform.='<tr>';
		$displayform.='<td colspan="2">';
		$displayform.='<div style="border:0px solid #000;text-align:center">';
		$attri=array(
			'name'=>'submit',
			'value'=>'Send Mail'
			);
		$displayform.=form_submit($attri);
		$displayform.='</div>';
		$displayform.='</td>';
		$displayform.='</tr>';

		$displayform.='</table>';
		$displayform.='<div align="right"><a href="'.$this->config->item('base_url').'homepage/loginscreen">Back to login</a></div>';
		$displayform.='</div>';
		$displayform.=form_close();

		$data = array(
			'footer' => 'Nhr 2009',
			'chapterName' => 'Hemophilia Federation (India)',
			'scrip' => '',
			'content' => $displayform
		);
		$this->load->view('needassis_view',$data);
	}
	function send_needassis(){
		
		$name=$this->input->post('txtname');
		$email=$this->input->post('txtemail');
		$contactno=$this->input->post('txtcontactno');
		$chapter=$this->input->post('txtchapter');
		$query=$this->input->post('query');
		
		$this->load->library('email');			
		$adminMailId=$this->config->item('adminMailId');
		
		$message='';
		$message .="<html><body>";
		$message.="Sir/Madam,<br/><br/>";
		$message.="I ".$name." from ".$chapter." <br/>";
		$message.="My query is : <br/>";
		$message.=$query;
		$message.="<br/><br/>Regards,<br/>";
		$message.=$name.'<br/>';
		$message.=$contactno.'<br/>';
		$message.=$email;
		$message .="</body></html>";
		$this->email->subject('NHR Need Assistance Mail, from: '.$chapter);
		$this->email->set_mailtype('html');
		$this->email->from($email);
		$this->email->to($adminMailId);
		$this->email->message($message);
		$this->email->send();
		$this->mail_success();
	}
		//sucess registration message
	function mail_success(){
		$display='<div align="center" class="mailmessage">Thank you for your valuable mail. Team will get back to you soon. <a href="'.$this->config->item('base_url').'homepage/loginscreen">Click here</a> to login</div>';
		$data = array(
			'content' => $display
		);
		$this->load->view('normalview',$data);
	}
	function register(){
		$this->load->helper('form');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$displayform='';		
		$displayform.='<div align="center" style="padding:0px 0px;">';
		
		$formAttr=array('name'=>'register_form','id'=>'register_form');
		$displayform.=form_open('homepage/register',$formAttr);
		
		$displayform.='<table border="0" class="registertable">';
		
		$displayform.='<tr>';
		$displayform.='<td colspan="2" align="center"><div class="regheading">Registration<div></td>';
		$displayform.='</tr>';
		
		$this->load->database();
		$query = $this->db->query('SELECT City_ID,cityName FROM tbl_city order by cityName');
		$resultarray=array(
			'0'=>'Select'
		);
		$attr='id="location"';
		foreach ($query->result() as $row)
		{
		    $resultarray[$row->City_ID]=$row->cityName;
		}
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Select location';
		$displayform.='</td>';
		$displayform.='<td>';
		$displayform.=form_dropdown('location',$resultarray,'0',$attr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td colspan="2">';
		$displayform.='<div id="message"></div>';
		$displayform.='<td>';
		$displayform.='<tr>';
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Username';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtUsername',
			'name'=>'txtUsername',
			'class'=>'',
			'value'=>$this->input->post('txtUsername')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Email ID/Login ID';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtEmailID',
			'name'=>'txtEmailID',
			'class'=>'',
			'value'=>$this->input->post('txtEmailID')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Password';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtPassword',
			'name'=>'txtPassword',
			'class'=>'',
			'type'=>'password',
			'value'=>$this->input->post('txtPassword')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td>';
		$displayform.='Confirm Password';
		$displayform.='</td>';
		$displayform.='<td>';
		$TxtAttr=array(
			'id'=>'txtCPassword',
			'name'=>'txtCPassword',
			'type'=>'password',
			'class'=>'',
			'value'=>$this->input->post('txtCPassword')
		);
		$displayform.=form_input($TxtAttr);
		$displayform.='</td>';
		$displayform.='</tr>';
		
		$displayform.='<tr>';
		$displayform.='<td colspan="2">';
		$displayform.='<div style="border:0px solid #000;text-align:center">';
		$attri=array(
			'name'=>'patsubmit',
			'value'=>'Register'
			);
		$displayform.=form_submit($attri);
		$displayform.='</div>';
		$displayform.='</td>';
		$displayform.='</tr>';
		$displayform.='</table>';
		
		$displayform.=form_close();
		
		$displayform.='<div align="right"><a href="'.$this->config->item('base_url').'homepage/loginscreen">Back to login</a></div>';
		$displayform.='</div>';
		
		$this->form_validation->set_rules('txtEmailID', 'EmailID', 'trim|required|valid_email|callback_validate_emailid');
		$this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|matches[txtCPassword]|md5');
		$this->form_validation->set_rules('txtCPassword', 'Password Confirmation', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_message('rule', 'Error Message');
			$data = array(
				'footer' => 'Nhr 2009',
				'chapterName' => 'Hemophilia Federation (India)',
				'script' => '<script type="text/javascript" src="'.$this->config->item("base_url").'js/jquery-1.3.2.js"></script>',
				'content' => $displayform
			);
			$this->load->view('view_registration',$data);
		}
		else
		{
			
			$this->load->library('session');
			//echo $this->session->userdata('chapterid');
			$dataarray = array(
				'username'=>$this->input->post('txtUsername'),
				'password'=>$this->input->post('txtPassword'),
				'pwh_id'=>'',
				'group_id'=>2,
				'email_id'=>$this->input->post('txtEmailID'),
				'access_id'=>0,
				'chap_id'=>$this->session->userdata('chapterid')
				);
			//print_r($dataarray);exit;
			$dataModel=$this->load->model('registration_model','registrationModel');
			$this->registrationModel->insert_entry($dataarray); 
			$this->confirmation_mail($dataarray);
			redirect('homepage/reg_success');
		}
		
	}
	function displaychapterdetails(){
		$this->load->database();
		$this->load->library('session');
		$cityid=$_POST['cityid_x'];
		
		$query = $this->db->query('select c.*,chap.* from tbl_city as c join tbl_chapters as chap where c.city_ID='.$cityid.' and chap.chapter_city='.$cityid);
		$qryResult = $query->row_array();
		
		$query1 = $this->db->query('select * from tbl_states where State_ID='.$qryResult['chapter_state'].'');
		$staResult = $query1->row_array();
		
		$chapterid = $qryResult['chapter_ID'];
		$chaptername = $qryResult['chapter_name'];
		$address =  $qryResult['chapter_address1']. '<br/>'.$qryResult['chapter_address2'].'<br/>'.$staResult['stateName'];
		
		$this->session->set_userdata('chapterid',$qryResult['chapter_ID']);

		$displaydata='';
		$displaydata.='<table width="100%">';
		$displaydata.='<tr>';
		$displaydata.='<td>';
		$displaydata.='Chapter Name';
		$displaydata.='</td>';
		$displaydata.='<td>';
		$displaydata.=$chaptername;
		$displaydata.='</td>';
		$displaydata.='</tr>';
		$displaydata.='<tr>';
		$displaydata.='<td>';
		$displaydata.='Chapter Address';
		$displaydata.='</td>';
		$displaydata.='<td>';
		$displaydata.=$address;
		$displaydata.='</td>';
		$displaydata.='</tr>';
		$displaydata.='</table>';
		
		echo $displaydata;
		
	}
	//validate email id
	function validate_emailid($emailid){
		$dataModel=$this->load->model('registration_model','registrationModel');
		$check=$this->registrationModel->validat_email($emailid);
		if ($check == FALSE)
		{
			$this->form_validation->set_message('validate_emailid', 'Emailid: '.$emailid.' already Exists. Please user another');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	//sucess registration message
	function reg_success(){
		$display='<div class="mailmessage">Thank you for Registration. Please check you mail to activate your account. <a href="'.$this->config->item('base_url').'homepage/loginscreen">Click here</a> to login</div>';
		$data = array(
			'footer' => 'Nhr 2009',
			'chapterName' => 'Hemophilia Society',
			'content' => $display
         	);
		$this->load->view('login',$data);
	}
	
	//Send confirmation Mail
	function confirmation_mail($mailData){
		$this->load->library('email');			
		$adminMailId=$this->config->item('adminMailId');
		
		$queryCheck="SELECT * FROM  tbl_users WHERE email_id='".$mailData['email_id']."'";
		$Result = $this->db->query($queryCheck);
		$row = $Result->row();
				
		$datestring = date('Y-m-d');
		
		$encrVariable=md5($row->username.$row->chap_id.$row->email_id."SomuPremDharmu");
		$urlToClick=$this->config->item('base_url')."homepage/accountactivation/".$encrVariable.'/'.$row->user_id;
		$message='';
		$message .="<html><body>";
		$message.="Sir/Madam,<br/><br/>";
		$message.="Thank you for registring with NHR Registry.<br/>";
		$message.=$urlToClick.'<br/>';
		$message.="Please click on above link to activate your account. ";
		$message.="<br/><br/>Regards,<br/>";
		$message.="NHR India Team.";
		$message .="</body></html>";
		$this->email->subject('NHR Registration Confirmation Mail, Dated: '.$datestring);
		$this->email->set_mailtype('html');
		$this->email->from($adminMailId, 'NHR India Team');
		$this->email->to($row->email_id);
		$this->email->message($message);
		$this->email->send();
		
	}
	function accountactivation($encVal, $userid)
	{
		$this->load->database();
		//user_id, username, password, pwh_id, group_id, email_id, , chap_id
		$data = array(
               'access_id' => 1
           	 );

		$this->db->where('user_id', $userid);
		$this->db->update('tbl_users', $data); 
		
		$displaymessage='<div class="mailmessage">Your account has been activated please <a href="'.$this->config->item("base_url").'">click here</a> to login</div>';
		
		$data = array(
		   'footer' => 'Nhr 2009',
		   'chapterName' => 'Hemophilia Society',
		   'content' => $displaymessage
		   );
		$this->load->view('login',$data);
	}
  
 
	function patient_form($id=0){
	  $this->load->library('session');
	  checkwrongpwhid($id,$this->session->userdata('chapter'));
		$this->load->database();
		$this->load->helper('form');
		
		//$this->load->library('form_validation');
		
		//Check for new entry session data
		$newnentryarray=$this->session->userdata('newentryArray');
    
		
      
    //$this->session->unset_userdata('newentryArray'); 
    
		
		
		$query=$this->db->query("select * from tbl_pat_personal where patient_ID='".$id."'");
		$formdata = ($id == 0) ? array(0) : $query->result_array();
		//Patch for empty   
		if ($id!=0){ 
		  foreach($formdata[0] as $key=>$value){
		   // echo $key.'->'.$value.'<br/>';
        if (!isset($value)){
          $formdata[0][$key]='';
        }
		  }
    }
		$formdisplay='';
		$formAttr=array('name'=>'pat_dispform','id'=>'pat_dispform');
		
		$formdisplay.=form_open('homepage/insert_patdata',$formAttr);
		
		$tabsHead='';
		$tabsHead .='<ul>';
		$tabsHead .='<li><a href="#tabs-1">Personal</a></li>';
		$tabsHead .='<li><a href="#tabs-2">Educational</a></li>';
		$tabsHead .='<li><a href="#tabs-3">Occupational</a></li>';
		$tabsHead .='<li><a href="#tabs-4">Medical</a></li>';
		$tabsHead .='<li><a href="#tabs-7">Other Medical</a></li>';
		$tabsHead .='<li><a href="#tabs-5">Family Details</a></li>';
		$tabsHead .='<li><a href="#tabs-6">Membership</a></li>';
		$tabsHead .='</ul>';
		
		if($this->session->userdata('group')==2){
			$txtIDhidden=array(
					'value'=>$id,
					'id'=>'Pid',
					'name'=>'Pid',
					'type'=>'hidden'
					);
			$formdisplay.= form_input($txtIDhidden);
      $txtIDhidden=array(
          'value'=>$this->session->userdata('chapter'),
          'id'=>'chapid',
          'name'=>'chapid',
          'type'=>'hidden'
          );
      $formdisplay.= form_input($txtIDhidden);
      
		}else if($this->session->userdata('group')==1){
		
			$txtIDhidden=array(
					'value'=>$id,
					'id'=>'Pid',
					'name'=>'Pid',
					'type'=>'hidden'
					);
			$formdisplay.= form_input($txtIDhidden);
			
			$query = $this->db->query('SELECT City_ID,cityName FROM tbl_city order by cityName');
			$resultarray=array(
				'0'=>'Select'
			);
			$attr='id="location"';
			foreach ($query->result() as $row)
			{
			    $resultarray[$row->City_ID]=$row->cityName;
			}
			
			$query1 = $this->db->query('SELECT * FROM tbl_chapters where chapter_ID="'.$formdata[0]['chap_id'].'"');
			$resultval = $query1->result_array();
			//print_r($resultval);
			
		
			$formdisplay.='<div align="center">Select Chapter : ';
			$formdisplay.=$resultval[0]['chapter_name'];
			$formdisplay.='</div><Br/>';
      $txtIDhidden=array(
          'value'=>$formdata[0]['chap_id'],
          'id'=>'chapid',
          'name'=>'chapid',
          'type'=>'hidden'
          );
      $formdisplay.= form_input($txtIDhidden);
      
		}
		
		//$formdisplay.=$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$formdisplay.='<div id="tabs">';
		$formdisplay.=$tabsHead;
		
		//open first tab tabs-1
		$formdisplay.='<div id="tabs-1">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('First Name: ','lblfname');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtfname',
				'name'=>'txtfname',
				'class'=>'required',	
				'value'=>$formdata[0]['patient_first_name'],
			);
     if (isset($newnentryarray)&&($id==0))
      $txtformElement['value']=$newnentryarray['txtfname'];
      
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Last Name: ','lbllname');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtlname',
				'name'=>'txtlname',
				'class'=>'',	
				'value'=>$formdata[0]['patient_last_name'],
			);
       if (isset($newnentryarray)&&($id==0))
      $txtformElement['value']=$newnentryarray['txtlname'];  
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Guardian/Father Name: ','lblfatname');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtfatname',
				'name'=>'txtfatname',
				'class'=>'',	
				'value'=>$formdata[0]['patient_father_name'],
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Date of Birth: ','lbldob');
		$formdisplay.='</div>';
		$dobdisp='';
		if (isset($formdata[0]['patient_dob'])){
			$dobdisp=explode('-',$formdata[0]['patient_dob']);
			$dobdisp=$dobdisp[1].'/'.$dobdisp[2].'/'.$dobdisp[0];
			//echo $dobdisp;
		}
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(isset($newnentryarray)?$txtformElement['value']=$newnentryarray['txtlname']:'',
				'id'=>'txtdob',
				'name'=>'txtdob',
				'class'=>'',	
				'value'=>$dobdisp
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Gender : ','lblFBB');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'radgender',
				'name'=>'radgender',
				'class'=>'',	
				'value'=>0,
			);
		if($formdata[0]['patient_sex']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		
		$formdisplay.='Male';
		$txtformElement=array(
				'id'=>'radgender',
				'name'=>'radgender',
				'class'=>'',	
				'value'=>1
			);
		if($formdata[0]['patient_sex']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		
		$formdisplay.='Female';
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Religion : ','lblflat');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'0'=>'Select',
				'1'=>'Hindu',
				'2'=>'Muslim',	
				'3'=>'Christan',
				'4'=>'Sikh',
				'5'=>'Parsi'
			);
		$formdisplay.=form_dropdown('txtreligion',$txtformElement,$formdata[0]['patient_religion']);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		$formdisplay.='<h2>Address</h2>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Flat/Door/Block No : ','lblflat');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtflat',
				'name'=>'txtflat',
				'class'=>'',	
				'value'=>$formdata[0]['comm_flat']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Premises/Building/Village : ','lblbuild');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtbuild',
				'name'=>'txtbuild',
				'class'=>'',	
				'value'=>$formdata[0]['comm_building']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Road/State/Lane/Post Office: ','lbllane');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtlane',
				'name'=>'txtlane',
				'class'=>'',	
				'value'=>$formdata[0]['commu_road']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Area/Locality/Taluk/sub-Division: ','lblATS');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtATS',
				'name'=>'txtATS',
				'class'=>'',	
				'value'=>$formdata[0]['commu_locality']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
	
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Town/City/District: ','lblTCD');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtTCD',
				'name'=>'txtTCD',
				'class'=>'',	
				'value'=>$formdata[0]['commu_state']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('State/Union Territory : ','lblTCD');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtSU',
				'name'=>'txtSU',
				'class'=>'',	
				'value'=>$formdata[0]['commu_city']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('PinCode: ','lblpincode');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtpincode',
				'name'=>'txtpincode',
				'class'=>'numericfield',	
				'value'=>$formdata[0]['commu_pincode']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div ctxtfnamelass="clearfield"></div>';
		
		$formdisplay.='<h2>&nbsp;</h2>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Zone : ','lblUR');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'0'=>'Urban',
				'1'=>'Rural'
			);
		$formdisplay.=form_dropdown('drpzone',$txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Contact number: ','lblUR');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtcont',
				'name'=>'txtcont',
				'class'=>'numericfield',	
				'value'=>$formdata[0]['commu_phone']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Email id: ','lblUR');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtemail',
				'name'=>'txtemail',
				 'class'=>'email',	
				'value'=>$formdata[0]['commu_email']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Mobile number: ','lblUR');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtmob',
				'name'=>'txtmob',
				'class'=>'numericfield',	
				'value'=>$formdata[0]['commu_cellnumber']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		//close tabs-1
		$formdisplay.='</div>';
		
		//open Second tab tabs-2
		$formdisplay.='<div id="tabs-2">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Studying: ','lblstudy');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'radstudy',
				'name'=>'radstudy',
				'class'=>'',	
				'value'=>1,
			);
		if($formdata[0]['patient_studying']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('Yes','lblyes');
		
		$txtformElement=array(
				'id'=>'radstudy1',
				'name'=>'radstudy',
				'class'=>'',	
				'value'=>0,
			);
		if($formdata[0]['patient_studying']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No','lblno');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Highest Class: ','lblhighEdu');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txthighEdu',
				'name'=>'txthighEdu',
				'class'=>'',	
				'value'=>$formdata[0]['patient_highestedu']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		//close tabs-2
		$formdisplay.='</div>';
		
		//open third tab tabs-3
		$formdisplay.='<div id="tabs-3">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Employed/Not Employed: ','lblemp');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'rademp',
				'name'=>'rademp',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['patient_working']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('Yes');
		
		$txtformElement=array(
				'id'=>'rademp',
				'name'=>'rademp',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['patient_working']==0){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Employment Type: ','lblEmploymentType');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
        'id'=>'txtEmploymentType',
        'name'=>'txtEmploymentType',
        'class'=>'',  
        'value'=>$formdata[0]['patient_employment_type']
      );
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
    
		$formdisplay.='<div class="label">';
    $formdisplay.=form_label('Remboursement : ','lblrembour');
    $formdisplay.='</div>';
    
    $formdisplay.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'radrembour',
        'name'=>'radrembour',
        'class'=>'',
        'value'=>1
      );
    if($formdata[0]['patient_Remboursement_faclity']==1){
      $formdisplay.=form_radio($txtformElement,1,true);
    }else{
      $formdisplay.=form_radio($txtformElement);
    }
    $formdisplay.=form_label('Yes');
    
    $txtformElement=array(
        'id'=>'radrembour',
        'name'=>'radrembour',
        'class'=>'',
        'value'=>0
      );
    if($formdata[0]['patient_Remboursement_faclity']==0){
      $formdisplay.=form_radio($txtformElement,0,true);
    }else{
      $formdisplay.=form_radio($txtformElement);
    }
    $formdisplay.=form_label('No');
    $formdisplay.='</div>';
    
    $formdisplay.='<div class="clearfield"></div>';
    $formdisplay.='<div class="infoMessage">
   
    <b>Note: </b> If PWH has remboursement faclity, please fill below details</div>';
    $formdisplay.='<div class="label">';
    $formdisplay.=form_label('Empl. Org. Name: ','lblEmployedOrgName');
    $formdisplay.='</div>';
    
    $formdisplay.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'txtEmplOrgName',
        'name'=>'txtEmplOrgName',
        'class'=>'',  
        'value'=>$formdata[0]['employment_organization']
      );
    $formdisplay.=form_input($txtformElement);
    $formdisplay.='</div>';
     $formdisplay.='<div class="clearfield"></div>';
     $formdisplay.='<div class="label">';
    $formdisplay.=form_label('Remboursement/Employment Reference Number: ','lblReferenceNumber');
    $formdisplay.='</div>';
    
    $formdisplay.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'txtEmplReferenceNumber',
        'name'=>'txtEmplReferenceNumber',
        'class'=>'',  
        'value'=>$formdata[0]['employment_ref_number']
      );
    $formdisplay.=form_input($txtformElement);
    $formdisplay.='</div>';
		/*$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Skilled/Manual: ','lblSM');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtSM',
				'name'=>'txtSM',
				'class'=>'',	
				'value'=>'',
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';*/
		
		//close tabs-3
		$formdisplay.='</div>';
		
		//open fourth tab tabs-4
		$formdisplay.='<div id="tabs-4">';

		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Age of Diagnose: ','lblagdia');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtagdia',
				'name'=>'txtagdia',
				'class'=>'numericfield',	
				'value'=>$formdata[0]['patient_age_Diagnose']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Hospital Diagnosed : ','lblhosdia');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txthosdia',
				'name'=>'txthosdia',
				'class'=>'',	
				'value'=>$formdata[0]['patient_hospital_diagnose']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Form of Diagnosis: ','lblfrmdia');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtfrmdia',
				'name'=>'txtfrmdia',
				'class'=>'',	
				'value'=>$formdata[0]['patient_form_diagnose']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Blood Group with RH Factor: ','lblblodgrp');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'0'=>'select blood group',
				'1'=>'B+',
				'2'=>'B-',	
				'3'=>'A+',
				'4'=>'A-',
				'5'=>'AB+',
				'6'=>'AB-',
				'7'=>'O+',
				'8'=>'O-'
			);
		$formdisplay.=form_dropdown('bloodgrop',$txtformElement,$formdata[0]['patient_bloodgroup']);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Factor Deficiency : ','lblfctdef');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$Mulattr='id="txtfctdef" class=""';
		$txtformElement=array(
				'0'=>'',
				'1'=>'1 (I)',
				'2'=>'2 (II)',
				'3'=>'3 (III)',	
				'4'=>'4 (IV)',
				'5'=>'5 (V)',
				'6'=>'6 (VI)',
				'7'=>'7 (VII)',
				'8'=>'8 (VIII)',
				'9'=>'9 (IX)',
				'10'=>'10 (X)',
				'11'=>'11 (XI)',
				'12'=>'12 (XII)',
				'13'=>'13 (XIII)'
			);
      
      $fDefaultValue=empty($formdata[0]['patient_factor_deficient'])?0:explode(',',$formdata[0]['patient_factor_deficient']);
      if (isset($newnentryarray)&&($id==0)){
       
       $fDefaultValue=$newnentryarray['txtfctdef']; 
      }
		$formdisplay.=form_multiselect('txtfctdef[]',$txtformElement,$fDefaultValue);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Others: ','lblfctother');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'0'=>'-- select --',
				'1'=>'Von Willebrand',
				'2'=>'Glanzmann',
				'3'=>'Fibrinogenemia',
				'4'=>'Hypofibrinogenemia',
				'5'=>'Functional Platelet Disorder'
			);
		$formdisplay.=form_dropdown('fctdefother',$txtformElement,$formdata[0]['patient_factor_defother']);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Factor Level: ','lblfctlel');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtfactlel',
				'name'=>'txtfaclel',
				'class'=>'valfactor',	
				'value'=>$formdata[0]['patient_factor_level']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='&nbsp;%</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Deformity: ','lbldefor');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'raddefor',
				'name'=>'raddefor',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['patient_Deformity']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		
		$formdisplay.=form_label('Yes');
		
		$txtformElement=array(
				'id'=>'raddefor',
				'name'=>'raddefor',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['patient_Deformity']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';
		
		//close tabs-4
		$formdisplay.='</div>';

		//open seventh tab tabs-7
		$formdisplay.='<div id="tabs-7">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Inhibitors :','lblinhi');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class=""boxarea>';
		$txtElement=array(
				'id'=>'radinhi',
				'name'=>'radinhi',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['patient_inhibitor_screen']==1){
			$formdisplay.=form_radio($txtElement,1,true);
		}else{
			$formdisplay.=form_radio($txtElement);
		}
		
		$formdisplay.=form_label('Yes');
		
		$txtElement=array(
				'id'=>'radinhi',
				'name'=>'radinhi',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['patient_inhibitor_screen']==0){
			$formdisplay.=form_radio($txtElement,0,true);
		}else{
			$formdisplay.=form_radio($txtElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		

		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('HIV: ','lblhiv');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'radhiv',
				'name'=>'radhiv',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['h2']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		
		$formdisplay.=form_label('Yes');
		
		$txtformElement=array(
				'id'=>'radhiv',
				'name'=>'radhiv',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['h2']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';

		
		
		$formdisplay.='<div class="clearfield"></div>';

		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('HCV: ','lblhcv');
		$formdisplay.='</div>';

		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'radhcv',
				'name'=>'radhcv',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['h3']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		
		$formdisplay.=form_label('Yes');
		
		$txtformElement=array(
				'id'=>'radhcv',
				'name'=>'radhcv',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['h3']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';

		
		
		$formdisplay.='<div class="clearfield"></div>';

		
		
		
		
		

		
		
		//open seventh tab tabs-7
		$formdisplay.='</div>';
		
		//open fifth tab tabs-5
		$formdisplay.='<div id="tabs-5">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Number of Affected : ','lblnumaff');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtnumaff',
				'name'=>'txtnumaff',
				'class'=>'numericfield',
				'value'=>$formdata[0]['patient_family_effected']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Affected NHR Id : ','lblaffnhr');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtaffnhr',
				'name'=>'txtaffnhr',
				'class'=>'',
				'value'=>$formdata[0]['patient_effected_nhrid']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Family Income : ','lblfmyinc');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtfmyinc',
				'name'=>'txtfmyinc',
				'class'=>'numericfield',
				'value'=>$formdata[0]['patient_family_income']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('BPL Eligibility : ','lblbplelig');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'radbpl',
				'name'=>'radbpl',
				'class'=>'',
				'value'=>1
			);
		if($formdata[0]['patient_bpl_eligibility']==1){
			$formdisplay.=form_radio($txtformElement,1,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('Yes');
		
		$txtformElement=array(
				'id'=>'radbpl',
				'name'=>'radbpl',
				'class'=>'',
				'value'=>0
			);
		if($formdata[0]['patient_bpl_eligibility']==0){
			$formdisplay.=form_radio($txtformElement,0,true);
		}else{
			$formdisplay.=form_radio($txtformElement);
		}
		$formdisplay.=form_label('No');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="clearfield"></div>';
		 
		$formdisplay.='<div class="label">';
    $formdisplay.=form_label('BPL Ref Number: ','lblBplRef');
    $formdisplay.='</div>';
    
    $formdisplay.='<div class="boxarea">';
    $txtformElement=array(
        'id'=>'txtBPLrefNo',
        'name'=>'txtBPLrefNo',
        'class'=>'',
        'value'=>$formdata[0]['bpl_ref_number']
      );
    $formdisplay.=form_input($txtformElement);
    $formdisplay.='</div>';
		
		//close tabs-5
		$formdisplay.='</div>';
		
		//open sixth tab tabs-6
		$formdisplay.='<div id="tabs-6">';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('Membership ID : ','lblmemid');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtmemid',
				'name'=>'txtmemid',
				'class'=>'',
				'value'=>$formdata[0]['patient_membership_id']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';
		
		/*$formdisplay.='<div class="clearfield"></div>';
		
		$formdisplay.='<div class="label">';
		$formdisplay.=form_label('nhr ID : ','lblmemid');
		$formdisplay.='</div>';
		
		$formdisplay.='<div class="boxarea">';
		$txtformElement=array(
				'id'=>'txtmemid',
				'name'=>'txtmemid',
				'class'=>'',
				'value'=>$formdata[0]['patient_membership_id']
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</div>';*/
		
		//close tabs-6
		$formdisplay.='</div>';
		
		//close tabs
		$formdisplay.='</div>';
		
		$formdisplay.='<div style="border:0px solid #000;text-align:center">';
		$attri=array(
			'name'=>'patsubmit',
			'value'=>'save registry'
			);
		$formdisplay.=form_submit($attri);
		$formdisplay.='<input type="button" name="Cancel" value="Cancel" onclick="javascript:window.location.href=\''.$this->config->item('base_url').'managepatient/patient_listdata\'" />';
		$formdisplay.='</div>';
		
		$formdisplay.=form_close();
		
		/*$this->form_validation->set_rules('txtfname', 'FirstName', 'required');
		$this->form_validation->set_rules('txtlname', 'LastName', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_message('rule', 'Error Message');
			echo 'error';
		}
		else
		{
			echo 'er';
			redirect('homepage/insert_patdata');
			//$this->g_framework->setFrameworkValue("Hemophilia Society","Divya");
		}*/
		
		if($this->session->userdata('group')==2){
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			$headerdata = array(
				'chapterName' => $result['chapter_name'],
				'username' => $this->session->userdata('username')
			);
			$this->template->write_view('header','header',$headerdata, True);
		
			$data = array('formdisplay'=>$formdisplay);
				
			//$this->form_validation->set_message('FirstName', 'The field can not be the word');
			//$this->template->add_js('js/tabsfun.js','import');
			//$this->template->add_js('js/ui.core.js','import');
			//$this->template->add_js('js/ui.tabs.js','import');
		//	$this->template->add_js('js/ui.datepicker.js','import');
		//	$this->template->add_js('js/jquery.numeric.js','import');
			$this->template->add_js('js/jquery.validate.js','import');
			$this->template->add_css('styles/tabs.css');
			$this->template->add_css('styles/ui.tabs.css');
		//	$this->template->add_css('styles/ui.datepicker.css');
		
		
			$this->template->write('pageheader', 'Patient Form ');
			$this->template->write_view('content','members/list_member',$data,True);
      
       $this->template->add_js('$(document).ready(function() {
        $("#tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
        $("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");
        
        
        jQuery.validator.addMethod("accept", function(value, element, param) {
            return value.match(new RegExp(param ));
        });
        
        $( "#txtdob" ).datepicker({
               changeMonth: true,
               changeYear: true,
                yearRange: "1950:2011" 
          });
        
     
       $("#pat_dispform").validate({
         rules:{
            txtfaclel:{ accept: "[<0-9]" }            
         },
         messages: {
           txtfaclel:"Valid input, 0-9 OR < OR ."
         },
         errorElement: "div"
         
       });
     
      
    });','embed');
    $this->template->add_css('#pat_dispform .error {
      width: auto;
        
        color:#ff0000;
      }', 'embed', 'all');
			$this->template->render();
		}else if($this->session->userdata('group')==1){
			$headerdata = array(
				'chapterName' => 'Hemophilia Federation (India)',
				'username' => $this->session->userdata('username')
			);
			$this->template->write_view('header','header',$headerdata, True);
		
			$data = array('formdisplay'=>$formdisplay);
				
			//$this->form_validation->set_message('FirstName', 'The field can not be the word');
			$this->template->add_js('js/tabsfun.js','import');
			$this->template->add_js('js/ui.core.js','import');
		//	$this->template->add_js('js/ui.tabs.js','import');
		//	$this->template->add_js('js/ui.datepicker.js','import');
		//	$this->template->add_js('js/jquery.numeric.js','import');
			$this->template->add_js('js/jquery.validate.js','import');
			$this->template->add_css('styles/tabs.css');
			$this->template->add_css('styles/ui.tabs.css');
		//	$this->template->add_css('styles/ui.datepicker.css');
			$this->template->write('pageheader', 'Patient Form ');
			$this->template->write_view('content','members/list_member',$data,True);
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
	function expdate($datval){
		if($datval==0){
			$davalue =0;
			return $davalue;
		}else{
			$dobdate=explode('/',$datval);
			$davalue=$dobdate[2].'-'.$dobdate[0].'-'.$dobdate[1];
			return $davalue;
		}
	}
	//To insert patient for data value
	function insert_patdata(){
	 // echo $_POST['txtfctdef'];
    
   
    
		$this->load->database();
		$this->load->library('session');
		$lastupdated=date("m/d/y");
		$chap=$_POST['chapid'];
		//echo $chap;
		//$dbdat=$_POST["txtdob"];
		//$dobdate=explode('/',$dbdat);
		$Pid=$_POST['Pid'];
		
		$lastupdated=date("Y-m-d H:i:s");
		
		if($this->session->userdata('group')==1){
			$query = $this->db->query("Select * from tbl_chapters where chapter_city='".$chap."'");
			$result = $query->result_array();
			$chapterid=$result[0]['chapter_ID'];
		}else if($this->session->userdata('group')==2){
			//Get chapter id
			//$chap=$_POST['chapid'];
			$chapterid=$this->session->userdata('chapter');
		}
		
		if($Pid==0){
		$tabledata=array(
			'patient_first_name' => $_POST['txtfname'],
			'patient_last_name' => $_POST['txtlname'],
			'patient_dob' => $this->expdate($_POST["txtdob"]),
			'patient_sex' => $_POST['radgender'],
			'patient_religion' => $_POST['txtreligion'],
			'patient_father_name' => $_POST['txtfatname'],
			'comm_flat' => $_POST['txtflat'],
			'comm_building' => $_POST['txtbuild'],
			'commu_road' => $_POST['txtlane'],
			'commu_locality' => $_POST['txtATS'],
			'commu_state' => $_POST['txtTCD'],
			'commu_city' => $_POST['txtSU'],
			'commu_pincode' => $_POST['txtpincode'],
			'comm_zone' => $_POST['drpzone'],
			'commu_phone' => $_POST['txtcont'],
			'commu_email' => $_POST['txtemail'],
			'commu_cellnumber' => $_POST['txtmob'],
			'patient_bloodgroup' => $_POST['bloodgrop'],
			'patient_factor_defother' => $_POST['fctdefother'],
			'patient_factor_deficient' => implode(',',$_POST['txtfctdef']),
			'patient_factor_level' => $_POST['txtfaclel'],
			'patient_inhibitor_screen' => $_POST['radinhi'],

		//	'patient_inhibitor_date' => $this->expdate($_POST['txtinhidate']),
		//	'patient_inhibitor_place' => $_POST['txtinhiplc'],
			'h2' => $_POST['radhiv'],
			//'hiv_date' => $this->expdate($_POST['txthivdate']),
			//'hiv_place' => $_POST['txthivplc'],
			'h3' => $_POST['radhcv'],
			//'hcv_date' => $this->expdate($_POST['txthcvdate']),
			//'hcv_place' => $_POST['txthcvplc'],
			//'hbv' => $_POST['radhbv'],
			//'hbv_date' => $this->expdate($_POST['txthbvdate']),
			//'hbv_place' => $_POST['txthbvplc'],

			'patient_studying' => $_POST['radstudy'],
			'patient_highestedu' => $_POST['txthighEdu'],
			'patient_working' => $_POST['rademp'],
			'patient_employment_type' => $_POST['txtEmploymentType'],
			'patient_age_Diagnose' => $_POST['txtagdia'],
			'patient_hospital_diagnose' => $_POST['txthosdia'],
			'patient_form_diagnose'=>$_POST['txtfrmdia'],
			'patient_Deformity'=>$_POST['raddefor'],
			'patient_family_effected' => $_POST['txtnumaff'],
			'patient_effected_nhrid' => $_POST['txtaffnhr'],
			'patient_family_income' => $_POST['txtfmyinc'],
			'patient_bpl_eligibility' => $_POST['radbpl'],
			'patient_Remboursement_faclity' => $_POST['radrembour'],
			'patient_membership_id' => $_POST['txtmemid'],
			'chap_id' => $chapterid,
			'employment_organization' => $_POST['txtEmplOrgName'],
			'employment_ref_number' => $_POST['txtEmplReferenceNumber'],
			'bpl_ref_number' => $_POST['txtBPLrefNo'],
			'last_updated' => $lastupdated
			
		);
		
		$this->db->insert('tbl_pat_personal',$tabledata);
		
		}else{
			$this->db->set('patient_first_name',$_POST['txtfname']);
			$this->db->set('patient_last_name', $_POST['txtlname']);
			$this->db->set('patient_dob',$this->expdate($_POST['txtdob']));
			$this->db->set('patient_sex', $_POST['radgender']);
			$this->db->set('patient_father_name', $_POST['txtfatname']);
			$this->db->set('comm_flat', $_POST['txtflat']);
			$this->db->set('comm_building',$_POST['txtbuild']);
			$this->db->set('commu_road' , $_POST['txtlane']);
			$this->db->set('commu_locality' , $_POST['txtATS']);
			$this->db->set('commu_state', $_POST['txtTCD']);
			$this->db->set('commu_city', $_POST['txtSU']);
			$this->db->set('commu_pincode' , $_POST['txtpincode']);
			$this->db->set('comm_zone', $_POST['drpzone']);
			$this->db->set('commu_phone', $_POST['txtcont']);
			$this->db->set('commu_email', $_POST['txtemail']);
			$this->db->set('commu_cellnumber' , $_POST['txtmob']);
			$this->db->set('patient_bloodgroup' ,$_POST['bloodgrop']);
			$this->db->set('patient_factor_defother' , $_POST['fctdefother']);
			$this->db->set('patient_factor_deficient', implode(',',$_POST['txtfctdef']));
			$this->db->set('patient_factor_level' , $_POST['txtfaclel']);
			$this->db->set('patient_inhibitor_screen' , $_POST['radinhi']);

		
			$this->db->set('h2' , $_POST['radhiv']);
			$this->db->set('h3' , $_POST['radhcv']);

			$this->db->set('patient_studying' ,$_POST['radstudy']);
			$this->db->set('patient_highestedu' , $_POST['txthighEdu']);
			$this->db->set('patient_working' , $_POST['rademp']);
			$this->db->set('patient_age_Diagnose', $_POST['txtagdia']);
			$this->db->set('patient_hospital_diagnose' , $_POST['txthosdia']);
			$this->db->set('patient_form_diagnose',$_POST['txtfrmdia']);
			$this->db->set('patient_Deformity',$_POST['raddefor']);
			$this->db->set('patient_family_effected' , $_POST['txtnumaff']);
			$this->db->set('patient_effected_nhrid' , $_POST['txtaffnhr']);
			$this->db->set('patient_family_income' , $_POST['txtfmyinc']);
			$this->db->set('patient_bpl_eligibility' , $_POST['radbpl']);
			$this->db->set('patient_Remboursement_faclity' ,$_POST['radrembour']);
			$this->db->set('patient_membership_id' , $_POST['txtmemid']);
      $this->db->set('employment_organization' , $_POST['txtEmplOrgName']);
      $this->db->set('employment_ref_number' , $_POST['txtEmplReferenceNumber']);
      $this->db->set('bpl_ref_number' , $_POST['txtBPLrefNo']);
      $this->db->set('patient_employment_type' , $_POST['txtEmploymentType']);
			//$this->db->set('chap_id' , $this->session->userdata('chapter'));
			$this->db->set('chap_id' , $chapterid);
			$this->db->set('last_updated', $lastupdated);
			$this->db->where('patient_ID',$Pid);
			$this->db->update('tbl_pat_personal');	
		}
		
		if($this->session->userdata('group')==1){
			$this->patient_listdataadmin();
		} else if($this->session->userdata('group')==2){
			redirect($this->config->item('base_url').'managepatient/patient_listdata');
		}
		/*$this->load->library('session');
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
		
		$headerdata = array(
			'chapterName' => $result['chapter_name'],
			'username' => $this->session->userdata('username')
			);
		$this->template->write_view('header','header',$headerdata, True);
		
		$display='Data inserted';
		
		$data= array('formdisplay'=>$display);
		
		$this->template->write_view('content','members/list_member',$data, True);
		//$this->template->write_view('','','PWH Management Form',true);
		$this->template->render();*/
	}
function notauthorised(){
  $displaylist="<div align='center'>Data you are looking is not matched <br/><a href='".$this->config->item('base_url')."managepatient/patient_listdata'>Back to List</a> </div>";
      
      $data= array('formdisplay'=>$displaylist);
      $this->template->write('pageheader', 'Not Authorised');
      $this->template->write_view('content','members/list_member',$data, True);
      $this->template->render();
}

	function patient_listdata($pageNumber=0){
		
		$this->load->database();
		$this->load->library('pagination');
		$this->load->library('session');
		
		//Get Total Number of Records		
		$query1 = $this->db->query("Select count(patient_ID) as totalrows from tbl_pat_personal where chap_id='".$this->session->userdata('chapter')."'");
		$result1 = $query1->result_array();
		
		$rec_perpage=15;
		$config['base_url'] = $this->config->item('base_url').'homepage/patient_listdata/';
		$config['total_rows'] = $result1[0]["totalrows"];
		$config['per_page'] =$rec_perpage;
	
		$sqlquery="Select * from tbl_pat_personal where chap_id='".$this->session->userdata('chapter')."' order by patient_ID desc limit ".$pageNumber.",".$rec_perpage."";
		$result=$this->db->query($sqlquery);
	
	  $displaylist='';
		$displaylist.='<div class="tableheading">List of PWH';
    $displaylist.='<div class="topnewright"><a href="patient_form">Add New</a></div></div>';
    $displaylist .='<table cellpadding="0" cellspacing="0" width="100%">';
    $displaylist .='<tr><td width="50%">';
		$displaylist.='<table border="0" width="99%" class="memberList">';
		$displaylist.='<tr>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Sl. no';
		$displaylist.='</th>';
		//$displaylist.='<th rowspan="2">';
		//$displaylist.='Reg No';
		//$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Name';
		$displaylist.='</th>';
		$displaylist.='<th colspan="2">';
		$displaylist.='Factor';
		$displaylist.='</th>';
	 //$displaylist.='<th rowspan="2">';
	//$displaylist.='Deformity';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.='Inhibitor';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.='Clinical';
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.="View";
	//$displaylist.='</th>';
	//$displaylist.='<th rowspan="2">';
	//$displaylist.="Upload";
	//$displaylist.='</th>';
		$displaylist.='</tr>';
		
		$displaylist.='<tr>';
		$displaylist.='<th>Deficiency';
		$displaylist.='</th>';
		$displaylist.='<th>Level';
		$displaylist.='</th>';
		$displaylist.='</tr>';
		$i=$pageNumber;
		foreach($result->result_array() as $row){
			$displaylist.='<tr>';
			$displaylist.='<td align="center">';
			$i++;
			$displaylist.=$i;
			$displaylist.='</td>';
			//$displaylist.='<td>';
			//$displaylist.='<a href="patient_form/'.$row['patient_ID'].'">'.$row['patient_effected_nhrid'].'</a>';
			//$displaylist.='</td>';
			$displaylist.='<td>';
			//$displaylist.='<a href="'.$this->config->item('base_url').'homepage/patient_form/'.$row['patient_ID'].'">'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
			$displaylist.='<a href="#" id="'.$row['patient_ID'].'" class="pwhdetailslink">'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_deficient'];
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_level'];
			$displaylist.='</td>';
		/*	if($row['patient_Deformity']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_blue.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_grey.jpg"/>';
				$displaylist.='</td>';
			}
			if($row['patient_inhibitor_screen']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_orange.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_grey.jpg"/>';
				$displaylist.='</td>';
			}
			$displaylist.='<td>';
			//$displaylist.=$row['commu_cellnumber'];
			$displaylist.='</td>';//abheshik roll no 61 sainic shcol kodagu kudige post 571232 kodagu distric somarpet taluk
			$displaylist.='<td align="center">';//pavan pawar roll no 32 8th cls sainic shol kodagu kudige distric
			$displaylist.='<!--<a href="'.$this->config->item('base_url').'homepage/pwhview/'.$row['patient_ID'].'">-->view<!--</a>-->';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.='upload';
			$displaylist.='</td>';*/
			$displaylist.='</tr>';
			
		}
		$displaylist.='</table>';
    $displaylist .='</td><td width="50%">';
    $displaylist .='<div id="pwh_resultdetails"></div>';
    $displaylist .='</td></tr></table>';
		$displaylist.='<br/><br/>';
		$displaylist.='<div class="paginationstyle">';
		$this->pagination->initialize($config);
		$displaylist.=$this->pagination->create_links();
		$displaylist.='</div>';	
		
		if($this->session->userdata('group')==2){
			$this->load->library('session');
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			
			$headerdata = array(
				//'chapterName' => 0,
				'chapterName' => $result['chapter_name'],
				'username' => $this->session->userdata('username')
				);
			$this->template->write_view('header','header',$headerdata, True);
			
			$data= array('formdisplay'=>$displaylist);
			
			$this->template->write('pageheader', 'Members List ');
			$this->template->write_view('content','members/list_member',$data, True);
      
      //Ajax Call for details
      
      //for tooltip
    $this->template->add_js('$(document).ready(function() {
        
       
        $(".memberList tr:even").css("background-color", "#E8E8E8");
        
        $(".pwhdetailslink").click(function() {
          var clickValue=$(this).attr(\'id\');
         
         $.ajax({
            url: "'.base_url().'homepage/details_pwh_dashboard/"+clickValue,
            success: function(data) {
               $("#pwh_resultdetails").html(data);
              
          }
        });
         
         
          
        });
        
        });
        
        
        function updatedata(){
          var chkValue=$("#tracedmode:checked").val();
          var clickID=$("#selectedid").val();
          //alert("I am clicked selectedid: "+chkValue+" "+clickID);
          if (chkValue=="on"){
          $.post("'.base_url().'homepage/details_pwh_dashboard", { selectedid: clickID },
            function(data){
              
            });          
          }
          
        }
        
      ', 'embed');
      
      
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
  function  details_pwh_dashboard($id=0){
    //fetch data from database
    $this->load->database();     
    
    $pwh_query = $this->db->query("Select *  from tbl_pat_personal where patient_ID=".$id);
    $pwh_result = $pwh_query->result_array();
    $pwh_result=$pwh_result[0];
    $pwh_details='';
    $pwh_details='<div class="tableheading">PWH Details</div>';
    $pwh_details.='<table width="100%" class="pwhdetails">';

    $pwh_details.='<tr>';
    $pwh_details.='<th>Name:</th>';
    $pwh_details.='<td>'.$pwh_result['patient_first_name'].' '.$pwh_result['patient_last_name'].'</td>';
    $pwh_details.='<td rowspan="4" class="pwhimage"><img src="'.$this->config->item('base_url').'images/miss_image.gif"/></td>';
    $pwh_details.='</tr>';

    $pwh_details.='<tr>';
    $pwh_details.='<th>Father/Gaurdin:</th>';
    $pwh_details.='<td>'.$pwh_result['patient_father_name'].'</td>';
    $pwh_details.='</tr>';
    
    $pwh_details.='<tr>';
    $pwh_details.='<th>Clinical:</th>';
    $otherFactorInfoTemp=otherfactors($pwh_result['patient_factor_defother']);
    $otherFactorInfoTemp=empty($otherFactorInfoTemp)?'':'/ '.$otherFactorInfoTemp;
    $factorinfo=factordeficiencyreturn($pwh_result['patient_factor_deficient']).$otherFactorInfoTemp;
    $pwh_details.='<td>Factor - '.$factorinfo.', '.$pwh_result['patient_factor_level'].', '.bloodgroupretrun($pwh_result['patient_bloodgroup']).'</td>';
    $pwh_details.='</tr>';
    
    $pwh_details.='<tr>';
    $pwh_details.='<th>Address:</th>';
    $pwh_details.='<td>';
    $pwh_details.=$pwh_result['comm_flat'].' '.$pwh_result['comm_building'].'<br/>';
    $pwh_details.=$pwh_result['commu_road'].' '.$pwh_result['commu_locality'].'<br/>';
    $pwh_details.=$pwh_result['commu_city'].'-'.$pwh_result['commu_pincode'].'<br/>';
    $pwh_details.=$pwh_result['commu_state'].'<br/>';
    $pwh_details.='</td>';
    $pwh_details.='</tr>';
    
    $pwh_details.='<tr>';
    $pwh_details.='<th>Phone:</th>';
    $pwh_details.='<td>'.$pwh_result['commu_phone'].' '.$pwh_result['commu_cellnumber'].'</td>';
    $pwh_details.='</tr>';
    
    $pwh_details.='</table>';
    $pwh_details.='<div class="pwhnavigation">';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/medicinelog.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/deformity.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/clinicaldata.jpg" /></a>';
    $pwh_details.='<a href="#"><img src="'.$this->config->item('base_url').'images/modifydata.jpg" /></a>';
    $pwh_details.='</div>';
    echo $pwh_details;
  }
	function patient_listdataadmin($pageNumber=0){
		
		$this->load->database();
		$this->load->library('pagination');
		$this->load->library('session');
		
		//Get Total Number of Records		
		$query1 = $this->db->query("Select count(patient_ID) as totalrows from tbl_pat_personal");
		$result1 = $query1->result_array();
		
		$rec_perpage=15;
		$config['base_url'] = $this->config->item('base_url').'homepage/patient_listdataadmin/';
		$config['total_rows'] = $result1[0]["totalrows"];
		$config['per_page'] =$rec_perpage;
		$config['uri_segment'] = 3;
	
		$sqlquery="Select * from tbl_pat_personal order by patient_first_name limit ".$pageNumber.",".$rec_perpage."";
		$result=$this->db->query($sqlquery);
	
		$displaylist='';
		$displaylist.='<div class="tableheading">List of PWHs </div>';
		$displaylist.='<div class="topnew"><a href="patient_form">Add New</a></div>';
		$displaylist.='<table border="0" width="99%" class="memberList" id="memberslist">';
		$displaylist.='<thead>';
		$displaylist.='<tr>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Sl. no';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Reg No';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Name';
		$displaylist.='</th>';
		$displaylist.='<th colspan="2">';
		$displaylist.='Factor';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Blood Group';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Inhibitor';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='Clinical';
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.="view";
		$displaylist.='</th>';
		$displaylist.='<th rowspan="2">';
		$displaylist.='photo';
		$displaylist.='</th>';
		$displaylist.='</tr>';
		
		$displaylist.='<tr>';
		$displaylist.='<th>Deficiency';
		$displaylist.='</th>';
		$displaylist.='<th>Level';
		$displaylist.='</th>';
		$displaylist.='</tr>';
		$displaylist.='</thead>';
		
		$displaylist.='<tbody>';
		$i=$pageNumber;
		
		foreach($result->result_array() as $row){
			//print_r($row);
			$displaylist.='<tr>';
			$displaylist.='<td align="center">';
			//$displaylist.=$i;
			$i++;
			$displaylist.=$i;
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.=''.$row['patient_effected_nhrid'].'';
			$displaylist.='</td>';
			$displaylist.='<td>';
			$displaylist.='<a href="'.$this->config->item('base_url').'homepage/patient_form/'.$row['patient_ID'].'">'.$row['patient_first_name'].' '.$row['patient_last_name'].'</a>';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_deficient'];
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			$displaylist.=$row['patient_factor_level'];
			$displaylist.='</td>';
			if($row['patient_Deformity']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_blue.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/deformity_grey.jpg"/>';
				$displaylist.='</td>';
			}
			if($row['patient_inhibitor_screen']=='1'){
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_orange.jpg"/>';
				$displaylist.='</td>';
			}else{
				$displaylist.='<td align="center">';
				$displaylist.='<img src="/images/inhibitors_grey.jpg"/>';
				$displaylist.='</td>';
			}
			$displaylist.='<td>';
			//$displaylist.=$row['commu_cellnumber'];
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			//$displaylist.='<a href="'.$this->config->item('base_url').'homepage/pwhview/'.$row['patient_ID'].'">view</a>';
			$displaylist.='view';
			$displaylist.='</td>';
			$displaylist.='<td align="center">';
			//$displaylist.='<a href="'.$this->config->item('base_url').'homepage/profilephoto/'.$row['patient_ID'].'">upload</a>';
			$displaylist.='upload';
			$displaylist.='</td>';
			$displaylist.='</tr>';
		}
		$displaylist.='</tbody>';
		$displaylist.='</table>';
		$displaylist.='<br/>';
		$displaylist.='<div class="paginationstyle">';
		$this->pagination->initialize($config);
		$displaylist.=$this->pagination->create_links();
		$displaylist.='</div>';	
		
		if($this->session->userdata('group')==1){
			$this->load->library('session');
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
			$headerdata = array(
				'chapterName' => 'Hemophilia Federation (India)',
				'username' => $this->session->userdata('username')
				);
			$this->template->write_view('header','header',$headerdata, True);
			
			$data= array('formdisplay'=>$displaylist);
			$this->template->add_js('js/jquery.tablesorter.js','import');
			//Java script for Sorting
			$this->template->add_js('$(document).ready(function(){ 
				$.tablesorter.defaults.widgets = ["zebra"]; 
				$.tablesorter.defaults.sortList = [[0,0]]; 
				$("#memberslist").tablesorter(); 
				}); ', 'embed');
			
			$this->template->write('pageheader', 'Members List ');
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			
			$this->load->view('normalview',$this->data);
		}
	}
	function pwhview(){
		echo 'yet to be done';
	}
	function profilephoto($pwhid){
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');

		$attr='enctype="multipart/form-data"';
		$display=form_open('homepage/uploadprofilepic',$attr);

		$display.='<table align="center">';
		
		$display.='<tr>';
		$display.='<td> Upload profile picture :';
		$display.='</td>';
		$display.='<td>';
		$txtformElement=array(
			'id'=>'profilepicname',
			'name'=>'profilepicname',
			'size'=>'40'
			);
		$display.=form_upload($txtformElement);
		$data = array(
			'pwnval' => $pwhid
			);
		$display.=form_hidden($data);
		$display.='</td>';
		$display.='</tr>';

		$display.='<tr>';
		$display.='<td colspan="2" align="center">';
		$data = array(
			'id'  => 'upload',
			'name'  => 'upload',
			'value'	=> 'upload',
			);
		$display.=form_submit('upload','upload');
		$display.='</td>';
		$display.='</tr>';
		$display.='</table>';
		
		$display.=form_close();	
		
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
		$headerdata = array(
			'chapterName' => 'Hemophilia Federation (India)',
			'username' => $this->session->userdata('username')
			);
		$this->template->write_view('header','header',$headerdata, True);
		
		$data= array('formdisplay'=>$display);
		$this->template->write('pageheader', 'upload profile photo');
		$this->template->write_view('content','members/list_member',$data, True);
        	$this->template->render();
	}
	function uploadprofilepic(){
		$this->load->database();
		$this->load->library('upload');
		//echo $_POST['pwnval'];
// 		if(isset($_FILES['profilepicname'])){
// 			$file   = read_file($_FILES['profilepicname']['tmp_name']);
// 			$name   = basename($_FILES['profilepicname']['name']);
// 			write_file('profilepic/'.$name, $file);
// 			//updating into database
// 			$this->db->where('patient_ID', $_POST['pwnval']);
// 			$this->db->update();
// 		}
		$this->image_path = $this->config->item('base_url').'profilepic';
		//echo $this->config->item('abspro_path');exit;
		if ($this->input->post('upload')){
			$config = array(
				'allowed_types'=>'gif|jpg|png',
				'upload_path'=> $this->image_path
			);
			//$config['allowed_types'] = 'gif|jpg|png';
			//$config['max_size']	= '100';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
		}
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//$this->upload->uploadprofilepic();
		/*if ( ! $this->homepage->uploadprofilepic())
		{
			$error = array('content' => 'errors in uploading');
			$this->load->view('normalview', $error);
		}	
		else
		{
			$data = array('content' => 'success');
			$this->load->view('normalview', $data);
		}*/
		//redirect('chapterdashboard');
		$this->patient_listdataadmin();
	}
	function chapterdashboard(){
		//to generate the chart
		$this->load->plugin('jpgraph');
		
		// We need some data 
		$datay=array(12,8,19,3,10,5);
		$graph = barcart($datay); 
		
		$this->load->library('session');
		$this->load->database();
		
		//File locations
		//$graph_temp_directory = "/home2/hemophil/public_html/nhr/graphimage";
		$graph_temp_directory = $this->config->item('abs_path');
		$graph_file_name = 'chartone.png'; 
		$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
		if (file_exists($graph_file_location)) {
			unlink($graph_file_location);
		}
		
		// Finally send the graph to the browser
		$graph->Stroke($graph_file_location); 
		
		$formdisplay='';
		if($this->session->userdata('group')==2){
			$formdisplay.='<table class="icons">';
			$formdisplay.='<tr>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.base_url().'managepatient/patient_listdata">';
			$formdisplay.='<img src="/images/pwh_members.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'reports/chapterreports/factordef">';
			$formdisplay.='<img src="/images/reports.jpg"/></a>';
			$formdisplay.='</td>';
			//$formdisplay.='<td rowspan="2">';
			//$formdisplay.='<img src="/graphimage/chartone.png" style="padding:5px;"/>';
			//$formdisplay.='</td>';
			$formdisplay.='</tr>';
		
			$formdisplay.='<tr>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="contact">';
			$formdisplay.='<img src="/images/contact.jpg"/>';
			$formdisplay.='</a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'search/datasearch"><img src="/images/pwh_search.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='</tr>';

			$formdisplay.='<tr>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'homepage/loginaccess/logout">';
			$formdisplay.='<img src="/images/logout1.jpg"/>';
			$formdisplay.='</a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			
			$formdisplay.='</td>';
			$formdisplay.='</tr>';
		
			$formdisplay.='</table>';
		  
       $this->load->library("nhrpwhdetails");
      $pwhcount=$this->nhrpwhdetails->fetch_factorwise();
      $emptycount=$this->nhrpwhdetails->fetch_empty();
			$formdisplay.='<div id="graph">';
       $formdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" >';
       $formdisplay.='<tr><td width="50%">';
      $formdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $formdisplay.='<tr><td class="'.$this->config->item("secction_head").'" colspan="5">PwH Factorwise Count</td></tr>';
       $formdisplay.='<tr>';
      $formdisplay.='<th >Factor 8</th>';
      $formdisplay.='<th >Factor 9</th>';
      $formdisplay.='<th >Others</th>';
      $formdisplay.='<th >Not Known</th>';
      $formdisplay.='<th > Tot Num</th>';
      $formdisplay.='</tr>';
       $formdisplay.='<td>'.$pwhcount['count_f8'].'</td>';
       $formdisplay.='<td>'.$pwhcount['count_f9'].'</td>';
       $formdisplay.='<td>'.$pwhcount['count_other_total'].'</td>';
       $formdisplay.='<td>'.$pwhcount['count_empty'].'</td>';
       $formdisplay.='<td>'.$pwhcount['count_total'].'</td>';
       $formdisplay.='<tr>';
        $formdisplay.='</tr>';
      $formdisplay.='</table>';
      $formdisplay.='<br/><table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $formdisplay.='<tr><td class="ui-accordion-header ui-state-default 
      ui-corner-all nhrpaneltitle" colspan="2">Data to be Collected</td></tr>';
      $formdisplay.='<tr><th width="180">Data of Birth</td><td>'.$emptycount['patient_dob'].'</td></tr>';
       $formdisplay.='<tr><th>Factor Deficiency</th><td>'.$emptycount['patient_factor'].'</td></tr>';
        $formdisplay.='<tr><th>Blood Group</th><td>'.$emptycount['patient_bloodgroup'].'</td></tr>';
         $formdisplay.='<tr><th>Father Name</th><td>'.$emptycount['patient_fathername'].'</td></tr>';
          $formdisplay.='<tr><th>Address</th><td>'.$emptycount['patient_address'].'</td></tr>';
          $formdisplay.='<tr><th>Phone number</th><td>'.$emptycount['patient_phone'].'</td></tr>';
      $formdisplay.='</table>';
        $formdisplay.='</td><td width="50%" style="padding-left:10px;">';
			$formdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $formdisplay.='<tr><td>
      <div class="ui-accordion-header ui-state-default 
      ui-corner-all nhrpaneltitle" colspan="5">From NHR Team</div>
      
      </td></tr>';
      $formdisplay.='</table>';
       $formdisplay.='</tr></table>';
			$formdisplay.='</div>';
		
			$formdisplay.='<div style="clear:both"></div>';
		
			$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
			$result = $query->row_array();
		
			$data= array(
				'formdisplay'=>$formdisplay,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>$result['chapter_name']
			);
			$this->session->set_userdata('headerdata',$headerdata);
			//$this->template->add_css('styles/form.css');
			$this->template->write('pageheader', 'Dashboard');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
        		$this->template->render();
		
		}else if ($this->session->userdata('group')==1){

			$formdisplay.='<table class="icons" border="0">';
			$formdisplay.='<tr>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'datamanage/chaptersnapshot">';
			$formdisplay.='<img src="/images/pwh_members.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="#"><img src="/images/pwh_list.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="#"><img src="/images/pwh_search.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='</tr>';
			
			$formdisplay.='<tr>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'homepage/listusers">';
			$formdisplay.='<img src="/images/user_details.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="/reports/adminreports2/zoneinfo">';
			$formdisplay.='<img src="/images/reports.jpg"/></a>';
			$formdisplay.='</td>';
			$formdisplay.='<td>';
			$formdisplay.='<a href="'.$this->config->item('base_url').'homepage/loginaccess/logout">';
			$formdisplay.='<img src="/images/logout1.jpg"/>';
			$formdisplay.='</a>';
			$formdisplay.='</td>';
			$formdisplay.='</tr>';
			$formdisplay.='</table>';
			
			$formdisplay.='<div style="clear:both"></div>';
			$data= array(
				'formdisplay'=>$formdisplay,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>'Hemophilia Federation (India)'
			);
			$this->session->set_userdata('headerdata',$headerdata);
			$this->template->write('pageheader', 'Dashboard');
			$this->template->write_view('header','header',$headerdata, True);
			$this->template->write_view('content','members/list_member',$data, True);
			$this->template->render();
		}else{
			$display="<div align='center'>Session expired please <a href='".$this->config->item('base_url')."'>login</a> again</div>";
			$this->data['content']=$display;
			$this->load->view('normalview',$this->data);
		}
		
	}
	function listusers($pagenumber=0){
		$this->load->database();
		$this->load->library('session');
		//Pagination Module
		$this->load->library('pagination');
		$listdisplay='';
		
		$querytot=$this->db->query('select count(*) as totaluser from tbl_users');
		$totuser=$querytot->result_array();
		
		$rec_perpage=10;
		$config['base_url'] = $this->config->item('base_url').'homepage/listusers/';
		$config['total_rows'] = $totuser[0]["totaluser"];
		$config['per_page'] = $rec_perpage;
		$config['uri_segment'] = 3;
		
		$query=$this->db->query('select * from tbl_users limit '.$pagenumber.','.$rec_perpage.'');
		$uservar=$query->result_array();
	
		$listdisplay.='<table border="0" width="99%" cellpadding="4" cellspacing="2" class="memberList" id="memberslist">';
		$listdisplay.='<tr>';
		$listdisplay.='<th>sl no</th>';
		$listdisplay.='<th>Registered user</th>';
		$listdisplay.='<th>Chapter</th>';
		$listdisplay.='<th>Publish</th>';
		$listdisplay.='</tr>';
		$i=$pagenumber;
		
		foreach($uservar as $key=>$value){
			if($i%2):$color="odd";else: $color="even"; endif;
			$listdisplay.='<tr class="'.$color.'">';
			$i++;
			$listdisplay.='<td>'.$i.'</td>';
			
			$listdisplay.='<td>'.$uservar[$key]['username'].'</td>';
			$querychap=$this->db->query('select * from tbl_chapters where chapter_ID='.$uservar[$key]['chap_id'].'');
			$chapname=$querychap->result_array();
			$chaptername='';
			
			
				if(isset($chapname[0]['chapter_name'])==''){
					$chaptername='Super Administrator';
					$listdisplay.='<td>'.$chaptername.'</td>';
				}else{
					$chaptername=$chapname[0]['chapter_name'];
					$listdisplay.='<td>'.$chaptername.'</td>';
				}
			
			//print_r($chapname);
			
			
			$listdisplay.='<td align="center"><a href="#" onclick="publish_user('.$uservar[$key]['user_id'].')">';
			
			if($uservar[$key]['access_id']==1){
				$listdisplay.='<img id="publish" src="'.$this->config->item("base_url").'images/tick.png" style="border:none" />';
			}else{
				$listdisplay.='<img id="publish" src="'.$this->config->item("base_url").'images/unpublish.png"   style="border:none"/>';
			}
			$listdisplay.='</a></td>';
			$listdisplay.='</tr>';
		}
		$listdisplay.='</table>';
		$listdisplay.='<br/>';
		$listdisplay.='<div class="paginationstyle">';
		$this->pagination->initialize($config);
		$listdisplay.=$this->pagination->create_links();
		$listdisplay.='</div>';
		
		$data= array(
			'formdisplay'=>$listdisplay,
		);
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>'Hemophilia Federation (India)'
		);
		$this->template->add_js('js/un-publish.js','import');
		$this->template->write('pageheader', 'List of Users');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	function publish_users($user_ID){
		$this->load->database();
		
		$query_res=$this->db->query("select * from tbl_users where user_id=".$user_ID);
		$res_user=$query_res->result_array();
		
		if($res_user[0]['access_id'] == 0)
		{
			$this->db->query("update tbl_users set access_id=1 where user_id=".$user_ID);
		}
		else 
		{
			$this->db->query("update tbl_users set access_id=0 where user_id=".$user_ID);
		}
		redirect('homepage/listusers');
	}
	function datamaping(){
		$this->load->library('session');
		$this->load->helper('form');
		
		$formdisplay=form_open('homepage/searchresult');
		$formdisplay.='<h2 align="center">Search</h2>';
		$formdisplay.='<table align="center">';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Enter Name : </td>';
		
		$formdisplay.='<td>';
		$txtformElement=array(
			'id'=>'name',
			'name'=>'name',
			'size'=>'40',
			'value'=>'',
			'alt'=>'Title'
			);
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td> Factor Deficiency : </td>';
		
		$formdisplay.='<td>';
		$txtformElement=array(
			'id'=>'name',
			'name'=>'name',
			'size'=>'40',
			'value'=>'',
			'alt'=>'Title');
		$formdisplay.=form_input($txtformElement);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td colspan="2" align="center">';
		$data = array(
			'id'  => 'mysubmit',
			'name'  => 'mysubmit',
			'value'	=> 'Send',
			'style'   => 'visibilty:hidden'
			);
		$formdisplay.=form_submit($data);
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='<tr>';
		$formdisplay.='<td colspan="2">';
		
		$formdisplay.='</td>';
		$formdisplay.='</tr>';
		
		$formdisplay.='</table>';
		$formdisplay.=form_close();
		
		$data= array(
			'formdisplay'=>$formdisplay,
		);
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>'Hemophilia'
		);
		
		$this->template->write('pageheader', 'Dashboard');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	//Send contact Mail
	function Contact_mail_HFI(){
		$this->load->library('email');			
		$adminMailId=$this->config->item('adminMailId');
		
		$title = $_POST['subject'];
		$comments = $_POST['comments'];
		$datestring = date('Y-m-d');
		
		$this->load->library('session');
		//echo $this->session->userdata('userid');
		$this->load->database();
		$query = $this->db->query('select * from tbl_users where user_id='.$this->session->userdata('userid'));
		$result = $query->row_array();
		
		$query1 = $this->db->query('select * from tbl_chapters where chapter_ID='.$result['chap_id']);
		$resultchapter = $query1->row_array();
		
		$message='';
		$message.="<html><body>";
		$message.="Sir/Madam,<br/><br/>";
		$message.='<b>'.$title.'</b><br/>';
		$message.=$comments."<br/>";
		$message.="<br/><br/>Regards,<br/>";
		$message.=$this->session->userdata('username');
		$message.="</body></html>";
		$this->email->subject($resultchapter['chapter_name']);
		$this->email->set_mailtype('html');
		$this->email->from($result['email_id']);
		$this->email->to($adminMailId);
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
		
		$this->load->library('session');
		$this->load->database();
		//echo $this->session->userdata('chapter')
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
		
		$messagedisplay='Mail sent to NHR admin. Thank you. Back to <a href="chapterdashboard">Dashboard</a>';
		
		$data= array(
			'formdisplay'=>$messagedisplay,
			);
		$headerdata = array(
			'username'=>$this->session->userdata('username'),
			'chapterName'=>$result['chapter_name']
			);
		//$this->template->add_css('styles/form.css');
		$this->template->write('pageheader', 'Dashboard');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	function contact(){
		$this->load->library('session');
		$this->load->helper('form');
		
		$formdata=form_open('homepage/Contact_mail_HFI');
		$formdata.='<table align="center" border="0" >';
		
		$formdata.='<tr>';
		$formdata.='<td colspan="2" align="center"><h2>Contact HFI</h2></td>';
		$formdata.='</tr>';
		
		$formdata.='<tr>';
		$formdata.='<td width="85">Title:</td>';
		$formdata.='<td>';
			$txtformElement=array(
				'id'=>'subject',
				'name'=>'subject',
				'size'=>'37',
				'value'=>'',
				'alt'=>'Title' );
		$formdata.=form_input($txtformElement);
		$formdata.='</td>';
		$formdata.='</tr>';
		
		$formdata.='<tr>';
		$formdata.='<td>Your message:</td>';
		$formdata.='<td>';
			$txtformElement=array(
				'id'=>'comments',
				'name'=>'comments',
				'rows'=>'10',
				'cols'=>'42',
				'value'=>'',
				'alt'=>'comments' );
		$formdata.=form_textarea($txtformElement);
		$formdata.='</td>';
		$formdata.='</tr>';
		
		$formdata.='<tr>';
		$formdata.='<td colspan="2" align="center">';
			$data = array(
			'id'  => 'mysubmit',
			'name'  => 'mysubmit',
			'value'	=> 'Send',
			'style'   => 'visibilty:hidden'
			);
		$formdata.=form_submit($data);
		$formdata.='</td>';
		$formdata.='</tr>';
		$formdata.='<table>';
		$formdata.=form_close();
		
		$formdata.='<div style="clear:both"></div>';
		
		$this->load->library('session');
		$this->load->database();
		$query = $this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
		$result = $query->row_array();
		$headerdata = array(
			'chapterName' => $result['chapter_name'],
			'username' => $this->session->userdata('username')
			);
		
		$data= array(
			'formdisplay'=>$formdata,
			);
		//$dashboard ='<a href="homepage/loginaccess/logout"><img src="/images/home.jpg" /></a>';
		//$this->template->write('dashboard',$dashboard);
		$this->template->write('pageheader', 'Contact Form');
		$this->template->write_view('header','header',$headerdata, True);
		$this->template->write_view('content','members/list_member',$data, True);
		$this->template->render();
	}
	
	function form_member(){
		$data = array('one'=>'This is a One', 'two'=>'This is a Tow');
		$this->template->write_view('content', 'members/form_member', $data, TRUE);
		$this->template->render();
	}
	function list_member() {
		$data = '';
		$this->template->write_view('content', 'members/list_member', $data, TRUE);
		$this->template->render();
	}
	function testzendframe() {
		$this->load->library('zend');
		$this->zend->load('Zend/Service/Flickr');
		$flickr = new Zend_Service_Flickr('c2f9d353e3fcaffb3db32e6254940ff8');
		$results = $flickr->tagSearch('human');
		$tvalue = '';
		foreach ($results as $result) {
			$tvalue .= $result->title.'<br />';
		}
		//$this->zend->load('Zend/Service/Twitter');
		//$twitter = new Zend_Service_Twitter('somushiv', 'Factor8');
		//$res = $twitter->account->verifyCredentials();
		
		$data = array('one'=>$tvalue, 'two'=>'$res');
		//$response = $twitter->account->endSession();
		$this->template->write_view('content', 'members/form_member', $data, TRUE);
		$this->template->render();
	}
	function testzacl1($resource='memUser') {
		$this->load->library('zend');
		$this->zend->load('Zend/Acl');
		$this->zend->load('Zend/Acl/Role');
		$this->zend->load('Zend/Acl/Resource');
		$acl=new Zend_Acl();
		//Add the Role
		$acl->addRole(new Zend_Acl_Role('NU'));
		$acl->addRole(new Zend_Acl_Role('memUser'),'member');
		//Add Resource
		$acl->add(new Zend_Acl_Resource('users_login'));
		$acl->add(new Zend_Acl_Resource('users_profile'),'users_login');
		$acl->allow('member','users_login');
		$acl->allow('memUser','users_profile');
		
		if ($acl->isAllowed($resource,'users_profile')){
			echo "I am allowed ".$resource;
		}else{
			echo "you are not allowed ".$resource;
		}
		echo "<br/>hello";
	}
	function testzacl($resource='memUser') {
		$this->load->library('zacl');
	}
}

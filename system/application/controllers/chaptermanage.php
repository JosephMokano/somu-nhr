<?php 
class chaptermanage extends Controller {

  function chaptermanage() {
          parent::Controller();
           $this->load->database();
    
    $this->load->library('session');
   $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
    $this->template->add_js('js/jquery-ui-1.8.7.custom.min.js','import');
    $this->template->add_css('styles/smoothness/jquery-ui-1.8.7.custom.css');
  }
  function index() {  
    $this->loginscreen();
  }
  function changepassword(){
  	
  	$this->load->library('session');
  	$chapterData=$this->db->query('select * from tbl_chapters where chapter_ID='.$this->session->userdata('chapter'));
  	$chapterData=$chapterData->row();
  	$formdisplay='<form id="signupform" autocomplete="off" method="post" action="'.$this->config->item('base_url').'chaptermanage/updatepassword">';
  	$formdisplay.='<table cellpadding="4" cellspacing="0" border="0" width="500px" align="center" style="margin:0px 200px">';
  	$formdisplay.='<tr><td>Chapter Keyperson: </td><td>'.$chapterData->chapter_keyperson.'</td><td class="status"></td>
  	</tr>';
  	$formdisplay.='<tr><td>Email Id: </td><td>'.$chapterData->chapter_email.'</td><td class="status"></td>
  	</tr>';
  	$formdisplay.='<tr><td>Phone Number: </td><td>'.$chapterData->chapter_phone.'</td><td class="status"></td>
  	</tr>';
  	$formdisplay.='<tr><th colspan="2">Password Change</th></tr>';
  	$formdisplay.='<tr><td>New Password: </td><td><input type="password" name="chapPassword" id="chapPassword"/></td><td class="status"></td>
  	</tr>';
  	$formdisplay.='<tr><td>Confirm Password: </td><td><input type="password" name="chapConfirmPassword" id="chapConfirmPassword"/></td><td class="status"></td>
  	</tr>';
  	$formdisplay.='<tr>
  		<td>Password Strength:</td><td style="border:1px dotted #cccccc">
  			<div class="password-meter">
	  					<div class="password-meter-message">&nbsp;</div>
	  					<div class="password-meter-bg">
		  					<div class="password-meter-bar"></div>
	  					</div>
	  				</div>
  		
  		
  		</td><td class="status"></td>
  		
  	</tr>';
  	$formdisplay.='<tr><td></td><td><input type="submit" value="Submit" /></td></tr>';
  	$formdisplay.='</table>';
  		$formdisplay.='</form>';
  	
  	$data= array(
				'formdisplay'=>$formdisplay,
			);
			$headerdata = array(
				'username'=>$this->session->userdata('username'),
				'chapterName'=>'Hemophilia Federation (India)'
			);
	//JS Part
	$this->template->add_js('js/jquery.validate.js');
	$this->template->add_js('js/jquery.validate.password.js');
	$this->template->add_css('styles/jquery.validate.password.css');
	$this->template->add_js('
		$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#signupform").validate({
		rules: {
			
			chapPassword: {
				password: "#username"
			},
			chapConfirmPassword: {
				required: true,
				equalTo: "#chapPassword"
			}
		},
		messages: {
			
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			}
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			error.prependTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});
	
	
	});
	

	
	
	','embed');		
  	$this->session->set_userdata('headerdata',$headerdata);
	$this->template->write('pageheader', 'Password Change');
	$this->template->write_view('header','header',$headerdata, True);
	$this->template->write_view('content','members/list_member',$data, True);
	$this->template->render();
  }
  function updatepassword(){
  	$this->load->library("session");
  	$user_id=$this->session->userdata("userid");
  	$dataArray=array(
  		'password'=>md5($_POST['chapPassword'])
  	);
  
  	$this->load->database();
  	$this->db->where('user_id',$user_id);
  	$this->db->update('tbl_users',$dataArray);
  	redirect($this->config->item('base_url').'homepage/login');
  }
}
?>
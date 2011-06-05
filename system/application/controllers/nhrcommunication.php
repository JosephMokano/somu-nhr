<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * {project name},
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package		communication on NHR Site
 * @author		SomuShiv, 05-Jun-2011 11:41:44 AM
 * @subpackage	Libraries
 * @category	Libraries
 * @link		http://WWW.TATWAA.IN
 * @copyright  Copyright (c) tATWAA
 * @version 1
 * 
 */
class nhrcommunication extends Controller{
 function nhrcommunication(){
    parent::Controller();
          $this->load->library('session');
         
      //$this->template->add_css('styles/form.css');
     
      $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
  }
  function index(){
    echo "Index Function";  
  }
  function send_email($refid=0,$groupmode=0){
  	$display='';
  		$display='<form action="'.$this->config->item('base_url').'nhrcommunication/dispatchemail" method="post" >';
  		$display.='<table cellpadding="2" cellspacing="4" border="0" width="80%" align="center">';
		$display.='<tr><th>
			Enter IDs to Send:	
		</th>
			<td><input type="text" name="toemailid" value="" style="width:500px"/></td>
		</tr>';
		$display.='<tr><th>
			Subject:	
		</th>
			<td><input type="text" name="email_subject" value="" style="width:500px"/></td>
		</tr>';
		$display.='<tr><th>
			Message:	
		</th>
			<td><textarea type="text" name="email_message" value="" style="width:500px;height:150px"></textarea></td>
		</tr>';
		$display.='<tr><th>
				
		</th>
			<td><input type="submit" value="Send Now" /><input type="button" value="Cancel" /></td>
		</tr>';
		
		$display.='</table>';
		$display.='</form>';
		$data= array('formdisplay'=>$display);
		$this->template->write('pageheader', 'Send E-Mail');
		$this->template->write_view('content','members/list_member',$data, True);
       	$this->template->render();
  }
  function dispatchemail($mailarray=''){
  	if (empty($mailarray)&&(isset($_POST))){
  		$mailarray=$_POST;
  	}
  	$config = Array(
    	'protocol' => 'smtp',
    	'smtp_host' => 'ssl://smtp.googlemail.com',
    	'smtp_port' => 465,
    	'smtp_user' => $this->config->item('nhrsmtpuser'),
    	'smtp_pass' => $this->config->item('nhrsmtppassword'),
	);
	$this->load->library('email', $config);
	$this->email->set_newline("\r\n");

	$this->email->from($this->config->item('adminMailId'), 'NHR Registry');
	$this->email->to($mailarray['toemailid']);

	$this->email->subject($mailarray['email_subject']);
	$this->email->message($mailarray['email_message']);


	if (!$this->email->send())
    	show_error($this->email->print_debugger());
	else
    	//echo 'Your e-mail has been sent!';  
    	redirect($this->config->item('base_url').'homepage/chapterdashboard');
  }
}
?>
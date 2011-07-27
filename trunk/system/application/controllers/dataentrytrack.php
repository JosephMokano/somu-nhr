<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * NHR Data collection Management,
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package		Appaaccess
 * @author		SomuShiv, 07-May-2011 9:15:28 AM
 * @subpackage	Libraries
 * @category	Libraries
 * @link		http://WWW.TATWAA.IN
 * @copyright  Copyright (c) tATWAA
 * @version 1
 * 
 */
class dataentrytrack extends Controller {
 public function dataentrytrack(){
      parent::Controller();
      $this->load->database();
      $this->load->library("session");
  	$this->session->set_userdata("chapter",0);
  }
  function index(){
    echo "Index Function";  
  }
  function chapterlogindetails(){
  	 $formElement='';
  	 $whereCondiation='';
  	 if (isset($_POST['lookdate'])){
  	 	$whereCondiation=' where date_format(log_datetime,"%m/%d/%Y")="'.$_POST['lookdate'].'"';
  	 }
  	  $chapterinfo='<div id="chapterinfodisplay" >
   	
   	
   	</div>';
  	 // DATE_FORMAT(log_datetime,'%m-%d-%Y');
  	 
  	 $querydate=$this->db->query('select  DISTINCT user_id,audit_id,date_format(log_datetime,"%W, %M %e, %Y") as dated,
  	  log_ipaddress  from tbl_login_audit '.$whereCondiation.' order by log_datetime desc limit 100');
  	 $displaylist='';
  	 $displaylist.='<form action="'.$this->config->item('base_url').'dataentrytrack/chapterlogindetails" method="post" >';
  	 $displaylist.='<div><b>Date: </b><input name="lookdate" id="lookid" />&nbsp;&nbsp;<input type="submit" value="submit"/>
  	 	'.repeater('&nbsp;',30).'<a href="'.$this->config->item('base_url').'homepage/chapterdashboard">[ Dashboard ]</a>
  	 </div>';
	$displaylist.='<div style="height:350px;overflow:auto"><table cellpadding="2" cellspacing="4" border="0" width="100%" class="mytable">
	<!--	<tr>
			<td width="20%">Date Range: </td>
			<td width="20%"><input name="fromdate" type="text" id="fromdate"/></td>
			<td width="20%"><input name="todate" type="text" id="todate"/></td>
		</tr> -->';
	$displaylist.='<tr>
				<th>Sl.No</th>
				<th>Chapter Name</th>
				<th>Phone</th>
				<!-- <th>User Name</th> -->
				<th>Logged Date Time</th>
				<th>Details</th>
			</tr>';
	$i=1;
	foreach($querydate->result() as $qdataRow){
		$chapinfo='';
		$chapinfo=$this->chapterinformation($qdataRow->user_id);
		if (!empty($chapinfo)){
			$loc='';
			if ($qdataRow->log_ipaddress=='122.166.118.19'){
				$loc='*';
			}
		$displaylist.='
			<tr>
				<td>'.$i.'</td>
				<td>'.$chapinfo->chapter_name.'</td>
				<td>'.$chapinfo->chapter_phone.'</td>
				<!-- <td>'.$chapinfo->chapter_keyperson.'</td> -->
				<td align="center">'.$qdataRow->dated.'</td>
				<td align="center"><a href="'.$this->config->item("base_url").'dataentrytrack/patdetails/'.$qdataRow->audit_id.'">View</a></td>
				
				
			</tr>
		';
		$i++;
		}
	}	
		
	$displaylist.='</table></div>';
	$displaylist.='</form>';
	$data= array('formdisplay'=>$displaylist);
	$this->template->add_js('
		$(document).ready(function() {
			$(".mytable tr:odd").addClass("odd");
			$( "#lookid" ).datepicker({
			showOn: "button",
			buttonImage: "/images/calendar.gif",
			buttonImageOnly: true
		});
			
		});
		


	
	','embed');
	$this->template->add_css('/styles/reports.css');
	$this->template->add_js('/js/overlay.js');
	$this->template->add_css('/styles/overlay.css');
	$this->template->add_css('
		.mytable th{
			background-color:#EDEBEB;
			padding:5px;
		}
		.mytable{
			border:1px solid #EDEBEB;
		}
		.odd { background-color: #F5F0F0; }
	','embed');
    $this->template->write('pageheader', 'Chapter Pending Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  private function chapterinformation($user_id){
  	$qryInfo=$this->db->query('select * from tbl_users a join tbl_chapters b on
  		a.chap_id=b.chapter_id where a.user_id='.$user_id);
  	return $qryInfo->row();
  }
  function  patdetails($audit_id){
  	 $formElement='';
  	 $whereCondiation='';
  	
  	  $chapterinfo='<div id="chapterinfodisplay" >
   	
   	
   	</div>';
  	 // DATE_FORMAT(log_datetime,'%m-%d-%Y');
  	 
  	 $queryaudit=$this->db->query('select   user_id,audit_id,date_format(log_datetime,"%Y-%m-%d") as dated,
  	 	date_format(log_datetime,"%W, %M %e, %Y") as dated1,
  	  log_ipaddress  from tbl_login_audit where audit_id='.$audit_id);
  	 $auditrow=$queryaudit->row();
  	 $chpaterinfo=$this->chapterinformation($auditrow->user_id);
  	 //Get User Data
  
  	 $patientQuery=$this->db->query('select * from tbl_pat_personal where chap_id='.$chpaterinfo->chap_id.' and date_format(last_updated,"%Y-%m-%d")="'.$auditrow->dated.'"');
  	 $displaylist='';
  	
  	 $displaylist.='<div>
  	 				<b>Chapter Name: </b>'.$chpaterinfo->chapter_name.'&nbsp; :: &nbsp;
  	 				<!-- <b>Key Person: </b>'.$chpaterinfo->chapter_keyperson.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
  	 				<b>Phone: </b>'.$chpaterinfo->chapter_phone.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/> -->
  	 				<b>Dated: </b>'.$auditrow->dated1.'<br/><a href="'.$this->config->item('base_url').'dataentrytrack/chapterlogindetails">Back to Audit list</a>
  	 			</div><br/>';
	$displaylist.='<div style="height:350px;overflow:auto"><table cellpadding="2" cellspacing="4" border="0" width="60%" class="mytable" align="center">
					';
	$displaylist.='<tr>
				<th>Sl.No</th>
				<th>Patient Name</th>
				<th>Details</th>
			</tr>';
	$i=1;
	foreach($patientQuery->result() as $qdataRow){
		$chapinfo='';
		
			
		$displaylist.='
			<tr>
				<td>'.$i.'</td>
				<td>'.$qdataRow->patient_first_name.' '.$qdataRow->patient_last_name.'</td>
				<td align="center"><a href="'.$qdataRow->patient_ID.'">Details</a></td>
				
				
			</tr>
		';
		$i++;
		
	}	
		
	$displaylist.='</table></div>';
	
	$data= array('formdisplay'=>$displaylist);
	$this->template->add_js('
		$(document).ready(function() {
			$(".mytable tr:odd").addClass("odd");
			$( "#lookid" ).datepicker({
			showOn: "button",
			buttonImage: "/images/calendar.gif",
			buttonImageOnly: true
		});
			
		});
		


	
	','embed');
	$this->template->add_css('/styles/reports.css');
	$this->template->add_js('/js/overlay.js');
	$this->template->add_css('/styles/overlay.css');
	$this->template->add_css('
		.mytable th{
			background-color:#EDEBEB;
			padding:5px;
		}
		.mytable{
			border:1px solid #EDEBEB;
		}
		.odd { background-color: #F5F0F0; }
	','embed');
    $this->template->write('pageheader', 'List of Patients Updated');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  
}
?>
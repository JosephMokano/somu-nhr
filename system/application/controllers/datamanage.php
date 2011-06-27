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
class datamanage extends Controller {
 public function datamanage(){
      parent::Controller();
      $this->load->database();
  }
  function index(){
    echo "Index Function";  
  }
  function chaptersnapshot($chap_zone=1){
  	 //echo $pwhid;
    $displaylist='';
    
    
	
   //Build Form
   $formElement='
   		<fieldset >
   			<legend>&nbsp;<b>Chapter Selector</b>&nbsp;</legend>
   				<div class="formholder">
   					<label> Zones:</label><br/>
   					<input type="radio" name="chap_zone" value="1" checked class="chap_zone" />&nbsp;North
   					<input type="radio" name="chap_zone" value="2" class="chap_zone"/>&nbsp;West
   					<input type="radio" name="chap_zone" value="3" class="chap_zone"/>&nbsp;East
   					<input type="radio" name="chap_zone" value="4" class="chap_zone"/>&nbsp;South
   				</div>
   				<div class="formholder" >
   					<label> List of chapters:</label><br/>
   					<select name="chap_names" id="chap_names">'.$this->chaptercall($chap_zone).'</select>
   				</div>
   				
   		</fieldset>
   		<div style="margin:10px 0px">
   					<a href="/datamanage/chpaterseethrough">:: List of chapters Data Available 	</a>
   					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   					<a href="/datamanage/chpaterseethroughnot">:: Chapters Data to be collected 	</a>
   		<div id="chapterdetails"></div>
   					
   		</div>
   			
   ';
   $chapterinfo='<div id="chapterinfodisplay" >
   	
   	</div>';
	$displaylist.='<table cellpadding="0" cellspacing="4" border="0" width="100%">
		<tr><td width="60%">'.$formElement.'</td><td width="40%">'.$chapterinfo.'</td></tr></table>';
	$data= array('formdisplay'=>$displaylist);
	$this->template->add_js('
		$(document).ready(function() {
			$(".chap_zone").click(function(){
				var myobj=$(this);
				console.log(myobj.val());
				updatechapter(myobj.val());
			});	
			$("#chap_names").change(function(){
				var myobj=$(this);
				console.log(myobj.val());
				getChapterinfo(myobj.val());
  			});
			
		});
		$(document).ajaxStart(function(){
  			show_overlay();
		}).ajaxStop(function(){
 			hide_overlay();
		});
		//Page onload ends
		function updatechapter(chap_zone){
			
		
			$.ajax({
  				"type":"POST",
  				"data":"chap_zone="+chap_zone,
  				"url":"'.$this->config->item('base_url').'datamanage/chaptercall",
  				success:function(data){
  					$("#chap_names").html(data);
  				}
  			});
		}
		function getChapterinfo(chapter_id){
			$.ajax({
  				"type":"POST",
  				"data":"chapter_id="+chapter_id,
  				"url":"'.$this->config->item('base_url').'datamanage/chapterdetails",
  				success:function(data){
  						jdata=jQuery.parseJSON(data);
  						
  					$("#chapterinfodisplay").html(jdata.pwddetails);
  					$("#chapterdetails").html(jdata.chapterdetails);
  				}
  			});
		}
	
	','embed');
	$this->template->add_css('/styles/reports.css');
	$this->template->add_js('/js/overlay.js');
	$this->template->add_css('/styles/overlay.css');
	$this->template->add_css('
	.factDet1{
		width:100%;
		margin:0px auto;
	}
		.factDet1 th{
			width:70%;
			text-align:right;
			padding-right:10px;
		}
		.faceDet1 td{
			border-bottom:1px dotted #E7E7E7;
		}
	.styleblock{
		background-color:#F3EEEE;
		border-bottom:1px solid #cccccc;
		border-top:1px solid #cccccc;
	}
	.leftalign{
		text-align:left;
	}
	','embed');
    $this->template->write('pageheader', 'Chapter Pending Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  function chaptercall($chap_zone=0){
  	$chapmode=0;
  	if (isset($_POST['chap_zone'])){
  		$chapmode=1;
  		$chap_zone=$_POST['chap_zone'];
  	}
  //Get Chapter Data
	$chap_query=$this->db->query('select chapter_ID,chapter_name,chapter_zone from tbl_chapters where chapter_zone='.$chap_zone.' order by chapter_name');
		$chapterelement='<option value="0">-- Select --</option>';
		foreach($chap_query->result() as $rowchap){
			$chapterelement.='<option value="'.$rowchap->chapter_ID.'">'.$rowchap->chapter_name.'</option>';
		}
	if ($chapmode==1){
		echo $chapterelement;
	}else{
		return $chapterelement;
	}
	
  }
  function chapterdetails(){
  	$chapter_id=$_POST['chapter_id'];
  	$params = array('chapter_id' => $chapter_id);
  	 $this->load->library("nhrpwhdetails",$params);
  	 $pwhcount=$this->nhrpwhdetails->fetch_factorwise($chapter_id);
     //PWH Snapshot
     $pwhCountdisplay='';
      $pwhCountdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" >';
      $pwhCountdisplay.='<tr><td width="50%">';
      $pwhCountdisplay.='<table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $pwhCountdisplay.='<tr><td class="'.$this->config->item("secction_head").'" colspan="5" style="font-weight:bold;font-size:1.2em">PwH Factorwise Count</td></tr>';
     
      $pwhCountdisplay.='<tr>';
      $pwhCountdisplay.='<th >Factor 8</th>';
      $pwhCountdisplay.='<th >Factor 9</th>';
      $pwhCountdisplay.='<th >Others</th>';
      $pwhCountdisplay.='<th >Not Known</th>';
      $pwhCountdisplay.='<th > Tot Num</th>';
      $pwhCountdisplay.='</tr><tr>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_f8'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_f9'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_other_total'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_empty'].'</td>';
      $pwhCountdisplay.='<td>'.$pwhcount['count_total'].'</td>';
      $pwhCountdisplay.='</tr>';
      $pwhCountdisplay.='<tr><td style="font-size:.8em" colspan="5"><b>Note: </b> Total may not come correct if you add-up Factor 8, Factor - 9, Others, Not Known. 
      	Becuase of multiple factor deficiency</td></tr>';
       
      $pwhCountdisplay.='</table>';
      
      $emptycount=$this->nhrpwhdetails->fetch_empty($chapter_id);
      $emptydisplay='';
      $emptydisplay.='<div style="text-align:center"in><a href="'.$this->config->item('base_url').'datamanage/generatespreadsheet/'.$chapter_id.'">Download Excel</a></div>';
      $emptydisplay.='<br/><table width="100%" cellpadding="0" celspacing="0" border="0" class="factDet factDet1" >';
       $emptydisplay.='<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Data to be Collected</td></tr>';
      $emptydisplay.='<tr><td colspan="2" class="styleblock">High Priority</td></tr>';
      $emptydisplay.='<tr><th width="180">Data of Birth</td><td>'.$emptycount['patient_dob'].'</td></tr>';
      $emptydisplay.='<tr><th>Blood Group</th><td>'.$emptycount['patient_bloodgroup'].'</td></tr>';
      $emptydisplay.='<tr><th>Factor Deficiency</th><td>'.$emptycount['patient_factor'].'</td></tr>';
      $emptydisplay.='<tr><th>Factor Assay/Level</th><td>'.$emptycount['patient_level'].'</td></tr>';
      $emptydisplay.='<tr><th>Deformity</th><td>'.$emptycount['patient_Deformity'].'</td></tr>';
      
      $emptydisplay.='<tr><td colspan="2" class="styleblock">Priority</td></tr>';
      $emptydisplay.='<tr><th>Inhibitors</th><td>'.$emptycount['patient_inhibitor_screen'].'</td></tr>';
      $emptydisplay.='<tr><th>HIV</th><td>'.$emptycount['h2'].'</td></tr>';
      $emptydisplay.='<tr><th>HCV</th><td>'.$emptycount['h3'].'</td></tr>';
      $emptydisplay.='<tr><th>BPL Eligibility</th><td>'.$emptycount['patient_bpl_eligibility'].'</td></tr>';
      $emptydisplay.='<tr><th>BPL Refrence</th><td>'.$emptycount['patient_bpl_eligibility'].'</td></tr>';
      
      $emptydisplay.='<tr><td colspan="2" class="styleblock">Important</td></tr>';
      $emptydisplay.='<tr><th>Father Name</th><td>'.$emptycount['patient_fathername'].'</td></tr>';
      $emptydisplay.='<tr><th>Address</th><td>'.$emptycount['patient_address'].'</td></tr>';
      //$emptydisplay.='<tr><th>Phone number</th><td>'.$emptycount['patient_phone'].'</td></tr>';
      $emptydisplay.='<tr><th>Studying</th><td>'.$emptycount['patient_studying'].'</td></tr>';
      $emptydisplay.='<tr><th>Highest Class</th><td>'.$emptycount['patient_highestedu'].'</td></tr>';
      $emptydisplay.='<tr><th>Employed</th><td>'.$emptycount['patient_working'].'</td></tr>';
      $emptydisplay.='<tr><th>Remboursement</th><td>'.$emptycount['patient_Remboursement_faclity'].'</td></tr>';
      
      
     
      
      $emptydisplay.='</table>';
      
      $chapterinfo='<div class="spacer"></div>';
      if ($pwhcount['count_total']==0){
      	$chapterinfo.='<div class="alertbox">Data needs to be collected from this Chapter</div><div class="spacer"></div>';
      }
     $retValueajax=array(
     	'pwddetails'=>$chapterinfo.$pwhCountdisplay.'<div class="spacer"></div>'.$emptydisplay,
     	'chapterdetails'=>$this->_viewchatper($chapter_id)
     );
      echo json_encode($retValueajax);
  }
  
  function chpaterseethrough(){
  	$chapterquery='select b.chapter_name,count(a.chap_id) pcount,b.chapter_zone from tbl_pat_personal a 
  	left join tbl_chapters b on a.chap_id=b.chapter_id 
  	group by a.chap_id order by b.chapter_zone, b.chapter_name';		
	$qrychapter=$this->db->query($chapterquery);
	$i=1;
	$displayView='';
	$displayView='<div style="margin:10px 0px;text-align:center">
   					<a href="/datamanage/chpaterseethrough">:: List of chapters Data Available 	</a>
   					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   					<a href="/datamanage/chpaterseethroughnot">:: Chapters Data to be collected 	</a>
   		</div>';
	$displayView.='<table cellpadding="2" cellspacing="1" border="0" width="100%" class="factDet">';
	$displayView.='<tr>
			<th>Slno</th>
			<th>C.Slno</th>
			<th>Chapter Name</th>
			<th>Count</th>
		</tr>';
	$zonearray=array('North','West','East','South');
	$zoneid=0;
	$j=0;

	foreach($qrychapter->result() as $chaprow){
		if ($zoneid!=$chaprow->chapter_zone){
			
			$zoneid=$chaprow->chapter_zone;
			$displayView.='<tr><td class="styleblock"></td><td colspan="3" class="styleblock">'.$zonearray[$zoneid-1].'</td></tr>';
			$j=1;
		}
		$displayView.='
			<tr>
				<td>'.$i.'</td>
				<td>'.$j.'</td>
				<td>'.$chaprow->chapter_name.'</td>
				<td>'.$chaprow->pcount.'</td>
			</tr>jdata=
		';
		$i++;$j++;
		
	}
	
	$displayView.='</table>'; 
	$data= array('formdisplay'=>$displayView);
	$this->template->add_js('','embed');
	$this->template->add_css('styles/reports.css');
	$this->template->add_css('
	.factDet{
		width:80%;
		margin:0px auto;
	}
		.factDet th{
			
			padding-right:10px;
		}
		.factDet td{
  			text-align:left;
			border-bottom:1px dotted #E7E7E7;
		}<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Data to be Collected</td></tr>
	.styleblock{
		background-color:#F3EEEE;
		border-bottom:1px solid #cccccc;
		border-top:1px solid #cccccc;
		text-align:center;
		font-size:1.2em;
		font-weight:bold;
	}
	.leftalign{
		text-align:left;
	}
	','embed');
    $this->template->write('pageheader', 'Chapters Data Available	');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
function chpaterseethroughnot(){
  	$chapterquery='select chapter_name,chapter_zone from tbl_chapters where not (chapter_id in (select DISTINCT chap_id from tbl_pat_personal))';		
	$qrychapter=$this->db->query($chapterquery);
	$i=1;
	$displayView='';
	$displayView='<div style="margin:10px 0px;text-align:center">
   					<a href="/datamanage/chpaterseethrough">:: List of chapters Data Available 	</a>
   					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   					<a href="/datamanage/chpaterseethroughnot">:: Chapters Data to be collected 	</a>
   		</div>';
	$displayView.='<table cellpadding="2" cellspacing="1" border="0" width="100%" class="factDet">';
	$displayView.='<tr>
			<th>Slno</th>
			<th>C.Slno</th>
			<th>Chapter Name</th>
			
		</tr>';
	$zonearray=array('North','West','East','South');
	$zoneid=0;
	$j=0;

	foreach($qrychapter->result() as $chaprow){
		if ($zoneid!=$chaprow->chapter_zone){
			
			$zoneid=$chaprow->chapter_zone;
			$displayView.='<tr><td class="styleblock"></td><td colspan="3" class="styleblock">'.$zonearray[$zoneid-1].'</td></tr>';
			$j=1;
		}
		$displayView.='
			<tr>
				<td>'.$i.'</td>
				<td>'.$j.'</td>
				<td>'.$chaprow->chapter_name.'</td>
				
			</tr>
		';
		$i++;$j++;
		
	}
	
	$displayView.='</table>'; 
	$data= array('formdisplay'=>$displayViewjdata);
	$this->template->add_js('','embed');
	$this->template->add_css('styles/reports.css');
	$this->template->add_css('
	.factDet{
		width:80%;
		margin:0px auto;
	}
		.factDet th{
			
			padding-right:10px;
		}
		.factDet td{
  			text-align:left;
			border-bottom:1px dotted #E7E7E7;
		}
	.styleblock{
		background-color:#F3EEEE;
		border-bottom:1px solid #cccccc;
		border-top:1px solid #cccccc;
		text-align:center;
		font-size:1.2em;
		font-weight:bold;
	}
	','embed');
    $this->template->write('pageheader', 'Chapter Pending Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
  
  function 	generatespreadsheet($chapter_id=67){
  	
  	$bloodgropuArray=array(
				'0'=>'',
				'1'=>'B+',
				'2'=>'B-',	
				'3'=>'A+',
				'4'=>'A-',
				'5'=>'AB+',
				'6'=>'AB-',
				'7'=>'O+',
				'8'=>'O-'
			);
		
 
  	$varFieldArray=array(
  		'Ref.Number',
  		'Patient Name',
  		'Patient Last Name',
  		'Father Name',
  		'DOB',
  		'Blood Group',
  		'Factor Deficiency',
  		'Other Factor Deficiency',
  		'Assay/Factor Level',
  		'Is PWH Deformed',
  		'Inhibitor',
  		'HIV',
  		'HCV',
  		'BPL Eligibility',
  		'BPL Ref.Number',
  		'Flat/Door/Block No',
  		'Premises/Building/Village',
		'Road/State/Lane/Post Office', 
		'Area/Locality/Taluk/sub-Division', 
		'Town/City/District',
		'State/Union Territory', 
		'PinCode',
		'Contact number',
		'Email id',
		'Mobile number',
  		'Employed/Not Employed',
  		'Employment Type',
  		'Highest Class'
  		
  	);
  	
  	$chapQuery=$this->db->query('select 
  			patient_ID,
  			patient_first_name,patient_last_name,
  			patient_father_name,
  			patient_dob,
  			patient_bloodgroup,
  			patient_factor_deficient,
			patient_factor_defother,
			patient_factor_level,
			patient_Deformity,
			patient_inhibitor_screen,
			h2,
			h3,
			patient_bpl_eligibility,
			bpl_ref_number,
			comm_flat,
			comm_building,
			commu_road,
			commu_locality,
			commu_state,
			commu_city,
			commu_pincode,
			comm_zone,
			commu_phone,
			commu_email,
			commu_cellnumber,
			patient_working,
			employment_organization,
			employment_ref_number,
			patient_highestedu
			
  			
  			from tbl_pat_personal where chap_id='.$chapter_id.' order by patient_first_name'	);
  	$empArray=array();
  	
  	foreach($chapQuery->result() as $row){
  		
  		if (!empty($row->patient_bloodgroup)){
  		$row->patient_bloodgroup=$bloodgropuArray[$row->patient_bloodgroup];
  		}else{
  			$row->patient_bloodgroup='-';
  		}
  		$row->patient_factor_deficient=$this->checkFactor($row->patient_factor_deficient);
  		
  		//$row->patient_factor_defother=$factorArray[$row->patient_factor_defother];
  		$row->patient_Deformity=$this->checkRadioValue($row->patient_Deformity);
  		$row->patient_factor_defother=$this->checkOtherFactor($row->patient_factor_defother);
  		$row->patient_inhibitor_screen=$this->checkRadioValue($row->patient_inhibitor_screen);
  		$row->h2=$this->checkRadioValue($row->h2);
  		$row->h3=$this->checkRadioValue($row->h3);
  		$row->patient_bpl_eligibility=$this->checkRadioValue($row->patient_bpl_eligibility);
  		$empArray[]=$row;
  		
  	}
  
  	$patpObj=array("headerArray"=>$varFieldArray,"dataArray"=>$empArray);
  	
  	$this->load->plugin('to_excel');
	nhr_to_excel($patpObj, 'test'); //
  }
  private function  checkRadioValue($rValue){
  	$retvalue='-';	
  	if ($rValue==1){
  		$retvalue='Yes';
  	}elseif  ($rValue==0){
	  	$retvalue='-';
  	}
  	return $retvalue;
  }
  private function checkFactor($factorValue){
  		$factorArray=array(
				'0'=>'-',
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
		$valueArray=explode(',',$factorValue);
		$retValue='';
		foreach($valueArray as $value){
			$retValue.=$factorArray[$value].", ";
		}
		$retValue=substr($retValue,0,-2);
		return $retValue;		
  
  }
  private function checkOtherFactor($factorValue){
  		 $otherArray=array(
				'0'=>'-',
				'1'=>'Von Willebrand',
				'2'=>'Glanzmann',
				'3'=>'Fibrinogenemia',
				'4'=>'Hypofibrinogenemia',
				'5'=>'Functional Platelet Disorder'
			);
		$valueArray=explode(',',$factorValue);
		$retValue='';
		foreach($valueArray as $value){
			$retValue.=$otherArray[$value].", ";
		}
		$retValue=substr($retValue,0,-2);
		return $retValue;		
  
  }
  function editchapterdetails($chapterid){
  	$chapterDetails=$this->db->query('select * from tbl_chapters where chapter_ID='.$chapterid);
  	$chapterRow=$chapterDetails->row();
  	$displaylist='<form method="post" action="'.$this->config->item('base_url').'datamanage/savechapterdetails">
  	<table cellpadding="4" cellspacing="2" border="0" width="90%">
  		<tr><th width="30%">Chapter Name: </th><td>'.$chapterRow->chapter_name.'</td></tr>
  		<tr><th width="30%">Chapter Address: </th><td><input type="text" name="chapter_address1" class="max" value="'.$chapterRow->chapter_address1.'"/></td></tr>
  		<tr><th width="30%"> </th><td><input type="text" name="chapter_address2" class="max" value="'.$chapterRow->chapter_address2.'"/></td></tr>
  		<tr><th width="30%">Phone Number: </th><td><input type="text" name="chapter_phone" class="max" value="'.$chapterRow->chapter_phone.'"/></td></tr>
  		<tr><th width="30%">Cell Number: </th><td><input type="text" name="chapter_cell" class="max" value="'.$chapterRow->chapter_cell.'"/></td></tr>
  		<tr><th width="30%">Key Person: </th><td><input type="text" name="chapter_keyperson" class="max" value="'.$chapterRow->chapter_keyperson.'"/></td></tr>
  		<tr><th width="30%">Fax: </th><td><input type="text" name="chapter_fax" class="max" value="'.$chapterRow->chapter_fax.'"/></td></tr>
  		<tr><th width="30%">Email: </th><td><input type="text" name="chapter_email" class="max" value="'.$chapterRow->chapter_email.'"/></td></tr>
  		<tr><th width="30%"> </th><td><input type="submit"   value="Submit"/></td></tr>
  		<input type="hidden" name="chapter_ID" value="'.$chapterid.'" />
  	</table></form>';
  	
	$data= array('formdisplay'=>$displaylist);
	$this->template->add_js('
		$(document).ready(function() {
			
		})
	
	','embed');
	
	
	
	$this->template->add_css('
	
	','embed');
    $this->template->write('pageheader', 'Chapter Edit Details');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  	
  	
  	
  }
  function  savechapterdetails(){
  	$dataArray=array(
  		
  		"chapter_address1"=>$_POST['chapter_address1'],
  		"chapter_address2"=>$_POST['chapter_address2'],
 		"chapter_city"=>$_POST['chapter_city'],
 		"chapter_state"=>$_POST['chapter_state'],
  		
  		"chapter_phone"=>$_POST['chapter_phone'],
  		"chapter_cell"=>$_POST['chapter_cell'],
  		"chapter_keyperson"=>$_POST['chapter_keyperson'],
  		"chapter_fax"=>$_POST['chapter_fax'],
  		"chapter_email"=>$_POST['chapter_email']
  	);
  	$this->db->where('chapter_ID',$_POST['chapter_ID']);
  	$this->db->update('tbl_chapters',$dataArray);
  	$this->load->helper("url");
  	redirect($this->config->item('base_url').'datamanage/chaptersnapshot');
  }
  function emailthischapter($chapter_id){
  	redirect($this->config->item('baseurl').'nhrcommunication/send_email/'.$chapter_id.'/2');
  }
  //Chapter Details:
  private function _viewchatper($chapter_id=0){
  	$chapterDetails=$this->db->query('select * from tbl_chapters where chapter_ID='.$chapter_id);
  	$chapterRow=$chapterDetails->row();
  	
  	$pwhCountdisplay='';
  	$this->load->library('session');
  	if ($this->session->userdata('group')==10){
  		$pwhCountdisplay='<tr><td></td><td style="text-align:left">
  		<ol> 
  		<li><a href="'.$this->config->item('base_url').'datamanage/updatecalls/'.$chapter_id.'">Update Calls</a></li>
  		<li><a href="'.$this->config->item('base_url').'datamanage/emailthischapter/'.$chapter_id.'">Email this Chapter</a></li>
       	<li><a href="'.$this->config->item('base_url').'datamanage/smsthischapter/'.$chapter_id.'">SMS this Chapter</a></li>
       	<li><a href="'.$this->config->item('base_url').'datamanage/editchapterdetails/'.$chapter_id.'">Edit this Chapter</a></li> 
       	
       	</ol>
       </td></tr>
       ';
  	}
  	$displaylist='
  	<table cellpadding="4" cellspacing="2" border="0" width="100%" class="factDet factDet1">
  		<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Chapter Details</td></tr>
  		<tr><th>Chapter Name: </th><td style="text-align:left">'.$chapterRow->chapter_name.'</td></tr>
  		<tr><th>Chapter Address: </th><td style="text-align:left">'.$chapterRow->chapter_address1.'</td></tr>
  		<tr><th> </th><td style="text-align:left">'.$chapterRow->chapter_address2.'</td></tr>
  		<tr><th>Phone Number: </th><td style="text-align:left">'.$chapterRow->chapter_phone.'</td></tr>
  		<tr><th>Cell Number: </th><td style="text-align:left">'.$chapterRow->chapter_cell.'</td></tr>
  		<tr><th>Key Person: </th><td style="text-align:left">'.$chapterRow->chapter_keyperson.'</td></tr>
  		<tr><th>Fax: </th><td style="text-align:left">'.$chapterRow->chapter_fax.'</td></tr>
  		<tr><th>Email: </th><td style="text-align:left">'.$chapterRow->chapter_email.'</td></tr>
  		
  		'.$pwhCountdisplay.'
  		
  	</table>';
  	
	
  return $displaylist;
  	
  }
  function updatecalls($chapter_id){
  	$formdisplay='';
  	
  	$chapterDetails=$this->db->query('select * from tbl_chapters where chapter_ID='.$chapter_id);
  	$chapterRow=$chapterDetails->row();
  	
  	$pwhCountdisplay='';
  	$this->load->library('session');
  	
  	$displaylist='
  	<form method="post" action="'.$this->config->item('base_url').'datamanage/updatecallsdb" id="commentForm" name="commentForm">
  	<table cellpadding="4" cellspacing="2" border="0" width="100%" class="factDet factDet1">
  		<tr><td class="'.$this->config->item("secction_head").'" colspan="2" style="font-weight:bold;font-size:1.2em">Chapter Details</td></tr>
  		<tr><th>Chapter Name: </th><td style="text-align:left">'.$chapterRow->chapter_name.'</td></tr>
  		<tr><th>Phone Number: </th><td style="text-align:left">'.$chapterRow->chapter_phone." ".$chapterRow->chapter_cell.'</td></tr>
  		
  		<tr><th>Key Person: </th><td style="text-align:left">'.$chapterRow->chapter_keyperson.'</td></tr> 		
  		'.$pwhCountdisplay.'
  		<tr><th>Call </th><td style="text-align:left;"><input type="radio" value="in" name="calltype" /> Incoming&nbsp&nbsp; <input type="radio" value="Out" name="calltype" validate="required:true" /> Outgoing</td></tr>
  		<tr><th>Spoke to: </th><td style="text-align:left;" class="required"><input type="text" value="" name="spoketo" class="max"/> </td></tr>
  		<tr><th>Notes: </th><td style="text-align:left;" class="required"><textarea   name="callnotes" class="max" rows="5"></textarea> </td></tr>
  		<tr><th>Priority: </th><td style="text-align:left;">
  				<select name="priority" validate="required:true">
  					<option value="0">--Select--</option>
  					<option value="1">Low</option>
  					<option value="2">Medium</option>
  					<option value="3">High</option>
  				</select>
  				
  		</td></tr>
  		<tr><td></td><td style="text-align:left;"><input type="submit" value="submit" /></td></tr>
  	</table>
  		<input type="hidden" value="'.$chapter_id.'" name="chapter_id" />
  	</from>
  	';
  		
  	
  	
  	$data= array(
				'formdisplay'=>$displaylist,
	);
	$headerdata = array(
		'username'=>$this->session->userdata('username'),
		'chapterName'=>'Hemophilia Federation (India)'
	);
	$this->template->add_js('js/jquery.validate.js');
	$this->template->add_css('
		.leftalign{
			text-align:left;
		}
	','embed');
	$this->template->add_js('
	$().ready(function() {
	
			$("#commentForm").validate();
		});
	','embed');
	$this->session->set_userdata('headerdata',$headerdata);
	$this->template->write('pageheader', 'Dashboard');
	$this->template->write_view('header','header',$headerdata, True);
	$this->template->write_view('content','members/list_member',$data, True);
	$this->template->render();
  }
  function updatecallsdb(){
  	$this->load->library("session");
  	$dataarray=array(
  		'chapter_id'=>$_POST['chapter_id'],
  		'spoketo'=>$_POST['spoketo'],
  		'calltype'=>$_POST['calltype'],
  		'callnotes'=>$_POST['callnotes'],
  		'priority'=>$_POST['priority'],
  		'user_id'=>$this->session->userdata('userid')
  	);
  	$this->load->database();
  	$this->db->insert('tbl_nhr_call_log',$dataarray);
  	redirect($this->config->item('base_url').'datamanage/chaptersnapshot');
  }
}
?>
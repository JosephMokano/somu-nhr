<?php 
class adminmanage extends Controller {

  function adminmanage() {
          parent::Controller();
          $this->load->library('session');
          $this->load->library('pwh_info');
    // $this->pwhDisplayData=$this->pwh_info->get_pwh_data($pwhid);
     $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
  }
  function index() {  
    $this->loginscreen();
  }
  function societysatus(){
    
    $formdisplay='';
    $formdisplay.='<table cellpadding="0" cellspacing="0" border="0" width="100%">';
    $formdisplay.='<tr>';
    $formdisplay.='<td width="50%">';
   $formdisplay.='<table cellpadding="0" cellspacing="0" border="0ab" width="100%">';
   $formdisplay.='<tr>';
    $formdisplay.='<th width="20%">Select zone:</th>'; 
    $formdisplay.='<td><select id="chapzone" name="chapzone">';
    $formdisplay.='<option value="0">--Select--</option>';
    $formdisplay.='<option value="1">North</option>';
    $formdisplay.='<option value="2">West</option>';
    $formdisplay.='<option value="3">East</option>';
    $formdisplay.='<option value="4">South</option>';
    $formdisplay.='</select></td>';
    $formdisplay.='</tr>';
    $formdisplay.='<tr>';
    $formdisplay.='<th>';
    $formdisplay.='Chapters:';
    $formdisplay.='</th>';
    $formdisplay.='<td>';
    $formdisplay.='<select id="chapterlist" name="chapterlist">';
    $formdisplay.='<option value="0">--Select--</option>';
    $formdisplay.='</select>';
    $formdisplay.='</td>';
    $formdisplay.='</tr>';
    $formdisplay.='</table>';
    $formdisplay.='</td>';
    $formdisplay.='<td width="530">';
    $formdisplay.='<div id="pwhstatus" style="width:530px;"></div>';
    $formdisplay.='</td>';
    $formdisplay.='</tr>';
    $formdisplay.="</table>";
    
    $data['formdisplay']=$formdisplay;
     $this->template->add_js('$(document).ready(function() {
        
         $("#chapzone").change(function(){
          
           var clickValue=$(this).val();
            $.ajax({
            url: "'.base_url().'adminmanage/listchapterzone/"+clickValue,
            success: function(data) {
            //  $(#shipping_method options).remove(); 
              $("#chapterlist").html(data);
            }
          });
         });
         
         $("#chapterlist").change(function(){
           var clickValue=$(this).val();
            $.ajax({
            url: "'.base_url().'adminmanage/chapterdetails/"+clickValue,
            success: function(data) {
            //  $(#shipping_method options).remove(); 
              $("#pwhstatus").html(data);
            }
          });
         });
     })','embed');   
        $this->template->write('pageheader', 'Chapter Information');
       $this->template->write_view('content','members/list_member',$data, True);
        $this->template->render(); 
  }
  function listchapterzone($chapvalue){
    $dispOption='';
    $this->load->database();
    $zonearray=array('','North','West','East','South');
    
    //Get Total Number of Records   
    $chpResult = $this->db->query("Select * from tbl_chapters where chapter_zone=".$chapvalue." order by chapter_name ");
   // $chpResult = $chpQuery->result_array();
   $dispOption.='<option value="0">-- '.$zonearray[$chapvalue].' zone --</option>';
    foreach($chpResult->result_array() as $row){
      $dispOption.='<option value="'.$row['chapter_ID'].'">'.$row['chapter_name'].'</option>';
    }
    
    echo $dispOption;
  }

  function chapterdetails($chapid=0){
    
     
    $formdisplay='';
    $chapcount='select * from tbl_pat_personal where chap_id='.$chapid;
    $this->load->database();
    $chapRes=$this->db->query($chapcount);
    if ($chapRes->num_rows()>0){
      $chapid=array('chapid'=>$chapid);
      $this->load->library("nhrpwhdetails",$chapid);
      $pwhcount=$this->nhrpwhdetails->fetch_factorwise();
      $emptycount=$this->nhrpwhdetails->fetch_empty();
      $formdisplay.='<div id="graph">';

      $formdisplay.='<table width="500" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $formdisplay.='<tr><td class="ui-accordion-header ui-state-default 
      ui-corner-all nhrpaneltitle" colspan="5">PwH Factorwise Count</td></tr>';
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
      $formdisplay.='<br/><table width="300" cellpadding="0" celspacing="0" border="0" class="factDet">';
      $formdisplay.='<tr><td class="ui-accordion-header ui-state-default 
      ui-corner-all nhrpaneltitle" colspan="2">Data to be Collected</td></tr>';
      $formdisplay.='<tr><th width="180">Data of Birth</td><td>'.$emptycount['patient_dob'].'</td></tr>';
       $formdisplay.='<tr><th>Factor Deficiency</th><td>'.$emptycount['patient_factor'].'</td></tr>';
        $formdisplay.='<tr><th>Blood Group</th><td>'.$emptycount['patient_bloodgroup'].'</td></tr>';
         $formdisplay.='<tr><th>Father Name</th><td>'.$emptycount['patient_fathername'].'</td></tr>';
          $formdisplay.='<tr><th>Address</th><td>'.$emptycount['patient_address'].'</td></tr>';
          $formdisplay.='<tr><th>Phone number</th><td>'.$emptycount['patient_phone'].'</td></tr>';
      $formdisplay.='</table>';
       
      
      $formdisplay.='</div>';
    }else{
      $formdisplay="No Data found";
      
    }
    echo $formdisplay;
    
  }
}
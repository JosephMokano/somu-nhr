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
    $formdisplay.='<table cellpadding="0" cellspacing="0" border="1" width="100%">';
    $formdisplay.='<tr>';
    $formdisplay.='<td width="50%">';
   $formdisplay.='<table cellpadding="0" cellspacing="0" border="1" width="100%">';
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
    $formdisplay.='<td width="50%">';
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
         })
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

  function chapterdetails($chapid){
    $chapdetails='';
    
    
  }
}
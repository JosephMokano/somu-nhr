<?php
class managemed extends Controller {
  var $pwhDisplayData='';
  function managemed() {
          parent::Controller();
          $this->load->library('session');
         
      //$this->template->add_css('styles/form.css');
      $pwhid=$this->uri->segment(3);
      
      
      $this->load->library('pwh_info');
     $this->pwhDisplayData=$this->pwh_info->get_pwh_data($pwhid);
     $this->template->write_view('header','header',$this->session->userdata('headerdata'), True);
  }
  function index() {  
    echo "I am called";
  }
  function med_list($pwhid){
    //echo $pwhid;
    $displaylist='';
    $displaylist.='<table cellpadding="0" cellspacing="0" border="0">';
    $displaylist.="<tr><td width='50%'>";
    $displaylist.=$this->pwhDisplayData;
    
    $displaylist.='<a href="'.$this->config->item('base_url').'managepatient/patient_listdata"><button id="managemed">
    <span class="ui-icon ui-icon-document nhrIcon"></span>PwH List</button></a>';
    $displaylist.="</td><td align='center'>";
     $displaylist.='<img src="'.$this->config->item('images_url').'under-construction.jpg" />';
    
    $displaylist.="</tr>";
    $displaylist.="</table>";
    $data= array('formdisplay'=>$displaylist);
      
    $this->template->write('pageheader', 'Medicine Managment ');
    $this->template->write_view('content','members/list_member',$data, True);
   $this->template->render();
  }
} 
?>
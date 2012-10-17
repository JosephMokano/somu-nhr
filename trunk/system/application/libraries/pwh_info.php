<?php

/**
 * NHR PWH Implemantion
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   NHRPWH Details CI
 * @author    Soma Shekar (somu@hemophiliabangalore.org)
 * @version   0.1
 * GPL (GPL-LICENSE.txt) licenses.
*/
class pwh_info{
  var $arrobjpwh=array();
  var $chapterid=0;
  var $obj='';
  var $pwh_id=0;
  function pwh_info(){
    $this->obj =& get_instance();
    //Load config
     $this->obj->load->library('session');
    $this->chapterid= $this->obj->session->userdata('chapter');
   }
  function get_pwh_data($pwhid=0){
    $pwhQuery="select * from tbl_pat_personal where patient_ID=".$pwhid;
    $datavalue=$this->getdataresult($pwhQuery);
    //print_r($datavalue);
    $displayData='';
    $displayData.='<fieldset>';
    $displayData.='<legend>PwH Details</legend>';
    $pwh_result=$datavalue[0];
    $pwh_details='';
    $pwh_details='<div class="ui-accordion-header ui-state-default ui-corner-all nhrpaneltitle" style="margin:5px 0px">PWH Details</div>';
    $pwh_details.='<table width="100%" class="pwhdetails" border="0">';

    $pwh_details.='<tr>';
    $pwh_details.='<td rowspan="5" class="pwhimage" ><img src="'.$this->obj->config->item('base_url').'images/miss_image.gif"/>
    
    </td>';
    $pwh_details.='<th>Name:</th>';
    $pwh_details.='<td>'.$pwh_result['patient_first_name'].' '.$pwh_result['patient_last_name'].'</td>';
   
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
   // $this->load->helper('form');
    $pwh_details.='<tr>';
    $pwh_details.='<th>Phone:</th>';
    $pwh_details.='<td>'.$pwh_result['commu_phone'].' '.$pwh_result['commu_cellnumber'].'</td>';

    $pwh_details.='</tr>';
    $pwh_details.='<tr>
      <td></td>
      <td colspan="2">
       
      </td>
    </tr>';
    $pwh_details.='</table>';
    $displayData.='</fieldset>';
    return $pwh_details;
  }
  private function getdataresult($resQuery){
       $this->obj->load->database();
      $qryObj= $this->obj->db->query($resQuery);
      $tempvar=$qryObj->result_array();
   
      return $tempvar; 
    }
   function getProfilePicture($profile_id){
     $retLink='';
      $this->obj->load->database();
      $qryObj= $this->obj->db->query('select * from tbl_profile_attachments where 
      profile_id='.$profile_id.' order by lastupdated desc limit 0,1');
      if ($qryObj->num_rows()>0){
        $objRow=$qryObj->row();
        $imagelink='profilephoto/'.$objRow->a_filename;
        $retLink=$retLink='<img src="'.$this->obj->config->item('base_url').$imagelink.'" width="120" height="133"/>';
      }else{
        $retLink='<img src="'.$this->obj->config->item('base_url').'images/miss_image.gif"/>';
      }
      return $retLink;
   }
    function getpwh_information($pwh_id){
       $this->obj->load->database();
      $pwhQuery="select * from tbl_pat_personal where patient_ID=".$pwh_id;
      $qryObject=$this->obj->db->query($pwhQuery);
      return $qryObject->row();
    }
} 
?>
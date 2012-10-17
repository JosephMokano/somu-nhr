<?php 
class datamatch extends Controller {

  function datamatch() {
          parent::Controller();
          $this->load->database();
  }
  function index() {  
    echo "Hello";
  }
  function matchdata($chapter_id=0){
    if ($chapter_id==0) exit('chapter id cannot be 0');
    $chapter_info=$this->db->query('select * from tbl_chapters where chapter_id='.$chapter_id);
    $chapter_info=$chapter_info->row();
    echo "<b>Matching for Chapter: </b>".$chapter_info->chapter_name;
    
    $queryobj=$this->db->query('select * from
       tbl_pat_personal where chap_id='.$chapter_id);
    foreach($queryobj->result() as $row){
      $inputText=$this->getfullString($row);
      $this->matchwithdatabase($inputText,$row->patient_ID);
    }  
    
  }
  
  function getfullString($row){
    $retValue='';
      $retValue.=$row->patient_first_name;
      $retValue.=$row->patient_last_name;
      $retValue.=$row->patient_father_name;
      $retValue.=$row->comm_flat;
      $retValue.=$row->comm_building;
      $retValue.=$row->commu_road;
      $retValue.=$row->commu_locality;
      $retValue.=$row->commu_state;
      $retValue.=$row->commu_city;
      $retValue.=$row->commu_pincode;
      $retValue.=$row->comm_zone;
      $retValue.=$row->patient_bloodgroup;
      $retValue.=$row->patient_factor_deficient;
      $retValue.=$row->patient_factor_defother;
      $retValue=$this->removeSpecial($retValue);
      return $retValue;
  }
  function removeSpecial($char_string){
    $retvalue=preg_replace("/[^A-Za-z0-9]/","",$char_string); 
    return strtolower($retvalue);
  }
  function checkSimilar($inputText,$matchText){
     similar_text($inputText, $matchText, $percent);
     return $percent;
  }
  function matchwithdatabase($inputText,$patient_id){
    $compObj=$this->db->query('select * from tbl_pat_personal');
    foreach($compObj->result() as $row){
     
      //  echo $row->patient_ID."<br/>";
        $comparetext=$this->getfullString($row);
        $percent=$this->checkSimilar($inputText,$comparetext);
        if ($percent>=75){
          $this->updatedb($patient_id,$row->patient_ID);
        }
        
    }
  }
  function updatedb($patient_id_pr,$patient_id_update){
    $dbdata=$this->db->query('select * from tbl_dup where patient_id='.$patient_id_pr);
    
    if ($dbdata->num_rows()==0){
      $dataArray=array(
        'patient_id'=>$patient_id_pr,
        'patient_match'=>$patient_id_update
      );
      $this->db->insert('tbl_dup',$dataArray); 
    }else{
      $datarow=$dbdata->row();
      $dataArray=array(
        'patient_match'=>$datarow->patient_match.','.$patient_id_update
      );
      $this->db->where('patient_id',$patient_id_pr);
      $this->db->update('tbl_dup',$dataArray);
    }
  }
}
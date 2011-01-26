<?php
class nhrtools_old extends Controller {

  function nhrtools_old() {
          parent::Controller();
          
  }
  function index() {  
  
  }
  function getolddata(){
    $this->load->database();
    $query="SELECT * FROM tbl_pat_personal_backup where chap_id=58";
    $qryObj=$this->db->query($query);
    foreach($qryObj->result() as $row){
   
      
      
    $dbarray=array(
      'patient_first_name'=>$row->patient_first_name,
      'patient_last_name'=>$row->patient_last_name,
       'patient_dob'=>$row->patient_dob,
      'patient_sex'=>$row->patient_sex,
      'patient_father_name'=>$row->patient_father_name,
       'comm_flat'=>$row->comm_flat,
       'comm_building'=>$row->comm_building,
      'commu_road'=>$row->commu_road,
       'commu_locality'=>$row->commu_locality,
      'commu_state'=>$row->commu_state,
       'commu_city'=>$row->commu_city,
      'commu_pincode'=>$row->commu_pincode,
      'comm_zone'=>$row->comm_zone,
        'commu_phone'=>$row->commu_phone,
       'commu_email'=>$row->commu_email,
       'commu_cellnumber'=>$row->commu_cellnumber,
      'patient_bloodgroup'=> $row->patient_bloodgroup,
      'patient_factor_deficient'=>$row->patient_factor_deficient,
      'patient_factor_defother'=>$row->patient_factor_defother,
       'patient_factor_level'=>$row->patient_factor_level,
       'patient_inhibitor_screen'=>$row->patient_inhibitor_screen,
       'patient_studying'=>$row->patient_studying,
      'patient_highestedu'=>$row->patient_highestedu,
      'patient_working'=>$row->patient_working,
      'patient_age_Diagnose'=>$row->patient_age_Diagnose,
      'patient_hospital_diagnose'=>$row->patient_hospital_diagnose,
      'patient_form_diagnose'=>$row->patient_form_diagnose,
      'patient_Deformity'=>$row->patient_Deformity,
      'patient_family_effected'=>$row->patient_family_effected,
      'patient_effected_nhrid'=>$row->patient_effected_nhrid,
      'patient_family_income'=>$row->patient_family_income,
      'patient_bpl_eligibility'=>$row->patient_bpl_eligibility,
      'patient_Remboursement_faclity'=>$row->patient_Remboursement_faclity,
       'patient_membership_id'=>$row->patient_membership_id,
      'chap_id'=>58,
     
     
      
    );
     //$this->db->insert('tbl_pat_personal', $dbarray); 
    $dataArray[]=$dbarray;
    }
$this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    $this->table->set_template($tmpl); 
   echo $this->table->generate($dataArray); 
  }
}
?>
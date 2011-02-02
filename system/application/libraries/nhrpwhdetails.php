<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
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
class nhrpwhdetails{
  var $arrobjpwh=array();
  var $chapterid=0;
  var $obj='';
    public function nhrpwhdetails($chapterid=0)
    {
    $this->obj =& get_instance();
    //Load config
    
    if ($chapterid==0){
     $this->obj->load->library('session');
    
    
    $this->chapterid= $this->obj->session->userdata('chapter');
    }else{
      $this->chapterid=$chapterid['chapid'];
    }
    
    }
    //get Factor Details
    public function fetch_factorwise(){
     
      $this->buildfactorQuery();
      return $this->arrobjpwh;
    }
     public function fetch_empty(){
     
      $this->fetch_emptywise();
      return $this->arrobjpwh;
    }
    private function buildfactorQuery(){
      
      //Factor 8 count
      $qryF8="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_factor_deficient=8";  
      $this->arrobjpwh['count_f8']=$this->getcoutresult($qryF8);   
      
      //Factor 9 Count        
      $qryF9="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_factor_deficient=9";
      $this->arrobjpwh['count_f9']=$this->getcoutresult($qryF9);   
      
       //Other Factors       
      $qryother="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              not (patient_factor_deficient in (8,9))";
        $this->arrobjpwh['count_other']=$this->getcoutresult($qryother);
      //To Addup other Factor deficiency
      $qryother="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_factor_defother>0";
       $this->arrobjpwh['count_other_total']=$this->arrobjpwh['count_other']+$this->getcoutresult($qryother);       
                
      //Empty Fields        
      $qryempty="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_factor_deficient=0";
       $this->arrobjpwh['count_empty']=$this->getcoutresult($qryempty); 
       
          
       //total Records;       
        $this->arrobjpwh['count_total']=$this->arrobjpwh['count_f8']
            +$this->arrobjpwh['count_f9']+$this->arrobjpwh['count_other']
            +$this->arrobjpwh['count_empty'];   
                                   
    }
    private function fetch_emptywise(){
      //check for Dob
      $qrydob="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_dob is null";
       $this->arrobjpwh['patient_dob']=$this->getcoutresult($qrydob);
       
       //check for father name
      $qryfathername="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_father_name is null";
       $this->arrobjpwh['patient_fathername']=$this->getcoutresult($qryfathername);
       
           //check for Address
      $qryaddress="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              comm_flat is null";
       $this->arrobjpwh['patient_address']=$this->getcoutresult($qryaddress);
                  //check for Phone
      $qryPhone="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              commu_phone is null";
       $this->arrobjpwh['patient_phone']=$this->getcoutresult($qryPhone);
                 //check for bloodgroup
      $qrybloodgroup="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              patient_bloodgroup is null";
       $this->arrobjpwh['patient_bloodgroup']=$this->getcoutresult($qrybloodgroup);
        //check for factor
      $qryfactor="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              (patient_factor_deficient is null or patient_factor_deficient='0')";
       $this->arrobjpwh['patient_factor']=$this->getcoutresult($qryfactor);
         //check for level
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              (patient_factor_level is null or patient_factor_deficient='0')";
       $this->arrobjpwh['patient_level']=$this->getcoutresult($qrylevel);
    }
    
    
    private function getcoutresult($resQuery){
       $this->obj->load->database();
      $qryObj= $this->obj->db->query($resQuery);
      $tempvar=$qryObj->row_array();
   
      return $tempvar['fcount']; 
    }
}

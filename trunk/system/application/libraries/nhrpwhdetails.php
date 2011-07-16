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
    public function nhrpwhdetails($params='')
    {
    $this->obj =& get_instance();
    //Load config
    
    if (empty($params)){
    	$chapterid=0;
    }else{
    	
    	$chapterid=$params['chapter_id'];
    }
    if ($chapterid==0){
     $this->obj->load->library('session');
    
    
    $this->chapterid= $this->obj->session->userdata('chapter');
    }else{
      $this->chapterid=$chapterid['chapid'];
    }
    
    }
    //get Factor Details
    
    public function fetch_factorwise($chapter_id=0){
     $this->chapterid=$chapter_id;
      $this->buildfactorQuery();
      return $this->arrobjpwh;
    }
     public function fetch_empty($chapter_id=0){
     $this->chapterid=$chapter_id;
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
              not (patient_factor_deficient in (8,9,0))";
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
       //Empty Fields        
      $qryempty="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid; 
        $this->arrobjpwh['count_total']=$this->getcoutresult($qryempty);                
    }
   
   function assayFactor($factValue){
     $arrAssay=array();
     
     //Assay <1
      $assay1="select count(patient_id) as fcount from tbl_pat_personal 
      where (REPLACE(patient_factor_level, ' ', '' ) in ('1.00','<1.00','1')) 
      and chap_id=".$this->chapterid."  and 
              patient_factor_deficient=".$factValue;
      $arrAssay[]=$this->getcoutresult($assay1);  
      //Assay 1 to 5
      $assay2="select count(patient_id) as fcount from tbl_pat_personal 
      where ((patient_factor_level*1)>=1 and (patient_factor_level*1)<=5)
      and chap_id=".$this->chapterid."  and 
              patient_factor_deficient=".$factValue;
      $arrAssay[]=$this->getcoutresult($assay2);  
      //Assay >5
      $assay3="select count(patient_id) as fcount from tbl_pat_personal 
      where ((patient_factor_level*1)>5=1)
      and chap_id=".$this->chapterid."  and 
              patient_factor_deficient=".$factValue;
      $arrAssay[]=$this->getcoutresult($assay3);  
      //Assay >5
      $assay4="select count(patient_id) as fcount from tbl_pat_personal 
      where chap_id=".$this->chapterid."  and 
              (patient_factor_level is null or patient_factor_deficient='0')";
      $arrAssay[]=$this->getcoutresult($assay4);  
      
      return  $arrAssay;
   }
   
   
    private function fetch_emptywise(){
      //check for Dob
      $qrydob="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and ((patient_dob is null) or (patient_dob='0000-00-00'))
              ";
       $this->arrobjpwh['patient_dob']=$this->getcoutresult($qrydob);
       
      //check for bloodgroup
      $qrybloodgroup="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
               ((patient_bloodgroup=0) || (patient_bloodgroup is null))";
      
       $this->arrobjpwh['patient_bloodgroup']=$this->getcoutresult($qrybloodgroup);
       
        //check for factor
      $qryfactor="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and (patient_factor_deficient='0') 
              and (patient_id in 
              (select patient_ID from tbl_pat_personal where chap_id=".$this->chapterid." and patient_factor_defother=0))";
                   
       $this->arrobjpwh['patient_factor']=$this->getcoutresult($qryfactor);

      //check for level
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_inhibitor_screen='0' or (patient_inhibitor_screen is null)) ";
       $this->arrobjpwh['patient_level']=$this->getcoutresult($qrylevel);

      //check Deformity
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_Deformity='0' or (patient_Deformity is null)) ";
       $this->arrobjpwh['patient_Deformity']=$this->getcoutresult($qrylevel);
       
//--------------------------------------- Block - 2

      //check Inhibitors
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_inhibitor_screen='0' or (patient_inhibitor_screen is null)) ";
       $this->arrobjpwh['patient_inhibitor_screen']=$this->getcoutresult($qrylevel);
       
       //check H2
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (h2='0' or (h2 is null)) ";
       $this->arrobjpwh['h2']=$this->getcoutresult($qrylevel);

     //check H3
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (h3='0' or (h3 is null)) ";
       $this->arrobjpwh['h3']=$this->getcoutresult($qrylevel);

     //check BPL Eligibility
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_bpl_eligibility='0' or (patient_bpl_eligibility is null)) ";
       $this->arrobjpwh['patient_bpl_eligibility']=$this->getcoutresult($qrylevel);

     //check BPL Refrence
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (bpl_ref_number='' or (bpl_ref_number is null)) ";
       $this->arrobjpwh['bpl_ref_number']=$this->getcoutresult($qrylevel);

//--------------------------------------- Block - 3
       //check for father name
      $qryfathername="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              (length(patient_father_name)=0 || (patient_father_name is null))";
      
       $this->arrobjpwh['patient_fathername']=$this->getcoutresult($qryfathername);
       
      //check for Address
      $qryaddress="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
              	(length(comm_flat)=0 || (comm_flat is null))";
       $this->arrobjpwh['patient_address']=$this->getcoutresult($qryaddress);
      
       //check for Phone
      $qryPhone="select count(patient_ID) as fcount from tbl_pat_personal 
              where chap_id=".$this->chapterid."  and 
               (length(commu_phone)=0)";
       $this->arrobjpwh['patient_phone']=$this->getcoutresult($qryPhone);

       //check is Studing
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_studying='0' or (patient_studying is null)) ";
       $this->arrobjpwh['patient_studying']=$this->getcoutresult($qrylevel);

      //check Highest Refrence
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_highestedu='' or (patient_highestedu is null)) ";
       $this->arrobjpwh['patient_highestedu']=$this->getcoutresult($qrylevel);

      //check is working
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_working='0' or (patient_working is null)) ";
       $this->arrobjpwh['patient_working']=$this->getcoutresult($qrylevel);

       //check is working
      $qrylevel="select count(patient_ID) as fcount from tbl_pat_personal 
      		where chap_id=".$this->chapterid." and (patient_Remboursement_faclity='0' or (patient_Remboursement_faclity is null)) ";
       $this->arrobjpwh['patient_Remboursement_faclity']=$this->getcoutresult($qrylevel);
       

    }
    
    
    
    private function getcoutresult($resQuery){
       $this->obj->load->database();
      $qryObj= $this->obj->db->query($resQuery);
      $tempvar=$qryObj->row();
   
      return $tempvar->fcount; 
    }
}

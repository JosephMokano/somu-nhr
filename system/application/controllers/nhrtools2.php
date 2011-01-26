<?php
class nhrtools2 extends Controller {

  function nhrtools2() {
          parent::Controller();
          
  }
  function index() {  
  
  }
  
  function readcsvfile($csvfilename=''){
    $this->load->library('csvreader');

           $csvfilename = $this->config->item('project_abs_path').'docs/'.$csvfilename;

    $row = 1;
    
    $dbarray=array();
    if (($handle = fopen($csvfilename, "r")) !== FALSE) {
     
    while (($dataArray = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($dataArray);
         if ($row == 1){
           $dataArray = fgetcsv($handle, 1000, ",");
         
         }
        //echo "<p> $num fields in line $row: <br /></p>\n";
        
          $dbarray[]=$this->updateTodb($dataArray);
        
        $row++;
        
       // for ($c=0; $c < $num; $c++) {
     //       echo $dataArray[$c] . "\n";
     //   }
    }
    fclose($handle);
    $this->load->library('table');
   echo $this->table->generate($dbarray); 
}
  }
  function updateTodb($dataArray=''){
    $flevelString='';
    $patmatch=array('/[ %-]/','/ve /','/F-/');
    $repString='';
  // $flevelString=preg_replace($patmatch,$repString,$dataArray[6]);    
   $bloodString=preg_replace($patmatch,$repString,$dataArray[5]);
    $factorinfo=preg_replace($patmatch,$repString,$dataArray[4]);
    
   
   // echo $dataArray[6];
    $dbarray=array(
      'patient_first_name'=>$dataArray[1],
     // 'patient_last_name'=>$dataArray[3],
        'patient_dob'=>$this->dobcorrect($dataArray[2]),
      'patient_sex'=>1,
       'patient_father_name'=>$dataArray[13],
       'comm_flat'=>$dataArray[12],
    //   'comm_building'=>$dataArray[15],
    //  'commu_road'=>$dataArray[0],
     //  'commu_locality'=>$dataArray[8].$dataArray[9],
   //   'commu_state'=>$dataArray[17],
    //   'commu_city'=>$dataArray[10],
  //    'commu_pincode'=>$dataArray[18],
   //   'comm_zone'=>$dataArray[0],
 //       'commu_phone'=>$dataArray[8],
  //     'commu_email'=>$dataArray[19],
   //    'commu_cellnumber'=>$dataArray[9],
    //  'patient_bloodgroup'=> $this->bloodgroupretrun($bloodString),
      'patient_factor_deficient'=>$this->factorvalue($factorinfo),
      'patient_factor_defother'=>$this->factorothervalue($factorinfo),
       'patient_factor_level'=>$flevelString,
       'patient_inhibitor_screen'=>$this->factInhInvalue($factorinfo),
     //  'patient_studying'=>$dataArray[23]=='Student'?1:0,
   //   'patient_highestedu'=>$dataArray[0],
  //    'patient_working'=>$dataArray[0],
  //    'patient_age_Diagnose'=>$dataArray[0],
 //     'patient_hospital_diagnose'=>$dataArray[0],
 //     'patient_form_diagnose'=>$dataArray[0],
  //    'patient_Deformity'=>$dataArray[0],
  //    'patient_family_effected'=>$dataArray[0],
  //    'patient_effected_nhrid'=>$dataArray[0],
 //     'patient_family_income'=>$dataArray[0],
 //     'patient_bpl_eligibility'=>$dataArray[0],
 //     'patient_Remboursement_faclity'=>$dataArray[0],
       //'patient_membership_id'=>$dataArray[1],
      'chap_id'=>4,
   //   'patient_religion'=>$dataArray[0],
      //'last_updated'=>$dataArray[0],
  //    'register_date'=>$dataArray[4]      
    );
    
      $this->load->database();
    // print_r($dbarray);
     
    //$this->db->insert('tbl_pat_personal', $dbarray); 
      
    return $dbarray;
   
  }

  function factorvalue($fvalue){
    $factorArray=array('','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII');
     $retvalue=array_search($fvalue,$factorArray);
     if (empty($retvalue)){
       $retvalue=0;
     } 
    return $retvalue;
  }
  function factInhInvalue($value){
    if (strtolower($value)=='inhibitor'){
      return 1;
    }
  }
  
  function factorothervalue($fvalue){
    if (strtolower($fvalue)=='vwd'){
      $fvalue='Von Willebrand';
    }
   // echo $fvalue."<br>";
    $ofactorArray=array(
        '',
        'Von Willebrand',
        'Glanzmann',
        'Fibrinogenemia',
        'Hypofibrinogenemia',
        'FunctionalPlateletDisorder'
      );
       $retvalue=array_search($fvalue,$ofactorArray);
     if (empty($retvalue)){
       $retvalue=0;
     }
    return $retvalue;
      
     
  }
  function bloodgroupretrun($bgvalue=''){
    $bgarray=array('','B+','B-','A+','A-','AB+','AB-','O+','O-');
    
     $retvalue=array_search($bgvalue, $bgarray);
     if (empty($retvalue)){
       $retvalue=0;
     }
    return $retvalue;
  }
  
  //Bangalore CSV file
  function datamig(){
    $this->readcsvfileah('Vranasi.csv');
  }
  function dobcorrect($dobvalue){
    //remove spaces
    
    //remove spaces
    
    $retvalue='';
    $patmatch=array('/[ %]/');
    $repString='';
    $patmatch1=array('/[\/]/');
    $repString1='.';
    $dobvalue=preg_replace($patmatch,$repString,$dobvalue); 
    $dobvalue=preg_replace($patmatch1,$repString1,$dobvalue); 
    //Check for only 4 Char
    if (strlen($dobvalue)==4){
      $retvalue=$dobvalue.'-1-1';
    }else{
      $dobarray=explode('.',$dobvalue);
      if (count($dobarray)==3){
        if (strlen($dobarray[2])==2){
        if ($dobarray[2]>=0&&$dobarray[2]<40){
          $dobarray[2]="20".$dobarray[2];
        }else{
          $dobarray[2]="19".$dobarray[2];
        }
        }
      $retvalue=$dobarray[2].'-'.$dobarray[1].'-'.$dobarray[0];
      }
    }
    if (empty($retvalue)){
      if (strlen($dobarray[0])<4){
        $retvalue=2011-$dobarray[0]."-1-1";
      }
    }
    return $retvalue;
  }
    function readcsvfileah($csvfilename=''){
    $this->load->library('csvreader');

           $csvfilename = $this->config->item('project_abs_path').'docs/'.$csvfilename;

    $row = 0;
    
    $dbarray=array();
    $dbarray=array();
    if (($handle = fopen($csvfilename, "r")) !== FALSE) {
     $tmpVar='';
     $counter=1;
    while (($dataArray = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($dataArray);
        
        //echo "<p> $num fields in line $row: <br /></p>\n";
        if ($dataArray[0]!=$tmpVar){
          $tmpVar=$dataArray[0];
        }
        if (!empty($dataArray[0])){
         // echo "<br/><br/>";
        
           $dataArray[]=''; 
           $dataArray[]='.'; 
           $dbarray[]=$dataArray;
          $counter=count($dbarray)-1;
         }else{
          
       // echo $row."-----".$dataArray[1]."<br/>";
          $strArray=array("s/o","d/o","c/o");
          $strtemp=strtolower(trim(substr($dataArray[1],0,3)));
          $retstrvalue=in_array($strtemp,$strArray);
          $tvar= $counter;
         
          if ($retstrvalue){
            $dbarray[$tvar][13]=$dataArray[1];
          }else{
         
           $dbarray[$tvar][12]=$dbarray[$tvar][12]." ".$dataArray[1];
          } 
           //$dbarray[$tvar][4]=$dbarray[$tvar][4].", ".$dataArray[4];
            //$dbarray[$tvar][9]=$dataArray[9];
             //$dbarray[$tvar][8]=$dataArray[8];
           
          //$counter++;
         
        }
          
       
        $row++;
        
       // for ($c=0; $c < $num; $c++) {
     //       echo $dataArray[$c] . "\n";
     //   }
    }
    fclose($handle);
    $dbarray2=array();
    foreach($dbarray as $row){
      $dbarray2[]=$this->updateTodb($row);
    }
   
   
    $this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    $this->table->set_template($tmpl); 
   echo $this->table->generate($dbarray2); 
}
  }


  }
?>
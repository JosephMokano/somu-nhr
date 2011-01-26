<?php
class nhrtools extends Controller {

  function nhrtools() {
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
    $patmatch1=array('/[ %Unkn]/','/ve /','/F/');
   $flevelString=preg_replace($patmatch1,$repString,$dataArray[4]);    
  //  $bloodString=preg_replace($patmatch,$repString,$dataArray[3]);
    $factorinfo=preg_replace($patmatch,$repString,$dataArray[3]);
    
  // $ludPatch=explode("s/o",$dataArray[1]);
 
   // echo $dataArray[6];
    $dbarray=array(
      'patient_first_name'=>$dataArray[1]." ".$dataArray[2],
     // 'patient_last_name'=>$dataArray[3],
     //  'patient_dob'=>$this->dobcorrect($dataArray[5]),
      'patient_sex'=>1,
     //'patient_father_name'=>$dataArray[2],
      // 'comm_flat'=>'s/o '.$ludPatch[1],
    //   'comm_building'=>$dataArray[15],
    //  'commu_road'=>$dataArray[0],
     //  'commu_locality'=>$dataArray[4],
   //   'commu_state'=>$dataArray[17],
   //    'commu_city'=>$dataArray[3],
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
    //   'patient_membership_id'=>$dataArray[1],
      'chap_id'=>35,
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
       //   echo "<br/><br/>";
           $dbarray[]=$dataArray;
          $counter=1;
         }else{
          
      //  echo $row."-----".$dataArray[1]."<br/>";
        
          $tvar= count($dbarray)-1;
           $dbarray[$tvar][1]=$dbarray[$tvar][1]." ".$dataArray[1];
           $dbarray[$tvar][4]=$dbarray[$tvar][4].", ".$dataArray[4];
            $dbarray[$tvar][9]=$dataArray[9];
             $dbarray[$tvar][8]=$dataArray[8];
           
          $counter++;
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
//------------------------------------------------Read HTML File
  function readhtml(){
    $dom = new domDocument; 
    $dom->loadHTMLFile("docs/VADODARA.html");
    $dom->preserveWhiteSpace = false;
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

    /*** loop over the table rows ***/
    $dataArray=array();
    foreach ($rows as $row)
    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');
        /*** echo the values ***/
        if (($cols->item(0)->nodeValue)){
            $tmpArray=array();
           
            $tmpArray[]=$cols->item(0)->nodeValue;
             $name=$cols->item(1)->getElementsByTagName('p');
             
             $tmpArray[]=trim($name->item(0)->nodeValue);
            $tmpstring=trim(isset($name->item(1)->nodeValue)?$name->item(1)->nodeValue:'');
            $tmpstring.=trim(isset($name->item(2)->nodeValue)?$name->item(2)->nodeValue:'');
            $tmpstring.=trim(isset($name->item(3)->nodeValue)?$name->item(3)->nodeValue:'');
            $tmpArray[].=$tmpstring;
            $tmpArray[]=trim($cols->item(2)->nodeValue);
            $tmpArray[]=trim($cols->item(3)->nodeValue);
            $tmpArray[]=trim($cols->item(4)->nodeValue);
            
          /*  $t1=$cols->item(6)->getElementsByTagName('p');
            
            $tmpArray[]=$t1->item(0)->nodeValue;
            if (isset($t1->item(1)->nodeValue)){
            $tmpArray[]=($t1->item(1)->nodeValue);
            }else{
              $tmpArray[]='';
            }
            
            
           
            $tmpArray[]=$cols->item(7)->nodeValue;*/
            $dataArray[]=$tmpArray;
        }
        /*** echo the values ***/
       
       
    }

    $dbarray2=array();
    foreach($dataArray as $row){
      $dbarray2[]=$this->updateTodb($row);
    }
     $this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    $this->table->set_template($tmpl); 
   echo $this->table->generate($dbarray2); 
  }

  function readhtm2(){
    $dom = new domDocument; 
    $dom->loadHTMLFile("docs/KUNNAMKUL.html");
    $dom->preserveWhiteSpace = false;
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

    /*** loop over the table rows ***/
    $dataArray=array();
    foreach ($rows as $row)
    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');
        /*** echo the values ***/
       
        if (($cols->item(0)->nodeValue)){
            $tmpArray=array();
           
            $tmpArray[]=$cols->item(0)->nodeValue;
            $name=$cols->item(1)->getElementsByTagName('p');
             
             $tmpArray[]=trim($name->item(0)->nodeValue);
            $tmpstring=trim(isset($name->item(1)->nodeValue)?$name->item(1)->nodeValue:'');
            $tmpstring.=trim(isset($name->item(2)->nodeValue)?$name->item(2)->nodeValue:'');
            $tmpstring.=trim(isset($name->item(3)->nodeValue)?$name->item(3)->nodeValue:'');
            $tmpArray[].=$tmpstring;
            //$tmpArray[]=$cols->item(1)->nodeValue;
            $bsdob=$cols->item(2)->getElementsByTagName('p');
            $tmpArray[]=trim($bsdob->item(0)->nodeValue);
            $tmpArray[]=trim(isset($bsdob->item(1)->nodeValue)?$bsdob->item(1)->nodeValue:'');
             
             $tmpArray[]=trim(isset($bsdob->item(2)->nodeValue)?$bsdob->item(2)->nodeValue:'');
              //$tmpArray[]=$bsdob->item(2)->nodeValue;
             $factorinfo=$cols->item(3)->getElementsByTagName('p');
            $tmpArray[]=trim(isset($factorinfo->item(0)->nodeValue)?$factorinfo->item(0)->nodeValue:'');
            $tmpArray[]=trim(isset($factorinfo->item(1)->nodeValue)?$factorinfo->item(1)->nodeValue:'');
            $dpan=$cols->item(4)->getElementsByTagName('p');
            $tmpArray[]=trim($dpan->item(0)->nodeValue);
           $tmpArray[]=trim(isset($dpan->item(1)->nodeValue)?$dpan->item(1)->nodeValue:'');
            $tmpArray[]=trim(isset($dpan->item(2)->nodeValue)?$dpan->item(2)->nodeValue:'');
            
         
            $dataArray[]=$tmpArray;
        }
    } 
    $dbarray2=array();
    foreach($dataArray as $row){
      $dbarray2[]=$this->updateTodb($row);
    }
    $this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );
    $this->table->set_template($tmpl); 
   echo $this->table->generate($dbarray2); 
  }


  }
?>
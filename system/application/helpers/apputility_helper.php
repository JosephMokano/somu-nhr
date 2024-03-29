<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function setValidateVariable($vartocheck){
  if (isset($vartocheck)){
    return $vartocheck;
  }else{
    return '';
  }
}
 function bloodgroupretrun($bgvalue=0){
   $bgarray=array('','B+','B-','A+','A-','AB+','AB-','O+','O-');
   if (is_numeric($bgvalue)){
     return $bgarray[$bgvalue];
   }else{
    return array_search($bgvalue, $bgarray); 
   }
    
    
  }
 function factordeficiencyreturn($fdefvalue=0){
   $factorArray=array('','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII');
   $fArray=explode(",",$fdefvalue);
   $retValue='';
   if (empty($fdefvalue)){
     $retValue='N/A';
   }else{
   foreach($fArray as $value){
     $retValue.=$factorArray[$value]." & ";
   }
   $retValue=substr($retValue,0,-2);
   }
   return $retValue;
 }
 function otherfactors($defvalue=0){
   if (!is_numeric($defvalue)){
     $defvalue=0;
   }
   $ofactorArray=array(
        '',
        'Von Willebrand',
        'Glanzmann',
        'Fibrinogenemia',
        'Hypofibrinogenemia',
        'Functional Platelet Disorder'
      );
      return $ofactorArray[$defvalue];
 }
 function checkwrongpwhid($pwhid,$chapterid){
 	
   if ($pwhid!=0){
    $ci=& get_instance();
   $ci->load->database(); 
   $checkQuery="select * from tbl_pat_personal 
          where patient_id=".$pwhid." and chap_id=".$chapterid;
  
  $qryResult=$ci->db->query($checkQuery);
  $numrows=$qryResult->num_rows();
  if ($numrows==0){
   redirect("homepage/notauthorised");
  } 
   }      
 }
 function getChapterNamefordisplay($chapterid){
 	$ci=& get_instance();
   $ci->load->database(); 
   $checkquery=$ci->db->query('select * from tbl_chapters where chapter_id='.$chapterid);
   $row=$checkquery->row();
   return $row;
 }
 function checkcaste($castid){
 	$castArray=array('','SC','ST','OBC','GL');
 	if ($castid!=0){
 		return $castArray[$castid];
 	}else{
 		return '';
 	}
 	
 }
 
 function checksex($sexvalue){
 	if ($sexvalue==1){
 		return 'Male';	
 	}else if ($sexvalue==2){
 		return 'Female';
 	}else{
 		return '';
 	}
 	}
 	
 function humantomysql($dt){
	$retvalue=explode('/',$dt);
	$retvalue=$retvalue[2].'-'.$retvalue[0].'-'.$retvalue[1];
	return $retvalue;
}
function mysqltohuman($dt){
	$retvalue='';
	if (!empty($dt)){
	$retvalue=explode('-',$dt);
	$retvalue=$retvalue[1].'/'.$retvalue[2].'/'.$retvalue[0];
	}
	return $retvalue;
}
function checkzero($dt){
	if ($dt==0){
		return '';
	}else{
		if ($dt==1){
			$dt="Yes";
		}
		return $dt;
	}
}
function pwhTagging($para=0){
   $maintenance_mode=array(
        '0'=>'--Select--',
        '1'=>'Transferred ',
        '2'=>'Deceased ',
        '3'=>'Blocked ',
        '4'=>'Duplicate ',
        '5'=>'Non-PWH ',
     );
  if ($para==0){
    return $maintenance_mode;
  }else{
    return $maintenance_mode[$para];
  }
}
function monthutility($para=0){
  $monthArray=array(
    '0'=>'--Select--',
    '1'=>'Jan',
    '2'=>'Feb',
    '3'=>'Mar',
    '4'=>'Apr',
    '5'=>'May',
    '6'=>'Jun',
    '7'=>'Jul',
    '8'=>'Aug',
    '9'=>'Sep',
    '10'=>'Oct',
    '11'=>'Nov',
    '12'=>'Dec',
  );
  if ($para==0){
    return $monthArray;
  }else{
    return $monthArray[$para];
  }
}

?>
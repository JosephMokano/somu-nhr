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

?>
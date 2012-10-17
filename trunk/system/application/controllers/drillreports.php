<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * NHR Data collection Management,
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package   Appaaccess
 * @author    SomuShiv, 07-May-2011 9:15:28 AM
 * @subpackage  Libraries
 * @category  Libraries
 * @link    http://WWW.TATWAA.IN
 * @copyright  Copyright (c) tATWAA
 * @version 1
 * 
 */
class drillreports extends Controller {
  var $zonename=array("North","West","East","South");
 public function drillreports(){
      parent::Controller();
      $this->load->database();
     // echo "index.php";
  }
 function zonecount(){
   $query="Select count(*) as count from tbl_chapters a join tbl_pat_personal b on a.chapter_id=b.chap_id
    group by a.chapter_zone";
    $qObj=$this->db->query($query);
    $objArray=array();
    
    $i=0;
    foreach($qObj->result() as $row){
      $objArray[]=array(
        "zonenm"=>$this->zonename[$i],
        "pcount"=>$row->count
      );
	$i++;
    }
    
    print_r(json_encode($objArray));
 }
 function factorcount($zonemode=0,$chapters=0){
   $wherequery="";
   $whereArray=array(
    " patient_factor_deficient in (8) ",
    " patient_factor_deficient in (9) ",
    " not (patient_factor_deficient in (8,9)) "
   );
   $factLabe=array(
    'Factor-8',
    'Factor-9',
    'Others'
   );
   $zonestring=$this->zonecheck($zonemode);
   
   $objArray=array();
   foreach($whereArray as $key=>$value){
    $query='Select count(*) count from tbl_pat_personal 
      where '.$value.$zonestring;
      
      $qObj=$this->db->query($query);
      $row=$qObj->row();
      $objArray[]=array(
        "factor"=>$factLabe[$key],    
        "fcount"=>$row->count
      );
   }
    
    print_r(json_encode($objArray));
 }
 
 function assayfactor($zonemode=0,$factValue=0,$chap_id=0){
     $arrAssay=array();
     $zonestring=$this->zonecheck($zonemode);
     $factorstring=$this->factorcheck($factValue);
     //Assay <1
      $assay1="select count(patient_id) as fcount from tbl_pat_personal 
      where (REPLACE(patient_factor_level, ' ', '' ) in ('1.00','<1.00','1')) 
        ".$zonestring.$factorstring;
      $arrAssay[]=array(
      'assaymode'=>'Severe',
      'acount'=>$this->getcoutresult($assay1)
      );  
      //Assay 1 to 5
      $assay2="select count(patient_id) as fcount from tbl_pat_personal 
      where ((patient_factor_level*1)>=1 and (patient_factor_level*1)<=5)
      ".$zonestring.$factorstring;
      
      $arrAssay[]=array(
      'assaymode'=>'Mild',
      'acount'=>$this->getcoutresult($assay2)
      );  
      //Assay >5
      $assay3="select count(patient_id) as fcount from tbl_pat_personal 
      where ((patient_factor_level*1)>5)
      ".$zonestring.$factorstring;
      $arrAssay[]=array(
      'assaymode'=>'Moderate',
      'acount'=>$this->getcoutresult($assay3)
      );    
      /*//Assay >5
      $assay4="select count(patient_id) as fcount from tbl_pat_personal 
      where chap_id=".$this->chapterid."  and 
              (patient_factor_level is null or patient_factor_deficient='0')";
      $arrAssay[]=$this->getcoutresult($assay4);*/  
      
      print_r(json_encode($arrAssay));
   }
 
 // Agewise Distribution
 // to display number patients by age...
  function show_report_by_age($zonemode=0,$factValue=0,$chap_id=0)
{
  //This is to Where condiation
    $where='';$where2='';$where1='';
 
   if ($zonemode>0){
     $where=' chap_id in 
        (select chapter_id from tbl_chapters 
          where chapter_zone='.$zonemode.' ) ';
   }
    if ( $factValue>0){
   $whereArray=array(
    " patient_factor_deficient in (8) ",
    " patient_factor_deficient in (9) ",
    " not (patient_factor_deficient in (8,9) )"
   );
	if (!empty($where)){
		$where.=" and ";
	}
	 $where.=$whereArray[$factValue-1];
   }
	if (!empty($where)){
	      $where= ' where '.$where;
	}
    
    $ageArray=array(
       "under 20",
    "20-39",
    "40-59",
    "60-79",
    "80-99",
    "100 plus"
    
    );
    
        $query="select SUM(IF(age < 20,1,0)) as a0,SUM(IF(age BETWEEN 20 and 39,1,0))
     as a1,SUM(IF(age BETWEEN 40 and 59,1,0)) as a2,SUM(IF(age BETWEEN 60 and 79,1,0)) as a3,
     SUM(IF(age BETWEEN 80 and 99,1,0)) as a4,SUM(IF(age > 100,1,0)) as a5 FROM (SELECT TIMESTAMPDIFF(year,patient_dob,current_date())
   as age from tbl_pat_personal ".$where.") as derived";
	
    $qObj=$this->db->query($query);
    $qryRow=$qObj->result_array();
    $qryRow=$qryRow[0];
    

   $resObj=array();$i=0;
	$tot=0;
	    foreach($ageArray as $value){
$tmp='a'.$i;
			$tot=$tot+$qryRow[$tmp];
		$i++;
		}	
$i=0;
    foreach($ageArray as $value){
      $tmp='a'.$i;
      $resArray[]=array(
		'agelabel'=>$value,
		'num'=>($qryRow[$tmp]/$tot)*100
		);
      $i++;
    }
   print_r(json_encode($resArray));    
  }

   private function getcoutresult($resQuery){
       
      $qryObj= $this->db->query($resQuery);
      $tempvar=$qryObj->row();
   
      return $tempvar->fcount; 
    }
 private function zonecheck($zonemode){
   $zonestring='';
   if ($zonemode>0){
     $zonestring=' and chap_id in 
        (select chapter_id from tbl_chapters 
          where chapter_zone='.$zonemode.' ) ';
   }
   return $zonestring;
 }
 private function factorcheck($factorvalue){
   $factorstring='';
   $whereArray=array(
    " patient_factor_deficient in (8) ",
    " patient_factor_deficient in (9) ",
    " not (patient_factor_deficient in (8,9)) "
   );
   if ($factorvalue>0){
     $factorstring=' and '.$whereArray[$factorvalue-1];
   }
   return $factorstring;
 }
 function worldsurveyform(){
   $where=" WHERE (  (TIMESTAMPDIFF(year,patient_dob,current_date()) is NULL))
      and patient_factor_defother=1
   ";
    $query="select SUM(IF(age < 5,1,0)) as a0,SUM(IF(age BETWEEN 5 and 13,1,0))
     as a1,SUM(IF(age BETWEEN 40 and 59,1,0)) as a2,SUM(IF(age BETWEEN 60 and 79,1,0)) as a3,
     SUM(IF(age BETWEEN 80 and 99,1,0)) as a4,SUM(IF(age > 100,1,0)) as a5 FROM (SELECT TIMESTAMPDIFF(year,patient_dob,current_date())
   as age from tbl_pat_personal ".$where.") as derived";
   $query1="select SUM(IF(age < 5,1,0)) as a0,SUM(IF(age BETWEEN 5 and 13,1,0))
     as a1,SUM(IF(age BETWEEN 14 and 18,1,0)) as a2,SUM(IF(age BETWEEN 19 and 44,1,0)) as a3,
     SUM(IF(age BETWEEN 45 and 120,1,0)) as a4  FROM (SELECT TIMESTAMPDIFF(year,patient_dob,current_date())
   as age from tbl_pat_personal ".$where.") as derived";
   echo $query1.'<br/>';
   $query2="SELECT count(patient_id) as count from tbl_pat_personal ".$where." ";
   //echo $query2.'<br/>';
   $query_obj=$this->db->query($query2);
   $query_row=$query_obj->row();
   print_r($query_row); 
   
 }
 function worldsurveyform1(){
   $where="  
   ";
   
   $query2="SELECT count(patient_id) as count from tbl_pat_personal ".$where." order by patient_factor_deficient";
    echo $query2.'<br/>';
   $query_obj=$this->db->query($query2);
   $query_row=$query_obj->row();
   print_r($query_row); 
   
 }
  function worldsurveyform2(){
   $where="  
   ";
   
   $query2="select  patient_factor_level  as fact from tbl_pat_personal group by patient_factor_level";
    echo $query2.'<br/>';
   $query_obj=$this->db->query($query2);
    foreach($query_obj->result() as $row){
      echo $row->fact.'<br/>';
    }
    
   
 }
} 

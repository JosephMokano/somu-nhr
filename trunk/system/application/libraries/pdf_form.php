<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * {project name},
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package		Appaaccess
 * @author		SomuShiv, 04-Jun-2011 1:52:37 PM
 * @subpackage	Libraries
 * @category	Libraries
 * @link		http://WWW.TATWAA.IN
 * @copyright  Copyright (c) tATWAA
 * @version 1
 * 
 */
class pdf_form {
 var  $pdfoject;
 var  $CI;
 var  $pwhdata;
 function pdf_form($params){
 	$this->CI =& get_instance();
 	$obj=$this->CI;
 	$obj->load->database();
 	$obj->load->library("cezpdf"); 	
 }
 function getpwhform($pwhid){
 	$obj=$this->CI;
 	$pwdquery=$obj->db->query('select * from tbl_pat_personal a join tbl_chapters b 
 	on a.chap_id=b.chapter_id where a.patient_id='.$pwhid);
 	$this->pwhdata=$pwdquery->row(); 
 	$this->generatepdf();
 	$obj->cezpdf->ezStream();	
 }
 function getchapterforms($chapter_id){
 	$obj=$this->CI;
 	$pwdquery=$obj->db->query('select * from tbl_pat_personal a join tbl_chapters b 
 	on a.chap_id=b.chapter_id where a.chap_id='.$chapter_id	);
 	foreach($pwdquery->result() as $pwhrow){
 		$this->pwhdata=$pwhrow; 
 		
 		$this->generatepdf();
 		$obj->cezpdf->ezNewPage();
 	}
 	
 	
 	$obj->cezpdf->ezStream();	
 }
 function generatepdf(){
 	// PDF Generation
 	$obj=$this->CI;
 	$pwhdata=$this->pwhdata;
 	$obj->load->library("cezpdf");
 	
		$obj->load->helper('apputility');
		$obj->cezpdf->setColor(0/255,0/255,0/255);
		$obj->cezpdf->selectFont($obj->config->item('project_abs_path').'fonts/Helvetica.afm');
		$obj->cezpdf->ezText($pwhdata->chapter_name, 14, array('justification' => 'center'));
		$obj->cezpdf->ezText('<b>Hemophilia Federation India</b>', 12, array('justification' => 'center'));		
		$obj->cezpdf->ezText('<i>National Hemophilia Registry</i>', 10, array('justification' => 'center'));
		$obj->cezpdf->addPngFromFile($obj->config->item('project_abs_path').'/images/login_logo.png', 20,760,60); 
		
		$obj->cezpdf->setLineStyle(0.5);
    	$obj->cezpdf->line(20,760,560,760);
    		
    	
    	$obj->cezpdf->ezText('');
		$pwhArray=array();
		$pwhArray[0]='<b>Full Name</b>:* '.$pwhdata->patient_first_name.' '.$pwhdata->patient_last_name;
		$pwhArray[1]='<b>Fathers Name</b>:* '.$pwhdata->patient_father_name;
		$t=mysqltohuman($pwhdata->patient_dob);
		if ($t=='00/00/0000')
			$t='';
		$pwhArray[2]='<b>DOB</b>:* '.$t;
		$pwhArray[3]='<b>Sex</b>:* '.checksex($pwhdata->patient_sex);
		$pwhArray[4]='<b>Address: </b>'.$pwhdata->comm_flat.' '.$pwhdata->comm_building.' '.$pwhdata->commu_road.' '.$pwhdata->commu_locality;
		/*$pwhArray[]='<b>Flat/Door/Block No: </b>'.$pwhdata->comm_flat;
		$pwhArray[]='<b>Premises/Building/Village: </b>'.$pwhdata->comm_building;
		$pwhArray[]='<b>Road/State/Lane/Post Office: </b>'.$pwhdata->commu_road;
		$pwhArray[]='<b>Area/Locality/Taluk/sub-Division</b>'.$pwhdata->commu_locality;*/
		$pwhArray[5]='<b>Town/City/District: </b>'.$pwhdata->commu_city;
		$pwhArray[6]='<b>Pincode</b>: '.$pwhdata->commu_pincode;
		$pwhArray[7]='<b>Contact number</b>:* '.$pwhdata->commu_phone;
		$pwhArray[8]='<b>Mobile number</b>: '.$pwhdata->commu_cellnumber;
		
		
		$pwhArray[9]='<b>Blood Group</b>:* '.bloodgroupretrun($pwhdata->patient_bloodgroup);
		$pwhArray[10]='<b>Factor Deficiency</b>:* '.factordeficiencyreturn($pwhdata->patient_factor_deficient);
		$pwhArray[11]='<b>Other Factor Deficiency</b>:* '.otherfactors($pwhdata->patient_factor_defother);
		$pwhArray[12]='<b>Assay/Factor Level</b>:* '.$pwhdata->patient_factor_level;
		
		$pwhArray[13]='<b>Is PWH Deformed</b>:* '.checkzero($pwhdata->patient_Deformity);
		$pwhArray[14]='<b>Inhibitor Screen</b>: '.checkzero($pwhdata->patient_inhibitor_screen);
		$pwhArray[15]='<b>Is Studying</b>: '.checkzero($pwhdata->patient_studying);
		$pwhArray[16]='<b>Is working</b>: '.checkzero($pwhdata->patient_working);		
		$pwhArray[17]='<b>Age of Diagnose</b>: '.checkzero($pwhdata->patient_age_Diagnose);
		$pwhArray[18]='<b>Diagnose Place</b>: '.checkzero($pwhdata->patient_hospital_diagnose);
		$pwhArray[19]='<b>Other Family Members</b>: '.checkzero($pwhdata->patient_family_effected);
		$pwhArray[20]='<b>Family Income</b>:* '.checkzero($pwhdata->patient_family_income);
		$pwhArray[21]='<b>Do You Have BPL</b>:* '.checkzero($pwhdata->patient_bpl_eligibility);
		$pwhArray[22]='<b>BPL Ref Number</b>: '.checkzero($pwhdata->bpl_ref_number);
		$pwhArray[23]='<b>Employed In</b>:* '.checkzero($pwhdata->patient_employment_type);
		$pwhArray[24]='<b>Employed Organization Name</b>:* '.checkzero($pwhdata->patient_Remboursement_faclity);
		$pwhArray[25]='<b>Caste: </b> '.checkcaste($pwhdata->patient_caste);
		
		//for($i=0;$i<count($pwhArray);$i++){
			//$obj->cezpdf->ezText($pwhArray[$i],10,array('spacing'=>2));	
			//echo $pwhArray[$i]."<br/>";
		//}
		
		$disparray=array();
		$disparray[]=$this->dataplacer(array($pwhArray[0]));
		$disparray[]=$this->dataplacer(array($pwhArray[1]));
		$disparray[]=$this->dataplacer(array($pwhArray[2],$pwhArray[3]));
		$disparray[]=$this->dataplacer(array($pwhArray[4]));
		$disparray[]=$this->dataplacer(array($pwhArray[5],$pwhArray[6]));
		$disparray[]=$this->dataplacer(array($pwhArray[7],$pwhArray[8]));
		$disparray[]=$this->dataplacer(array($pwhArray[9],$pwhArray[10]));
		$disparray[]=$this->dataplacer(array($pwhArray[11]));
		$disparray[]=$this->dataplacer(array($pwhArray[12]));		
		$disparray[]=$this->dataplacer(array($pwhArray[13],$pwhArray[14]));
		$disparray[]=$this->dataplacer(array($pwhArray[15]));
		$disparray[]=$this->dataplacer(array($pwhArray[16]));
		$disparray[]=$this->dataplacer(array($pwhArray[17],$pwhArray[18]));		
		$disparray[]=$this->dataplacer(array($pwhArray[19],$pwhArray[25]));
		$disparray[]=$this->dataplacer(array($pwhArray[20]));
		$disparray[]=$this->dataplacer(array($pwhArray[21],$pwhArray[22]));
		$disparray[]=$this->dataplacer(array($pwhArray[23]));
		$disparray[]=$this->dataplacer(array($pwhArray[24]));
		$y=680;
		$i=0;
		$x=100;
		for($i=0;$i<count($disparray);$i++){
			
			$obj->cezpdf->addText(60,$y,10,$disparray[$i][0]);
			if (count($disparray[$i])>1){
				$obj->cezpdf->addText(340,$y,10,$disparray[$i][1]);
			}
			if ($i==3){
				$y=$y-50;
			}
			$y=$y-25;
			//echo $row.'<br/>';
			
		}
		$obj->cezpdf->setLineStyle(.2,'','',array(.2));
	
		$obj->cezpdf->rectangle(50,702,480,50);
		$disptext='National Hemophilia Registry(NHR) is a database of PWHs in India. Please verify your details and fill information which his missing. * marks are compulsory, Please take help from your Chapter. Contact details and phone number is printed below the page.
		';
		$obj->cezpdf->setColor(92/255,94/255,96/255);
		$disptext=$obj->cezpdf->addTextWrap(60,740,470,9,$disptext,array('justification' => 'left'));
		$disptext=$obj->cezpdf->addTextWrap(60,725,470,9,$disptext,array('justification' => 'left'));
		$disptext=$obj->cezpdf->addTextWrap(60,710,470,9,$disptext,array('justification' => 'left'));
		
		//Footer Block
		$obj->cezpdf->setLineStyle(.2,'','',array(.2));
		$obj->cezpdf->rectangle(50,150,480,40);
		$obj->cezpdf->setColor(0/255,0/255,0/255);
		$obj->cezpdf->addText(60,165,9,'Signature');
		$obj->cezpdf->addText(400,165,9,'Date');
		$obj->cezpdf->setLineStyle(.6,'','',array(.2));
		$obj->cezpdf->setStrokeColor(0/255,0/255,0/255);		
    	$obj->cezpdf->line(20,140,560,140);
    	$disptext='<b>For more Details contact your Chapter:</b>';  
    	$obj->cezpdf->addText(20, 130,8,$disptext);
    	$disptext='<i>     Chapter Keyperson:</i> '.$pwhdata->chapter_keyperson;
    	$obj->cezpdf->addText(20, 120,8,$disptext);
    	$disptext='<i>     Phone Number:</i> '.$pwhdata->chapter_phone;
    	$obj->cezpdf->addText(20, 110,8,$disptext);
    	$disptext='<i>     Email:</i> '.$pwhdata->chapter_email;
    	$obj->cezpdf->addText(20, 100,8,$disptext);
    	$obj->cezpdf->setColor(160/255,164/255,160/255);
    	$disptext='<b>NHR Helpline:</b>  <i>Phone Number:</i> +91.7353777778/+91.9845188706.           <i>Email:</i> registry@hemophilia.in     <i>Ref.Id:</i> '.$pwhdata->patient_ID;
    	$obj->cezpdf->line(20,95,560,95);
    	$obj->cezpdf->addText(100, 80,7,$disptext);
		//$obj->cezpdf->ezTable($pwhArray);
		
 }
 	function dataplacer($arrayData){
 		
 		return $arrayData;
 	}
}
?>

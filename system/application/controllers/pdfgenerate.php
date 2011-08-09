<?php
class pdfgenerate extends Controller {
	var  $pdfoject;
	function pdfgenerate() {
        	parent::Controller();
          $this->load->library("cezpdf");  
          $this->cezpdf->ezSetMargins(100,100,100,100); 
	}
	function index() {	
		
	}
	function showpdf1(){
		
	}
	function testingshowpdf(){
		
     	// page info here, db calls, etc.
    	$displayview='';
     	$this->load->database();
     	$chapterdata=$this->db->query('select * from tbl_pat_personal where chap_id=67 limit 0,20');
     	$datarow=array();
     	foreach($chapterdata->result_array()  as $row){
     		//if ($this->buildpending($row)==1){
     			$datarow[]=$row;
     		//}
     	}
     	
     	//$displayview.='<table cellpadding="4" cellspacing="1" width="100%" border="0" >';
     	$i=0;
     	//$displayview.='<tr>';
     	$displayview=array();
     	
     	foreach($datarow as $row){
     		
     		
     		//$displayview.='<td>';
     		$displayview[]=$this->buildui((object)$row);
     		
     		//$displayview.='</td>';
     		//$i++;
     	}
     	
   		$tmp = array(
			'b'=>'Courier-Bold.afm'
			,'i'=>'Courier-Oblique.afm'
			,'bi'=>'Courier-BoldOblique.afm'
			,'ib'=>'Courier-BoldOblique.afm'
			,'bb'=>'Times-Roman.afm'			
			);
		$this->cezpdf->setFontFamily('Courier.afm',$tmp);
     	
		
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		
		
		$this->cezpdf->ezTable($db_data);
		
		
		
		$this->cezpdf->ezStream();
   		
	}
	/*
	function buildpending($row){
		$retvalue=0;
		if (empty($row->patient_father_name)){
			$retvalue=1;
		}
		if ($row->patient_bloodgroup==0){
			$retvalue=1;
		}
		if (($row->patient_factor_deficient==0)&&($row->patient_factor_defother==0)){
			$retvalue=1;
		}
		if (($row->patient_Deformity==0)||(empty($row->patient_factor_defother))){
			$retvalue=1;
		}
		if (empty($row->patient_factor_level)){
			$retvalue=1;
		}
		if ((empty($row->patient_dob)||($row->patient_dob=='0000-00-00'))){
			$retvalue=1;
		}
		if (($row->patient_bpl_eligibility==0)||(empty($row->patient_bpl_eligibility))){
			$retvalue=1;
		}
		if (empty($row->comm_flat)){
			$retvalue=1;
		}
		if (empty($row->commu_phone)){
			$retvalue=1;
		}
		return $retvalue;
	}*/
	function buildui($row){
		
		$retvalue='';
		$this->cezpdf->selectFont('./fonts/Helvetica-Bold.afm');
		
		$this->cezpdf->ezText('<b>Hemophilia Federation India</b>', 16, array('justification' => 'center'));		
		$this->cezpdf->ezText('<i>National Hemophilia Registry</i>', 12, array('justification' => 'center'));
		$this->cezpdf->addPngFromFile('./images/login_logo.png', 60,680,80); 
		$this->cezpdf->selectFont('./fonts/Helvetica.afm');
		$this->cezpdf->setLineStyle(0.5);
    	$this->cezpdf->line(20,680,560,680);
    	$this->cezpdf->setStrokeColor(0,0,0);
    	$this->cezpdf->ezText('', 10);
    	$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('<b>Chapter Name: </b>Hemophilia Society Bangalore Chapter', 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('Dear '.$row->patient_first_name.' '.$row->patient_last_name, 10);
		$this->cezpdf->ezText('', 10);
		
		$this->cezpdf->ezText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id neque dui, sit amet mollis velit. Pellentesque elit felis, dapibus eu tincidunt aliquet,facilisis eu odio. Nam at lectus lobortis libero feugiat elementum non ut mi. Etiam blandit scelerisque nibh, a dignissim eros consequat et. Sed ac justo velit.proin commodo interdum iaculis. Praesent lobortis tincidunt felis, in accumsan mauris', 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id neque dui, sit amet mollis velit. Pellentesque elit felis, dapibus eu tincidunt aliquet,facilisis eu odio. Nam at lectus lobortis libero feugiat elementum non ut mi. Etiam blandit scelerisque nibh, a dignissim eros consequat et. Sed ac justo velit.proin commodo interdum iaculis. Praesent lobortis tincidunt felis, in accumsan mauris', 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id neque dui, sit amet mollis velit. Pellentesque elit felis, dapibus eu tincidunt aliquet,facilisis eu odio. Nam at lectus lobortis libero feugiat elementum non ut mi. Etiam blandit scelerisque nibh, a dignissim eros consequat et. Sed ac justo velit.proin commodo interdum iaculis. Praesent lobortis tincidunt felis, in accumsan mauris', 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText(str_repeat('_',70), 10);
		$this->cezpdf->ezText('<b>Following Data is not available please submit by 20th, June 2011</b>', 12);
		$this->cezpdf->ezText('', 10);
	
		for ($i=1;$i<10;$i++){
			$this->highlight($row,$i);
		}
		$this->cezpdf->ezText(str_repeat('_',70), 10);
		$this->cezpdf->ezText('', 10);
		$this->cezpdf->ezText('Please Call 080-123232323 or visit our chapter before.', 10);
		/*$this->cezpdf->ezText('Hemophilia Federation India', 14, array('justification' => 'center'));
		$this->cezpdf->ezText('Hemophilia Federation India', 14, array('justification' => 'center'));
		$this->cezpdf->ezText('Hemophilia Federation India', 14, array('justification' => 'center'));
		$this->cezpdf->ezText('Hemophilia Federation India', 14, array('justification' => 'center'));
		$retvalue.='<div align="center"><img src="/images/login_logo.jpg" style="float:left" width="80"/><h1>Hemophilia Federation India<br/>
			<span class="line2">National Hemophilia Registry Data Form</span></h1>
		</div>';
		$retvalue.='<div style="clear:both"><b>Chapter Name: </b>Hemophilia Society Bangalore Chapter</div>';
		$retvalue.='<div style="margin:20px;padding:10px;">
		Dear '.$row->patient_first_name.' '.$row->patient_last_name.'
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id neque dui, 
		sit amet mollis velit. Pellentesque elit felis, dapibus eu tincidunt aliquet, 
		facilisis eu odio. Nam at lectus lobortis libero feugiat elementum non ut mi. 
		Etiam blandit scelerisque nibh, a dignissim eros consequat et. Sed ac justo velit. 
		Proin commodo interdum iaculis. Praesent lobortis tincidunt felis, in accumsan mauris</p>
		
 		<p>
 			Please Call 080-123232323 or visit our chapter before.
 		</p>
 		<p style="border:1px solid #cccccc;text-align:center">
 			Generated by NHR applicatioin
 		</p>
		</div>
		
		';*/
		$this->cezpdf->ezNewPage();
		
		return $retvalue;
	}
	function highlight($row,$para){
		switch($para){
			case 1:
			if (empty($row->patient_father_name)){
				$this->cezpdf->ezText('          <b>Father Name</b>');
			}else{
				$this->cezpdf->ezText('          Father Name');
			}
				break;
			case 2:
			if ($row->patient_bloodgroup==0){
				$this->cezpdf->ezText('          <b>Blood Group</b>');
			}else{
				$this->cezpdf->ezText('          Blood Group');
			}
				break;
			case 3:
			if (($row->patient_factor_deficient==0)&&($row->patient_factor_defother==0)){
				$this->cezpdf->ezText('          <b>Factor definition</b>');
			}else{
				$this->cezpdf->ezText('          Factor definition');
			}
				break;
			case 4:
		if (empty($row->patient_factor_level)){
				$this->cezpdf->ezText('          <b>Assay Level</b>');
			}else{
				$this->cezpdf->ezText('          Assay Level');
			}
					
				break;
			case 5:
			if (($row->patient_Deformity==0)||(empty($row->patient_factor_defother))){
				$this->cezpdf->ezText('          <b>Deformity</b>');
			}else{
				$this->cezpdf->ezText('          Deformity');
			}	
				break;
			case 6:
			if ((empty($row->patient_dob)||($row->patient_dob=='0000-00-00'))){
				$this->cezpdf->ezText('          <b>Date of Birth</b>');
			}else{
				$this->cezpdf->ezText('          Date of Birth');
			}
				break;
			case 7:
			if ((empty($row->patient_bpl_eligibility))){
				$this->cezpdf->ezText('          <b>BPL Eligibility</b>');
			}else{
				$this->cezpdf->ezText('          BPL Eligibility');
			}
				break;
			case 8:
			if (empty($row->comm_flat)){
				$this->cezpdf->ezText('          <b>Address</b>');
			}else{
				$this->cezpdf->ezText('          Address');
			}
				break;
			case 9:
			if (empty($row->commu_phone)){
				$this->cezpdf->ezText('          <b>Phone</b>');
			}else{
				$this->cezpdf->ezText('          Phone');
			}
				break;
		}
		
		
	}
}
?>
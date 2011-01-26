<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function test_method($var=0)
{
	$valarry =  array(
		'1' => 'I Fibrinogen',
		'2' => 'II Prothrombin',
		'3' => 'III Tissue Factor',
		'4' => 'VI Calcium',
		'5' => 'V Proaccelerin, labile factor',
		'6' => 'VI',
		'7' => 'VII Stable Factor',
		'8' => 'VIII Anti Hemophilic Factor A',
		'9' => 'IX Anti Hemophilic Factor B or Christmas Factor',
		'10' => 'X Stuart-Prower Factor',
		'11' => 'XI Plasma Thromboplastin Antecedent)',
		'12' => 'XII Hageman Factor',
		'13' => 'XIII Fibrin-Stabilizing Factor',
		'14' => 'Others'
	);
	
	if($var==0){
		return $valarry;
	}else{
		return $valarry[$var];
	}
	/*$option_case = $var;
	$optionvalue='';
	switch($option_case){
		case '1':
			$optionvalue.='I (fibrinogen)';
		case '2':
			$optionvalue.='II (prothrombin)';
		case '3':
			$optionvalue.='Tissue factor';
		case '4':
			$optionvalue.='Calcium';
		case '5':
			$optionvalue.='V (proaccelerin, labile factor)';
		case '6':
			$optionvalue.='VI';
		case '7':
			$optionvalue.='VII (stable factor)';
		case '8':
			$optionvalue.='VIII (Anti Hemophilic factor A)';
		case '9':
			$optionvalue.='IX (Anti Hemophilic Factor B or Christmas factor)';
		case '10':
			$optionvalue.='X (Stuart-Prower factor)';
		case '11':
			$optionvalue.='XI (plasma thromboplastin antecedent)';
		case '12':
			$optionvalue.='XII (Hageman factor)';
		case '13':
			$optionvalue.='XIII (fibrin-stabilizing factor)';
	}
	return $optionvalue;*/
}

?>
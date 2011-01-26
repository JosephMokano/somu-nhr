<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function test_method($var=0)
{
	$valarry = array(
		'0' => '--',
		'1' => 'Pharmacy',
		'2' => 'HFI',
		'3' => 'Charity Organisation',
		'4' => 'Other'
	);
	if($var==0){
		return $valarry;
	}else{
		return $valarry[$var];
	}
}
?>
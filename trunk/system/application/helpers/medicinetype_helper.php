<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function test_method($var==0)
{
	$valarry = array(
		'0' => '--',
		'1' => 'factor 8',
		'2' => 'factor 9',
		'3' => 'fiba',
		'4' => 'NovoSeven'
	);
	if($var==0){
		return $valarry;
	}else{
		return $valarry[$var];
	}
}
?>
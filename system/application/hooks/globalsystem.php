<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');
	class globalsystem

	{
	function globalsystem(){
		
	}
	function initializeSystem()	
	{	
	
	$CI =& get_instance();
	
		// "I am from hook";
		define('MAIL',"hello this");
	
	
	}
	}
?>
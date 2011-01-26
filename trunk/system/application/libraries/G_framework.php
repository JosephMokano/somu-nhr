<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  CI_G_framework{

	//var $userName='Divya';
	//var $chapterName='Hemophilia Society - Bangalore Chapter';
	
    function CI_G_framework()
    {
    	$CI =& get_instance();
    	$CI->template->add_js('js/jquery-1.4.4.min.js','import');
		$CI->template->add_css('styles/layout.css'); 
    $CI->template->add_js("js/jquery-ui-1.8.7.custom.min.js",'import');
    $CI->template->add_css('styles/smoothness/jquery-ui-1.8.7.custom.css');
		
		/*$data_header=array(
			'chapterName'=>$this->chapterName,
			'username'=>$this->userName
		);*/
		$data_footer=array(
			'company'=>'NHR',
			'copyright'=>'2009'		
			);
		$CI->template->write_view('footer', 'footer',$data_footer,false);
		//$CI->template->write_view('header','header',$data_header,false);
    }
	
	function setFrameworkValue($chaptername,$username){
		$this->chapterName=	$chaptername;
	}
	
}
?>
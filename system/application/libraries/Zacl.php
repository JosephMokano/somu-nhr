<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class CI_Zacl {
	var $acl;
    function __construct($class = NULL) {
    	$CI =& get_instance();
        $CI->load->library('zend');
        $CI->zend->load('Zend/Acl');
		$CI->zend->load('Zend/Acl/Role');
		$CI->zend->load('Zend/Acl/Resource');
		$acl=new Zend_Acl();
		
		//Add the Role
		$acl->addRole(new Zend_Acl_Role('NU'));
		$acl->addRole(new Zend_Acl_Role('memUser'),'member');
		//Add Resource
		$acl->add(new Zend_Acl_Resource('users_login'));
		$acl->add(new Zend_Acl_Resource('users_profile'),'users_login');
		$acl->allow('member','users_login');
		$acl->allow('memUser','users_profile');
    }
	
    
}
?>

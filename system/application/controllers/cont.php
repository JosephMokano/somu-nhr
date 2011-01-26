<?php
if (!defined('AMFPHP')) exit('No direct script access allowed');

class Cont extends Controller {

    function Cont()
    {
        parent::Controller();
    }
    
    function func()
    {
        global $value;
        
        $test = 'Some Stuff';
        
        $value = $test; // $value can be any data type. If it's an array, it should be sent back as an array collection.
    }
}
?>
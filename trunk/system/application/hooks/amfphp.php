<?php 
class Amfphp {
    var $ci;
    function output() {
        if (!defined('AMFPHP')) {
            $this->ci = &get_instance();
            $this->ci->output->_display($this->ci->output->get_output());
        }
    }
}
?>
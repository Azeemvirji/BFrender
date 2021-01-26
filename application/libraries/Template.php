<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
    function show($view, $args = NULL)
    {
        $CI =& get_instance();

        $CI->load->view('header',$args);
        $CI->load->view('navigation',$args);
        $CI->load->view($view, $args);
        $CI->load->view('footer',$args);
    }
}
?>

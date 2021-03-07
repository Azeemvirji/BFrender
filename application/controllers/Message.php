<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index(){
    $this->template->show('message', $this->TPL);
  }

  public function chat($uname){
    $this->TPL['chatUname'] = $uname;
    $this->template->show('message', $this->TPL);
  }


}

?>

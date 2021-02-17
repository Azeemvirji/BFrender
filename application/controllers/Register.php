<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code


   $this->TPL['loggedin'] = $this->userauth->validSessionExists();

  }

  public function index()
  {
    $this->template->show('register', $this->TPL);
  }
}
?>

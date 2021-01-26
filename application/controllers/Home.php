<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();

   $_SESSION['page'] = 'home';
   $this->TPL['loggedin'] = $this->userauth->validSessionExists();
   $this->TPL['active'] = array('home' => true,
                                'members'=>false,
                                'login'=>false);

  }

  public function index()
  {
    $this->template->show('home', $this->TPL);
  }
}
?>

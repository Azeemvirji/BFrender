<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $_SESSION['page'] = 'profile';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
   $this->TPL['active'] = array('home' => false,
                                'profile'=>true,
                                //'admin' => false,
                                'login'=>false);
  }

  public function index()
  {
    $this->template->show('profile', $this->TPL);
  }
}
?>

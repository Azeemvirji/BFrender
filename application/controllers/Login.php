<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

  //specify the current page
   $_SESSION['page'] = 'login';
   //msg prints on screen, mainly used to display errors
   $this->TPL['msg'] = "";
   //is the user logged in?
   $this->TPL['loggedin'] = false;

  }

  public function index()
  {
    //show the login view
    $this->template->show('login', $this->TPL);
  }

  public function loginuser()
  {
    //if the login fails the method will get the reason and show it to the user on the login page
    $this->TPL['msg'] =
      $this->userauth->login(trim($this->input->post("username")),
                             trim($this->input->post("password")));
    // send the username the user entered so they dont have to retype it
    $this->TPL['username'] = $this->input->post("username");
    $this->template->show('login', $this->TPL);
  }

  public function logout()
  {
    $this->userauth->logout();
  }
}
?>

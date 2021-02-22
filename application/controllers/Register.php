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

  public function registeruser(){
    date_default_timezone_set('America/Toronto');
    $uname = $this->input->post("username");
    $email = $this->input->post("email");

    $this->formValidation();
    if($this->form_validation->run() == true){
      $data = array(
        'uname' => $uname,
        'email' => $email,
        'password' => $this->input->post("password"),
        'dateOfBirth' => $this->input->post('dob'),
        'accessLevel' => "member",
        'frozen' => 'N',
        'dateJoined' => date("Y-m-d h:i:sa")
      );
      $this->TPL['msg'] = $this->userauth->register($data, $this->input->post("password"));
    }

    $this->TPL['username'] = $uname;
    $this->TPL['email'] = $email;

    $this->template->show('register', $this->TPL);
  }

  public function formValidation(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.uname]');
    $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_is_password_strong');
    $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');

    $this->form_validation->set_message('is_unique', 'This %s is already taken');
  }
  public function is_password_strong($password)
	{
	   if (preg_match('#[0-9]#', $password) && preg_match('#[A-Z]#', $password)) {
		 return TRUE;
	   }
	   $this->form_validation->set_message('is_password_strong', 'Please make sure password has atleast one number and one captial letter');
	   return FALSE;
	}
}
?>

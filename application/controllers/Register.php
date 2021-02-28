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
    //get the username,dob and email the user entered and store it in a variable for easy use
    $uname = $this->input->post("username");
    $email = $this->input->post("email");
    $date = $this->input->post('dob');

    $this->formValidation();
    //if everything the user entered meets the requirments proceed to add them to the database
    if($this->form_validation->run() == true){
      $data = array(
        'uname' => $uname,
        'email' => $email,
        'password' => $this->input->post("password"),
        'dateOfBirth' => $date,
        'accessLevel' => "member",
        'frozen' => 'N',
        'dateJoined' => date("Y-m-d h:i:sa")
      );
      //if the registeration is unsuccessfull, get the reason and show it to the user
      $this->TPL['msg'] = $this->userauth->register($data, $this->input->post("password"));
    }

    //send the username,dob and email so the user dont have to enter it again
    $this->TPL['username'] = $uname;
    $this->TPL['email'] = $email;
    $this->TPL['date'] = $date;

    $this->template->show('register', $this->TPL);
  }

  public function formValidation(){
    $this->load->library('form_validation');
    //username must be atleast 5 in length and be unique
    $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.uname]');
    $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
    //must be a valid email and be unique
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
    //password must be atleast 8 in length and be strong with atleast one number and one captial letter
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_is_password_strong');
    //passwords must match
    $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');

    $this->form_validation->set_message('is_unique', 'This %s is already taken');
  }
  public function is_password_strong($password)
	{
    //check that the entered password has atleast one number and one capital letter
	   if (preg_match('#[0-9]#', $password) && preg_match('#[A-Z]#', $password)) {
		 return TRUE;
	   }
	   $this->form_validation->set_message('is_password_strong', 'Please make sure password has atleast one number and one captial letter');
	   return FALSE;
	}
}
?>

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
        'username' => $uname,
        'email' => $email,
        'password' => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
        'dateOfBirth' => $date,
        'accessLevel' => "member",
        'frozen' => 'N',
        'dateJoined' => date("Y-m-d h:i:sa"),
        'imageLocation' => 'default.png'
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
    $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.username]');
    $this->form_validation->set_rules('dob', 'Date Of Birth', 'required|callback_is_over_18');
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

  public function is_over_18($dob){
    $age = $this->getAge($dob);
    if($age >= 18){
      return TRUE;
    }
    $this->form_validation->set_message('is_over_18', 'You must be atleast 18 to sign up');
    return FALSE;
  }

  protected function getAge($birthDate){
    $birthDate = explode("-", $birthDate);
    $tdate = time();

    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));

    return $age;
  }
}
?>

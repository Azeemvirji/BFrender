<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  var $TPL;
  var $userinfo;
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    date_default_timezone_set('America/Toronto');
   $_SESSION['page'] = 'profile';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index()
  {
    $this->load->model('users');

    $this->getUserInfo();
    $this->TPL['friends'] = $this->users->GetAllUsers();
    $this->template->show('profile', $this->TPL);
  }


  protected function getUserInfo(){
    $this->load->model('users');
    $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    $this->TPL['user'] = $this->userinfo;
    $this->TPL['user']['age'] = $this->getAge($this->userinfo['dateOfBirth']);
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

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
   $this->TPL['active'] = array('home' => false,
                                'profile'=>true,
                                //'admin' => false,
                                'login'=>false);
  }

  public function index()
  {
    $this->getUserInfo();
    $this->template->show('profile', $this->TPL);
  }

  public function getUserInfo(){
    $this->userinfo = $this->user->GetUserInfoFromUsername($_SESSION['username']);
    $this->TPL['user'] = $this->userinfo;
    $this->TPL['user']['age'] = $this->getAge($this->userinfo['dateOfBirth']);
  }

  public function getAge($birthDate){
    $birthDate = explode("-", $birthDate);
    $tdate = time();

    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));

    return $age;
  }
}
?>

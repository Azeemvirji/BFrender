<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  var $TPL;
  var $userinfo;
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    //adding the models neededs
    $this->load->model('tags');
    $this->load->model('users');
    $this->load->model('friendsmodel');

    date_default_timezone_set('America/Toronto');
   $_SESSION['page'] = 'profile';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index()
  {
    $this->display();
  }

  public function addFriend($friendUname){
    $userId = $this->users->GetUserID($_SESSION['username']);
    $friendId = $this->users->GetUserID($friendUname);

    $this->friends->AddFriends($userId, $friendId);

    $this->TPL['msg'] = "You are now friends with " . $friendUname;
    $this->display();
  }

  public function Debug(){
    print_r($this->friendsmodel->GetFriendsForUser(4));
  }

  protected function display(){
    $this->getUserInfo();
    $this->TPL['usersAdd'] = $this->users->GetAllUsers();
    $this->TPL['friends'] = $this->friendsmodel->GetFriendsForUser($this->userinfo['userId']);
    $this->TPL['tags'] = $this->GetTags($this->userinfo['userId']);

    $this->template->show('profile', $this->TPL);
  }

  protected function GetTags($userId) {
    $tagsId = $this->tags->GetUserTags($userId);
    $tags = [];

    foreach ($tagsId as $row) {
      array_push($tags, $this->tags->GetTagName($row['tagId']));
    }

    return $tags;
  }

  protected function getUserInfo(){
    $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    $this->TPL['user'] = $this->userinfo;
    $this->TPL['user']['bio'] = $this->users->GetUserBio($this->userinfo['userId']);
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

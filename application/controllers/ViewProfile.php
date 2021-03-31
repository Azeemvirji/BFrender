<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewProfile extends CI_Controller {

  var $TPL;
  var $userinfo;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    //adding the models neededs
    $this->load->model('tags');
    $this->load->model('users');
    $this->load->model('category');
    $this->load->model('friendsmodel');
    $this->load->model('location');

    date_default_timezone_set('America/Toronto');
    $_SESSION['page'] = 'viewprofile';
    $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index()
  {
    $this->display($_SESSION['username']);
  }

  public function view($friend){
    $this->display($friend);
  }



  protected function display($username){
    $this->getUserInfo($username);
    $this->TPL['userTags'] = $this->GetTagsForUser($this->userinfo['userId'], "InterestRelational");
    $userId = $this->users->GetUserID($_SESSION['username']);
    $this->TPL['friends'] = $this->friendsmodel->CheckIfInFriendsTable($userId, $this->userinfo['userId']);

    $friendsId = $this->friendsmodel->GetFriendsId($userId, $this->userinfo['userId']);
    $this->TPL['sentBy'] = $this->users->GetUsernameFromUserId($this->friendsmodel->RequestSentBy($friendsId));

    $this->template->show('viewProfile', $this->TPL);
  }

  /*
  Getting the tags/interests for the user and since they are id we need to get the name before returning them
  Input: userId
  Output: array of all the interests names
  */
  protected function GetTagsForUser($userId) {
    $tagsId = $this->tags->GetUserTags($userId, "InterestRelational");
    $tags = [];

    foreach ($tagsId as $row) {
      array_push($tags, $this->tags->GetTagName($row['tagId']));
    }

    return $tags;
  }

  /*
  Gets all the info that the profile page would need
  Modifies the TPL array that will be passed on to the page
  Input: None
  Output: None
  */
  protected function getUserInfo($username){
    $this->userinfo = $this->users->GetUserInfoFromUsername($username);
    $this->TPL['user'] = $this->userinfo;
    $this->TPL['user']['bio'] = $this->users->GetUserBio($this->userinfo['userId']);
    $this->TPL['user']['location'] = $this->location->GetLocationById($this->users->GetUserLocation($this->userinfo['userId']));
    $this->TPL['user']['age'] = $this->getAge($this->userinfo['dateOfBirth']);
  }

  /*
  Calculates the age of our user using the date of birth
  Input: Date of birth
  Output: calculated age
  */
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

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

  public function RemoveInterest(){
    $tag = $this->input->post('tag');

    $tagId = $this->tags->GetTagId($tag);
    $userId = $this->users->GetUserID($_SESSION['username']);

    $this->tags->RemoveTagForUser($userId, $tagId);

    $tags = $this->tags->GetUserTags($userId);

    foreach($tags as $tag){
      $tagName = $this->tags->GetTagName($tag['tagId']);
      echo "<a href=\"\" id=\"" . $tagName . "\" onclick=\"return removeTag(this.id)\">" . $tagName . "</a><br/>";
    }
  }

  public function AddInterest(){
    $tag = $this->input->post('tag');

    $tagId = $this->tags->GetTagId($tag);
    $userId = $this->users->GetUserID($_SESSION['username']);

    //Add check if user already has this tag, echo success for not and msg if they do

    $this->tags->AddRelationalTag($tagId, $userId);
  }

  public function GetTagsForCategory(){
    $category = $this->input->post('category');

    $tags = $this->tags->GetTagsForCategory($category);

    $tags = $this->RemoveUserTags($tags);

    foreach($tags as $tag){
      echo "<a href=\"\" id=\"" . $tag['tagName'] . "\" onclick=\"return addInterest(this.id)\">" . $tag['tagName'] . "</a><br/>";
    }
  }

  public function addFriend($friendUname){
    $userId = $this->users->GetUserID($_SESSION['username']);
    $friendId = $this->users->GetUserID($friendUname);

    $this->friends->AddFriends($userId, $friendId);

    $this->TPL['msg'] = "You are now friends with " . $friendUname;
    $this->display();
  }

  public function Debug(){
    print_r($this->RemoveUserTags($this->tags->GetAllTags()));
  }

  protected function display(){
    $this->getUserInfo();
    $this->TPL['usersAdd'] = $this->users->GetAllUsers();
    $this->TPL['friends'] = $this->friendsmodel->GetFriendsForUser($this->userinfo['userId']);
    $this->TPL['userTags'] = $this->GetTags($this->userinfo['userId']);
    $this->TPL['allTags'] = $this->RemoveUserTags($this->tags->GetAllTags());
    $this->TPL['category']  = $this->tags->GetAllCategory();

    $this->template->show('profile', $this->TPL);
  }

  public function RemoveUserTags($tags){
    $this->getUserInfo();
    $updated = [];
    $userTags = $this->GetTags($this->userinfo['userId']);

    foreach($tags as $tag){
      if(!in_array($tag['tagName'], $userTags)){
        array_push($updated, $tag);
      }
    }

    return $updated;
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

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
    $this->load->model('category');
    $this->load->model('location');

    date_default_timezone_set('America/Toronto');
   $_SESSION['page'] = 'profile';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index()
  {
    $this->display();
  }

  protected function display(){
    $this->getUserInfo();
    $this->TPL['userTags'] = $this->GetTagsForUser($this->userinfo['userId'], "InterestRelational");
    $this->TPL['category']  = $this->category->GetAllCategory();

    $this->template->show('profile', $this->TPL);
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
  gets all the insterest in a perticular category, intended to use by ajax
  Input(post) : categoryName
  Output: all the the interest in the category echoed out to a tags
  */
  public function GetTagsForCategory(){
    $category = $this->input->post('category');

    $tags = $this->tags->GetTagsForCategory($category);

    $tags = $this->RemoveUserTags($tags);

    foreach($tags as $tag){
      echo "<a href=\"\" id=\"" . $tag['tagName'] . "\" onclick=\"return addInterest(this.id)\">" . $tag['tagName'] . "</a><br/>";
    }
  }

  /*
  Removes an interest for the user in the database, intended to be used by ajax
  Input(post): name of the interest the user selected
  Output: Updated current user tags after removing echoed out to a tags
  */
  public function RemoveInterest(){
    $tag = $this->input->post('tag');

    $tagId = $this->tags->GetTagId($tag);
    $userId = $this->users->GetUserID($_SESSION['username']);

    $this->tags->RemoveTagForUser($userId, $tagId, "InterestRelational");

    $tags = $this->tags->GetUserTags($userId, "InterestRelational");

    foreach($tags as $tag){
      $tagName = $this->tags->GetTagName($tag['tagId']);
      echo "<a href=\"\" id=\"" . $tagName . "\" onclick=\"return removeTag(this.id)\">" . $tagName . "</a><br/>";
    }
  }

  /*
  Adds an interest for a user in the database, intended to be used by ajax
  Input(post): name of the interest the user selected
  Output: none
  */
  public function AddInterest(){
    $tag = $this->input->post('tag');

    $tagId = $this->tags->GetTagId($tag);
    $userId = $this->users->GetUserID($_SESSION['username']);

    //Add check if user already has this tag, echo success for not and msg if they do

    $this->tags->AddRelationalTag($tagId, $userId, "InterestRelational");
  }

  /*
  used to see the output of variables, perticularly the models
  */
  public function Debug(){
    $userId = $this->users->GetUserID($_SESSION['username']);
    $test = $this->users->UpdateBioAndLocation($_SESSION['username'], "", 0);

    echo $test;
  }

  /*
  removes the tags that the user currently has from the array provided
  input: list of tags
  output: modified list
  */
  public function RemoveUserTags($tags){
    $this->getUserInfo();
    $updated = [];
    $userTags = $this->GetTagsForUser($this->userinfo['userId']);

    foreach($tags as $tag){
      if(!in_array($tag['tagName'], $userTags)){
        array_push($updated, $tag);
      }
    }

    return $updated;
  }

  /*
  Gets all the info that the profile page would need
  Modifies the TPL array that will be passed on to the page
  Input: None
  Output: None
  */
  protected function getUserInfo(){
    $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
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

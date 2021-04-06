<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friends extends CI_Controller {
    var $TPL;
    var $userinfo;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
      //adding the models neededs
      $this->load->model('users');
      $this->load->model('friendsmodel');
      $this->load->model('location');
      $this->load->model('tags');
      $this->load->model('matchesmodel');

      date_default_timezone_set('America/Toronto');
     $_SESSION['page'] = 'friends';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->display();
    }

    public function Debug(){
        $id = $this->matchesmodel->CheckIfUserDetailsExist(1);

        echo $id;
    }

    protected function display(){
      $this->getUserInfo();
      $this->TPL['friends'] = $this->formatFriendsArray($this->friendsmodel->GetFriendsForUser($this->userinfo['userId'], "accepted"));
      $this->TPL['pending'] = $this->formatFriendsArray($this->friendsmodel->GetFriendsForUser($this->userinfo['userId'], "pending"));
      $this->template->show('friends', $this->TPL);
    }

    protected function formatFriendsArray($friends){
      $newArray = [];
      $userId = $this->users->GetUserID($_SESSION['username']);
      $userInterests = $this->GetInterestsForUser($userId);
      foreach($friends as $friends){
        $formatted = [];

        #names
  		  $formatted['username'] = $friends['username'];
  		  $formatted['firstname'] = $friends['firstname'];
  		  $formatted['lastname'] = $friends['lastname'];

  		  #image
  		  $formatted['imageLocation'] = $friends['imageLocation'];

  		  #age
  		  $formatted['age'] = $this->getAge($friends['dateOfBirth']);

        #city
        $location = $this->location->GetLocationById($this->users->GetUserLocation($friends['userId']));
		    $formatted['city'] = $location['city'];


        $friendsId = $this->friendsmodel->GetFriendsId($userId, $friends['userId']);
        $formatted['sentBy'] = $this->users->GetUsernameFromUserId($this->friendsmodel->RequestSentBy($friendsId));

        $commonInterest = $this->GetCommonInterests($userInterests, $friends['userId']);
		    $formatted['CommonInterest'] = $commonInterest;
        $formatted['InterestCount'] = count($commonInterest);


  		  #Suggested Activity
  		  $formatted['ActivitySuggestion'] = $this->getActivity($commonInterest); #todo: make algorithm

        array_push($newArray, $formatted);
      }
      return $newArray;
    }

    protected function GetCommonInterests($userInterests, $friendId){
      $friendsInterests = $this->GetInterestsForUser($friendId);
      $common = [];

      foreach ($userInterests as $interest) {
        if(in_array($interest, $friendsInterests)){
          array_push($common, $interest);
        }
      }

      return $common;
    }

    protected function GetInterestsForUser($userId) {
      $tagsId = $this->tags->GetUserTags($userId, "InterestRelational");
      $tags = [];

      foreach ($tagsId as $row) {
        array_push($tags, $this->tags->GetTagName($row['tagId']));
      }

      return $tags;
    }

    protected function getUserInfo(){
      $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
      $this->TPL['user'] = $this->userinfo;
    }

    public function Add($friendUname){
      $user1 = $this->users->GetUserID($_SESSION['username']);
      $user2 = $this->users->GetUserID($friendUname);

      $this->friendsmodel->AddFriends($user1, $user2, "pending");

      $this->display();
    }

    public function Remove($friendUname){
      $user1 = $this->users->GetUserID($_SESSION['username']);
      $user2 = $this->users->GetUserID($friendUname);

      $this->friendsmodel->RemoveFriend($user1, $user2);

      $this->display();
    }

    public function Confirm($friendUname){
      $user1 = $this->users->GetUserID($_SESSION['username']);
      $user2 = $this->users->GetUserID($friendUname);

      $this->friendsmodel->AddFriends($user1, $user2, "accepted");

      $this->display();
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

    // function to provide a suggested activity
    protected function getActivity($commonInterest){

      $Suggestion = '';

      // determine which catagory has the most common interests
      foreach ($commonInterest as $CI){



      }

      // based on the catagory with the most in common, returns an activity.
      // Activities should be stored in the database, but for now, here they are:
      // Watch/Stream A Movie, Wine Tasting, Yoga Class, Try an escape room,
      // volunteer at a charity, go shopping together, go hiking,visit a car show, and grab a coffee.








      $Suggestion = 'Grab a Coffee';

      return $Suggestion;
      }
}

?>

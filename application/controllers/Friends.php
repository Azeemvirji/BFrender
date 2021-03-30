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

      date_default_timezone_set('America/Toronto');
     $_SESSION['page'] = 'friends';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->display();
    }

    public function Debug(){
        $id = $this->users->GetUsernameFromUserId($this->friendsmodel->RequestSentBy(11));

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

        $formatted['InterestCount'] = 3;

		    #$formatted['CommonInterest'] = 'Test' #May try to turn this into an array.


  		  #Suggested Activity
  		  $formatted['ActivitySuggestion'] = 'Hiking'; #todo: make algorithm

        array_push($newArray, $formatted);
      }
      return $newArray;
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

}

?>

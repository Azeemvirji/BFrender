<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friendsmodel extends CI_Model{
  protected $table = 'friends';

  public function AddFriends($userId, $friendId){
    $data = array('userId' => $userId,
                  'friendId' => $friendId
                );

    $this->db->insert($this->table, $data);
  }

  public function GetFriendsForUser($userId){
    $this->load->model('users');

    $friends = [];

    $query = $this->db->get($this->table);
    $relationships = $query->result_array();
	
	// We need: username, firstname, lastname, profile_pic/default_pic, age(from dob)
	// , # of common interests, a list of (some) common interests, and a suggested activity ~ Peter
	
    foreach($relationships as $relation){
		$nextID = '';
		$NextFriend = [];
      if($relation['userId'] == $userId){
		  $nextID = 'friendId';
        //array_push($friends, $this->users->GetUserInfoFromUserId($relation['friendId']));
      }else if($relation['friendId'] == $userId){
		  $nextID = 'userId';
        //array_push($friends, $this->users->GetUserInfoFromUserId($relation['userId']));
      }
	  if($nextID != ''){
		  $UserInfoArray = $this->users->GetUserInfoFromUserId($relation[$nextID]);
		  
		  #names
		  $NextFriend['username'] = $UserInfoArray['username'];
		  $NextFriend['firstname'] = $UserInfoArray['firstname'];
		  $NextFriend['lastname'] = $UserInfoArray['lastname'];
		  
		  #image
		  $NextFriend['imageLocation'] = $UserInfoArray['imageLocation'];
		  
		  #age
		  $age = $this->getAge($UserInfoArray['dateOfBirth']);
		  $NextFriend['age'] = $age;
		  
		  #city
		  $NextFriend['city'] = 'Toronto'; #todo: get relevant db
		  
		  #Common Interests (?) todo: add a count, and list some interests.
		  $NextFriend['InterestCount'] = 3;
		  
		  #$NextFriend['CommonInterest'] = 'Test' #May try to turn this into an array.
		  
		  
		  #Suggested Activity
		  $NextFriend['ActivitySuggestion'] = 'Hiking'; #todo: make algorithm
		  
		  
		  array_push($friends, $NextFriend);#$this->users->GetUserInfoFromUserId($relation[$nextID]));
	  }
    }

    return $friends;
  }

	protected function getAge($birthDate){
		date_default_timezone_set('America/Toronto');
		$birthDate = explode("-", $birthDate);
		$tdate = time();

		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
		? ((date("Y") - $birthDate[0]) - 1)
		: (date("Y") - $birthDate[0]));

		return $age;
  }

}

?>

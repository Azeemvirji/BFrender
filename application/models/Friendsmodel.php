<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friendsmodel extends CI_Model{
  protected $table = 'friends';

  public function AddFriends($userId, $friendId, $status){
    $check = $this->CheckIfInFriendsTable($userId, $friendId);

    if($check == "false" or $check == "seen"){
      $data = array('userId' => $userId,
                    'friendId' => $friendId,
                    'status' => $status
                  );

      $this->db->insert($this->table, $data);
    }else if($check == "removed" or $check == "pending"){
      $friendsId = $this->GetFriendsId($userId, $friendId);

      $this->db->set('status', $status);
      $this->db->where('friendsId', $friendsId);
      $this->db->update($this->table);
    }
  }

  public function RemoveFriend($userId, $friendId){
    $friendsId = $this->GetFriendsId($userId, $friendId);

    $this->db->set('status', "removed");
    $this->db->where('friendsId', $friendsId);
    $this->db->update($this->table);
  }

  public function GetFriendsId($userId, $friendId){
    $query = $this->db->get($this->table);
    $relationships = $query->result_array();

    foreach($relationships as $relation){
      if($relation['userId'] == $userId){
        if($relation['friendId'] == $friendId){
          return $relation['friendsId'];
        }
      }elseif($relation['userId'] == $friendId){
        if($relation['friendId'] == $userId){
          return $relation['friendsId'];
        }
      }
    }

  }

  public function RequestSentBy($friendsId){
    $this->db->where('friendsId', $friendsId);
    $query = $this->db->get($this->table);
    $record = $query->result_array();

    return $record[0]['userId'];
  }

  public function GetFriendsForUser($userId, $status){
    $this->load->model('users');

    $friends = [];

    $query = $this->db->get($this->table);
    $relationships = $query->result_array();

	// We need: username, firstname, lastname, profile_pic/default_pic, age(from dob)
	// , # of common interests, a list of (some) common interests, and a suggested activity ~ Peter

    foreach($relationships as $relation){
      if($relation['userId'] == $userId){
        if($relation['status'] == $status){
          array_push($friends, $this->users->GetUserInfoFromUserId($relation['friendId']));
        }
      }else if($relation['friendId'] == $userId){
        if($relation['status'] == $status){
          array_push($friends, $this->users->GetUserInfoFromUserId($relation['userId']));
        }
      }
    }

    return $friends;
  }

  public function GetFriendsRecords($userId){
    $this->load->model('users');

    $friends = [];

    $query = $this->db->get($this->table);
    $relationships = $query->result_array();

    foreach($relationships as $relation){
      if($relation['userId'] == $userId){
        array_push($friends, $relation);
      }else if($relation['friendId'] == $userId){
        array_push($friends, $relation);
      }
    }

    return $friends;
  }

  public function CheckIfInFriendsTable($userId, $friendId){
    $friends = $this->GetFriendsRecords($userId);

    foreach ($friends as $friend) {
      if($friend['userId'] == $friendId or $friend['friendId'] == $friendId){
        return $friend['status'];
      }
    }
    return "false";
  }

}

?>

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

    foreach($relationships as $relation){
      if($relation['userId'] == $userId){
        array_push($friends, $this->users->GetUserInfoFromUserId($relation['friendId']));
      }else if($relation['friendId'] == $userId){
        array_push($friends, $this->users->GetUserInfoFromUserId($relation['userId']));
      }
    }

    return $friends;
  }

  public function CheckIfFriends($userId, $friendId)
  {
    $this->db->select('userId', 'friendId');
    $this->db->where('userId', $userId);
    $this->db->where('friendId', $friendId);
    $query = $this->db->get('friends');
    $friends = $query->result_array();

    return $friends;
  }

}

?>

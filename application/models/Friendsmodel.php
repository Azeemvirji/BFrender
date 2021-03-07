<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friendsmodel extends CI_Model{
  protected $table = 'friends';

  public function AddFriends($userId, $friendId){
    $CI =& get_instance();

    $data = array('userId' => $userId,
                  'friendId' => $friendId
                );

    $CI->db->insert($this->table, $data);
  }

  public function GetFriendsForUser($userId){
    $CI =& get_instance();

    $this->load->model('users');

    $friends = [];

    $query = $CI->db->get($this->table);
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

}

?>

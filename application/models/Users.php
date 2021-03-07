<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model{

  protected $table = 'users';

  public function GetUserID($username){
    $CI =& get_instance();

    $CI->db->where('username', $username);
    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users[0]['userId'];
  }

  public function GetUserInfoFromUsername($username){
    $CI =& get_instance();

    $CI->db->where('username', $username);
    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users[0];
  }

  public function GetUserInfoFromUserId($userId){
    $CI =& get_instance();

    $CI->db->where('userId', $userId);
    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users[0];
  }

  public function UpdateImageName($imgName, $username){
    $CI =& get_instance();

    $CI->db->set('imageLocation', $imgName);
    $CI->db->where('username', $username);
    $CI->db->update('users');
  }

  public function GetAllUsers(){
    $CI =& get_instance();

    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users;
  }

  #user details table
  public function GetUserBio($userId){
    $CI =& get_instance();

    $CI->db->where('userId', $userId);
    $query = $CI->db->get('userDetails');
    $users = $query->result_array();

    return $users[0]['bio'];
  }

  public function UpdateBio($username, $bio){
    $CI =& get_instance();

    $userId = $this->GetUserID($username);

    $CI->db->set('bio', $bio);
    $CI->db->where('userId', $userId);
    $CI->db->update('userDetails');
  }
}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model{

  protected $table = 'users';

  public function GetUserID($username){
    $CI =& get_instance();

    $CI->db->where('uname', $username);
    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users[0]['userId'];
  }

  public function GetUserInfoFromUsername($username){
    $CI =& get_instance();

    $CI->db->where('uname', $username);
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
    $CI->db->where('uname', $username);
    $CI->db->update('users');
  }

  public function GetAllUsers(){
    $CI =& get_instance();

    $query = $CI->db->get('users');
    $users = $query->result_array();

    return $users;
  }
}

?>

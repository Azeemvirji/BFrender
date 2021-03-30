<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model{

  protected $table = 'users';

  public function GetUserID($username){
    $this->db->where('username', $username);
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users[0]['userId'];
  }

  public function GetUsernameFromUserId($userId){
    $this->db->where('userId', $userId);
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users[0]['username'];
  }

  public function GetUserInfoFromUsername($username){
    $this->db->where('username', $username);
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users[0];
  }

  public function GetUserInfoFromUserId($userId){
    $this->db->where('userId', $userId);
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users[0];
  }

  public function UpdateImageName($imgName, $username){
    $this->db->set('imageLocation', $imgName);
    $this->db->where('username', $username);
    $this->db->update('users');
  }

  public function GetImageName($username){
    $this->db->where('username', $username);
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users[0]['imageLocation'];
  }

  public function GetAllUsers(){
    $query = $this->db->get('users');
    $users = $query->result_array();

    return $users;
  }

  #user details table
  public function GetUserBio($userId){
    $this->db->where('userId', $userId);
    $query = $this->db->get('userDetails');
    $users = $query->result_array();

    return $users[0]['bio'];
  }

  public function GetUserLocation($userId){
    $this->db->where('userId', $userId);
    $query = $this->db->get('userDetails');
    $users = $query->result_array();

    return $users[0]['location'];
  }

  public function UpdateBioAndLocation($username, $bio, $location){
    $userId = $this->GetUserID($username);

    $this->db->set('bio', $bio);
    $this->db->set('location', $location);
    $this->db->where('userId', $userId);
    $this->db->update('userDetails');
  }
}

?>

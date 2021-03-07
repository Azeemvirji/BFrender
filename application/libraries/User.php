<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user  {
	function __construct()
    {
      error_reporting(E_ALL & ~E_NOTICE);
    }

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

}
?>

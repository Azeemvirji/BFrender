<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Model{
  public function AddCategory($categoryName){
    $CI =& get_instance();

    $data = array('categoryName' => $categoryName);

    $CI->db->insert('category', $data);
  }

  public function GetAllCategory(){
    $CI =& get_instance();

    $query = $CI->db->get('category');
    $category = $query->result_array();

    return $category;
  }

  public function AddTag($category, $tag){
    $CI =& get_instance();

    $data = array(
      'categoryId' => $category,
      'tagName' => $tag
    );

    $CI->db->insert('tags', $data);

    $tagId = $this->GetTagId($tag);
    $this->load->model('users');
    $userId = $this->users->GetUserID($_SESSION['username']);

    $this->AddRelationalTag($tagId, $userId);
  }

  public function AddRelationalTag($tagId, $userId){
    $CI =& get_instance();

    $data = array(
      'userId' => $userId,
      'tagId' => $tagId
    );

    $CI->db->insert('relational', $data);
  }

  public function GetTagId($tag){
    $CI =& get_instance();

    $CI->db->where('tagName', $tag);
    $query = $CI->db->get('tags');
    $users = $query->result_array();

    return $users[0]['tagId'];
  }

  public function GetAllTags(){
    $CI =& get_instance();

    $query = $CI->db->get('tags');
    $tags = $query->result_array();

    return $tags;
  }

  public function GetUserTags($userId){
    $CI =& get_instance();

    $CI->db->select('tagId');
    $CI->db->where('userId', $userId);
    $query = $CI->db->get('relational');
    $tagsId = $query->result_array();

    return $tagsId;
  }

  public function GetTagName($tagId)
  {
    $CI =& get_instance();

    $CI->db->where('tagId', $tagId);
    $query = $CI->db->get('tags');
    $users = $query->result_array();

    return $users[0]['tagName'];
  }
}

?>

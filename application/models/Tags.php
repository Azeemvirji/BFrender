<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Model{
  public function AddTag($category, $tag){
    $data = array(
      'categoryId' => $category,
      'tagName' => $tag
    );

    $this->db->insert('tags', $data);
  }

  public function AddRelationalTag($tagId, $userId, $table){
    $data = array(
      'userId' => $userId,
      'tagId' => $tagId
    );

    return $this->db->insert($table, $data);
  }

  public function GetTagId($tag){
    $this->db->where('tagName', $tag);
    $query = $this->db->get('tags');
    $users = $query->result_array();

    return $users[0]['tagId'];
  }

  public function GetAllTags(){
    $this->db->order_by('tagName','asc');
    $query = $this->db->get('tags');
    $tags = $query->result_array();

    return $tags;
  }

  public function GetUserTags($userId, $table){
    $this->db->select('tagId');
    $this->db->where('userId', $userId);
    $query = $this->db->get($table);
    $tagsId = $query->result_array();

    return $tagsId;
  }

  public function GetTagsForCategory($category){
    if($category == "All"){
      $tags = $this->GetAllTags();
    }else{
      $this->load->model('category');
      $categoryId = $this->category->GetCategoryId($category);

      $this->db->order_by('tagName','asc');
      $this->db->where('categoryId', $categoryId);
      $query = $this->db->get('tags');
      $tags = $query->result_array();
    }
    return $tags;
  }

  public function GetTagName($tagId)
  {
    $this->db->where('tagId', $tagId);
    $query = $this->db->get('tags');
    $users = $query->result_array();

    return $users[0]['tagName'];
  }

// function to add weights for the user to the tag
  public function AddWeightForTag($userId, $tagId, $type)
  {
    $this->RemoveTagForUser($userId, $tagId, "TagsRelational");

    $data = array(
      'userId' => $userId,
      'tagId' => $tagId,
      'type' => $type
    );

    $this->db->insert('TagsRelational', $data);
  }

//removes the entry in the relational table
  public function RemoveTagForUser($userId, $tagId, $table)
  {
    $this->db->where('userId', $userId);
    $this->db->where('tagId', $tagId);
    $this->db->delete($table);
  }

  public function GetTagsByWeightForUser($type,$userId){
    $this->db->where('userId', $userId);
    $this->db->where('type', $type);
    $query = $this->db->get('TagsRelational');
    $tags = $query->result_array();

    return $tags;
  }
}

?>

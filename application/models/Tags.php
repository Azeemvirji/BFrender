<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Model{
  public function AddCategory($categoryName){
    $data = array('categoryName' => $categoryName);

    $this->db->insert('category', $data);
  }

  public function GetAllCategory(){
    $this->db->order_by('categoryName','asc');
    $query = $this->db->get('category');
    $category = $query->result_array();

    return $category;
  }

  public function GetCategoryId($category){
    $this->db->where('categoryName', $category);
    $query = $this->db->get('category');
    $category = $query->result_array();

    return $category[0]['categoryId'];
  }

  public function AddTag($category, $tag){
    $data = array(
      'categoryId' => $category,
      'tagName' => $tag
    );

    $this->db->insert('tags', $data);
  }

  public function AddRelationalTag($tagId, $userId){
    $data = array(
      'userId' => $userId,
      'tagId' => $tagId
    );

    return $this->db->insert('relational', $data);
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

  public function GetUserTags($userId){
    $this->db->select('tagId');
    $this->db->where('userId', $userId);
    $query = $this->db->get('relational');
    $tagsId = $query->result_array();

    return $tagsId;
  }

  public function GetTagsForCategory($category){
    if($category == "All"){
      $tags = $this->GetAllTags();
    }else{
      $categoryId = $this->GetCategoryId($category);

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
  public function AddWeightForTag($userId, $tagId, $weight)
  {
    $this->RemoveTagForUser($userId, $tagId);

    $data = array(
      'userId' => $userId,
      'tagId' => $tagId,
      'weight' => $weight
    );

    $this->db->insert('relational', $data);
  }

//removes the entry in the relational table
  public function RemoveTagForUser($userId, $tagId)
  {
    $this->db->where('userId', $userId);
    $this->db->where('tagId', $tagId);
    $this->db->delete('relational');
  }

}

?>

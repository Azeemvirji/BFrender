<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Model{
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
}

?>

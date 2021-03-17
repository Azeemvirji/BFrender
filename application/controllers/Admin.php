<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  var $TPL;
  var $selectedCategory = "";

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->load->model('tags');

   $_SESSION['page'] = 'admin';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
   $this->TPL['isAdmin'] = $this->userauth->isAdmin();
   $this->TPL['active'] = array('home' => false,
                                'members'=>false,
                                'admin' => true,
                                'login'=>false);
	$this->TPL['acl'] = $_SESSION['acl'];
  $this->TPL['options_dropdown'] = [
                              'member' => "member",
                              'admin' => "admin"];
  }

  private function display()
  {
    $query = $this->db-> query("SELECT * FROM users ORDER BY userId ASC;");
	   $this->TPL['listing'] = $query->result_array();
     $this->TPL['selectedCategory'] = $this->selectedCategory;
     $this->TPL['category'] = $this->tags->GetAllCategory();

    $this->template->show('admin', $this->TPL);
  }

  public function index()
  {
	$this->display();
  }

  public function AddCategory(){
    $this->categoryValidation();
    $this->load->model('tags');
    if($this->form_validation->run()){
      $this->tags->AddCategory($this->input->post("categoryName"));
    }

    $this->display();
  }

  public function categoryValidation(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('categoryName', 'Category', 'required|is_unique[category.categoryName]');
  }

  public function AddTag(){
    $this->tagValidation();
    $this->load->model('tags');
    if($this->form_validation->run()){
      $this->tags->AddTag($this->input->post("category"),$this->input->post("tag"));
    }

    $this->selectedCategory = $this->input->post("category");

    $this->display();
  }

  public function tagValidation(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('tag', 'Tag Name', 'required|is_unique[tags.tagName]');
  }

  public function addUser(){
	$this->formValidation();
	if($this->form_validation->run()){
    $data = array(
      'username' => $this->input->post("username"),
      'password' => $this->input->post("password"),
      'accessLevel' => $this->input->post("accesslevel"),
      'frozen' => 'N'
    );
		$query = $this->db->insert('users', $data);
	}

	$this->display();
}

  public function delete($id)
  {
    $query = $this->db->query("DELETE FROM users where userId = '$id';");

    $this->display();
  }

  public function freeze($id)
  {
	$query = $this->db->query("UPDATE users " .
							  "SET frozen = 'Y'" .
							  " WHERE userId = '$id';");

    $this->display();
  }

  public function unfreeze($id)
  {
	$query = $this->db->query("UPDATE users " .
							  "SET frozen = 'N'" .
							  " WHERE userId = '$id';");

    $this->display();
  }

  public function formValidation(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.uname]',
	array(
                'is_unique'     => 'A user with that username already exists!'
        ));
	$this->form_validation->set_rules('password', 'Password', 'required');
	$this->form_validation->set_rules('accesslevel', 'Access level', 'callback_accesslevel_check');
  }

  public function accesslevel_check($str)
        {
                if ($str == 'member' || $str == 'admin')
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('accesslevel_check', 'Access level must be either member or admin.');
                        return FALSE;
                }
        }
}
?>

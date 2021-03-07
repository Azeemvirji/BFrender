<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interests extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->model('tags');
    $_SESSION['page'] = 'interests';
    $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index(){
    $this->display();
  }

  public function display(){
    $this->TPL['category'] = $this->tags->GetAllCategory();
    $this->TPL['tags'] = $this->tags->GetAllTags();

    $this->template->show('interests', $this->TPL);
  }

  public function AddTag(){
    $this->display();
  }

  public function CreateTag(){
    $this->tagValidation();
    $this->load->model('tags');
    if($this->form_validation->run()){
      $this->tags->AddTag($this->input->post("category"),$this->input->post("tag"));
    }

    $this->display();
  }

  public function tagValidation(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('tag', 'Tag Name', 'required|is_unique[tags.tagName]');
  }
}
?>

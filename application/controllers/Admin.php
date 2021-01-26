<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $_SESSION['page'] = 'admin';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
   $this->TPL['isAdmin'] = $this->userauth->isAdmin();
   $this->TPL['active'] = array('home' => false,
                                'members'=>false,
                                'admin' => true,
                                'login'=>false);
	$this->TPL['acl'] = $_SESSION['acl'];
  }
  
  private function display()
  {
    $query = $this->db-> query("SELECT * FROM userslab6 ORDER BY compid ASC;");
	$this->TPL['listing'] = $query->result_array();
	
    $this->template->show('admin', $this->TPL);
  }

  public function index()
  {
	$this->display();
  }
  
  public function addUser(){
	$this->formValidation();
	if($this->form_validation->run()){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$accesslevel = $this->input->post("accesslevel");
		$query = $this->db->query("INSERT INTO userslab6 VALUES (NULL, '$username', '$password', '$accesslevel', 'N');");
	}
	
	$this->display();
  }
  
  public function delete($id)
  {
    $query = $this->db->query("DELETE FROM userslab6 where compid = '$id';");
 
    $this->display();
  }
  
  public function freeze($id)
  {      
	$query = $this->db->query("UPDATE userslab6 " .
							  "SET frozen = 'Y'" .
							  " WHERE compid = '$id';");

    $this->display();
  }
  
  public function formValidation(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('username', 'Username', 'required|is_unique[userslab6.username]', 
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {

  var $TPL;
  var $currentUser;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->model('users');
   $this->TPL['loggedin'] = $this->userauth->loggedin();
   $this->setActive('home');
  }

  public function index()
  {
    $this->currentUser = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    $this->TPL['user'] = $this->currentUser;
    $this->TPL['user']['bio'] = trim($this->users->GetUserBio($this->currentUser['userId']));
    $this->template->show('edit', $this->TPL);
  }

  public function Submit(){
    if (isset($_FILES['pic']['name']) && !empty($_FILES['pic']['name'])) {
        $this->uploadPic();
      }

    $data = array(
      'firstname' => $this->input->post("first_name"),
      'lastname' => $this->input->post("last_name"),
      'email' => $this->input->post("email"),
      'gender' => $this->input->post("gender")
    );
    $this->db->where('username', $_SESSION['username']);
    $query = $this->db->update('users', $data);

    $this->users->UpdateBio($_SESSION['username'], $this->input->post("bio"));

    $this->TPL['user'] = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    header("Location: ". base_url() . "index.php/Profile");
  }

  protected function uploadPic(){
    $CI =& get_instance();

    $user = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    if($user['imageLocation'] != ""){
        $this->user->UpdateImageName("", $_SESSION['username']);

        $url = './assets/img/users/' . $user['image'];
        if(file_exists($url)){
          unlink($url);
        }
      }
      $config['upload_path'] = './assets/img/users/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['file_name'] = $_SESSION['username'];

      $this->load->library('upload', $config);
      if(!$this->upload->do_upload('pic')){
        $this->TPL['error'] = array('error' => $this->upload->display_errors());
      }else{
        $uploadData = $this->upload->data();
        $this->user->UpdateImageName($uploadData['file_name'], $_SESSION['username']);
      }
  }

  public function ResetPassword(){
    $this->formValidation();
    if($this->form_validation->run() == false){

      $this->setActive('password');
      $this->template->show('edit', $this->TPL);
    }else{
      $this->TPL['msg'] = $this->userauth->changePassword($_SESSION['username'], $this->input->post("newPassword"));
      header("Location: ". base_url() . "index.php/Profile");
    }
  }

  protected function formValidation(){
    $this->currentUser = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    $this->load->library('form_validation');
    $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|callback_is_current_password');
    $this->form_validation->set_rules('newPassword', 'New Password', 'required|min_length[8]|callback_is_password_strong');
    $this->form_validation->set_rules('verify', 'Confirm Password', 'required|matches[newPassword]');
  }
  protected function is_password_strong($password)
  {
     if (preg_match('#[0-9]#', $password) && preg_match('#[A-Z]#', $password)) {
     return TRUE;
     }
     $this->form_validation->set_message('is_password_strong', 'Please make sure password has atleast one number and one captial letter');
     return FALSE;
  }
  protected function is_current_password($password){
    if($password == $this->currentUser['password']){
      return TRUE;
    }
    $this->form_validation->set_message('is_current_password', 'Please make sure you enter your current password');
  }

  protected function setActive($item){
    if($item == 'home'){
       $this->TPL['home'] = "active";
       $this->TPL['password'] = "";
       $this->TPL['options'] = "";
    }else if($item == 'password'){
        $this->TPL['home'] = "";
        $this->TPL['password'] = "active";
        $this->TPL['options'] = "";
    }else{
        $this->TPL['home'] = "";
        $this->TPL['password'] = "";
        $this->TPL['options'] = "active";
    }
  }
}
?>

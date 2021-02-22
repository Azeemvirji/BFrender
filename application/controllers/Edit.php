<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $this->TPL['loggedin'] = $this->userauth->loggedin();

  }

  public function index()
  {
    $this->TPL['user'] = $this->user->GetUserInfoFromUsername($_SESSION['username']);
    $this->template->show('edit', $this->TPL);
  }

  public function Submit(){
    if (isset($_FILES['pic']['name']) && !empty($_FILES['pic']['name'])) {
        $this->uploadPic();
      }

    $data = array(
      'fname' => $this->input->post("first_name"),
      'lname' => $this->input->post("last_name"),
      'email' => $this->input->post("email"),
      'gender' => $this->input->post("gender")
    );
    $this->db->where('uname', $_SESSION['username']);
    $query = $this->db->update('users', $data);

    $this->TPL['user'] = $this->user->GetUserInfoFromUsername($_SESSION['username']);
    header("Location: ". base_url() . "index.php/Profile");
  }

  public function uploadPic(){
    $CI =& get_instance();

    $user = $this->user->GetUserInfoFromUsername($_SESSION['username']);
    if($user['imageLocation'] != ""){
        $this->user->UpdateImageName("", $_SESSION['username']);

        $url = './assets/img/' . $user['image'];
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
}
?>

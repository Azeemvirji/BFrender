<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friends extends CI_Controller {
    var $TPL;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
     $_SESSION['page'] = 'friends';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->template->show('friends', $this->TPL);
    }

    public function Find(){
      $str = strtolower($this->input->post('str'));
      if(!is_null($str) && $str != ""){
        $this->load->model('users');

        $users = $this->users->GetAllUsers();

        $output = "<h4>Click on a name to add as friend</h4>\n<ul>";
        foreach($users as $user){
          if($user['uname'] == $_SESSION['username']){
                continue;
           }
          if(strpos(strtolower($user['fname']), $str) !== false || strpos(strtolower($user['lname']), $str) !== false || strpos(strtolower($user['uname']), $str) !== false){
            $output .= "<a href=\"<?= base_url(); ?>index.php?/Friends/Add/" . $user['userId'] . "\"><li>". $user['uname'] . "</li></a>";
          }
        }
        }else{
          echo "Please enter a username to search";
        }
      echo $output;
    }

    public function Add($friendId){
      $this->load->model('users');

      $user1 = $this->users->GetUserID($_SESSION['username']);
      $user2 = $friendId;

      $this->users->AddFriends($user1, $user2);

      $this->template->show('friends', $this->TPL);
    }

}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friends extends CI_Controller {
    var $TPL;
    var $userinfo;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
      //adding the models neededs
      $this->load->model('users');
      $this->load->model('friendsmodel');

     $_SESSION['page'] = 'friends';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->display();
    }

    protected function display(){
      $this->getUserInfo();
      $this->TPL['friends'] = $this->friendsmodel->GetFriendsForUser($this->userinfo['userId']);
      $this->template->show('friends', $this->TPL);
    }

    protected function getUserInfo(){
      $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
      $this->TPL['user'] = $this->userinfo;
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

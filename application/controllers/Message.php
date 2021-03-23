<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->model('users');
    $this->load->model('friendsmodel');
    $this->load->model('messagesModel');

    date_default_timezone_set('America/Toronto');
    $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index(){
    //$this->display();
  }

  public function chat($uname){
    $this->display($uname);
  }

  protected function display($uname){
    $this->TPL['chatUname'] = $uname;
    $this->TPL['conversation'] = $this->GetConversation($uname);
    $this->TPL['pics'] = $this->GetImageLocation($uname);

    $this->template->show('message', $this->TPL);
  }

  protected function GetImageLocation($uname){
    $pics = array(
      'user' => $this->users->GetImageName($_SESSION['username']),
      'friend' => $this->users->GetImageName($uname)
    );

    return $pics;
  }

  public function GetAllMessages(){
    $friend = $this->input->post('friend');

    $conversation = $this->GetConversation($friend);
    $pics = $this->GetImageLocation($friend);

    foreach ($conversation as $key => $value) {
      $output = "";
      if($value['senderUname'] == $_SESSION['username']) {
        $output .= "<li class=\"message right appeared\"><img class=\"avatar\" src=\"" . assetUrl() . "img/users/" . $pics['user'] . "\"/>";
      }else{
        $output .= "<li class=\"message left appeared\"><img class=\"avatar\" src=\"" . assetUrl() . "img/users/" . $pics['friend'] . "\"/>";
      }
      $output .= "<div class=\"text_wrapper\"><div class=\"text\">" . $value['messageString'] . "</div></div></li>";

      echo $output;
    }
  }

  public function SendMessage(){
    $msg = htmlentities($this->input->post('msg'));
    $friend = $this->input->post('friend');

    $userId = $this->users->GetUserID($_SESSION['username']);
    $friendId = $this->users->GetUserID($friend);

    $friendsId = $this->friendsmodel->GetFriendsId($userId, $friendId);

    $datetime = date('c');

    $this->messagesModel->AddMessage($friendsId, $msg, $userId, $datetime);

    echo $msg;
  }

  protected function GetConversation($friend){
    $userId = $this->users->GetUserID($_SESSION['username']);
    $friendId = $this->users->GetUserID($friend);

    $friendsId = $this->friendsmodel->GetFriendsId($userId, $friendId);

    $conversation = $this->messagesModel->GetConversation($friendsId);

    return $this->ReplaceId($conversation, $friend);
  }

  protected function ReplaceId($conversation, $friendUname){
    $user = array(
      'username' => $_SESSION['username'],
      'userId' => $this->users->GetUserID($_SESSION['username'])
    );

    $friend = array(
      'username' => $friendUname,
      'userId' => $this->users->GetUserID($friendUname)
    );

    for($i = 0; $i < count($conversation); $i++){
      if($conversation[$i]['senderID'] == $user['userId']){
        $conversation[$i]['senderUname'] = $user['username'];
      }elseif($conversation[$i]['senderID'] == $friend['userId']){
        $conversation[$i]['senderUname'] = $friend['username'];
      }
    }

    return $conversation;
  }

  public function Debug(){
    echo $this->users->GetUserID($_SESSION['username']);
  }
}

?>

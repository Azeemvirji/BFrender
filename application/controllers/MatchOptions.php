<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MatchOptions extends CI_Controller {
    var $TPL;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
      $this->load->model('tags');
      $this->load->model('users');
     $_SESSION['page'] = 'matchOptions';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->display();
    }

    protected function display()
    {
      $this->TPL['category'] = $this->tags->GetAllCategory();
      $this->TPL['tags'] = $this->tags->GetAllTags();
      //$this->TPL['tags'] = $this->GetTags($this->users->GetUserID($_SESSION['username']));

      $this->template->show('matchOptions', $this->TPL);
    }

    protected function GetTags($userId) {
      $tagsId = $this->tags->GetUserTags($userId);
      $tags = [];

      foreach ($tagsId as $row) {
        array_push($tags, $this->tags->GetTagName($row['tagId']));
      }

      return $tags;
    }
}
?>

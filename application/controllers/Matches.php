<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matches extends CI_Controller {
  var $TPL;
  var $userinfo;
  var $matchesRanked;
  
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->model('users');
	$this->load->model('MatchesModel');
	
    date_default_timezone_set('America/Toronto');
   $_SESSION['page'] = 'matches';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }
	
	public function index(){
      $this->display();
    }
	
	protected function display(){
      $this->getUserInfo();
	  $this->matchesRanked = $this->MatchesModel->GetUserRankedMatches($this->userinfo['userId']); // The Matching algorithm
	  $this->TPL['matches'] = $this->MatchesModel->GetMatchesForUser($this->userinfo['userId'], $this->matchesRanked);
      $this->template->show('matches', $this->TPL);
    }
	
	 protected function getUserInfo(){
      $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
      $this->TPL['user'] = $this->userinfo;
    }
}
?>

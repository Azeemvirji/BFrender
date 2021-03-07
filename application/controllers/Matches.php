<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matches extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->model('users');
    date_default_timezone_set('America/Toronto');
   $_SESSION['page'] = 'matches';
   $this->TPL['loggedin'] = $this->userauth->loggedin();
  }

  public function index()
  {
    $this->TPL['user'] = $this->users->GetUserInfoFromUsername($_SESSION['username']);
    $this->template->show('matches', $this->TPL);
  }

}
?>

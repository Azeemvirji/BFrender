<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MatchOptions extends CI_Controller {
    var $TPL;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
     $_SESSION['page'] = 'matchOptions';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->template->show('matchOptions', $this->TPL);
    }
}
?>

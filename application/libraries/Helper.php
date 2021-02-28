<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper  {
  public function redirect($page)
  {
      header("Location: ".$page);
      exit();
  }
}

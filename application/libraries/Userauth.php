<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userauth  {

    private $login_page = "";
    private $logout_page = "";
	private $members_page = "";
	private $home_page = "";

    private $username;
    private $password;
	private $frozen;
	private $accesslevel;

    /**
    * Turn off notices so we can have session_start run twice
    */
    function __construct()
    {
      error_reporting(E_ALL & ~E_NOTICE);
      $this->login_page = base_url() . "index.php?/Login";
      $this->logout_page = base_url() . "index.php?/Home";
	  $this->members_page = base_url() . "index.php?/Profile";
	  $this->home_page = base_url() . "index.php?/Home";
    }

    /**
    * @return string
    * @desc Login handling
    */
    public function login($username,$password)
    {

      session_start();

      // User is already logged in if SESSION variables are good.
      if ($this->validSessionExists() == true)
      {
        $this->redirect($_SESSION['basepage']);
      }
      $this->updateLastLogin($username);
      // First time users don't get an error message....
      if ($_SERVER['REQUEST_METHOD'] == 'GET') return;

      // Check login form for well formedness.....if bad, send error message
      if ($this->formHasValidCharacters($username, $password) == false)
      {
         return "Username/password fields cannot be blank!";
      }

      // verify if form's data coresponds to database's data
      if ($this->userIsInDatabase() == false)
      {
        return "Invalid username/password!";
      }
      else
      {
		if($this->frozen == 'Y'){
			return 'Account frozen!';
		}else{
			// We're in!
			// Redirect authenticated users to the correct landing page
			// ex: admin goes to admin, members go to members
			$this->writeSession();
			$this->redirect($_SESSION['basepage']);
		}
	  }
    }

  public function register($data, $passwordString){
  session_start();

  if ($this->validSessionExists() == true)
  {
    $this->redirect($_SESSION['basepage']);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') return;

  // Remember: you can get CodeIgniter instance from within a library with:
  $CI =& get_instance();
  // And then you can access database query method with:
  //$query = $CI->db->query("INSERT INTO `user`(`fname`,`lname`,`uname`,`email`,`password`,`accesslevel`,`securityQuestion`,`securityAnswer`) values ('" + $firstname + "','" + $lastname + "','" + $username + "','" + $email + "','" + $password + "','member','" + $secQuestion + "','" + $secAnswer + "');");
  $CI->db->insert('users', $data);

  $_SESSION['validChar'] = $this->formHasValidCharacters($data['username'], $passwordString);

  if ($this->userIsInDatabase() == false)
  {
    return 'User didnt get inserted';
  }else{
    $this->writeSession();
    $this->redirect($_SESSION['basepage']);
  }
}

    /**
    * @return void
    * @desc Validate if user is logged in
    */
    public function loggedin()
    {

      session_start();

      // Users who are not logged in are redirected out
      if ($this->validSessionExists() == false)
      {
        $this->redirect($this->login_page);
      }

    $this->updateLastActive($_SESSION['username']);

    $accesslevel = $_SESSION['accesslevel'];
	  if($accesslevel == ""){
		  $accesslevel = 'public';
	  }

	  $_SESSION['acl'] = $acl[$_SESSION['page']][$accesslevel];

	  if(!$_SESSION['acl']){
		  if($accesslevel == 'members'){
			$this->redirect($this->members_page);
		  }else if($accesslevel == 'public'){
			$this->redirect($this->home_page);
		  }
	  }
      // Access Control List checking goes here..
      // Does user have sufficient permissions to access page?
      // Ex. Can a bronze level access the Admin page?


      return true;
    }

	public function isAdmin(){
		if($_SESSION['accesslevel'] != 'admin'){
			$this->redirect($this->members_page);
		}

		return true;
	}

    /**
    * @return void
    * @desc The user will be logged out.
    */
    public function logout()
    {
      session_start();
      $_SESSION = array();
      session_destroy();
      header("Location: ".$this->logout_page);
    }

    /**
    * @return bool
    * @desc Verify if user has got a session and if the user's IP corresonds to the IP in the session.
    */
    public function validSessionExists()
    {
      session_start();
      if (!isset($_SESSION['username']))
      {
        return false;
      }
      else
      {
        return true;
      }
    }

    /**
    * @return void
    * @desc Verify if login form fields were filled out correctly
    */
    public function formHasValidCharacters($username, $password)
    {
      // check form values for strange characters and length (3-12 characters).
      // if both values have values at this point, then basic requirements met
      if ( (empty($username) == false) && (empty($password) == false) )
      {
        $this->username = $username;
        $this->password = $password;
        return true;
      }
      else
      {
        return false;
      }
    }

    /**
    * @return bool
    * @desc Verify username and password with MySQL database.
    */
    public function userIsInDatabase()
    {

      // Remember: you can get CodeIgniter instance from within a library with:
      $CI =& get_instance();
      // And then you can access database query method with:
      $query = $CI->db->query("SELECT * FROM users ORDER BY userId ASC;");
	  $listing = $query->result_array();
      // Access database to verify username and password from database table
	  foreach($listing as $row){
		  {
        //$this->test = $row['uname'];
        if ($this->username ==  $row['username'])
  		  {
  			if(password_verify($this->password, $row['password'])){
  				$this->frozen = $row['frozen'];
  				$this->accesslevel = $row['accessLevel'];

  				return true;
  			}
        }
		  }
	  }
      return false;

    }

    public function updateLastLogin($username){
      $CI =& get_instance();
      date_default_timezone_set('America/Toronto');
      $CI->db->set('lastLogin', date("Y-m-d h:i:sa"));
      $CI->db->where('username', $username);
      $CI->db->update('users');
    }

    public function updateLastActive($username){
      $CI =& get_instance();
      date_default_timezone_set('America/Toronto');
      $CI->db->set('lastActive', date("Y-m-d h:i:sa"));
      $CI->db->where('username', $username);
      $CI->db->update('users');
    }


    /**
    * @return void
    * @param string $page
    * @desc Redirect the browser to the value in $page.
    */
    public function redirect($page)
    {
        header("Location: ".$page);
        exit();
    }

    /**
    * @return void
    * @desc Write username and other data into the session.
    */
    public function writeSession()
    {
        $_SESSION['username'] = $this->username;
        $_SESSION['accesslevel'] = $this->accesslevel;
		if($this->accesslevel == 'admin'){
			$_SESSION['basepage'] = base_url() . "index.php?/Admin";
		}else{
			$_SESSION['basepage'] = base_url() . "index.php?/Profile";
		}

    }

    /**
    * @return string
    * @desc Username getter, not necessary
    */
    public function getUsername()
    {
        return $_SESSION['username'];
    }

    public function changePassword($username, $password){
      session_start();
      $CI =& get_instance();

      $CI->db->set('password', password_hash($password, PASSWORD_DEFAULT));
      $CI->db->where('username', $username);
      $CI->db->update('users');

      return $this->login($username, $password);
    }
}

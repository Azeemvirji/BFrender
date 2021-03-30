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
	  $this->matchesRanked = $this->GetUserRankedMatches($this->userinfo['userId']); // The Matching algorithm
	  $this->TPL['matches'] = $this->GetMatchesForUser($this->userinfo['userId'], $this->matchesRanked);
      $this->template->show('matches', $this->TPL);
    }

	 protected function getUserInfo(){
      $this->userinfo = $this->users->GetUserInfoFromUsername($_SESSION['username']);
      $this->TPL['user'] = $this->userinfo;
    }

	// take the userID, and a ranked list of matchIds, and returns data to populate the view.
	public function GetMatchesForUser($userId, $matchIds){
		$this->load->model('users');


		$matches = [];

		//
		// We need...
		foreach($matchIds as $matchID){

			$UserInfoArray = $this->users->GetUserInfoFromUserId($matchID['ID']);

			$NextMatch = [];

			$NextMatch['rank'] = $matchID['Rank'];
			$NextMatch['score'] = $matchID['Score'];

			#names
			$NextMatch['firstname'] = $UserInfoArray['firstname'];
			$NextMatch['lastname'] = $UserInfoArray['lastname'];
      $NextMatch['username'] = $UserInfoArray['username'];

			#image
			$NextMatch['imageLocation'] = $UserInfoArray['imageLocation'];

			#age
			$age = $this->getAge($UserInfoArray['dateOfBirth']);
			$NextMatch['age'] = $age;

			#last active
			$NextMatch['lastlogin'] = $this->getActiveTime($UserInfoArray['lastlogin']);

			array_push($matches, $NextMatch);
		}


		return $matches;
	}

	// function to check if user is valid
	public function CheckTestUserValidity($userId, $testId){
		$this->load->model('users');

		$UserInfoArray = $this->users->GetUserInfoFromUserId($userId);
		$TestInfoArray = $this->users->GetUserInfoFromUserId($testId);

		// check if user
		if($testId == $userId){return 0;}


		// check if user is frozen.
		if($TestInfoArray['frozen'] != 'N'){return 0;}


		// check if user is recently active
		$ActiveThreshold = 14; // 2 week cut-off.
		$LastActiveTime = $this->getActiveTime($TestInfoArray['lastLogin']);
		//if($LastActiveTime > $ActiveThreshold){return 0;}

		// check if friend/blocked.



		// check if user has a dealbreaker interest.


		// check if user is missing a required interest.


		return 1;
	}

	// function to score match
	public function ScoreUser($userId, $testId){
		// setup
		$this->load->model('users');

		$UserInfoArray = $this->users->GetUserInfoFromUserId($userId);
		$TestInfoArray = $this->users->GetUserInfoFromUserId($testId);

		# Note: below is bad code. Will remove when proper db functions implemented.
		// Interests (may want to change tag model to get user-specific interests)
		//$query = $this->db->get('InterestsRelational');
		//$IntRelational = $query->result_array();

		// Requirements/Preferences and Dealbreakers (may want to change tag model to get user-specific tags)
		//$query = $this->db->get('TagsRelational');
		//$TagRelational = $query->result_array();
		# note: above is bad code. Will remove once proper db functions implemented.

		// Score = W1*DemographicScore+W2*PreferedInterestScore+W3*MatchingInterestScore+W4*SimilarInterestScore+W5*ActivityScore+...
		$score = 0;

		// Demographic Score: City, Gender, Age, etc.
		$UAge = $this->getAge($UserInfoArray['dateOfBirth']);
		$TAge = $this->getAge($TestInfoArray['dateOfBirth']);
		$AgeScore = max(100 - pow(abs($UAge-$TAge),1.8),0); // Max 100

		$UGen = $UserInfoArray['gender'];
		$TGen = $TestInfoArray['gender'];
		$GenderScore = 0;
		if ($UGen == $TGen) {$GenderScore = 10;} // Max 10

		$DemScore = $AgeScore + $GenderScore; //Max 110

		// Prefered Interest Score



		$PIScore = 0;

		// Matching Interest Score








		$MIScore = 0;

		// Similar Interest Score


		$SIScore = 0;

		// Activity Score




		$ActScore = 0;


		// Total
		$W1 = 1;
		$W2 = 1;
		$W3 = 1;
		$W4 = 1;
		$W5 = 1;

		$score = $score + $W1*$DemScore + $W2*$PIScore + $W3*$MIScore + $W4*$SIScore + $W5*$ActScore;

		return $score;
	}


	// Model for the matching algorithm - Peter
	public function GetUserRankedMatches($userId){
		$this->load->model('users');

		// step 1: create an empty array. Note, there are 3 cases to deal with: 0 matches, 1-9 matches, and 10 matches.
		$matchIds = [];
		$MatchListCount = 0;


		// step 2: make an array of all users.
		// if there is time, or if we have slowdowns, pre-filter users who are not frozen, recently active (7 days), not blocked/friends by/with user, etc.

		//$matchuserlist = $this->users->SelectAllUserIds(); # todo: make this work. For now, will get all users.
		$matchuserlist = $this->users->GetAllUsers();


		// step 3: for each user in the array, rank them and put the results in $matchIds
		foreach($matchuserlist as $matchuser){
			$testId = $matchuser['userId'];
			$NextUserTest = [];

			// todo: make if statement to remove invalid userids
			$valid = $this->CheckTestUserValidity($userId, $testId);

			// Scoring and sorting - wip
			if($valid == 1){
				$MatchScore = $this->ScoreUser($userId, $testId);

				// todo: make scoring algorithm


				$NextUserTest['Rank'] = 0; //$MatchListCount + 1;
				$NextUserTest['ID'] = $testId;
				$NextUserTest['Score'] = $MatchScore;


				// insert user into list, and shift all users down.
				for ($Rank = 1; $Rank <= $MatchListCount; $Rank++) {
					if ($matchIds[$Rank-1]['Score'] < $NextUserTest['Score']){
						$tempId = $matchIds[$Rank-1]['ID'];
						$tempScore = $matchIds[$Rank-1]['Score'];
						$matchIds[$Rank-1]['ID'] = $NextUserTest['ID'];
						$matchIds[$Rank-1]['Score'] = $NextUserTest['Score'];
						$NextUserTest['ID'] = $tempId;
						$NextUserTest['Score'] = $tempScore;
					}

				}
				// if there is less than 10 matches, add to the end.
				if ($MatchListCount < 10){
					$MatchListCount = $MatchListCount + 1;
					$NextUserTest['Rank'] = $MatchListCount;
					array_push($matchIds, $NextUserTest);
				}


			}
		}

		return $matchIds; //output needs each row to have a rank, userid, and score.
	}

	protected function getAge($birthDate){
		date_default_timezone_set('America/Toronto');
		$birthDate = explode("-", $birthDate);
		$tdate = time();

		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
		? ((date("Y") - $birthDate[0]) - 1)
		: (date("Y") - $birthDate[0]));

		return $age;
	}

	protected function getActiveTime($lastLogin){ // not sure what is going wrong here.
		date_default_timezone_set('America/Toronto');
		//$lastLogin = date_create($lastLogin);//explode("-", $lastLogin);
		//$tdate = date_create();//time();

		$lastLogin = strtotime($lastLogin);
		$tdate = time();

		//$LL_days = (date("md", date("U", mktime(0, 0, 0, $lastLogin[2], $lastLogin[1], $lastLogin[0]))) > date("md")
		//? ((date("Y") - $lastLogin[0]) - 1)
		//: (date("Y") - $lastLogin[0]));

		//$LL_days = date_diff($lastLogin, $tdate);
		$LL_days = ($tdate-$lastLogin)/(60*60*24);

		return abs(round($LL_days));// / 86400));
		//return $LL_days;
	}







}
?>

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
    $this->load->model('matchesmodel');
    $this->load->model('friendsmodel');
    $this->load->model('location');
    $this->load->model('tags');
    $this->load->model('category');

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

    $userInterests = $this->GetInterestsForUser($userId);
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

      $location = $this->location->GetLocationById($this->users->GetUserLocation($UserInfoArray['userId']));
      $NextMatch['city'] = $location['city'];

      $commonInterest = $this->GetCommonInterests($userInterests, $UserInfoArray['userId']);
      $NextMatch['CommonInterest'] = $commonInterest;
      $NextMatch['InterestCount'] = count($commonInterest);

      $NextMatch['ActivitySuggestion'] = '';

			#last active
			$NextMatch['lastActive'] = $this->getActiveTime($UserInfoArray['lastActive']);

			array_push($matches, $NextMatch);
		}


		return $matches;
	}

  protected function GetCommonInterests($userInterests, $friendId){
    $friendsInterests = $this->GetInterestsForUser($friendId);
    $common = [];

    foreach ($userInterests as $interest) {
      if(in_array($interest, $friendsInterests)){
        array_push($common, $interest);
      }
    }

    return $common;
  }

  protected function GetInterestsForUser($userId) {
    $tagsId = $this->tags->GetUserTags($userId, "InterestRelational");
    $tags = [];

    foreach ($tagsId as $row) {
      array_push($tags, $this->tags->GetTagName($row['tagId']));
    }

    return $tags;
  }

	// function to check if user is valid
	public function CheckTestUserValidity($userId, $testId){
		$UserInfoArray = $this->users->GetUserInfoFromUserId($userId);
		$TestInfoArray = $this->users->GetUserInfoFromUserId($testId);

    $TestInterests =  $this->matchesmodel->GetUserInterests($testId);

		// check if user
		if($testId == $userId){return 0;}


		// check if user is frozen.
		if($TestInfoArray['frozen'] != 'N'){return 0;}


		// check if user is recently active
		$ActiveThreshold = 28; // 4 week cut-off.
		$LastActiveTime = $this->getActiveTime($TestInfoArray['lastActive']);
		if($LastActiveTime > $ActiveThreshold){return 0;}



		// check if friend/blocked.
    if ($this->friendsmodel->CheckIfInFriendsTable($userId, $testId) != "false"){return 0;}

		// check if user has a dealbreaker interest.
    $dealbreakers = $this->matchesmodel->GetUserMatchOptions($userId, 'dealbreaker');
    foreach ($dealbreakers as $db){if (in_array($db,$TestInterests) == 1){return 0;}}

		// check if user is missing a required interest.
    $requirements = $this->matchesmodel->GetUserMatchOptions($userId, 'requirements');
    foreach ($requirements as $required){if (in_array($required,$TestInterests) == 0){return 0;}}

    return 1;
	}

	// function to score match
	public function ScoreUser($userId, $testId){
		// setup
		$this->load->model('users');

		$UserInfoArray = $this->users->GetUserInfoFromUserId($userId);
		$TestInfoArray = $this->users->GetUserInfoFromUserId($testId);

    $UserInterests =  $this->matchesmodel->GetUserInterests($userId);
    $TestInterests =  $this->matchesmodel->GetUserInterests($testId);

    $UserPreferedList = $this->matchesmodel->GetUserMatchOptions($userId, 'preferences');
    $UserRequiredList = $this->matchesmodel->GetUserMatchOptions($userId, 'requirements'); // technically also preferences

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

    $ULoc = $this->location->GetLocationById($this->users->GetUserLocation($userId));
    $TLoc = $this->location->GetLocationById($this->users->GetUserLocation($testId));

    $CityScore = 0;
    if ($ULoc == $TLoc) {$CityScore = 30;} // Max 30

		$DemScore = $AgeScore + $GenderScore + $CityScore; //Max 140

		// Prefered Interest Score
    $PrefCount = count($UserPreferedList);
    $ReqCount = count($UserRequiredList);
    $PRcount = $PrefCount + $ReqCount;
    $PRMatch = 0;
    $PIScoreA = 0;
    if ($PRcount != 0){
        foreach ($UserPreferedList as $UserPref){if (in_array($UserPref,$TestInterests) == 1){$PRMatch += 1;}}
        foreach ($UserRequiredList as $UserReq){if (in_array($UserReq,$TestInterests) == 1){$PRMatch += 1;}}
        $PIScoreA = $PRMatch/$PRcount*100; //Max 100
    }

    // may look like bloat. I have these variables seperate to allow for future potential nuance.
		$PIScore = $PIScoreA;

		// Matching Interest Score
    $UserIntCount = count($UserInterests);
    $TestIntCount = count($TestInterests);
    $AvIntCount = ($UserIntCount + $TestIntCount)/2;
    $MICount = 0;
    foreach ($UserInterests as $UserI){if (in_array($UserI,$TestInterests) == 1){$MICount += 1;}}

    $IdealInterestCount = 20; // To prevent someone spamming interests for matches
    if ($AvIntCount > $IdealInterestCount){
        $MICount = $MICount * (1 - $IdealInterestCount/$AvIntCount);
    }

		$MIScore = $MICount;

		// Similar Interest Score
    // This checks for interests that users have which are in the same catagory
    // and while not as valuable as direct matches, they show commonalities.
    $Catagories = $this->category->GetAllCategory();

    $SIScoreA = 0;
    foreach($Catagories as $Catagory){
      $SIUser = 0;
      $SITest = 0;
      $TagList = $this->tags->GetTagsForCategory($category);
      foreach($TagList as $TagL){
        $TagID = $this->tags->GetTagId($TagL);
        if (in_array($TagID,$TestInterests) == 1){$SIUser += 1;}
        if (in_array($TagID,$UserInterests) == 1){$SITest += 1;}
      }

      $SIScoreA = $SIScoreA + $SIUser*$SITest;
    }

		$SIScore = sqrt($SIScoreA); // not changing the score for some reason.

		// Activity Score

    $LastActiveTime = $this->getActiveTime($TestInfoArray['lastActive']);

		$ActScore = 100-5*$LastActiveTime; //max 100, can be negative.


		// Total
		$W1 = 1;
		$W2 = 1;
		$W3 = 25; // Higher to offset lower value
		$W4 = 5;
		$W5 = 1;

		$score = $W1*$DemScore + $W2*$PIScore + $W3*$MIScore + $W4*$SIScore + $W5*$ActScore;

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

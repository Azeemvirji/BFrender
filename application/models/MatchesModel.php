<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Model for the layout of the Matches Page - Peter
class MatchesModel extends CI_Model{

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
			
			#image
			$NextMatch['imageLocation'] = $UserInfoArray['imageLocation'];
			
			#age
			$age = $this->getAge($UserInfoArray['dateOfBirth']);
			$NextMatch['age'] = $age;
			
			
			array_push($matches, $NextMatch);
		}
		
		
		return $matches;
	}
	
	// function to check if user is valid
	public function CheckTestUserValidity($userId, $testId){
		
		// check if user
		if($testId == $userId){return 0;}
		
		
		
		
		return 1;
	}
	
	// function to score match
	public function ScoreUser($userId, $testId){
		// setup
		$this->load->model('users');
		
		$UserInfoArray = $this->users->GetUserInfoFromUserId($userId);
		$TestInfoArray = $this->users->GetUserInfoFromUserId($testId);
		
		
		// Score = W1*DemographicScore+W2*PreferedInterestScore+W3*MatchingInterestScore+W4*SimilarInterestScore+W5*ActivityScore+...
		$score = 0;

		// Demographic Score: City, Gender, Age, etc.
		$W1 = 1;
		
		$UAge = $this->getAge($UserInfoArray['dateOfBirth']);
		$TAge = $this->getAge($TestInfoArray['dateOfBirth']);
		
		
		$AgeScore = 100/(1+abs($UAge-$TAge));
		
		
		
		$score = $score + $W1*($AgeScore);
		
		
		
		
		
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

}

?>
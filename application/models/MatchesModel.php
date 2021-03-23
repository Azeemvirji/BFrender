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
			
			#names
			$NextMatch['firstname'] = $UserInfoArray['firstname'];
			$NextMatch['lastname'] = $UserInfoArray['lastname'];
			
			#image
			$NextMatch['imageLocation'] = $UserInfoArray['imageLocation'];
			
			
			array_push($matches, $NextMatch);
		}
		
		
		return $matches;
	}
	
	
	public function CheckTestUserValidity($userId, $testId){
		$valid = 1;
		
		if($testId == $userId){$valid = 0;}
		
		return $valid;
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
		
		//echo($matchuserlist);
		//echo($matchuserlist['userId']);
		
		
		// step 3: for each user in the array, rank them and put the results in $matchIds
		foreach($matchuserlist as $matchuser){
			$testId = $matchuser['userId'];
			$NextUserTest = [];
			
			// todo: make if statement to remove invalid userids
			$valid = $this->CheckTestUserValidity($userId, $testId);
			
			// Scoring and sorting - wip
			if($valid == 1){
				
				
				$MatchListCount = $MatchListCount + 1;
				
				$NextUserTest['Rank'] = $MatchListCount;
				$NextUserTest['ID'] = $testId;
				$NextUserTest['Score'] = 100;
				
				
				
				array_push($matchIds, $NextUserTest);
			}
		}
		
		//$matchIds = [[1],[2],[3],[4],]; //test array. Will remove.
		return $matchIds; //output needs each row to have a rank, userid, and score.
	}

}

?>
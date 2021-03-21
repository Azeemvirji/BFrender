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
			
			$NextMatch = [];
			
			
			$NextMatch['rank'] = 1;
			
			
			array_push($matches, $NextMatch);#$this->users->GetUserInfoFromUserId($relation[$nextID]));
		}
		
		
		return $matches;
	}
	
	
	
	// Model for the matching algorithm - Peter
	public function GetUserRankedMatches($userId){
		
		$matchIds = [[1],[2],[3],[4],];
		
		
		
		
		return $matchIds;
	}

}

?>
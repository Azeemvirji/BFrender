<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// A series of functions to get interests, tag preferences/dealbreakers, and catagories from the database the purpose of matching.
// Note, there are likely duplicate functions.
class MatchesModel extends CI_Model{


	// function to get list of interests for a userid (from the relational table)
	public function GetUserInterests($userId){
		$this->db->select('tagId');
		$this->db->where('userId', $userId);
		$query = $this->db->get('InterestRelational');
		$tagsId = $query->result_array();

		return $tagsId;
	}


	// function to get a list of tags for a userid (from the relational table).
	// types can be 'requirements', 'preferences', or 'dealbreaker'
	public function GetUserMatchOptions($userId, $type){
		$this->db->select('tagId');
		$this->db->where('userId', $userId);
		$this->db->where('type', $type);
		$query = $this->db->get('TagsRelational');
		$tagsId = $query->result_array();

		return $tagsId;
	}

}

?>

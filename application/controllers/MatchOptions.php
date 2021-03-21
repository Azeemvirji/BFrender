<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MatchOptions extends CI_Controller {
    var $TPL;

    public function __construct()
    {
      parent::__construct();
      // Your own constructor code
      $this->load->model('tags');
      $this->load->model('users');
      $this->load->model('category');

     $_SESSION['page'] = 'matchOptions';
     $this->TPL['loggedin'] = $this->userauth->loggedin();
    }

    public function index(){
      $this->display();
    }

    public function Debug($userId, $tagId, $type){
      $this->tags->AddWeightForTag($userId, $tagId, $type);
    }

    protected function display()
    {
      $requirements = $this->GetTagsForWeights("requirements");
      $preferences = $this->GetTagsForWeights("preferences");
      $dealbreaker = $this->GetTagsForWeights("dealbreaker");

      $this->TPL['category'] = $this->category->GetAllCategory();
      $this->TPL['tags'] = $this->RemoveUsedTags($this->tags->GetAllTags(), $requirements, $preferences, $dealbreaker);
      $this->TPL['requirements'] = $requirements;
      $this->TPL['preferences'] = $preferences;
      $this->TPL['dealbreaker'] = $dealbreaker;

      $this->template->show('matchOptions', $this->TPL);
    }

    public function GetTagsForWeights($weight){
      $user = $this->users->GetUserInfoFromUsername($_SESSION['username']);

      $tags = $this->tags->GetTagsByWeightForUser($weight, $user['userId']);
      $names = [];

      foreach ($tags as $tag) {
        array_push($names, $this->tags->GetTagName($tag['tagId']));
      }

      return $names;
    }

    public function RemoveUsedTags($allTags, $requirements, $preferences, $dealbreaker){
      $updated = [];

      foreach ($allTags as $tag) {
        if(!in_array($tag['tagName'], $requirements) and !in_array($tag['tagName'], $preferences) and !in_array($tag['tagName'], $dealbreaker)){
          array_push($updated, $tag);
        }
      }

      return $updated;
    }

    public function SetWeight(){
      $type = $this->input->post('weight');
      $tagName = $this->input->post('tagName');

      $tagId = $this->tags->GetTagId($tagName);
      $userId = $this->users->GetUserID($_SESSION['username']);

      if($type == "main"){
        $this->tags->RemoveTagForUser($userId, $tagId, "TagsRelational");
      }else{
        $this->tags->AddWeightForTag($userId, $tagId, $type);
      }
    }

    public function GetTagsForCategory(){
      $category = $this->input->post('category');
      $requirements = $this->GetTagsForWeights("requirements");
      $preferences = $this->GetTagsForWeights("preferences");
      $dealbreaker = $this->GetTagsForWeights("dealbreaker");;

      $tags = $this->tags->GetTagsForCategory($category);

      foreach($tags as $tag){
        if(!in_array($tag['tagName'], $requirements) and !in_array($tag['tagName'], $preferences) and !in_array($tag['tagName'], $dealbreaker)){
          echo "<div class=\"list-item\" draggable=\"true\" id=\"" . $tag['tagName'] . "\">" . $tag['tagName'] . "</div>";
        }
      }
    }

    protected function GetTagsForUser($userId) {
      $tagsId = $this->tags->GetUserTags($userId);
      $tags = [];

      foreach ($tagsId as $row) {
        array_push($tags, $this->tags->GetTagName($row['tagId']));
      }

      return $tags;
    }
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messagesmodel extends CI_Model{
  protected $table = 'messages';

  public function GetConversation($messageId)
  {
    $query = $this->db->get_where('messages', array('messageId' => $messageId), $limit, $offset);

    return $query;
  }

  public function AddMessage($friendsID, $messageString, $senderID, $timeSent)
  {
    $data = array(
        'friendsID' => $friendsID,
        'messageString' => $messageString,
        'senderID' => $senderID,
        'timeSent' => $timeSent
      );

      $this->db->insert($this->table, $data);


  }

  public function GetMessage($friendsID, $senderID)
  {
    $this->db->select('friendsID, messageID, messageString, senderID, timeSent');
    $this->db->from('messages');
    $this->db->where('friendsID', $friendsID);
    $this->db->where('senderID', $senderID);

    $query = $this->db->get();

    return $query;
  }

}

?>

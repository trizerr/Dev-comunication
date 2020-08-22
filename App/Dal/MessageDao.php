<?php


namespace App\Dal;

use App\Application;
use App\Entity\Message;

class MessageDao
{
  private $db;

  public function __construct()
  {
    $this->db = Application::$db;
  }

  public function create(Message $message)
  {
    $this->db->query("INSERT INTO messages (user_id, text) VALUES (:user_id, :text)");
    $this->db->bind('user_id', $message->getUserId());
   // $this->db->bind('receiver_id', $message->getReceiverId());
    $this->db->bind('text', $message->getText());
    $this->db->execute();
    return true;
  }

  public function read($messagesdb) //function to read messages which are selected in $messagesdb
  {                              //using in all messagedao methods
    $messages = null;
    for ($i = 0; $i < count($messagesdb); $i++) {
      $userdao = new UserDao();
      $user = $userdao->read($messagesdb[$i]['user_id']); // create user of current message
      $messages[$i]['username'] = $user->getUserName();
      $messages[$i]['firstname'] = $user->getFirstName();
      $messages[$i]['lastname'] = $user->getLastName();

      if (file_exists($user->getPhoto())) //check if photo exists
        $messages[$i]['photo'] = $user->getPhoto();
      else
        $messages[$i]['photo'] = ""; //if not, set to null

      $messages[$i]['user_id'] = $messagesdb[$i]['user_id']; // setting params to pass to twig
      $messages[$i]['receiver_id'] = $messagesdb[$i]['receiver_id'];
      $messages[$i]['text'] = $messagesdb[$i]['text'];
      $messages[$i]['id'] = $messagesdb[$i]['id'];
      $messages[$i]['created_at'] = $messagesdb[$i]['created_at'];

      if (file_exists($messagesdb[$i]['image'])) //check if post image exists
        $messages[$i]['image'] = $messagesdb[$i]['image'];
      else
        $messages[$i]['image'] = "";

      if ($messages[$i]['user_id'] == $_SESSION['id']) { // check if I am the author
        $messages[$i]['author'] = "me";
      } else {
        $messages[$i]['author'] = "not me";
      }
    }
    return $messages;
  }

  public function readAll(array $searchFields)
  {
    // TODO: Implement readAll() method.
  }

  public function delete($id)
  {
    $this->db->query("DELETE FROM messages WHERE id = $id"); //delete post from database
    $this->db->execute();
  }

  public function getAllMessages($id) // get my messages  to see in dialog window
  {
    $messages = null;
    $messagesdb = $this->db->row("SELECT * FROM messages  WHERE user_id = $id");
    return $this->read($messagesdb);

  }

  public function renderLast() // render last message
  {
    $messagesdb = $this->db->row("SELECT * FROM messages ORDER BY ID DESC LIMIT 1"); // get last message from database
    return $this->read($messagesdb);
  }

  public function getTotalMessages()
  {
    $messages = null;
    $messagesdb = $this->db->row("SELECT * FROM messages");
    return $this->read($messagesdb);
  }

  public function getTotalMessagesByUserName($username)// message from some person
  {
  }

  public function addPicture($photo, $message_id)
  {
    $this->db->query("UPDATE messages SET image = '$photo' WHERE id = $message_id");
    $this->db->execute();
  }
}
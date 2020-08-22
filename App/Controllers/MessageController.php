<?php


namespace Controllers;

use App\Dal\MessageDao;
use App\Entity\Message;
use App\Entity\User;
use App\helpers\Params;
use Core\Controller;

class MessageController extends Controller
{
  private $messageDao;

  public function __construct()
  {
    $this->messageDao = new MessageDao();
  }

  public function createAction()
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'user_id' => $_SESSION['id'],
        'text' => $_POST['text'],
        // 'receiverName' => $_POST['receiverName']
      ];
      $message = new Message();
      $message = $message->fromArray($data);
      $this->messageDao->create($message);

      $messagedao = new MessageDao();
      $messages = $messagedao->renderLast(); //getting last message(just created)
      $params = ['messages' => $messages,
        'server' => "http://" . $_SERVER['HTTP_HOST'] . '/']; //setting parameters to pass to twig
      $this->render('user/blocks/message.twig', $params);
    }
  }
}
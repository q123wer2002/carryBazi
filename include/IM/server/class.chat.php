<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class AdvancedChatServer implements MessageComponentInterface {
  protected $clients;
  private $dbh;
  private $users = array();
  
  public function __construct() {
    global $dbh;
    $this->clients = array();
    $this->dbh = $dbh;
    date_default_timezone_set('Asia/Taipei');
  }
  
  public function onOpen(ConnectionInterface $conn) {
    $this->clients[$conn->resourceId] = $conn;
    $this->checkOnliners($conn);
    $this->finishOpen($conn);
    echo "New connection! ({$conn->resourceId})\n";
  }

  public function onMessage(ConnectionInterface $conn, $data) {
    $id  = $conn->resourceId;
    $data = json_decode($data, true);
    
    if(isset($data['data']) && count($data['data']) != 0){
      $type = $data['type'];
      $user = isset($this->users[$id]) ? $this->users[$id] : false;
      $receiver = ($data['data']['receiver'] != "") ? $data['data']['receiver'] : false;
      
      if($type == "register"){
        $name = htmlspecialchars($data['data']['name']);
        if(array_search($name, $this->users) === false){
          $this->users[$id] = $name;
          $this->send($conn, "register", "success");
          
          $this->fetchMessages($conn, $name);
          $this->checkOnliners($conn);
        }else{
          $this->send($conn, "register", "taken");
        }
      }elseif($type == "send" && isset($data['data']['type']) && $user !== false && $receiver !== false){
        $msg = htmlspecialchars($data['data']['msg']);
        
        /*
         * The base64 value of Audio Or Image
        */
        if(isset($data['data']['base64'])){
          $base64 = $data['data']['base64'];
        }else{
          $base64 = null;
        }
        
        if($data['data']['type'] == "text"){
            /*$sql = $this->dbh->prepare("SELECT `id`, `sender`, `receiver`, `type`, `content`, `postDate` FROM `carrybazi_talk` WHERE `sender`='".$user."' and `receiver`='".$receiver."' ORDER BY `id` DESC LIMIT 1");
            $sql->execute();
            $lastMsg = $sql->fetch(PDO::FETCH_ASSOC);

            if($lastMsg['sender'] == $user && $lastMsg['type'] == "text"){
              // Append message
              $msg = $lastMsg['content'] . "<br/>" . $msg;
              
              $sql = $this->dbh->prepare("UPDATE `carrybazi_talk` SET `content` = ?, `postDate` = NOW() WHERE `id` = ?");
              $sql->execute(array($msg, $lastMsg['id']));
              
              $id = $this->dbh->query("SELECT `id` FROM `carrybazi_talk` ORDER BY `id` DESC LIMIT 1")->fetchColumn();
              $resultAry = array(
                "id" => $id,
                "name" => $user,
                "type" => "text",
                "msg" => $msg,
                "posted" => date("Y-m-d H:i:s"),
                "append" => true
              );
            }else{*/
            $sql = $this->dbh->prepare("INSERT INTO `carrybazi_talk` (`sender`, `receiver`, `type`, `content`, `postDate`) VALUES(?, ?, ?, ?, NOW())");
            $sql->execute(array($user, $receiver, "text", $msg));
            
            $id = $this->dbh->query("SELECT `id` FROM `carrybazi_talk` ORDER BY `id` DESC LIMIT 1")->fetchColumn();
            $resultAry = array(
              "id" => $id,
              "sneder" => $user,
              "receiver" => $receiver,
              "type" => "text",
              "content" => $msg,
              "posted" => date("Y-m-d H:i:s")
            );

          //}
        }elseif($data['data']['type'] == "img"){
          echo "here is Photo";
          $uploaded_file_name = $data['data']['file_name'];
          $sql = $this->dbh->prepare("INSERT INTO `carrybazi_talk` (`sender`, `receiver`, `type`, `content`, `postDate`) VALUES(?, ?, ?, ?, NOW())");
          $sql->execute(array($user, $receiver, "img", $uploaded_file_name));
          
          $id = $this->dbh->query("SELECT `id` FROM `carrybazi_talk` ORDER BY `id` DESC LIMIT 1")->fetchColumn();
          
          $resultAry = array(
            "id" => $id,
            "sneder" => $user,
            "receiver" => $receiver,
            "type" => "img",
            "content" => $uploaded_file_name,
            "posted" => date("Y-m-d H:i:s")
          );
        }
        
        //server only push the last msg to receiver
        foreach($this->users as $eachUserID => $eachUserName){
          if( $eachUserName == $receiver ){
            $receicerCon = $this->clients[$eachUserID];
            $this->send($receicerCon, "single", $resultAry);
            break;
          }
        }
        

      }elseif($type == "onliners"){
        $this->checkOnliners($conn);
      }elseif($type == "fetch"){
        /**
         * Fetch previous messages
         */
        $this->fetchMessages($conn, $data['data']['id']);
      }
    }
  }

  public function onClose(ConnectionInterface $conn) {
    if(isset($this->users[$conn->resourceId])){
      unset($this->users[$conn->resourceId]);
    }
    $this->checkOnliners($conn);
    unset($this->clients[$conn->resourceId]);
  }

  public function onError(ConnectionInterface $conn, \Exception $e) {
    if(isset($this->users[$conn->resourceId])){
      unset($this->users[$conn->resourceId]);
    }
    $conn->close();
    $this->checkOnliners();
  }
  
  /**
   * My custom functions
   */
  public function fetchMessages(ConnectionInterface $conn, $name = ""){
    if($name != ""){
      $sql = $this->dbh->query("SELECT * FROM `carrybazi_talk` WHERE `receiver`='".$name."' ORDER BY `id` ASC");
      $msgs = $sql->fetchAll();
      $msgCount = count($msgs);

      if($msgCount > 5){
        $msgs = array_slice($msgs, $msgCount - 5, $msgCount);
      }
    
      foreach($msgs as $msg){
        $resultAry = array(
          "id" => $msg['id'],
          "sneder" => $msg['sender'],
          "receiver" => $msg['receiver'],
          "type" => $msg['type'],
          "content" => $msg['content'],
          "posted" => $msg['postDate']
        );
        $this->send($conn, "single", $resultAry);
      }
      if($msgCount > 5){
        $this->send($conn, "single", array(
          "type" => "more_messages"
        ));
      }
    }/*else{
      $sql = $this->dbh->prepare("SELECT * FROM `carrybazi_talk` WHERE `id` < :id ORDER BY `id` DESC LIMIT 10");
      $sql->bindParam(":id", $id, PDO::PARAM_INT);
      $sql->execute();
      
      $msgs = $sql->fetchAll();
      foreach($msgs as $msg){
        $resultAry = array(
          "id" => $msg['id'],
          "name" => $msg['user'],
          "type" => $msg['type'],
          "msg" => $msg['msg'],
          "posted" => $msg['posted'],
          "earlier_msg" => true
        );
        $this->send($conn, "single", $resultAry);
      }

      sort($msgs);
      $firstID = $msgs[0]['id'];
      if($firstID != "1"){
        $this->send($conn, "single", array(
          "type" => "more_messages"
        ));
      }
    }*/
  }
  
  public function checkOnliners(ConnectionInterface $conn){    
    /**
     * Send online users to everyone
     */
    $data = $this->users;
    foreach($this->clients as $id => $client) {
      $this->send($client, "onliners", $data);
    }
  }
  
  public function send(ConnectionInterface $client, $type, $data){
    $send = array(
      "type" => $type,
      "data" => $data
    );
    $send = json_encode($send, true);
    $client->send($send);
  }

  public function finishOpen(ConnectionInterface $conn){    
    /**
     * Send finish Event to current user
     */
    $this->send($conn, "finishOpen", "doRegistering");
  }

}

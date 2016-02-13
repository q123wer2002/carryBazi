<!DOCTYPE html>
<html>
  <head>
    <script src="http://lab.subinsb.com/projects/jquery/core/jquery-2.1.1.js"></script>
    <script src="http://lab.subinsb.com/projects/jquery/voice/recorder.js"></script>
    <script src="http://lab.subinsb.com/projects/jquery/voice/jquery.voice.min.js"></script>
    
    <script src="cdn/ws.js"></script>
    <script src="cdn/time.js"></script>
    <script src="cdn/chat.js"></script>
    <link href="cdn/chat.css" rel="stylesheet"/>
    <title>Subin's Blog - subinsb.com</title>
  </head>
  <body>
    <div id="content">
      <center><h1>Advanced Live Group Chat</h1></center>
      <div class="chatWindow">
        <div style="display: none;postion: absolute;">
          <input type="file" id="photoFile" accept="image/*" />
          <audio src="cdn/message.wav" controls="false" id="notification"></audio>
        </div>
        <div class="users"></div>
        <div class="chatbox">
          <div class="topbar">
            <span id="status" title="Click to Login/Logout">Offline</span>
            <span id="fullscreen" title="Toggle Fullscreen of Chat Box">Fullscreen</span>
          </div>
          <div class="chat">
            <div class="msgs"></div>
            <form id="msgForm">
              <textarea name="msg" placeholder="Type message here...."></textarea>
              <a class="button" id="voice" title="Click to start recording message"></a>
              <a class="button" id="photo" title="Type in a message and choose image to send"></a>
            </form>
          </div>
          <div class="login">
            <p>Type in your name to start chatting !</p>
            <form id="loginForm">
              <input type="text" value="" />
              <button>Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- http://subinsb.com/php-websocket-advanced-chat -->
  </body>
</html>

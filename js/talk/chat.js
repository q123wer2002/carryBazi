function log(m){
  console.log(m);
}
String.prototype.linkify = function() {

  // http://, https://, ftp://
  var urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;

  // www. sans http:// or https://
  var pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

  // Email addresses
  var emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;

  return this
    .replace(urlPattern, '<a target="_blank" href="$&">$&</a>')
    .replace(pseudoUrlPattern, '$1<a target="_blank" href="http://$2">$2</a>')
    .replace(emailAddressPattern, '<a target="_blank" href="mailto:$&">$&</a>');
};

window.prevKeyCode, window.checkConnection = "";

window.scrollToBottom = function(){
  scrollHeight = $(".chatWindow .msgs")[0].scrollHeight || 0;
  $(".chatWindow .msgs").animate({
    scrollTop : scrollHeight
  }, 0);
  Fr.timeago();
};

window.connect = function(){
  // ws-subins.rhcloud.com:8000/?service=advanced-chat
  window.ws = $.websocket("ws://127.0.0.1:8000/", {
    open: function() {
      clearInterval(checkConnection);
      $(".chatWindow #status").text("Online");
    },
    close: function() {
      if($(".chatWindow #status").text() == "Online"){
        $(".chatWindow #status").click();
        window.checkConnection = setInterval(function(){
          connect();
        }, 20000);
      }
      $(".chatWindow #status").text("Offline");
    },
    events: {
      fetch: function(e) {
        
      },
      onliners: function(e){
        $(".chatDiv .UserList").html('');
        $.each(e.data, function(userResourceID, userName){
          $(".chatDiv .UserList").append("<a href='?receiver=" + userName + "' title='go chatting'><li>"+ userName +"</li></a>");
          //console.log(userResourceID);
        });
      },
      single: function(e){
        elem = e.data;
        attachmentURL = typeof elem.content != "undefined" ? window.location.protocol + "//" + window.location.host + "/github/carryBazi_photo/images/talk/uploads/" + elem.content : "";
        console.log(e);
        if(elem.type == "text"){
          html = "<div class='msg' id='"+ elem.id +"'><div class='name'>"+ elem.receiver +"</div><div class='msgc'><div>"+ elem.content +"</div><div class='posted'><span class='timeago'>"+ elem.posted +"</span> by "+ elem.sneder +"</div></div></div>";
          
          if(typeof elem.append != "undefined"){
            $(".msgs .msg:last").remove();
          }
          
          if(typeof elem.earlier_msg == "undefined"){
            $(".chatWindow .chat .msgs").append(html);
            scrollToBottom();
          }else{
            $(".chatWindow .chat .msgs #load_earlier_messages").remove();
            $(".chatWindow .chat .msgs .msg:first").before(html);
          }
        }else if(elem.type == "img"){
          console.log(attachmentURL);
          html = "<div class='msg' id='"+ elem.id +"'><div class='name'>"+ elem.receiver +"</div><div class='msgc'><div>"+ elem.content +"</div><div class='extra'><a target='_blank' href='"+ attachmentURL +"'><img src='"+ attachmentURL +"' /></a></div><div class='posted'><span class='timeago'>"+ elem.posted +"</span> by "+ elem.sneder +"</div></div></div>";
          
          $(".chatWindow .chat .msgs").append(html);
          scrollToBottom();
        }else if(elem.type == "more_messages"){
          $(".chatWindow .chat .msgs .msg:first").before("<a id='load_earlier_messages'>Load Earlier Messages...</a>");
        }
        Fr.timeago();
      },
      register: function(e){
        if(e.data == "taken"){
          window.user = "";
          alert("Name already in use. Try another name");
        }else{
          $(".chatWindow .login").fadeOut(1000, function(){
            $(".chatWindow .chat").fadeIn(1000, function(){
              scrollToBottom();
              $(".chatWindow .chat #msgForm input[type=text]").focus();
            });
          });
        }
      },
      finishOpen : function(e){
        if(e.data == "doRegistering"){
          var myName = $(".enterChatRoom #myName").val();
          if( myName != "" ){
            $(".enterChatRoom").css('display','none');
            $(".chatDiv").css('display','block');
            
            var receiver = $(".chatWindow #receiver").val();
            ws.send("register", {"name": myName, "receiver": receiver});
          }
        }
      }
    }
  });
};

$(document).ready(function(){
  //websocket connect
  connect();

  $(".enterChatRoom #btnEnter").on("click", function(){
    var myName = $(".enterChatRoom #myName").val();
    if( myName != "" ){
      //layout show or hide
      $(".enterChatRoom").css('display','none');
      $(".chatDiv").css('display','block');
      var loginObj = {"action" : "login", "myName": myName};
      //login chatroom
      $.ajax({
        url: "server/talkUpload.php",
        type: "POST",
        data: $.param(loginObj),
        success: function(result) {
          console.log(result);
          if(result != ""){
            var receiver = $(".chatWindow #receiver").val();
            ws.send("register", {"name": myName, "receiver": receiver});
          }
        }
      });
      
    }
  });
  
  $(document).on("click", "#load_earlier_messages", function(){
    ws.send("fetch", {"id" : $(".msgs .msg:first").attr("id")});
  });
  
  $(".chatWindow .topbar #fullscreen").on("click", function(){
    if($(".chatWindow").hasClass("fullscreen")){
      $("#content").css("min-width", 600);
      $(".chatWindow").removeClass("fullscreen");
    }else{
      $("#content").css("min-width", 0);
      $(".chatWindow").addClass("fullscreen");
    }
  });
  
  $(".chatWindow .chat #msgForm textarea").on("keydown", function(e){
    if(e.keyCode == 13 && prevKeyCode != 16){
      e.preventDefault();
      $(".chatWindow .chat #msgForm").submit();
    }
    prevKeyCode = e.keyCode;
  });
  
  $(".chatWindow .chat #msgForm").on("submit", function(e){
    e.preventDefault();
    var form = $(this);
    var val   = $(this).find("textarea").val();
    //receiver name
    var receiver = $(".chatWindow #receiver").val();
    
    if(val != ""){
      ws.send("send", {"type" : "text", "receiver": receiver, "msg": val});
      form[0].reset();
    }
  });

  /*$(".chatWindow .login #loginForm").on("submit", function(e){
    e.preventDefault();
    var val  = $(this).find("input[type=text]").val();
    
    if(val != ""){
      window.user = val;
      ws.send("register", {"name": val});
    }else{
      alert("Come on, type in a name");
    }
  });*/
  
  $(".chatWindow #status").on("click", function(){
    if($(this).text() == "Offline"){
      connect();
    }else{
      ws.close();
      $(".chatWindow .chat").fadeOut(1000, function(){
        $(".chatWindow .login").fadeIn(1000, function(){
          $(".chatWindow .msgs, .chatWindow .users").html('');
          $(".chatWindow .login #loginForm input[type=text]").focus();
        });
      });
    }
  });
  
  $(".chatWindow #photo").on("click", function(){
    $(".chatWindow #photoFile").click();
  });
  
  $(".chatWindow #photoFile").change(function(){
    if(typeof $(".chatWindow #photoFile")[0].files[0] != "undefined"){
      file = $(".chatWindow #photoFile")[0].files[0];
      
      fd = new FormData();
      fd.append('file', file);
      
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();

          xhr.upload.addEventListener("progress", function(evt) {
            if(evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              console.log(percentComplete);
              $("#msgForm").css({background : "linear-gradient(90deg, #009bcd "+ percentComplete +"%, white 0%)"});
            }
          }, false);
          return xhr;
        },
        url: "server/talkUpload.php",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function(result) {
          $("#msgForm").css({background : ""});
          val  = $("#msgForm").find("textarea").val();
          var receiver = $(".chatWindow #receiver").val();
          if(result != ""){
            ws.send("send", {"type" : "img","receiver" : receiver, "msg" : val, "file_name" : result});
            $("#msgForm").find("textarea").val('');
          }
          console.log(result);
        }
      });
    }
  });
  
});

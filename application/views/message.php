<div class="chat_window">
  <div class="top_menu">
      <div class="title">Chatting with <?= $chatUname ?></div>
  </div>
  <ul class="messages" id="messages">
  </ul>
  <div class="bottom_wrapper clearfix">
      <div class="message_input_wrapper">
          <input class="message_input" id="messageInput" placeholder="Type your message here..." />
      </div>
      <div class="send_message">
          <div class="icon"></div>
          <div class="text" id="sendButton" onclick="sendMessage()">Send</div>
      </div>
  </div>
</div>

<script>

var activeFriend = "<?= $chatUname ?>";
var input = document.getElementById("messageInput");
var lastReceived = 0;
var oldReceived = 0;

input.addEventListener("keyup", function(event){

	event.preventDefault();
	if(event.keyCode === 13){
		$('#sendButton').click();
	}
});

function getAllMessages(){
   var url = "<?= base_url() ?>index.php?/Message/GetAllMessages";
   $.ajax({
     type:'POST',
     data:{
     friend: activeFriend},
     url:url,
     success: function(result){
       $("#messages").html(result);
       $("#messages").scrollTop($("#messages")[0].scrollHeight);
     }
   });
}
getAllMessages();
getLastReceived(false);
function getLastReceived(input){
  var url = "<?= base_url() ?>index.php?/Message/GetLastReceived";
  $.ajax({
    type:'POST',
    data:{
    friend: activeFriend},
    url:url,
    success: function(result){
      if(input){
        if(lastReceived < result){
          updateMessages(lastReceived);
          lastReceived = result;
        }
      }else{
        lastReceived = result;
      }
    }
  });
}

function sendMessage(){
 var msg = $("#messageInput").val();
 $("#messageInput").val("");

 var url = "<?= base_url() ?>index.php?/Message/SendMessage";
 $.ajax({
   type:'POST',
   data:{msg: msg,
   friend: activeFriend},
   url:url,
   success: function(result){
     $("#messages").append(result);
     $("#messages").scrollTop($("#messages")[0].scrollHeight);
   }
 });

}

function updateMessages(count){
  var url = "<?= base_url() ?>index.php?/Message/GetNewMessages";
  $.ajax({
    type:'POST',
    data:{lastReceived: count,
    friend: activeFriend},
    url:url,
    success: function(result){
      $("#messages").append(result);
      $("#messages").scrollTop($("#messages")[0].scrollHeight);
    }
  });
}

setInterval(function(){
  getLastReceived(true);
}, 2000);

setTimeout(function(){
  $("#messages").scrollTop($("#messages")[0].scrollHeight);
}, 500);
</script>
<style>
.date{
  float:right;
}
</style>
<link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/messages.css">

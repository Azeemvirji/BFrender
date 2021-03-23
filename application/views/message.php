<div class="chat_window">
  <div class="top_menu">
      <div class="buttons">
          <div class="button close"></div>
          <div class="button minimize"></div>
          <div class="button maximize"></div>
      </div>
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
     $("#messages").append("<li class=\"message right appeared\"><div class=\"text_wrapper\"><div class=\"text\">" + result + "</div></div></li>");
     $("#messages").scrollTop($("#messages")[0].scrollHeight);
   }
 });

}
setTimeout(function(){
  $("#messages").scrollTop($("#messages")[0].scrollHeight);
}, 500);
</script>
<link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/messages.css">

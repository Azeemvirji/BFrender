<div class="col-md-3 chat_sidebar" style="float:left">
  <div class="row">
    <div class="dropdown all_conversation">
               <button style="width:155px"><h5>Conversations</h5></button>
            </div>
            <br/>
            <? foreach($friends as $friend){ ?>
              <span class="chat-img pull-left">
                     <img src="<?= assetUrl(); ?>img/users/<?= $friend['imageLocation'] ?>" alt="User Avatar" class="img-circle">
                     </span>
                     <div class="chat-body clearfix">
                        <div class="header_sec">
                           <a href="" id="<?= $friend['username'] ?>" onclick="return changeFriend(this.id)">&nbsp;&nbsp;<?= $friend['username'] ?></a>
                        </div>
                      </div>
            <? } ?>
  </div>
  </div>

<div class="row">
<div class="chat_window">
  <div class="top_menu">
      <? if($chatUname != ""){ ?>
        <div class="title" id="title">Chatting with <?= $chatUname ?></div>
      <? }else{ ?>
        <div class="title" id="title"></div>
      <? } ?>
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

function changeFriend(friend){
  activeFriend = friend;
  $("#title").html("Chatting with " + friend);
  getAllMessages();

  return false;
}

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

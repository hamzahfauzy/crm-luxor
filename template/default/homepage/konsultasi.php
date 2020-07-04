<?php 
$this->title .= ' | Beranda';
$this->visited = "beranda";
?>

<style type="text/css">
.chat-bg {
  /*I ripped this image from the WhatsApp apk*/
  /*This is WhatsApp's official BK color*/
  background: #ECE5DD;
  font-family: "Helvetica Neue", Helvetica;
}

.container {
  width: 75%;
  margin: 0 auto;
}

.msg {
  width: 100%;
  height: auto;
  display: block;
  overflow: hidden;
}
.msg .bubble {
  float: left;
  max-width: 75%;
  width: auto;
  height: auto;
  display: block;
  background: #ebebeb;
  border-radius: 5px;
  position: relative;
  margin: 10px 0 3px 25px;
  box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.2);
}
.msg .bubble.alt {
  margin: 10px 25px 3px 0px;
  background: #DCF8C6;
  float: right;
}
.msg .bubble.follow {
  margin: 2px 0 3px 25px;
}
.msg .bubble.altfollow {
  margin: 2px 25px 3px 0px;
  background: #DCF8C6;
  float: right;
}
.msg .bubble .txt {
  padding: 8px 0 8px 0;
  width: 100%;
}
.msg .bubble .txt .name {
  font-weight: 600;
  font-size: 14px;
  display: inline-table;
  padding: 0 0 0 15px;
  margin: 0 0 4px 0;
  color: #3498db;
}
.msg .bubble .txt .name span {
  font-weight: normal;
  color: #b3b3b3;
  overflow: hidden;
}
.msg .bubble .txt .name.alt {
  color: #2ecc51;
}
.msg .bubble .txt .message {
  font-size: 14px;
  font-weight: 500;
  padding: 0 15px 0 15px;
  /*margin: auto;*/
  color: #2b2b2b;
  display: table;
}
.msg .bubble .txt .timestamp {
  font-size: 11px;
  margin: auto;
  padding: 0 15px 0 15px;
  display: table;
  position: relative;
  text-transform: uppercase;
  color: #999;
}
.msg .bubble .bubble-arrow {
  position: absolute;
  float: left;
  left: -11px;
  top: 0px;
}
.msg .bubble .bubble-arrow.alt {
  bottom: 20px;
  left: auto;
  right: 4px;
  float: right;
}
.msg .bubble .bubble-arrow:after {
  content: "";
  position: absolute;
  border-top: 15px solid #ebebeb;
  border-left: 15px solid transparent;
  border-radius: 4px 0 0 0px;
  width: 0;
  height: 0;
}
.msg .bubble .bubble-arrow.alt:after {
  border-top: 15px solid #DCF8C6;
  transform: scaleX(-1);
}

@media only screen and (max-width: 450px) {
  .container {
    width: 100%;
  }

  .timestamp {
    display: none;
    color: red;
  }
}

</style>
<div class="produk-container row">
	<div class="col-sm-12 col-md-6 mx-auto">
		<h2>Konsultasi</h2>

		<div class="chat-bg" style="height: 500px;overflow: auto;">
			<div class="container chat" style="width: 100%;height: 100%;">
				<?php 
				/*
				<!-- With Name and Arrow - LEFT -->
				<div class="msg">
				  <div class="bubble">
				    <div class="txt">
				      <span class="name">Mike</span>
				      <span class="timestamp">10:20 pm</span>      
				      <span class="message">
				        Can you believe this amazing chat bubbles? It's all CSS. 
				      </span> 
				      
				    </div>
				    <div class="bubble-arrow"></div>
				  </div>
				</div>  

				<!-- Without Name nor Arrow - LEFT -->
				<div class="msg">
				  <div class="bubble follow">
				    <div class="txt">
				      <span class="timestamp">10:21 pm</span>
				      <span class="message follow">Think of the possibilities. &#x1f60d; </span>      
				    </div>
				  </div>
				</div>

				<!-- With Name and Arrow - RIGHT -->
				<div class="msg">
				  <div class="bubble alt">
				    <div class="txt">
				      <span class="name alt">My Name
				      </span>
				      <span class="timestamp">10:22 pm</span>
				      <p class="message">It's nuts, dude. Nuts</p>
				    </div>
				    <div class="bubble-arrow alt"></div>
				  </div>
				</div>

				<!-- With Number and Name and Arrow - LEFT -->
				<div class="msg">
				  <div class="bubble">
				    <div class="txt">
				      <span class="name">+353 87 1234 567<span> ~ John</span></span>
				      <span class="timestamp">10:20 pm</span>
				      <p class="message">Hey, check out this Pure CSS speech bubble...</p>
				    </div>
				    <div class="bubble-arrow"></div>
				  </div>
				</div>  

				<!-- Without Name, With Arrow - RIGHT -->
				<div class="msg">
				  <div class="bubble altfollow">
				    <div class="txt">
				      <span class="timestamp">10:22 pm</span>
				      <p class="message follow">Nice... this will work great for my new project.</p>
				    </div>
				    <div class="bubble-arrow alt"></div>
				  </div>
				</div>

				<!-- Without Name nor Arrow - RIGHT -->
				<div class="msg">
				  <div class="bubble altfollow">
				    <div class="txt">
				      <span class="timestamp">10:21 pm</span>
				      <p class="message follow">
				        Thanks Benni! You the real mvp
				      </p>      
				    </div>
				  </div>
				</div>
				*/
				?>
				  
			</div>
		</div>
		<div class="text-container" style="position: relative;">
			<form method="post" onsubmit="return false;">
			<input type="text" name="konten" class="form-control" placeholder="Konsultasi masalah anda disini...">
			<div style="position: absolute;right:0;top:0">
				<button class="btn btn-success" onclick="sendChat()"><i class="fa fa-send"></i></button>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">

var interval = setInterval(async () => {
	var get  = await fetch('<?=base_url()?>/home/loadChat')
	var data = await get.json();
	var contens = data.items
	var chat = document.querySelector('.chat')
	chat.innerHTML = ""
	contens.forEach(val => {
		var tipe = val.tipe == 1 ? 'alt' : ''
		var from = val.tipe == 1 ? 'Anda' : 'Admin'
		chat.innerHTML += `
				<div class="msg">
				  <div class="bubble ${tipe}">
				    <div class="txt">
				      <span class="timestamp">${val.tanggal}</span>      
				      <span class="name">${from}</span>
				      <span class="message">
				        ${val.konten}
				      </span> 
				      
				    </div>
				    <div class="bubble-arrow ${tipe}"></div>
				  </div>
				</div>  
		`
	})
	var objDiv = document.querySelector(".chat-bg");
	objDiv.scrollTop = objDiv.scrollHeight;
},2500)

async function sendChat()
{
	var konten = document.querySelector("input[name=konten]").value
	var formData = new FormData;
	formData.append('konten',konten)
	var send   = await fetch('<?=base_url()?>/home/sendChat',{
		method:'POST',
		header:{
			'content-type':'application/x-www-form-urlencoded'
		},
		body:formData
	})
	document.querySelector("input[name=konten]").value = ""
}
</script>
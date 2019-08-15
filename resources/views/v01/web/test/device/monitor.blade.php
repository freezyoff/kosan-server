<html>
<head>
	<style>
		.scr { width:100%; min-height:200px; }
		.shell-send { border-color:red; }
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
</head>
<body>
	<form id="fm-monitor" name="fm-monitor" action="{{url('test/device/monitor')}}" method="POST">
		@csrf
		<label>Device MAC</label>
		<input id="device-mac" name="device-mac" type="text" />
	</form>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="49%">
				<div>Device State: <span id="last-update"></span></div>
				<textarea id="device-state" class="scr"></textarea>
				<div align="right">
					<button onclick="$('#device-state').val('')">Bersihkan Layar</button>
				</div>
			</td>
			<td width="1%"></td>
			<td width="50%">
				<form id="fm-command" action="{{url('test/device/shell')}}" style="margin:0;">
					@csrf
					<div class="margin-left-8">Send Command:</div>
					<input id="shell-device-mac" name="device-mac" type="hidden" />
					<textarea id="shell-shell" name="shell" class="scr"></textarea>
					<div align="right">
						<button type="submit">Kirim Perintah</button>
					</div>
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<div>Device Config:</div>
				<textarea id="device-config" class="scr"></textarea>
				<div align="right">
					<button onclick="$('#device-state').val('')">Bersihkan Layar</button>
				</div>
			</td>
			<td width="1%"></td>
			<td>
				<div>
					<button onclick="sendButtonCommand(12,0)" style="padding:1rem">Ch1 ON</button>
					<button onclick="sendButtonCommand(12,1)" style="padding:1rem">Ch1 OFF</button>
				</div>
				<div>
					<button onclick="sendButtonCommand(13,0)" style="padding:1rem">Ch2 ON</button>
					<button onclick="sendButtonCommand(13,1)" style="padding:1rem">Ch2 OFF</button>
				</div>
				<div>
					<button onclick="sendButtonCommand(15,0)" style="padding:1rem">Ch3 ON</button>
					<button onclick="sendButtonCommand(15,1)" style="padding:1rem">Ch3 OFF</button>
				</div>
				<div>
					<button onclick="sendButtonCommand(1,0)" style="padding:1rem">Ch4 ON</button>
					<button onclick="sendButtonCommand(1,1)" style="padding:1rem">Ch4 OFF</button>
				</div>
			</td>
		</tr>
	</table>
</body>
<script>
//button command
var sendButtonCommand = function(chanel, signal){
	var url = "{{url('test/device/button')}}" +"/"+ $("#device-mac").val() +"/"+ chanel +"/"+ signal;
	$.ajax({
	  url: url
	  //success: function(){}
	});
}

$(document).ready(function(){
	$("#fm-monitor").submit(function(event){
		event.preventDefault();
		
		var form = $(this);

		$.ajax({
			   type: "POST",
			   url: form.attr("action"),
			   data: form.serialize(), 
			   success: function(data){
				   $("#device-state").val(data.state);
				   $("#device-config").val(data.config);
				   $("#last-update").html(data.lastUpdate);
			   }
		 });
	});
	
	$("#fm-command").submit(function(event){
		event.preventDefault();
		var form = $(this);
		$("#shell-device-mac").val($("#device-mac").val());
		
		$.ajax({
			   type: "POST",
			   url: form.attr("action"),
			   data: form.serialize(), 
			   beforeSend: function() {
					$("#shell-shell").addClass("shell-send");
				},
			   success: function(data){
				   if (data.code != 200){
					   alert(data.message);
				   }
				   $("#shell-shell").removeClass("shell-send");
			   }
		 });
	});
	
	setInterval(function(){
		$("#fm-monitor").trigger("submit");
	},3000);
	
});
</script>
</html>
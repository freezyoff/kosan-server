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
				<div>Device State:</div>
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
	</table>
</body>
<script>
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
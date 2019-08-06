<html>
<head>
	<style>
		.spacing 	{ margin: 12px 0 12px 0; }
		label.width { min-width: 150px; display:inline-block;}
	</style>
</head>
<body>
	<form action="{{url()->full()}}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="spacing">
			<label class="width">Chipset</label>
			<select name="chipset_id">
				@foreach($chipsets as $chip)
				<option value="{{$chip->id}}">{{$chip->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="spacing">
			<label class="width">Version</label>
			<input name="version" type="text" value="" />
		</div>
		<div class="spacing">
			<label class="width">Firmware Binary File</label>
			<input name="firmware_bin" type="file"/>
		</div>
		<div class="spacing">
			<label class="width">Storage Binary File</label>
			<input name="spiffs_bin" type="file"/>
		</div>
		<div class="spacing">
			<label class="width"></label>
			<button type="submit" name="submit">Simpan</button>
		</div>
	</form>
</body>
</html>
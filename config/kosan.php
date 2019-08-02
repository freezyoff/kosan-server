<?php 
return [
	"api_version"=>"v01",
	"api_path"=>[
		"v01"=>base_path("routes/api/v01.php")
	],
	
	"device"=>[
		"api_token_lifetime"=>60*5
	],
	
	"device_io_enum"=>[
		"mode"=>[
			"NOT_SET"=>-1,
			"INPUT"=>0,
			"OUTPUT"=>1,
			"INPUT_PULLUP"=>2
		],
		"type"=>[
			"SENSOR"=>0,
			"RELAY"=>1,
		],
		"signal"=>[
			"LOW"=>0,
			"HIGH"=>1,
		],
	],
];
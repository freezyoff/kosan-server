<?php return[

	'sudoer_password_file'=> "/home/apache/kosan-server-http/artisan-sudoer",
	'mqtt_password_file'=> '/home/admin/mosquitto/passwd',
	
	'genders'=>[
		"m"=>"laki - laki",
		"f"=>"perempuan",
	],
	
	'sidebar'=>[
		'owner'=>[
			'left'=>[
				["label"=>"dashboard", 'icon'=>'dashboard', "href"=> app()->runningInConsole()? "" : url("")],
				["label"=>"Perangkat Kosan", 'icon'=>'usb', "href"=> app()->runningInConsole()? "" : url("devices")],
				["label"=>"Kamar Kost", 'icon'=>'usb', "href"=> app()->runningInConsole()? "" : url("rooms")],
			]
		]
	]
	
];
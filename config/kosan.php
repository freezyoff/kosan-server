<?php return[

	'sudoer_password_file'=> "/home/apache/kosan-server-http/artisan-sudoer",
	'mqtt_password_file'=> '/etc/mosquitto/passwd',
	
	'genders'=>[
		"m"=>"laki - laki",
		"f"=>"perempuan",
	],
	
	'sidebar'=>[
		'owner'=>[
			'left'=>[
				["label"=>"dashboard", 'icon'=>'dashboard', "href"=> app()->runningInConsole()? "" : url("")],
				["label"=>"profil", 'icon'=>'portrait', "href"=> app()->runningInConsole()? "" : "route:web.owner.profile"],
				["label"=>"Perangkat Kosan", 'icon'=>'router', "href"=> app()->runningInConsole()? "" : url("devices")],
				["label"=>"Kamar Kost", 'icon'=>'room', "href"=> app()->runningInConsole()? "" : url("rooms")],
				["label"=>"Hak Akses", 'icon'=>'login', "href"=> app()->runningInConsole()? "" : "route:web.owner.rooms.access"],
				//["label"=>"Sewa", 'icon'=>'receipt', "href"=> app()->runningInConsole()? "" : url("lease")],
				["label"=>"Keluar", 'icon'=>'power_settings_new', "href"=> app()->runningInConsole()? "" : 'route:web.service.auth.logout'],
			]
		],
		'user'=>[
			'left'=>[
				["label"=>"dashboard", 'icon'=>'dashboard', "href"=> app()->runningInConsole()? "" : "route:web.my.dashboard"],
				["label"=>"Keluar", 'icon'=>'power_settings_new', "href"=> app()->runningInConsole()? "" : 'route:web.service.auth.logout'],
			]
		]
	],
	
	'invoice'=>[
		'grace_periode'=>60*60*24*7,	//30 days,
		''
	]
	
];
<?php
return [
    //'adminEmail' => 'admin@example.com',
    //'supportEmail' => 'support@example.com',
    //'user.passwordResetTokenExpire' => 3600,
	'public' => [
		'langs' => [ 'en', 'pl'  ], //the first value will be default lang
	],
	'priv' => [
		'auth' => ["username" => "demo",  "password" => "test123" ],//z bazy danych jest demo/demo - tak bylo wczesniej
	]
];

<?php

return [
	'database' => [
		'name' => 'horsesimdb',
		'username' => 'root',
		'password' => '082Aug86',
		'connection' => 'mysql:host=127.0.0.1',
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	],
	'raceSettings' => [
		'baseSpeed'=>5,
		'trackLength'=>1500,
		'enduranceMetres'=>100,
		'strengthPercentage'=>8,
		'maximumRaces'=>3,
		'maximumHorses'=>8,
	]
];

?>
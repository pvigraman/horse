<?php
require 'app/Horse.php';
require 'app/Race.php';
$raceObj=new Race($query);
$completedRaces=$raceObj->getCompletedRaces();
$activeRaces=$raceObj->getActiveRaces();
$activeRacesCount=count($raceObj->getActiveRaces());
$bestRaceHorse=$raceObj->getBestRaceHorse();

//$raceObj->newRace($pdo);


require 'app/views/index.view.php';
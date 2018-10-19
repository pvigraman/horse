<?php
require 'app/Horse.php';
require 'app/Race.php';
$raceObj=new Race($query);

$req=trim($_SERVER['REQUEST_URI'],"/");

$id=explode("/", $req);
 

if(isset($id[1]) && is_numeric($id[1]))
$race=$id[1];
else
$race=$raceObj->newRace();

if(isset($_REQUEST['status']) && $_REQUEST['status']=="progress")
$raceObj->progress($race);

// echo "Race No.:".$race;
$raceHorses=$raceObj->getRaceHorses($race);

require 'app/views/race/index.view.php';
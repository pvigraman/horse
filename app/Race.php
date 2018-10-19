<?php
/**
 * Class for Race
 */
class Race extends Horse
{
	protected $query;
	
	function __construct($query)
	{
		$this->query=$query;
	}

	public function newRace()
	{
		$parameters=array('status'=>'Active','startedtime'=>date('Y-m-d H:i:s'));
		try{
			$this->query->insert('races',$parameters);	
			$raceId = $this->query->lastInsertId();
			
			//generate horses
			$horse=new Horse($this->query);
			$horse->generateHorses($raceId);
			header("Location: /race/".$raceId);
			//return $raceId;

		}
		catch(PDOException $e)
		{
			echo $insertRaceSQL . "<br>" . $e->getMessage();
		}
	}

	public function getRaces($pdo,$numberOfRaces=5)
	{
		//Get Last 5 Races
		$getRaceStatement=$pdo->prepare("SELECT * FROM races ORDER BY id DESC LIMIT $numberOfRaces");
		$getRaceStatement->execute();
		$races=$getRaceStatement->fetchAll(PDO::FETCH_OBJ);
		return $races;
	}

	public function getCompletedRaces($numberOfRaces=5)
	{
		$races=$this->query->sql('SELECT * FROM races r WHERE r.status="Completed" ORDER BY r.id DESC LIMIT 5');
		$horsesArr=array();
		foreach ($races as $race) {
			$horses=$this->query->sql('SELECT * FROM horses h WHERE h.race_id='.$race->id.' ORDER BY h.`currenttime` ASC LIMIT 3');
			foreach ($horses as $horse) {
				$horsesArr[$race->id][]=$horse->horse_no."#".$horse->currenttime;
			}
		}
		return $horsesArr;
	}

	public function getActiveRaces()
	{
		$races=$this->query->sql('SELECT * FROM races r WHERE r.status="Active" ORDER BY r.id DESC');
		$horsesArr=array();
		foreach ($races as $race) {
			$horses=$this->query->sql('SELECT * FROM horses h WHERE h.race_id='.$race->id.' ORDER BY h.`distance_covered` DESC');
			foreach ($horses as $horse) {
				$horsesArr[$race->id][]=$horse->horse_no."#".$horse->currenttime."#".$horse->distance_covered;
			}
		}
		return $horsesArr;
	}

	public function getBestRaceHorse()
	{
		$horse=$this->query->sql('SELECT * FROM `horses` ORDER BY `horses`.`currenttime`  ASC LIMIT 1');
		return $horse;
	}

	public function getRaceHorses($raceid)
	{
		$raceHorses=$this->query->sql("SELECT * FROM horses WHERE race_id=$raceid  ORDER BY distance_covered DESC, currenttime ASC");
		return $raceHorses;
	}

	public function progress($raceid)
	{
		$raceHorses = $this->query->sql("SELECT r.id as raceid,h.id as horseid,h.speed,h.strength,h.endurance,h.distance_covered,h.position,h.currenttime,r.status as race_status,h.status as horse_status,h.horse_no FROM races r 
			LEFT JOIN horses h ON h.race_id=r.id
			WHERE r.status='Active' AND r.id='".$raceid."'");
		
		$horseStillRunning=0;
		foreach($raceHorses as $raceHorse)
		{
			$horseid=$raceHorse->horseid;
			$speed=$raceHorse->speed;
			$strength=$raceHorse->strength;
			$endurance=$raceHorse->endurance;
			$distance_covered=$raceHorse->distance_covered;
			$position=$raceHorse->position;
			$currenttime=$raceHorse->currenttime;
			$race_status=$raceHorse->race_status;
			$horse_status=$raceHorse->horse_status;

			if($race_status=='Active')
			{
				//Do the calculation
				if($distance_covered<1500)
				{
					$horseStillRunning+=1;
					$baseSpeed=5;
					$horseSpeed=$baseSpeed+$speed;
					$enduranceDistance=$endurance*100;
					$advancingDistance=($horseSpeed*10);
					$strengthDistance=$strength*(8/100);
					if($distance_covered>$enduranceDistance)
					{
						//echo $row['horse_no']." - ".$strengthDistance."<br>";
						$advancingDistance=$advancingDistance-(5*10)+$strengthDistance;

						//echo $row['horse_no']." Reached endurance<br>";
					}

					$distance_covered=$distance_covered+$advancingDistance;
					if($distance_covered>1500)
					{
						$distance_covered=1500;
						$horse_status='Completed';
					}	


					$currenttime = new DateTime($currenttime);
					$currenttime->modify('+10 seconds');
					//echo $currenttime->format("H:i:s");
					
					$this->query->sql("UPDATE horses SET distance_covered='".$distance_covered."',currenttime='".$currenttime->format("H:i:s")."',status='".$horse_status."' WHERE id='".$horseid."'");

					$this->query->sql("INSERT INTO `progress`(`id`, `raceid`, `horseid`, `distance_covered`, `currenttime`,`advancing_distance`,`strength_distance`) VALUES (null,'".$raceid."','".$horseid."','".$distance_covered."','".$currenttime->format("H:i:s")."','".$advancingDistance."','".$strengthDistance."')");
					
				}
			}
		}

		if($horseStillRunning==0)
		{
			$this->query->sql("UPDATE races SET status='Completed',completedtime='".date("Y-m-d H:i:s")."' WHERE id='".$raceid."'");
			header("Location: /race/".$raceid."/?status=completed");
		}
		else
		header("Location: /race/".$raceid);

	}
}
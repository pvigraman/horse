<?php
/**
 * Class for Horse
 */
class Horse
{
	//set number of horses here
	protected $numberOfHorse=8;
	protected $query;
	
	function __construct($query)
	{
		$this->query=$query;
	}

	public function generateHorses($raceid)
	{
		# code...
		$horses=array();
		$statsArrSpeed=array();
		$statsArrStrength=array();
		$statsArrEndurance=array();

		for($i=0;$i<8;$i++)
		{
			$statSpeed=$this->randomStat(0, 10, 1,$statsArrSpeed);
			$statStrength=$this->randomStat(0, 10, 1,$statsArrStrength);
			$statEndurance=$this->randomStat(0, 10, 1,$statsArrEndurance);

			$statsArrSpeed[]=$statSpeed;
			$statsArrStrength[]=$statStrength;
			$statsArrEndurance[]=$statEndurance;

			$horses[$i]=array("num"=>$i+1,"speed"=>$statSpeed,"strength"=>$statStrength,"endurance"=>$statEndurance);
		}

		foreach ($horses as $horse) {
			$parameters=array('race_id'=>$raceid,'horse_no'=>$horse['num'],'speed'=>$horse['speed'],'strength'=>$horse['strength'],'endurance'=>$horse['endurance'],'distance_covered'=>'0','position'=>'0','currenttime'=>'00:00:00','status'=>'Active');

			//$insertHorseSQL="INSERT INTO `horses`(`id`, `race_id`, `horse_no`, `speed`, `strength`, `endurance`, `distance_covered`, `position`, `currenttime`,`status`) VALUES (null,'$raceid','".$horse['num']."','".$horse['speed']."','".$horse['strength']."','".$horse['endurance']."','0','0','00:00:00','Active')";

			try{
			$this->query->insert('horses',$parameters);	
			}
			catch(PDOException $e)
			{
				echo $insertHorseSQL . "<br>" . $e->getMessage();
			}
		}
	}

	private function randomStat($min, $max, $decimals = 0,$arr) {
	  $scale = pow(10, $decimals);
	  $val=mt_rand($min * $scale, $max * $scale) / $scale;
	  if(in_array($val, $arr))
		{
			$val=$this->randomStat($min, $max, 1,$arr);
		}
	  return $val;
	}
}
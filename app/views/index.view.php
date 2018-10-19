<?php require 'main/header.php'; ?>


      
      <div class="jumbotron">
        <h1>PHP Horse Simulator</h1>
        <p>Horse race between randomly generated horses. Enjoy your time.</p>
        <p>
	      <?php if($activeRacesCount<3) : ?>
	          <a class="btn btn-lg btn-primary" href="/race" role="button">Create Race</a>
	      <?php else: ?>
	      	  <a class="btn btn-lg btn-primary" role="button" disabled>Create Race</a>
	      <?php endif;?>
        </p>
        <p>Races in Progress <span class="label label-default"><?=$activeRacesCount;?></span></p>
      </div>

<div style="float: left; padding: 5px">
	<h4>Races in Progress</h4>
	<table class="table table-bordered">
		<tr><th>Race No.:</th><th>Position 1</th><th>Position 2</th><th>Position 3</th><th>Position 4</th><th>Position 5</th><th>Position 6</th><th>Position 7</th><th>Position 8</th><th>Action</th></tr>
		<?php foreach($activeRaces as $race=>$raceVal): ?>
			<tr><td>Race No: <?=$race;?></td>
			<?php foreach($raceVal as $ra): ?>
			<td><?php $p=explode("#",$ra); echo "Horse :".$p[0]." - ".$p[1]." - ".round($p[2])."m";?></td>
			<?php endforeach;?>
			<td><a class="btn btn-lg btn-primary" role="button" href="/race/<?=$race?>">View</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>


<div style="float: left; padding: 5px">
	<h4>Last 5 Completed Races</h4>
	<table class="table table-bordered">
		<tr><th>Race No.:</th><th>Position 1</th><th>Position 2</th><th>Position 3</th></tr>
		<?php foreach($completedRaces as $race=>$raceVal): ?>
		<tr><td><?=$race;?></td><td>
			<?php
			$p1=explode("#",$raceVal[0]); echo "Horse :".$p1[0]." - ".$p1[1];?></td>
			<td><?php
			$p2=explode("#",$raceVal[1]); echo "Horse :".$p2[0]." - ".$p2[1];?></td>
			<td><?php
			$p3=explode("#",$raceVal[2]); echo "Horse :".$p3[0]." - ".$p3[1];?></td>
		<?php endforeach; ?>
	</table>
</div>


<div style="float: left; padding: 5px">
	<h4>Hall of Fame - Best Horse Ever Generated</h4>
	<table class="table table-bordered">
		<tr><th>Best Time</th><th>Race No.</th><th>Horse No.</th><th>Speed</th><th>Endurance</th><th>Strength</th></tr>
		<?php foreach($bestRaceHorse as $raceHorse): ?>
		<tr><td><?=$raceHorse->currenttime;?></td><td><?=$raceHorse->race_id;?></td><td><?=$raceHorse->horse_no;?></td><td><?=$raceHorse->speed;?></td><td><?=$raceHorse->endurance;?></td><td><?=$raceHorse->strength;?></td></tr>
		<?php endforeach; ?>
	</table>
</div>

</div> <!-- /container -->
<?php require 'main/footer.php'; ?>
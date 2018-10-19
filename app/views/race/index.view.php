<?php require 'app/views/main/header.php'; ?>
<div class="jumbotron">
	<center><h3>Race No.: <span class="label label-default"><?=$race;?></span></h3>

	<table class="table" style="width: 500px">
		<tr>
			<th>Horse No.</th>
			<th>Distance Covered</th>
			<th>Position</th>
			<th>Current Time</th>
			<th>Status</th>
		</tr>
	
	<?php 
	$pos=0;
	
	foreach($raceHorses as $horse) : $pos+=1;?>
		<tr><td>Horse: <?=$horse->horse_no;?></td><td><?=$horse->distance_covered;?>m</td><td><?=$pos;?></td><td><?=$horse->currenttime;?></td><td><?=$horse->status;?></td></tr>
	<?php endforeach; ?>
	</table></center>
<?php if(isset($_GET['status']) && $_GET['status']=="completed"):?>
<center><a class="btn btn-lg btn-primary" href="/" role="button">Completed</a></center>
<?php else:?>	
<center><a class="btn btn-lg btn-primary" href="/race/<?=$id[1]?>/?status=progress" role="button">Progress</a></center>
<?php endif;?>
</div>
<?php require 'app/views/main/footer.php'; ?>
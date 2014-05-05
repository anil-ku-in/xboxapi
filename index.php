<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Xbox Live</title>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class='container'>

	<h1>Xbox Live Profile</h1>

	<div class="well col-md-4">
		<p>Enter your xbox gamertag</p>
		<form action="" method="post">
			<p>Gamertag: <input type="text" class='form-control' name="gamertag" value=""></p>
			<p><input type="submit" name="submit" value="Go" class="btn btn-success"></p>
		</form>
	</div>

	<?php if(isset($_POST['submit'])){ ?>
	<div class='well col-md-offset-1 col-md-6'>
	<?php
		$gamertag = $_POST['gamertag'];
		require('cache.php'); 
		$cache = new SimpleCache();
		$json = $cache->get_data($gamertag, "https://xboxapi.com/v1/json/profile/$gamertag");
		$obj = json_decode($json);

		if($obj->Success == 1){
			echo 'API Hourly Limit: '.$obj->API_Limit.'<br>';
			echo 'Gamertag: '.$obj->Player->Gamertag.'<br>';
			echo 'Membership: '.$obj->Player->Status->Tier.'<br>';
			
			if($obj->Player->Status->Online == 1){
				echo 'Online<br>';
			} else {
				echo 'Offline<br>';
			}

			echo $obj->Player->Status->Online_Status.'<br>';
			echo "<img src='".$obj->Player->Avatar->Gamertile->Large."' alt=''><br>";
			echo 'Gamerscore: '.$obj->Player->Gamerscore.'<br>';
			echo 'Reputation: '.$obj->Player->Reputation.'<br>';
			echo $obj->Player->Name.'<br>';
			echo $obj->Player->Location.'<br>';

			echo "<p>";
			foreach($obj->RecentGames as $row){
				echo "<img src='".$row->BoxArt->Small."' alt='$row->Name' title='$row->Name'> ";	
			}
			echo "</p>";
		} else {
			echo $obj->Error;
		} 
	?>
	</div>
	<?php } ?>
 
</div>
</body>
</html>		
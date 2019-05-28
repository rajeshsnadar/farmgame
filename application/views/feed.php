<?php
	echo "<pre>";
	//print_r($fed_data);
	print_r($this->session->userdata('round'));
	print_r($this->session->userdata('feed_history'));
	echo "</pre>";

?>
<!DOCTYPE html>
<html>
<head>
	<title>FarmGame</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/css/bootstrap.css')?>">
</head>
<body class="container">
	<div class="">
		&nbsp;

	</div>
	<div class="row">
		<h1>FarmGame</h1>	
		<table class="table table-bordered table">
			<tr>
				<th></th>
				<th>Farmer</th>
				<th>Cow 1</th>
				<th>Cow 2</th>
				<th>Bunny 1</th>
				<th>Bunny 2</th>
				<th>Bunny 3</th>
				<th>Bunny 4</th>
			</tr>
			<tbody>
				<tr>
					<td>Round 1</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row">
		<form action="<?=base_url('farmgame');?>" method="post" name="farmgame" id="farmgame">
			<button type="submit" name="submit_farmgame" class="btn btn-default pull-right">Feed</button>			
		</form>
		<form action="<?=base_url('farmgame/reset_fed');?>" method="post" name="reset_farmgame" id="reset_farmgame">
			<button type="submit" name="submit_farmgame" class="btn btn-default ">Reset Feed</button>			
		</form>
	</div>

</body>
</html>
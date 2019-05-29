<!DOCTYPE html>
<html>
<head>
	<title>FarmGame</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/css/bootstrap.css')?>">
	<style type="text/css">
		.red{
			background-color: red;
		}
	</style>
	<?php 
		$highlight=json_decode($died,true);
	?>
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
				<th <?php if (in_array(0, $highlight)){echo "class='red'";	}?> >Farmer</th>
				<th <?php if (in_array(1, $highlight)){echo "class='red'";	}?> >Cow 1</th>
				<th <?php if (in_array(2, $highlight)){echo "class='red'";	}?> >Cow 2</th>
				<th <?php if (in_array(3, $highlight)){echo "class='red'";	}?> >Bunny 1</th>
				<th <?php if (in_array(4, $highlight)){echo "class='red'";	}?> > Bunny 2</th>
				<th <?php if (in_array(5, $highlight)){echo "class='red'";	}?> > Bunny 3</th>
				<th <?php if (in_array(6, $highlight)){echo "class='red'";	}?> > Bunny 4</th>
			</tr>
			<tbody>
				<?php 
					$srno=0;
					if ( !empty($roundwise) ){
						foreach ($roundwise as $key => $value) {	
							$data=json_decode($value[0],true);
							echo "
								<tr>
									<td>Round ".++$srno ."</td>
									<td>".@$data[0]['status']."</td>
									<td>".@$data[1]['status']."</td>
									<td>".@$data[2]['status']."</td>
									<td>".@$data[3]['status']."</td>
									<td>".@$data[4]['status']."</td>
									<td>".@$data[5]['status']."</td>
									<td>".@$data[6]['status']."</td>
								</tr>
							";
						}
					}					
				?>
				
			</tbody>
		</table>
	</div>
	<div class="row">
		<form action="<?=base_url('farmgame');?>" method="post" name="farmgame" id="farmgame">
			<input type="hidden" name="round" value="<?=$round; ?>" />
			<input type="hidden" name="died" value='<?=$died; ?>' />
			<input type="hidden" name="feed_history" value='<?=$feed_history; ?>' />
			<input type="hidden" name="roundwise" value='<?=json_encode($roundwise); ?>' />
			<?php				
				if(isset($game_over)){
					echo "<lable>".$game_over."</lable>";
				}else{
					echo '<button type="submit" name="submit_farmgame" class="btn btn-default pull-right">Feed</button>	';
				}
			?>					
		</form>
		<form action="<?=base_url('farmgame/reset_fed');?>" method="post" name="reset_farmgame" id="reset_farmgame">
			<button type="submit" name="submit_farmgame" class="btn btn-default ">Reset Feed</button>			
		</form>
	</div>

</body>
</html>
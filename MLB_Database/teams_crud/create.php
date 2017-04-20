<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$team_locationError = null;
		$team_mascotError = null;
		$salary_capError = null;
		
		// keep track post values
		$team_location = $_POST['team_location'];
		$team_mascot = $_POST['team_mascot'];
		$salary_cap = $_POST['salary_cap'];
		
		// valiteam_location input
		$valid = true;
		if (empty($team_location)) {
			$team_locationError = 'Please enter the team location';
			$valid = false;
		}
		
		if (empty($team_mascot)) {
			$team_mascotError = 'Please enter the team mascot';
			$valid = false;
		}
		
		if (empty($salary_cap)) {
			$salary_capError = 'Please enter a salary_cap';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO teams (team_location,team_mascot,salary_cap) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($team_location,$team_mascot,$salary_cap));
			Database::disconnect();
			header("Location: index.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a team</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					  <div class="control-group <?php echo !empty($team_locationError)?'error':'';?>">
					    <label class="control-label">Team Location</label>
					    <div class="controls">
					      	<input name="team_location" type="text"  placeholder="Team Location" value="<?php echo !empty($team_location)?$team_location:'';?>">
					      	<?php if (!empty($team_locationError)): ?>
					      		<span class="help-inline"><?php echo $team_locationError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($team_mascotError)?'error':'';?>">
					    <label class="control-label">Team Mascot</label>
					    <div class="controls">
					      	<input name="team_mascot" type="text" placeholder="Team Mascot" value="<?php echo !empty($team_mascot)?$team_mascot:'';?>">
					      	<?php if (!empty($team_mascotError)): ?>
					      		<span class="help-inline"><?php echo $team_mascotError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($salary_capError)?'error':'';?>">
					    <label class="control-label">Salary Cap</label>
					    <div class="controls">
					      	<input name="salary_cap" type="text"  placeholder="Salary Cap" value="<?php echo !empty($salary_cap)?$salary_cap:'';?>">
					      	<?php if (!empty($salary_capError)): ?>
					      		<span class="help-inline"><?php echo $salary_capError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
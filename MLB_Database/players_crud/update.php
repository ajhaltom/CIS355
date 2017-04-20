<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$first_nameError = null;
		$last_nameError = null;
		$rookie_yearError = null;
		
		// keep track post values
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$rookie_year = $_POST['rookie_year'];
		
		// valifirst_name input
		$valid = true;
		if (empty($first_name)) {
			$first_nameError = 'Please enter the first name';
			$valid = false;
		}
		
		if (empty($last_name)) {
			$last_nameError = 'Please enter the last name';
			$valid = false;
		}
		
		if (empty($rookie_year)) {
			$rookie_yearError = 'Please enter a rookie year';
			$valid = false;
		}

		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE players set first_name = ?, last_name = ?, rookie_year =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($first_name,$last_name,$rookie_year,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM players where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$first_name = $data['first_name'];
		$last_name = $data['last_name'];
		$rookie_year = $data['rookie_year'];
		Database::disconnect();
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
		    			<h3>Update a player</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($first_nameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="first_name" type="text"  placeholder="First Name" value="<?php echo !empty($first_name)?$first_name:'';?>">
					      	<?php if (!empty($first_nameError)): ?>
					      		<span class="help-inline"><?php echo $first_nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($last_nameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="last_name" type="text" placeholder="Last Name" value="<?php echo !empty($last_name)?$last_name:'';?>">
					      	<?php if (!empty($last_nameError)): ?>
					      		<span class="help-inline"><?php echo $last_nameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($rookie_yearError)?'error':'';?>">
					    <label class="control-label">Rookie Year</label>
					    <div class="controls">
					      	<input name="rookie_year" type="text"  placeholder="Rookie Year" value="<?php echo !empty($rookie_year)?$rookie_year:'';?>">
					      	<?php if (!empty($rookie_yearError)): ?>
					      		<span class="help-inline"><?php echo $rookie_yearError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
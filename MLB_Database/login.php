<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : Alex Haltom
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 */
class Database 
{
	private static $dbName = '...' ; 
	private static $dbHost = '...' ;
	private static $dbUsername = '...';
	private static $dbUserPassword = '...';
	
	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect()
	{
	   // One connection through whole application
       if ( null == self::$cont )
       {      
        try 
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);  
        }
        catch(PDOException $e) 
        {
          die($e->getMessage());  
        }
       } 
       return self::$cont;
	}
	
	public static function disconnect()
	{
		self::$cont = null;
	}
}
if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		Database::disconnect();
		header("Location: /players_crud/index.php");
		exit();
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
	}
} 
// if $_POST NOT filled then display login form, below.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="players_crud/css/bootstrap.min.css" rel="stylesheet">
    <script src="players_crud/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
		
			<div class="row">
				<h3>MLB Database Login</h3>
			</div>
			
			<img src="MLB logo.jpeg" alt="MLB logo" style="width:304px;height:228px;">
			
			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="Password" required> 
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="create_acc.html">Join (New User)</a>
				</div>
				
							
				<footer>
					<small>&copy; Copyright 2017, Alex Haltom
					</small>
				</footer>
				
			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>
	

	

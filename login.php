<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
	

	if(isset($_POST['logId']) && isset($_POST['pass']))
	{
	
		$user_name = $_POST['logId'];
		$pass = $_POST['pass'];
		
		$user_name = trim($user_name);
		$pass = trim($pass);

		echo $user_name. " ". $pass;
		$con = mysqli_connect('rds instance link','user name','password','master database name');
		
		
		if(!$con){
			die("Connection filed: ". mysqli_connect_error());
		}
		
		$sql = "Select * from login where user_name ='".$user_name."' and password ='".$pass."'";
		
		
		$result = mysqli_query($con,$sql);
		
		
		if(mysqli_num_rows($result)>0)
		{
			
					session_start();
					$_SESSION['user_name'] = $user_name;
					header("Location: home.php");
		}
		else
		{
					echo "Invalid login id or password ";
		}
		
	
	}
	else
	{
	
			echo "All fields are required:";
	}

	
?>
<body>
</body>
</html>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if(isset($_POST['rate']))
	{


			$con = mysqli_connect('rds instance link','user name','password','master database name');

		$sqlq = "select ratings from s3files "." where accessCode ='".$_POST['ac']."'";

		echo $sqlq;
	$result = mysqli_query($con,$sqlq) or die('error: not able to save');

	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
			
			$totalratings = $row['ratings'] + $_POST['rate'];
    	}
		} 

	mysqli_close($con);




	$con = mysqli_connect('rds instance link','user name','password','master database name');

		$sqlq = "update s3files set ratings=".$totalratings." where accessCode ='".$_POST['ac']."'";

		echo $sqlq;
	mysqli_query($con,$sqlq) or die('error: not able to save');

	mysqli_close($con);
	


	$con = mysqli_connect('rds instance link','user name','password','master database name');

		$sqlq = "select totalVotes from s3files "." where accessCode ='".$_POST['ac']."'";

		echo $sqlq;
	$result = mysqli_query($con,$sqlq) or die('error: not able to save');

	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
			
			$totalVotes = $row['totalVotes'];
    	}
		} 

	mysqli_close($con);

	$totalVotes++;


	$con = mysqli_connect('rds instance link','user name','password','master database name');

		$sqlq = "update s3files set totalVotes=".$totalVotes." where accessCode ='".$_POST['ac']."'";

		echo $sqlq;
	mysqli_query($con,$sqlq) or die('error: not able to save');

	mysqli_close($con);


	

	$con = mysqli_connect('rds instance link','user name','password','master database name');

		$sqlq = "insert into userImage(user_name,accessCode) values('".$_SESSION['user_name']."','".$_POST['ac']."')";

	mysqli_query($con,$sqlq) or die('error: not able to save');

	mysqli_close($con);


	header("Location: home.php");
}

}
    // …

?>
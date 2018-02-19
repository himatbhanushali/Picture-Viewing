<?php 
session_start();
if(isset($_SESSION['user_name']))
{

echo '
<!DOCTYPE html>
<html>
<body>
<p align="right"><a href="logout.php"><b>Sign out</b></a></p>
<table align="center">
<tr><td><h1>Picture Viewing for  :  '.$_SESSION['user_name'].'</h1></td></tr>

<form action="upload.php" method="post" enctype="multipart/form-data">
<tr><td>
	<input type="text" name="title" id="title" placeholder="Title for Image" size="68" required> </td></tr>
	<tr><td>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"></td></tr>
    <tr><td>
    <input type="submit" value="Upload Image" name="submit"></td></tr>
</form
</table>
';
?>
<?php
		$con = mysqli_connect('rds instance link','user name','password','master database name');
		
		
		if(!$con){
			die("Connection filed: ". mysqli_connect_error());
		}
		
		$sql = "Select * from s3files";
		
		
		$result = mysqli_query($con,$sql);
		echo '<table width="80%" align="center"><thead><tr>
		<th> Title </th>
		<th> Image </th>
		<th> Last Modified </th>
		<th> Access Code </th>
		<th> Ratings </th>
		<th> Vote </th>
		</tr></thead><tbody>
		';
		if (mysqli_num_rows($result) > 0) {
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
			
			echo '

				<tr align="center">
				<td>'. $row['title'] .'</td>
				<td><img src="https://s3.us-east-2.amazonaws.com/lab2-files/'.  $row['s3FilePath'] .'" width="250" height="250"></td>
				<td>'. $row['dtime'] .'</td>
				<td>'. $row['accessCode'] .'</td>
				<td>'. $row['ratings']/$row['totalVotes'].'</td>
				<td><a href="vote.php?accessCode='. $row['accessCode'].'">  Vote Here</a></td>
				<tr>
			';
    	}
		} 
		echo '</tbody></table>
		<center><h2>Favorite Images<h2></center><br><br><br><br>
		';
		mysqli_close($con);
?>
<?php


$con = mysqli_connect('rds instance link','user name','password','master database name');
		
		
		if(!$con){
			die("Connection filed: ". mysqli_connect_error());
		}
		
		$sql = "Select * from s3files where accessCode in (select accessCode from userImage where user_name='".$_SESSION['user_name']."')";
		
		
		$result = mysqli_query($con,$sql);
		echo '<table width="80%" align="center"><thead><tr>
		<th> Title </th>
		<th> Image </th>
		<th> Last Modified </th>
		<th> Access Code </th>
		<th> Ratings </th>
		
		</tr></thead><tbody>
		';
		if (mysqli_num_rows($result) > 0) {
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
			
			echo '

				<tr align="center">
				<td>'. $row['title'] .'</td>
				<td><img   src="https://s3.us-east-2.amazonaws.com/lab2-files/'.  $row['s3FilePath'] .'" width="250" height="250"></td>
				<td>'. $row['dtime'] .'</td>
				<td>'. $row['accessCode'] .'</td>
				<td>'. $row['ratings']/$row['totalVotes'].'</td>
				<tr>
			';
    	}
		} 
		echo '</tbody></table>
		';
		mysqli_close($con);
?>
<?php
echo '</body>
</html>';
}
else
{
header("Location: index.php");
}
?>
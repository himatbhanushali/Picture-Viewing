
<<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
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
		</tr></thead><tbody>
		';
		if (mysqli_num_rows($result) > 0) {
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
			
			echo '

				<tr align="center">
				<td>'. $row['title'] .'</td>
				<td><img src="https://s3.us-east-2.amazonaws.com/lab2-files/'.  $row['s3FilePath'] .'"></td>
				<td>'. $row['dtime'] .'</td>
				<td>'. $row['accessCode'] .'</td>
				<tr>
			';
    	}
		} 
		echo '</tbody></table>';
		mysqli_close($con);
?>
</body>
</html>

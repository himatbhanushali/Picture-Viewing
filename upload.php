<?php
	
require './vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
	
// AWS Info
$bucketName = 'lab2-files';
$IAM_KEY = '';
$IAM_SECRET = '';
	
// Connect to AWS
	
try {
	// You may need to change the region. It will say in the URL when the bucket is open
	// and on creation.
	
	$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'us-east-2'
			)
		);
	} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: " . $e->getMessage());
	}
	
	// For this, I would generate a unqiue random string for the key name. But you can do whatever.
	$keyName = 'test_example/' . basename($_FILES["fileToUpload"]['name']);
	$pathInS3 = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["fileToUpload"]['tmp_name'];
		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY',
				
				
			)
		);
	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}

	// Save file to files  table  - TODO

	// Create access code 

	$ACCESS_CODE = uniqid();
	$title = $_POST['title'];
	$con = mysqli_connect('rds instance link','user name','password','master database name');
	$mtime = date('Y-m-d H:i:s');
	mysqli_query($con,"INSERT INTO s3files(title,s3FilePath,accessCode,dtime) VALUES ('$title','$keyName','$ACCESS_CODE','$mtime') ") or die('error: not able to save');

	mysqli_close($con);
	echo 'Done';
	header("Location: home.php");
	// Now that you have it working, I recommend adding some checks on the files.
	// Example: Max size, allowed file types, etc.
?>
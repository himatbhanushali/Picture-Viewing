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

	$result = $s3->listObjects(array('Bucket'=>$bucketName));

	echo "Keys retrieved! \n";
	foreach($result['Contents'] as $object)
	{
		$p = "https://s3.us-east-2.amazonaws.com/lab2-files/".$object['Key'];
		echo "<img src ='$p'>";
		//var_dump($object);
	}
?>
<?php
require './aws.phar';
use Aws\Common\Aws;



fetch_img("101_1403118320995.jpg");




function fetch_img($key){

	// Create a service locator using a configuration file
	$aws = Aws::factory('./configaws.php');

	// Get client instances from the service locator by name
	$s3Client = $aws->get('s3');


	$bucket = 'blue-cheese-photos';
	//$key = 'Aburaage_1.jpg';//test case

	$result = $s3Client->getObject(array(
		'Bucket' => $bucket,
		'Key'    => $key,
		'SaveAs' => './img/'.$key
	));

	/* another way to retrive data from S3
	date_default_timezone_set('America/New_York');
	$signedUrl = $s3Client->getObjectUrl($bucket, $key, '+10 minutes');

	$img = "./1".$key;
	file_put_contents($img, file_get_contents($signedUrl));
	*/
}
?>

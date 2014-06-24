<?php
require './aws.phar';
use Aws\Common\Aws;

// Create a service locator using a configuration file
$aws = Aws::factory('./configaws.php');

// Get client instances from the service locator by name
$s3Client = $aws->get('s3');


$bucket = 'edible-wiki-data';
$key = 'Aburaage_1.jpg';

$result = $s3Client->getObject(array(
    'Bucket' => $bucket,
    'Key'    => $key,
    'SaveAs' => './'.$key
));

/*
date_default_timezone_set('America/New_York');
$signedUrl = $s3Client->getObjectUrl($bucket, $key, '+10 minutes');

$img = "./1".$key;
file_put_contents($img, file_get_contents($signedUrl));
*/
?>

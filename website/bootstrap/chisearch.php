<?php
require './aws.phar';
use Aws\Common\Aws;



	$keyword = "blue+cheese";
	edible_search($keyword);

	
	
	
	
	function edible_search($keyword){
		$keyword = str_replace(" ","%20",$keyword);
		$url = 'http://default-environment-9hfbefpjmu.elasticbeanstalk.com/food?title='.$keyword;
		$contents = file_get_contents($url);
		$contents_json = json_decode($contents);
		
		if (count($contents_json->result) != 0) {
			foreach($contents_json->result as $result){
				
				foreach( $result->photos as $photo){
					$photourl =$photo->url;
					echo $photourl;
					fetch_img($photourl);
				}
				$tags =   $result-> tags;
				$fid = $result->fid;        
				$title = $result->title;       
				$desc = $result->description; 
				$name = $result->name;
				echo $title. ": ". $name . ": " . $photourl."<br>";
				echo $desc."<br>";
				
			}
			
		}
		else {// if no avaliable records, then use faroo API			
			faroo_search($keyword);
		}
	}
		
		
	function faroo_search($buffer){
		$picName = str_replace(" ", "_",$buffer);
		$name=$buffer;
		
		// $name = str_replace(" ", "+",$buffer);
		//$name = urlencode($buffer);
		$url = 'http://www.faroo.com/api?start=1&length=10&l=en&src=web&i=true&f=json&key=Z-bZ3ptedg1j-quqsGXhl2O05cY_&q=' . $name; 
		$data = get_url_contents($url);
		
		//$data_json = json_decode($data);
		
		return $data;
		
		
	}


	function fetch_img($key){

		// Create a service locator using a configuration file
		$aws = Aws::factory('./configaws.php');

		// Get client instances from the service locator by name
		$s3Client = $aws->get('s3');


		$bucket = 'blue-cheese-photos';
		//$key = 'Aburaage_1.jpg';//test case
		try{
			$result = $s3Client->getObject(array(
				'Bucket' => $bucket,
				'Key'    => $key,
				'SaveAs' => './img/'.$key
		));
		}
		catch (Exception $e){
			echo "IMAGE-NULL";
			}

		/* another way to retrive data from S3
		date_default_timezone_set('America/New_York');
		$signedUrl = $s3Client->getObjectUrl($bucket, $key, '+10 minutes');

		$img = "./1".$key;
		file_put_contents($img, file_get_contents($signedUrl));
		*/
	}


	function get_url_contents($url) {
		
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($crl, CURLOPT_URL, $url);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
		$ret = curl_exec($crl);
		curl_close($crl);
		return $ret;
	}
	 
?>
	

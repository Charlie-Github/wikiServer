<?php 


	$query = "apple";
	
	search($query);
	
	
	
	function search($query){
	
		$img_name = str_replace(" ","_",$query);
		$query = str_replace(" ","+",$query);
	
    	$accountKey = 'hfZ3wZX812gJMJqswuK3YZkyRwrp9IkuxYeKVfu99Pg';
    	$url = 'https://api.datamarket.azure.com/Bing/Search/Image?$format=json&$top=2&Query=%27'.$query.'+food%27';//search for food
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($process, CURLOPT_USERPWD, "username:hfZ3wZX812gJMJqswuK3YZkyRwrp9IkuxYeKVfu99Pg");
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($process);
		$json= json_decode($response);
		
	
		$counter = 0;
		foreach($json->d->results as $value){
		$image_url = $value->MediaUrl;
		$img = "./".$img_name."_".$counter.".jpg";
		file_put_contents($img, file_get_contents($image_url));
		
		$counter ++;
		
	}
	
	}
	
	
	
	
?>

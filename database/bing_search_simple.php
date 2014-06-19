<?php 


	$file_name = $argv[1];//'./foodlist_a-z_sample100.txt';//.$argv[0];//simple txt file
	$fp=fopen($file_name,'r');
	
	$output_folder = $argv[2];	// 'pic'
	
	
	echo "Open file for read and write...\r\n";
	
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$buffer = str_replace(",", " ", $buffer);
		
		
		echo $buffer."\r\n";
		
		
		search($buffer,$output_folder);
		
		
		
 	}
 	
	
	fclose($fp);
	
	echo "Done with file read and write...\r\n";
	
	
	
	
	
	
	
	
	
	
	
	
	function search($query,$output_folder){
	
		$img_name = str_replace(" ","_",$query);
		$query = str_replace(" ","+",$query);

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
			$img = "./".$output_folder."/".$img_name."_".$counter.".jpg";
			
			file_put_contents($img, file_get_contents($image_url));
		
			$counter ++;
		
		}
	
	}
	
	
	
	
?>

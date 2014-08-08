<?php

	$file_name='./foods_iowacity.xml';
	$fp=fopen($file_name,'r');
	
	echo "Open file for read and write...\r\n";
	
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$buffer = str_replace(",", " ", $buffer);
		
		
		
		
		$pattern_name = '#<Name>.*</Name>#';
		
		if(preg_match($pattern_name,$buffer)){
		
			echo $buffer."\r\n";
			$buffer = str_replace("<Name>","",$buffer);
			$buffer = str_replace("</Name>","",$buffer);
			search($buffer);
			
		
		}
		
		
		
		
 	}
 	
	
	fclose($fp);
	
	echo "Done with file read and write...\r\n";
	
	

function search($buffer){
	$picName = str_replace(" ", "_",$buffer);
	$name = str_replace(" ", "+",$buffer);

	$url = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . $name; 

	$json = get_url_contents($url);
	$data = json_decode($json);
	
	
	foreach ($data->responseData->results as $result) {
	
	
		
    	$results[] = array($result->url);
    
	}
	
	$counter = 0;
		
	foreach ($results as $image_url){
			
				
		if($counter == 2){
			
			break;
		}
		$img = "./pic/".$picName."_".$counter.".jpg";
		echo $image_url[0]."\r\n";
		file_put_contents($img, file_get_contents($image_url[0]));
				
		$counter ++;
	}

	sleep(1);
	

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
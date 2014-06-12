<?php
// Charlie's work
// Youdao translate
//functions for retrieving images	

	$input='./foodlist_a-z_xml.xml';
	$input_handle=fopen($input,'r');
	
	$output = './foodlist_a-z_chinese_xml.xml';
	$output_handle = fopen($output, "w+");
	
	$temp = './youdao_temp.xml';
	
	
	echo "Open for read and write...\r\n";
	
		$counter = 0;
	//while(!feof($input_handle))
	{
				
		$buffer=fgets($input_handle,4096);
		
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$buffer = str_replace("_", " ", $buffer);
		
		$pattern = '#<Image>(.*)</Image>#Us';
		$patternName = '#<Name>(.*)</Name>#Us';
		$patternDesc = '#<Desc>(.*)</Desc>#Us';
		
		if(preg_match($pattern,$buffer)){
			continue;//skip image url
		}
		if($buffer == "<Desc></Desc>"){
			continue;
		}
		
		if(preg_match($patternName,$buffer)){
			$buffer = str_replace("<Name>", "", $buffer);
			$buffer = str_replace("</Name>", "", $buffer);
			
			echo $counter .": " .$buffer."\r\n";
			$transword = "<ENName>".$buffer. "</ENName>\r\n";
			fwrite($output_handle,$transword);
			
			$word = urlencode($buffer);
			
			$url = 'http://fanyi.youdao.com/openapi.do?keyfrom=goodDict&key=2121816595&type=data&doctype=json&version=1.1&only=translate&q='.$word;
			$contents = file_get_contents($url);
			

			$chinese = json_decode($contents);
			$chinese = $chinese->translation[0];
				
			$transword = "<ZHName>".$chinese. "</ZHName>\r\n";
			$counter ++;
			fwrite($output_handle,$transword);
			
		}
		
		if(preg_match($patternDesc,$buffer)){
			$buffer = str_replace("<Desc>", "", $buffer);
			$buffer = str_replace("</Desc>", "", $buffer);
			
			$word = urlencode($buffer);
			
			$url = 'http://fanyi.youdao.com/openapi.do?keyfrom=goodDict&key=2121816595&type=data&doctype=json&version=1.1&only=translate&q='.$word;
			$contents = file_get_contents($url);
			

			$chinese = json_decode($contents);
			$chinese = $chinese->translation[0];
			
			
			$transword ="<Desc>".$chinese."</Desc>\r\n";
			fwrite($output_handle,$transword);
			
		}
		
		
		
		
		
				
		sleep(4);

 	}
	fclose($input_handle);
	fclose($output_handle);
	
	echo "Done with file read and write...\r\n";




?>
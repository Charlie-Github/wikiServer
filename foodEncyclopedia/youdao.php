<?php
// Charlie's work
// Youdao translate
//functions for retrieving images	

	$input='./foods_newyork.xml';
	$input_handle=fopen($input,'r');
	
	$output = './foods_newyork_chinese.xml';
	$output_handle = fopen($output, "w+");
	
	$temp = './youdao_temp.xml';
	$temp_handle = fopen($temp,"w+");
	
	echo "Open for read and write...\r\n";
	
		$counter = 0;
	while(!feof($inputHandle))
	{
		$buffer=fgets($inputHandle,4096);
		
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$buffer = str_replace("_", " ", $buffer);
		
		$pattern = '#<Image>(.*)</Image>#Us';
		$patternName = '#<Name>(.*)</Name>#Us';
		$patternDesc = '#<Desc>(.*)</Desc>#Us';
		
		if(preg_match($pattern,$buffer)){
			continue;//skip image url
		}
		if($buffer == ""){
			continue;
		}
		
		if(preg_match($patternName,$buffer)){
			$buffer = str_replace("<Name>", "", $buffer);
			$buffer = str_replace("</Name>", "", $buffer);
			
			echo $counter .": " .$buffer."\r\n";
			$transword = "<ENName>".$buffer. "</ENName>\r\n";
			fwrite($outputHandle,$transword);
			
			$word = urlencode($buffer);
			
			$url = 'http://fanyi.youdao.com/openapi.do?keyfrom=goodDict&key=2121816595&type=data&doctype=xml&version=1.1&only=translate&q='.$word;
			$contents = file_get_contents($url);
			fwrite($temp_handle, $contents);
			
			$xml=simplexml_load_file("./youdao_temp.xml");

			$chinese = $xml->translate->paragraph;
			
			$transword = "<ZHName>".$chinese. "</ZHName>\r\n";
			$counter ++;
			fwrite($outputHandle,$transword);
			
		}
		
		if(preg_match($patternDesc,$buffer)){
			$buffer = str_replace("<Desc>", "", $buffer);
			$buffer = str_replace("</Desc>", "", $buffer);
			
			$word = urlencode($buffer);
			
			$url = 'http://fanyi.youdao.com/openapi.do?keyfrom=goodDict&key=2121816595&type=data&doctype=xml&version=1.1&only=translate&q='.$word;
			$contents = file_get_contents($url);
			fwrite($temp_handle, $contents);
			
			$xml=simplexml_load_file("./youdao_temp.xml");

			$chinese = $xml->translate->paragraph;
			
			
			$transword ="<Desc>".$chinese."</Desc>\r\n";
			fwrite($outputHandle,$transword);
			
		}
		
		
		
		
		
		
		
		sleep(1);

 	}
	fclose($inputHandle);
	fclose($outputHandle);
	fclose($temp_handle);
	echo "Done with file read and write...\r\n";




?>
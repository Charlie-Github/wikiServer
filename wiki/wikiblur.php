<?php 
       //Charlie's work
		// $_GET['keyword'];
		$inputFile='./foodnames_2600.txt';
		$inputHandle=fopen($inputFile,'r');
	
		$outputFile='./foodnames_keyformat_2600.txt';
		$outputHandle=fopen($outputFile,'w+');
		
		echo "Open file for read...\r\n";
		while(!feof($inputHandle)){
			$buffer=fgets($inputHandle,4096);
			$keyword = $buffer;
			
			
			$keyword = str_replace(" ", "_",$keyword);
			
			$keyword = str_replace("\r", "",$keyword);
			$keyword = str_replace("\n", "",$keyword);
			
			echo $keyword."\r\n";
			
			blursearch($keyword,$outputHandle);
			
		}
		
		fclose($inputHandle);
		fclose($outputHandle);
		echo "Done with file read and write...\r\n";
		
		
		function blursearch($keyword,$handle){
			$url = 'http://en.wikipedia.org/w/api.php?action=query&list=search&format=json&srlimit=3&srsearch='.$keyword;
			$ch = curl_init($url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript");
			$c = curl_exec($ch);

			$json = json_decode($c);
	
			$content = $json->{'query'}->{'search'}; 
		
		
			$length = sizeof($content);
			for($index = 0; $index < $length; $index++){
				$searchword=$content[$index]->{'title'};
			
				$searchword = str_replace(" ", "_",$searchword);
			
				
			
				fwrite($handle,$searchword);			
				fwrite($handle,"\r\n");
			}
		}
		
	
?>
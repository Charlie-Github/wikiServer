<?php
// Charlie's work
// xml parser
	

	$input='./basic_foods_wiki_5000.xml';
	$input_handle=fopen($input,'r');
	
	$output = './basic_foods_wiki5000_en.txt';
	$output_handle = fopen($output, "w+");
	
	$output_zhName = './basic_foods_wiki5000_zh.txt';
	$output_zhName_handle = fopen($output_zhName, "w+");
	
	$inputXML = simplexml_load_file($input);
	$food = $inputXML->food;
	
	
	$counter = 0;
	foreach ($food as $sigleFood):
        $enName=$sigleFood->enName;
        $enDesc=$sigleFood->enDesc;
        $zhName=$sigleFood->zhName;
		$zhDesc=$sigleFood->zhDesc;
		if(validate($enName,$enDesc,$zhName,$zhDesc)){
		
			$counter++;
			echo $counter."\r\n";
			fwrite($output_handle,$enName."\r\n");
			fwrite($output_zhName_handle,$zhName."\r\n");
		}
		
		
    endforeach;
	
	
	function validate($enName,$enDesc,$zhName,$zhDesc){
		if(strlen($enName) < 20 && $zhName != ""){
			return true;		
		}
		else{
			return false;
		}
	
	}
	
	
?>
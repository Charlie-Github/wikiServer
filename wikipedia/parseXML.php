<?php
// Charlie's work
// Youdao translate
	

	$input='./basic_foods_desc.xml';
	$input_handle=fopen($input,'r');
	
	$output = './basic_foods_desc_parsed.xml';
	$output_handle = fopen($output, "w+");
	
	$inputXML = simplexml_load_file($input);
    echo $inputXML->food[0]->title;
	
	
?>
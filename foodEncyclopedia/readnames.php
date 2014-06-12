<?php

$input = './foodlist_a-z_html.html';
$input_handle = fopen($input, "r");

$output = './foodlist_a-z_utf8.xml';
$output_handle = fopen($output,"w+");


	$counter = 0;
	echo "Start..\r\n";
	while(!feof($input_handle))
	{
		$buffer=fgets($input_handle,4096);
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);

		$unicode_html = $buffer;
		
		

		// to utf-8
		$str = mb_convert_encoding($unicode_html, 'UTF-8', 'HTML-ENTITIES'); 
		$str = $str."\r\n";
		fwrite($output_handle, $str);
		$counter++;
	}
	
	fclose($input_handle);
	fclose($output_handle);
	
	echo "Done!\r\n";
?>
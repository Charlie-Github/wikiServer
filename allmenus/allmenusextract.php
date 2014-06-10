<?php 
//functions for retrieving images	

	$input='./allmenus_iowacity.dat';
	$input_handle=fopen($input,'r');
	
	$output = './menus_iowacity.xml';
	$output_handle = fopen($output, "w+");
	
	echo "Open for read and write...\r\n";
	
	$counter = 0;
	while(!feof($input_handle))
	{
		/* test break point*/
		/*
		if($counter == 2){
			break;
		}
		*/
		
		$buffer=fgets($input_handle,4096);
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$restaurant_id = $buffer;

		echo $counter.": ".$restaurant_id."\r\n";
		
		$url = 'http://api.allmenus.com/restaurant?type=menu&restaurant_id='.$restaurant_id.'&v=2&api_key=xhg7nngf56kxmxqye5nbb7em';
		$contents = file_get_contents($url);  

		fwrite($output_handle, $contents);
			
		$counter++;
		
 	}
 	
	fclose($input_handle);
	fclose($output_handle);
	
	echo "Done with file read and write...\r\n";
	

	

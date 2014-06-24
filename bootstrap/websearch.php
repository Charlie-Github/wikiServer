<?php

	$keyword = $_GET["key"];
	$keyword = str_replace(" ","%20",$keyword);
	
	
	$url = 'http://default-environment-9hfbefpjmu.elasticbeanstalk.com/food?title='.$keyword;
	$contents = file_get_contents($url);
	$contents_json = json_decode($contents);
	
	foreach($contents_json->result as $result){
	
		foreach( $result->photos as $photo){
	
			$photourl =$photo->url;
        }
         $tags =   $result-> tags;
         $fid = $result->fid;        
        $title = $result->title;       
              $desc = $result->description; 
            $name = $result->name;
            
            echo $title. ": ". $name . ": " . $photourl."<br>";
            
            echo $desc;
                
	}
	
?>
	

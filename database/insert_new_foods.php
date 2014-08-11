<?php

$input='./basic_foods_wiki_5.xml';
$input_handle=fopen($input,'r');

$output = './basic_foods_wiki5000_en.txt';
$output_handle = fopen($output, "w+");

$output_zhName = './basic_foods_wiki5000_zh.txt';
$output_zhName_handle = fopen($output_zhName, "w+");

$inputXML = simplexml_load_file($input);
$food = $inputXML->food;


$con = mysqli_connect('aa25dqkbwfsa09.cuzbw4369xvy.us-west-2.rds.amazonaws.com', 'edible', 'edible001', 'blue_cheese', 3306);	

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// change character set to utf8
if (!$con->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $con->error);
} else {
    printf("Current character set: %s\n", $con->character_set_name());
}

/*prototype
	//insertFoods($con,"CHARLIE");
	//checkExist($con,"foods","CHARLIE");
	//checkFid($con,"CHARLIE");
	//insertToEn($con,"1790","CHARLIE","Charlie","Desc");
	//insertToZh($con,"1790","CHARLIE","ZHName","ZhDesc");
*/
	

$counter = 0;
foreach ($food as $sigleFood):
	$title=strtoupper($sigleFood->enName);
	$enName=$sigleFood->enName;
	$enDesc=$sigleFood->enDesc;
	$zhName=$sigleFood->zhName;
	$zhDesc=$sigleFood->zhDesc;
	if(validate($enName,$enDesc,$zhName,$zhDesc)){
	
		$counter++;
		echo $counter."\r\n";
		insertNewTitle($con,$title,$enName,$zhName,$enDesc,$zhDesc);
		fwrite($output_handle,$enName."\r\n");
		fwrite($output_zhName_handle,$zhName."\r\n");
		
		
	}
	
	
endforeach;

mysqli_close($con);


//========================================================================functions=============

function validate($enName,$enDesc,$zhName,$zhDesc){
		if(strlen($enName) < 20 && $zhName != ""){
			return true;		
		}
		else{
			return false;
		}
	
	}

function insertNewTitle($con,$title,$enName,$zhName,$enDesc,$zhDesc){

	$exist = checkExist($con,"foods",$title);
	if($exist < 1){
		insertFoods($con,$title);
		$fid = checkFid($con,$title);
		insertToEn($con,$fid,$title,$enName,$enDesc);
		insertToZh($con,$fid,$title,$zhName,$zhDesc);
	}
	else{
		echo "Duplicate: ".$title."\r\n";
	}
	

}

function checkExist($con,$table,$title){
	$result =  mysqli_query($con,"
						
							SELECT Count(*) from ".$table."
							WHERE title = \"".$title."\";
	");
	$count = mysqli_fetch_array($result);
	return $count[0];

}

function checkFid($con,$title){
	$result =  mysqli_query($con,"						
							SELECT fid from foods
							WHERE title = \"".$title."\";
	");
	$count = mysqli_fetch_array($result);

	return strval($count[0]);


}

function insertFoods($con,$title){
	$result =  mysqli_query($con,"
						
							INSERT INTO foods
							VALUES(0,\"".$title."\",0,0);
						
	");
}




function insertToEn($con,$fid,$title,$name,$enDesc){
	$result =  mysqli_query($con,"						
							INSERT INTO foods_EN
							VALUES(".$fid.",\"".$title."\",\"".$name."\",\"N/A\",\"".$enDesc."\",\"\",0);
						
	");
	//
	return $result;
}

function insertToZh($con,$fid,$title,$zhName,$zhDesc){
	$result =  mysqli_query($con,"						
							INSERT INTO foods_CN
							VALUES(".$fid.",\"".$title."\",\"".$zhName."\",\"N/A\",\"".$zhDesc."\",\"\",0);
						
	");
	//
	return $result;
}











?> 


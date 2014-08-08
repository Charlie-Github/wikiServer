<?php

$con = mysqli_connect('aa25dqkbwfsa09.cuzbw4369xvy.us-west-2.rds.amazonaws.com', 'edible', 'edible001', 'blue_cheese', 3306);	

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


/*prototype
	//insertFoods($con,"CHARLIE");
	//checkExist($con,"foods","CHARLIE");
	//checkFid($con,"CHARLIE");
	//insertToEn($con,"1790","CHARLIE","Charlie","Desc");
	//insertToZh($con,"1790","CHARLIE","ZHName","ZhDesc");
*/

/*
//Sample
$result = mysqli_query($con,"SELECT * FROM foods where title = \'CHARLIE\'");

while($result != "" && $row = mysqli_fetch_array($result)) {
  echo $row[0];
  echo "\r\n";
}
*/


mysqli_close($con);


function insertTitle(){



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

	return $count[0];


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


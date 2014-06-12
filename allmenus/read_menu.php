<?php
$xml=simplexml_load_file("menus_iowacity_1.xml");




foreach ($xml->group->category as $category){
	foreach($category->item as $item){
		$name = $item->name;
		$desc = $item->description;
		echo $name."\r\n";
		echo $desc."\r\n";
	}

}


?>
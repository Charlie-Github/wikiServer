<?php



$xml=simplexml_load_file("menus_iowacity.xml");


$output = "./foods_iowacity.xml";
$output_handle = fopen($output,"w+");

foreach($xml->menu as $menu){

	foreach ($menu->group->category as $category){
		
		foreach($category->item as $item){
		
			$name = "<Name>" . $item->name . "</Name>\r\n";
			$desc = "<Desc>" . $item->description ."</Desc>\r\n";
			fwrite($output_handle, $name);
			fwrite($output_handle, $desc);
		}

	}
}


?>
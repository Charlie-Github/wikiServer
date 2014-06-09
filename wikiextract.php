<?php 
//functions for retrieving images	

	$file_name='./foodnames_keyformat_2600.txt';
	$fp=fopen($file_name,'r');
	
	$filepath = './wikiextraction_query_2600.xml';
	$handle = fopen($filepath, "w+");
	
	echo "Open file for read and write...\r\n";
	while(!feof($fp))
	{
		
		
		
		$buffer=fgets($fp,4096);
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		
		
		
		wikiquery($buffer,$handle);
		
		
		
 	}
 	
	fclose($handle);
	fclose($fp);
	
	echo "Done with file read and write...\r\n";
	
	
	
function wiki3image($keyword,$handle){

	$imageUrls = wikipediaImageUrls('http://en.wikipedia.org/wiki/'.$keyword);

	$counter = 0;
	
	foreach ($imageUrls as &$value) {
		
		if (counter == 2){
			break;
		}
		fwrite($handle,"<Image>".$value."</Image>\r\n");
		$img = "./pic/".$keyword."_".$counter.".jpg";
		file_put_contents($img, file_get_contents($value));
		
		
   		 $counter++;
   	}

}



function wikiquery($keyword,$handle){

		
		$url = 'http://en.wikipedia.org/w/api.php?action=query&list=search&format=json&srlimit=3&srsearch='.$keyword;
		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
		$c = curl_exec($ch);

		$json = json_decode($c);

		$content = $json->{'query'}->{'search'}; // get the main text content of the query (it's parsed HTML)
		
		$length = sizeof($content);
		for($index = 0; $index < $length; $index++){
			$new_keyword = $content[$index]->{'title'};
			fwrite($handle,"<Name>".$content[$index]->{'title'}."</Name>\r\n");
			fwrite($handle,"<Desc>".$content[$index]->{'snippet'}."</Desc>\r\n");
			
		}
		wiki3image($new_keyword,$handle);
	


}

	
function wikisearch($keyword,$handle){

		fwrite($handle,"<Name>".$keyword."</Name>\r\n");
		
		$url = 'http://en.wikipedia.org/w/api.php?action=parse&page='.$keyword.'&format=json&prop=text&section=0';
		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, "test"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
		$c = curl_exec($ch);

		$json = json_decode($c);
		
		try{
		
		$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)

		// pattern for first match of a paragraph
		$pattern = '#<p>(.*)</p>#Us'; // http://www.phpbuilder.com/board/showthread.php?t=10352690
		if(preg_match($pattern, $content, $matches))
		{
 		   // print $matches[0]; // content of the first paragraph (including wrapping <p> tag)
  			 $content_2 = strip_tags($matches[1]); // Content of the first paragraph without the HTML tags.
			fwrite($handle,"<Desc>".$content_2."</Desc>\r\n");
		}
		
		}
		catch (Exception $e) {
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
		
		
}
		
		
		
function makeCall($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    return curl_exec($curl);
}

function wikipediaImageUrls($url) {
    $imageUrls = array();
    $pathComponents = explode('/', parse_url($url, PHP_URL_PATH));
    $pageTitle = array_pop($pathComponents);
    $imagesQuery = "http://en.wikipedia.org/w/api.php?action=query&titles={$pageTitle}&prop=images&format=json";
    $jsonResponse = makeCall($imagesQuery);
    $response = json_decode($jsonResponse, true);
    $imagesKey = key($response['query']['pages']);
    foreach($response['query']['pages'][$imagesKey]['images'] as $imageArray) {
        if($imageArray['title'] != 'File:Commons-logo.svg' && $imageArray['title'] != 'File:P vip.svg') {
            $title = str_replace('File:', '', $imageArray['title']);
            $title = str_replace(' ', '_', $title);
            $imageUrlQuery = "http://en.wikipedia.org/w/api.php?action=query&titles=Image:{$title}&prop=imageinfo&iiprop=url&format=json";
            $jsonUrlQuery = makeCall($imageUrlQuery);
            $urlResponse = json_decode($jsonUrlQuery, true);
            $imageKey = key($urlResponse['query']['pages']);
            $imageUrls[] = $urlResponse['query']['pages'][$imageKey]['imageinfo'][0]['url'];
        }
    }
    return $imageUrls;
}
?>


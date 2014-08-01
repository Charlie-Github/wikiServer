<?php 
//functions for retrieving images	

	//$file_name='./foodnames_keyformat_2600.txt';
	//$fp=fopen($file_name,'r');
	
	//$filepath = './wikiextraction_2600.txt';
	//$handle = fopen($filepath, "w+");
	echo "Open file for read and write...\r\n";
	//while(!feof($fp))
	{
		
		//$keyword=fgets($fp,4096);
		$keyword = "apple";
		$keyword = str_replace("\n", "", $keyword);
		$keyword = str_replace("\r", "", $keyword);
		
		echo $keyword."\r\n";
		
		wikisearch($keyword);//,$handle
		//wiki2image($keyword,$handle);
		
		
 	}
 	
	//fclose($handle);
	//fclose($fp);
	
	echo "Done with file read and write...\r\n";
	
	
	

	
function wikisearch($keyword){//,$handle

	//fwrite($handle,"<Name>".$keyword."</Name>\r\n");

	$url = 'http://en.wikipedia.org/w/api.php?action=opensearch&search='.$keyword.'&format=xml&limit=1';
	
	$ch = curl_init($url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "test"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$content = curl_exec($ch);
	
	parse_content_en($content);
	
}

function parse_content_en($content){
	
	$pattern_keyword = '#<Text xml:space=.preserve.>(.*)</Text>#Us';
	if(preg_match($pattern_keyword, $content, $matches_keyword))
	{
	   
		$content_keyword = strip_tags($matches_keyword[1]);
		echo $content_keyword."\r\n";
		
	}
	
	// pattern for first match of a paragraph
	$pattern = '#<Description xml:space=.preserve.>(.*)</Description>#Us';
	if(preg_match($pattern, $content, $matches))
	{
	   
		$content_desc = strip_tags($matches[1]);
		echo $content_desc."\r\n";
		//fwrite($handle,"<Desc>".$content_2."</Desc>\r\n");
	}
	
	search_zh($content_keyword);
	wiki2image($content_keyword);

}

function search_zh($keyword){
	
	$url = 'http://en.wikipedia.org/w/api.php?action=query&titles='.$keyword.'&prop=langlinks&lllimit=500&format=xml';
	
	$ch = curl_init($url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "test"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$content = curl_exec($ch);
	
	parse_content_zh($content);
	

}

function parse_content_zh($content){

	// pattern for first match of a paragraph
	$pattern_lang = '#<ll lang=.zh. xml:space=.preserve.>(.*)</ll>#Us';
	if(preg_match($pattern_lang, $content, $matches_lang))
	{
	   
		$content_keyword_zh = strip_tags($matches_lang[1]);
		echo $content_keyword_zh."\r\n";
		wikisearch_zh($content_keyword_zh);
	}
}

function wikisearch_zh($keyword_zh){
	$url = 'http://zh.wikipedia.org/w/api.php?action=opensearch&search='.$keyword_zh.'&format=xml&limit=1';
	
	$ch = curl_init($url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "test"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$content = curl_exec($ch);
	
	// pattern for first match of a paragraph
	$pattern = '#<Description xml:space=.preserve.>(.*)</Description>#Us';
	if(preg_match($pattern, $content, $matches))
	{
	   
		$content_desc = strip_tags($matches[1]);
		echo $content_desc."\r\n";
		//fwrite($handle,"<Desc>".$content_2."</Desc>\r\n");
	}




}



function wiki2image($keyword){//,$handle

	$imageUrls = wikipediaImageUrls('http://en.wikipedia.org/wiki/'.$keyword);

	$counter = 0;
	
	foreach ($imageUrls as &$value) {
		
		if($counter == 3){
			break;
		}
			echo $value."\r\n";
			//fwrite($handle,"<Image>".$value."</Image>\r\n");
			//$img = "./pic/".$keyword."_".$counter.".jpg";
			//file_put_contents($img, file_get_contents($value));
		
   		 $counter++;
   	}

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



function makeCall($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    return curl_exec($curl);
}
?>


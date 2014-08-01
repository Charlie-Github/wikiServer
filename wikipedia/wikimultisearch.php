<?php 
       
		
		$url = 'http://en.wikipedia.org/w/api.php?action=query&list=search&srwhat=text&format=json&srsearch=banana';
		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
		$c = curl_exec($ch);

		$json = json_decode($c);

		$content = $json->{'query'}->{'search'}; // get the main text content of the query (it's parsed HTML)
		
		//echo $content[0];
		//var_dump($content);
		echo $content[4]->{'title'};

		/*
		// pattern for first match of a paragraph
		$pattern = '#<p ns="0" title=(.*)snippet#Us'; // http://www.phpbuilder.com/board/showthread.php?t=10352690
		if(preg_match($pattern, $content,$matches))
		{
 		   // print $matches[0]; // content of the first paragraph (including wrapping <p> tag)
  		  print strip_tags($matches[1]); // Content of the first paragraph without the HTML tags.
		}
		*/
	
?>
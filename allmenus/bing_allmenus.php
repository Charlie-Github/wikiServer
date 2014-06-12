<?php

$translator = new BingTranslation('edible_translator','11111111111111111111');
$from='en';
$to='zh';

	
$inputPath = './foods_iowacity.xml';
$inputHandle = fopen($inputPath, "r");

$outputPath = './foods_iowacity_chinese.txt';
$outputHandle = fopen($outputPath, "w+");


	while(!feof($inputHandle))
	{
		$buffer=fgets($inputHandle,4096);
		
		
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		$buffer = str_replace("_", " ", $buffer);
		
		$pattern = '#<Image>(.*)</Image>#Us';
		$patternName = '#<Name>(.*)</Name>#Us';
		$patternDesc = '#<Desc>(.*)</Desc>#Us';
		
		if(preg_match($pattern,$buffer)){
			continue;//skip image url
		}
		
		if(preg_match($patternName,$buffer)){
			$buffer = str_replace("<Name>", "", $buffer);
			$buffer = str_replace("</Name>", "", $buffer);
			
			echo $buffer."\r\n";
			$transword = "<ENName>".$buffer. "</ENName>\r\n";
			fwrite($outputHandle,$transword);
			
			$word = urlencode($buffer);
			
			$transword = "<ZHName>".$translator->translate($word, $from, $to) . "</ZHName>\r\n";

			fwrite($outputHandle,$transword);
			
		}
		
		if(preg_match($patternDesc,$buffer)){
			$buffer = str_replace("<Desc>", "", $buffer);
			$buffer = str_replace("</Desc>", "", $buffer);
			
			$word = urlencode($buffer);
			$transword ="<Desc>".$translator->translate($word, $from, $to)."</Desc>\r\n";
			fwrite($outputHandle,$transword);
			
		}
		
		
		
		
		
		
		
		

 	}
	fclose($inputHandle);
	fclose($outputHandle);





//-------------------bing translation class
class BingTranslation
{
    public $clientID;
    public $clientSecret;

    public function __construct($cid, $secret)
    {
        $this->clientID = $cid;
        $this->clientSecret = $secret;
    }

    public function get_access_token()
    {   
        //if access token is not expired and is stored in COOKIE
        if(isset($_COOKIE['bing_access_token']))
            return $_COOKIE['bing_access_token'];

        // Get a 10-minute access token for Microsoft Translator API.
        $url = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';
        $postParams = 'grant_type=client_credentials&client_id='.urlencode($this->clientID).
        '&client_secret='.urlencode($this->clientSecret).'&scope=http://api.microsofttranslator.com';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $rsp = curl_exec($ch); 
        $rsp = json_decode($rsp);
        $access_token = $rsp->access_token;

        //setcookie('bing_access_token', $access_token, $rsp->expires_in);

        return $access_token;
    }

    public function translate($word, $from, $to)
    {
        $access_token = $this->get_access_token();
        $url = 'http://api.microsofttranslator.com/V2/Http.svc/Translate?text='.$word.'&from='.$from.'&to='.$to;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:bearer '.$access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $rsp = curl_exec($ch); 
        preg_match_all('/<string (.*?)>(.*?)<\/string>/s', $rsp, $matches);

        return $matches[2][0];
    }


}
?>
		
		
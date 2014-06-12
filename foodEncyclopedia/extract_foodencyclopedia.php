<?php 


$url = 'http://www.foodterms.com/encyclopedia/alitame/index.html';
$contents = file_get_contents($url);

$contents = str_replace("\r","",$contents);
$contents = str_replace("\n","",$contents);

$desc_pattern = '#<p class=\'term-note-item\'>.*<p class=\'copyright crumb\'#';
$pattern_2 = '#<p>.*</p>#';

preg_match($desc_pattern,$contents,$match);

preg_match($pattern_2,$match[0],$match);

$str = mb_convert_encoding($match[0], 'UTF-8', 'HTML-ENTITIES');

$str = str_replace("<p>","",$str);
$str = str_replace("</p>","",$str);

echo $str;


?>
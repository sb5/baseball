
<?php

//add cgi script in order to run this every so often
$urls = array('list_pitchers=1','list_games=1','list_pitchers_by_id='.rand(0,99999));

 
function get_data($url) {
$header =(get_headers($url, 1));
return $header;
 
}

foreach($urls as $urlkey=>$urlval){
$headersarray[$urlval]= get_data('http://www.stephenbreighner.com/bball/index.php?'.$urlval);

}



$file = 'status.txt';
 
$current = file_get_contents($file);
 $i=1;
 
foreach($headersarray as $headerkey=>$headerval){
$current .=  $headerkey.": ".$headerval['0'].", Date: ".$headerval['Date']."\n ";

 

 
}

 
file_put_contents($file, $current);
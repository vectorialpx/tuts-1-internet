<?php

// ping google.com

$host = 'https://www.google.com';
$port = 80;
$waitTimeoutInSeconds = 1;
if($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)){
   var_dump('Yey!');
} else {
   var_dump('Error:', $errCode, $errStr);
}
fclose($fp);

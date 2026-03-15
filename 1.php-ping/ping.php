<?php
/**
 * Ping a server, or google.com by default
 * 
 * Usage:
 * > ping.php yahoo.com 80
 */

// ?? is a null-safe operator,
// if $argv[1] is not set, host will become 'google.com'
$host = $argv[1] ?? 'google.com';

// same for port, if $argv[2] is not set, port will be 80
$port = $argv[2] ?? 80;

$waitTimeoutInSeconds = 1;

echo "\nStarting ping...";

if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
   echo "\nPong! From {$host}, port {$port}";
} else {
   echo "\nError!";
   var_dump('Code', $errCode, 'Details', $errStr);
}

fclose($fp);

echo "\n\nEnd!\n";

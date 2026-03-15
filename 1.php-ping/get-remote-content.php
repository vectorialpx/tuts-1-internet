<?php
/**
 * Get content from another server
 * 
 * Usage:
 * > get-remote-content.php https://www.bbc.com 500
 */

$remoteUrl = $argv[1] ?? 'https://www.bbc.com';
$maxChars = intval($argv[2] ?? 0);

// works only if you have `allow_url_fopen` true
$contentViaFileGetContents = file_get_contents($remoteUrl);

echo "\nExtracted " . strlen($contentViaFileGetContents) . " characters via file_get_contents";

echo "\nContent:\n".($maxChars
    ? substr($contentViaFileGetContents, 0, $maxChars)
    : $contentViaFileGetContents);

echo "\n------\n";

print_r(get_web_page($remoteUrl, $maxChars));

// https://stackoverflow.com/questions/14953867/how-to-get-page-content-using-curl
function get_web_page(string $url, int $maxChars): array
{
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_FORBID_REUSE   => true,
        );

        $ch      = curl_init( $url );
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err     = curl_errno($ch);
        $errmsg  = curl_error($ch);
        $result  = curl_getinfo($ch);

        $result['errno']   = $err;
        $result['errmsg']  = $errmsg;
        $result['content'] = $maxChars ? substr($content, 0, $maxChars) : $content;

        return $result;
    }
echo "\n\nEnd!\n";

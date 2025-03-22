<?php
header("Content-Type: application/vnd.apple.mpegurl"); // Correct MIME type for M3U8
header("Access-Control-Allow-Origin: *"); // Allow cross-origin access
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Content-Disposition: inline; filename=playlist.m3u8");

// Get the id parameter from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id)) {
    die("# Error: ID parameter is missing\n");
}

// Fetch the M3U8 content
$m3u8_url = "https://8088y.site/Api/JioTV/app/ts_live_$id.m3u8";
$m3u8_content = @file_get_contents($m3u8_url);

if ($m3u8_content === false) {
    die("# Error: Unable to fetch M3U8 file\n");
}

// Define base URLs for replacement
$base_url_1 = "https://8088y.site/Api/JioTV/app/";
$base_url_2 = "https://8088y.site/";

// Replace stream.php links with full URLs
$m3u8_content = preg_replace_callback('/(stream\.php\?[^"\s]+)/', function ($matches) use ($base_url_1, $base_url_2) {
    return $base_url_1 . $matches[1]; // Assuming API path is correct
}, $m3u8_content);

// Ensure proper content length for better compatibility
header("Content-Length: " . strlen($m3u8_content));

// Output the modified M3U8 content
echo $m3u8_content;
?>

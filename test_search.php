<?php
$address = "Mandiri Beach, Jl. Wisata Mandiri, Sejati, Kec. Krui Sel., Kabupaten Pesisir Barat, Lampung 34874";
$url = "https://www.google.com/search?q=" . urlencode($address);
echo "Fetching Google Search: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

$html = curl_exec($ch);
curl_close($ch);

file_put_contents('google_search.html', $html);
echo "Written search html to google_search.html. Size: " . strlen($html) . " bytes\n";

// Search for coordinates. Mandiri Beach is -5.2484818, 103.9650851
// Let's search for "103.96" or "-5.24"
if (preg_match('/-5\.24\d*/', $html, $matches)) {
    echo "Found lat pattern: {$matches[0]}\n";
}
if (preg_match('/103\.96\d*/', $html, $matches)) {
    echo "Found lng pattern: {$matches[0]}\n";
}

// Search for staticmap center or coordinates inside URLs:
// e.g. center=... or ll=... or q=...
// Matches patterns like -5.xxxx,103.xxxx
preg_match_all('/(-5\.\d{5,8}),\s*(103\.\d{5,8})/', $html, $matchesAll);
print_r($matchesAll[0]);

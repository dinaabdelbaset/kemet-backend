<?php
header('Content-Type: text/plain');
$ch = curl_init("http://localhost:8000/hotels/redsea.png");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true); // only fetch headers
curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "Status Code for hotels/redsea.png: " . $code . "\n";

<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://muscle-group-image-generator.p.rapidapi.com/getBaseImage?transparentBackground=0",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: muscle-group-image-generator.p.rapidapi.com",
		"x-rapidapi-key: af63ccdbe7mshc57206ec31da19ep1a3ce2jsn4f59643dcf7c"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
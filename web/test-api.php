<?php
    $data = [
        "location" => 1
    ];

    $jsonData = json_encode($data);

    $curl = curl_init("https://192.168.1.40/api/v1/banner/list-banner");
    
    // Set cURL options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

    // To handle self-signed SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    // Debugging options
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "Error: " . curl_error($curl);
    }
    
    curl_close($curl);
    
    return json_decode($response, true);
?>
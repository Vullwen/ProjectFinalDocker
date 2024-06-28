<?php

function callAPI($method, $url, $data = false, $headers = [])
{
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Set the URL and other options
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // Add headers if provided
    if (!empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    // Set options to catch errors
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    // Execute the request
    $result = curl_exec($curl);

    // Check for errors
    if ($result === false) {
        $error = curl_error($curl);
        curl_close($curl);
        error_log("Connection Failure: " . $error);
        die("Connection Failure: " . $error);
    }

    curl_close($curl);

    return $result;
}




<?php
function fetch_api($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($http_code == 200) {
        return json_decode($response, true);
    } else {
        error_log("Lỗi fetch API: HTTP $http_code - $error - URL: $url");
        return false;
    }
}

function fix_image_url($url) {
    if (empty($url)) {
        error_log("URL trống: " . $url);
        return 'https://via.placeholder.com/200x300?text=No+Image';
    }
    if (!preg_match('/^http(s)?:\/\//', $url) && !str_contains($url, 'img.ophim.live')) {
        $url = 'https://img.ophim.live/uploads/movies/' . $url;
        error_log("Ghép URL đầy đủ: " . $url);
    } elseif (!preg_match('/^http(s)?:\/\//', $url)) {
        $url = 'https:' . $url;
        error_log("Thêm https: cho URL: " . $url);
    }
    return $url;
}

function get_proxy_image($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $image_data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($http_code == 200) {
        $base64 = 'data:image/jpeg;base64,' . base64_encode($image_data);
        error_log("Proxy image success for URL: $url");
        return $base64;
    } else {
        error_log("Proxy image failed for URL: $url - HTTP $http_code - $error");
        return 'https://via.placeholder.com/200x300?text=Proxy+Error';
    }
}
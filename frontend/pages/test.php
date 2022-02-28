<?php

public function stripUrlPath($url){
    $urlParts = parse_url($url);
    $newUrl = $urlParts['scheme'] . "://" . $urlParts['host'] . "/";
    return $newUrl;
}

var_dump($_SERVER['HTTP_HOST']);
?>
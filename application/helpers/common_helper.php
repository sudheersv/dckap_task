<?php
function getLocalTimeStamp() {
    date_default_timezone_set('Asia/Kolkata');

    return date('Y-m-d H:i:s');
}

function pr($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function vdump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

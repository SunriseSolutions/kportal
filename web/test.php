<?php

echo json_encode('http://www.imagefully.com/wp-content/uploads/2015/07/Blue-Eyes-Hot-Girl-Hd-Wallpaper.jpg');

$timestamp = base_convert((string)date_timestamp_get(new DateTime()), 10, 32);

for ($i = 0; $i < 16 - strlen($timestamp);) {
    $timestamp = '0' . $timestamp;
}

$tsStr = substr(chunk_split($timestamp, 4, "-"), 0, -1);

//        $tsArray = explode(';;', $tsStr);


$id = generate4DigitCode() .
    '-' . $tsStr
; // base_convert($this->id, 10, 32)

$tsArray = explode(';;', $tsStr);


var_dump($timestamp);
var_dump($tsStr);
var_dump($tsArray);
var_dump($id);


function generate4DigitCode($code = null)
{
    if ($code === null) {
        $code = base_convert(rand(0, 1048575), 10, 32);
    }
    for ($i = 0; $i < 4 - strlen($code);) {
        $code = '0' . $code;
    }
    return $code;
}
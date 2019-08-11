<?php
function _pseudo_rand($length)
{
    if (function_exists('openssl_random_pseudo_bytes')) {
        $is_strong = false;
        $rand = openssl_random_pseudo_bytes($length, $is_strong);
        if ($is_strong === true) return $rand;
    }
    $rand = '';
    $sha = '';
    for ($i = 0; $i < $length; $i++) {
        $sha = hash('sha256', $sha . mt_rand());
        $chr = mt_rand(0, 62);
        $rand .= chr(hexdec($sha[$chr] . $sha[$chr + 1]));
    }
    return $rand;
}

function create_salt()
{
    $salt = _pseudo_rand(128);
    return substr(preg_replace('/[^A-Za-z0-9_]/is', '.', base64_encode($salt)), 0, 21);
}

function create_hash($passwdInput, $passwdSalt)
{
    return crypt($passwdInput, $passwdSalt);
}

function validate_hash($passwdInput, $passwdHash, $passwdSalt)
{
    return $passwdHash == crypt($passwdInput, $passwdSalt);
}

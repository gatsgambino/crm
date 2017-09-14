<?php

function letters_only($str)
{
    if (!preg_match('/\d/', $str) && !preg_match('/[^a-zA-Z\d]/', $str)) {
        return true;
    } else {
        return false;
    }
}

// check if string contains alphanumeric and special chars
function validate_pwd($str)
{
    if (strlen($str) > 7 && preg_match('/[a-zA-Z]/', $str) && preg_match('/\d/', $str) && preg_match('/[^a-zA-Z\d]/', $str)) {
        return true;
    } else {
        return false;
    }
}

// create random string with given param to define length
function random_str($limit = null)
{
    $param = str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
    $str   = (!empty($limit)) ? substr($param, 0, $limit) : substr($param, 0, 32) ;
    return $str;
}

function html($string) {
    return htmlspecialchars(str_replace("&#39;", "'", $string));
}
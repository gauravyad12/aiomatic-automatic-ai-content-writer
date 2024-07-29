<?php
function readability_mb_strlen($string, $encoding = null)
{
    if(empty($encoding) || trim($encoding) == '')
    {
        $encoding = null;
    }
    if(function_exists('mb_strlen'))
    {
        error_reporting(0);
        $func_val = mb_strlen($string, $encoding);
        error_reporting(E_ALL);
        return $func_val;
    }
    else
    {
        return strlen($string);
    }
}
function readability_mb_chr($codepoint, $encoding = null)
{
    if(empty($encoding) || trim($encoding) == '')
    {
        $encoding = null;
    }
    if(function_exists('mb_chr'))
    {
        error_reporting(0);
        $func_val = mb_chr($codepoint, $encoding);
        error_reporting(E_ALL);
        return $func_val;
    }
    else
    {
        return chr($codepoint);
    }
}
function readability_mb_strtolower($string, $encoding = null)
{
    if(empty($encoding) || trim($encoding) == '')
    {
        $encoding = null;
    }
    if(function_exists('mb_strtolower'))
    {
        error_reporting(0);
        $func_val = mb_strtolower($string, $encoding);
        error_reporting(E_ALL);
        return $func_val;
    }
    else
    {
        return strtolower($string);
    }
}
function readability_mb_stripos($haystack, $needle, $offset = 0, $encoding = null)
{
    if(empty($encoding) || trim($encoding) == '')
    {
        $encoding = null;
    }
    if(function_exists('mb_stripos'))
    {
        error_reporting(0);
        $func_val = mb_stripos($haystack, $needle, $offset, $encoding);
        error_reporting(E_ALL);
        return $func_val;
    }
    else
    {
        return stripos($haystack, $needle, $offset);
    }
}
?>
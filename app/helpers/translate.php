<?php

/**
 * Translate helper
 */

function translate(String $string, Array $translations) : String
{
    return $translations[strtolower($string)] ?? $string;
}
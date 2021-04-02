<?php

function format_money($value) {
	return number_format($value, 0, '', '.') . ' đ';
}

function getLocaleValue($value, $localeCode = null){
    if ($localeCode == null) {
        $localeCode = LaravelLocalization::getCurrentLocale();
    }
    $pattern = "/\[:{$localeCode}\]([^\[]+)\[:/";
    preg_match($pattern, $value, $matches);
    if (isset($matches[1])) return $matches[1];
    else return '';
}

if (! function_exists('str_words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function str_words($value, $words = 100, $end = ' ...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

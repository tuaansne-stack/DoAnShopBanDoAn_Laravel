<?php

/**
 * Helper functions converted from config/config.php
 */

if (!function_exists('format_currency')) {
    /**
     * Format currency
     */
    function format_currency($amount)
    {
        return number_format($amount, 0, ',', '.') . ' đ';
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text
     */
    function truncate_text($text, $limit = 100)
    {
        if (strlen($text) <= $limit) {
            return $text;
        }
        $text = substr($text, 0, $limit);
        return $text . '...';
    }
}

if (!function_exists('create_slug')) {
    /**
     * Create slug from Vietnamese string
     */
    function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#[^a-z0-9\s]#i',
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            '',
        );
        $string = preg_replace($search, $replace, mb_strtolower($string, 'UTF-8'));
        $string = preg_replace('/[\s]+/', '-', trim($string));
        return $string;
    }
}


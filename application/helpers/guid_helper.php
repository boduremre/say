<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('GUID')) {
    /**
     * @return string
     */
    function GUID(): string
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
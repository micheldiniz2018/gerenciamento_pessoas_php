<?php
namespace app\helpers;

class Uri
{   /**
     * Get the uri.
     */
    public static function get(string $type):string
    {
        return parse_url($_SERVER['REQUEST_URI'])[$type];
    }
}
<?php
namespace app\helpers;

class Request
{
    /**
     * Get the type requisition.
     */
    public static function get():string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
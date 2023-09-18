<?php

namespace App\Helpers;

class ErrorFormatter
{
    public static function format($errors)
    {
        $result = [];
        foreach ($errors as $key => $message) {
            $result[] = [
                'key' => $key,
                'message' => $message[0]
            ];
        }
        return $result;
    }

    public static function getFirstArrayItem($firstErrors)
    {
        foreach ($firstErrors as $firstError) {
            return $firstError;
        }
        return "";
    }
}

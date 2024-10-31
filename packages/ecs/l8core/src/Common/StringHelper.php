<?php

namespace  Ecs\L8Core\Common;

class StringHelper
{
    public static function mb_trim($str)
    {
        $str = preg_replace("/^[\s]+/u", '', $str);

        return preg_replace("/[\s]+$/u", '', $str);
    }

    public static function escapeBeforeSearch($str)
    {
        return str_replace('_', '\_', str_replace('%', '\%', str_replace('\\', '\\\\', $str)));
    }

    public static function randomStr($length = 6)
    {
        $string = "";
        $alpha  = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        for ($i = 0; $i < $length; $i++) {
            $string .= $alpha[rand(0, strlen($alpha)-1)];
        }

        return $string;
    }

    public static function randomNumber($length)
    {
        $string = "";
        $alpha  = "0123456789";

        for ($i = 0; $i < $length; $i++) {
            $string .= $alpha[rand(0, strlen($alpha)-1)];
        }

        return $string;
    }
}

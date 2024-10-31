<?php

namespace  Ecs\L8Core\Common;

class Phone
{
    public static function formatBeforeHandle($phone)
    {
        return '+' . $phone;
    }
}

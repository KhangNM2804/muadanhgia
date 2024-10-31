<?php

namespace Ecs\L8Core\Exceptions;

use Ecs\L8Core\Core\BaseException;

class RepositoryException extends BaseException
{
    public static function invalidMethod()
    {
        return self::code('repository.invalid_method');
    }

    public static function invalidModel()
    {
        return self::code('repository.invalid_model');
    }
}

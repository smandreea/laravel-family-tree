<?php

namespace App\Exceptions;

use Exception;

class InvalidFamilyMember extends Exception
{
    public static function invalidFamilyMember()
    {
        return 'You need a parent in order to add a child.';
    }
}

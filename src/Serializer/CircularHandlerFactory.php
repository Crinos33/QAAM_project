<?php

namespace App\Serializer;

use Closure;

class CircularHandlerFactory
{
    /**
     * @return Closure
     */
    public static function getId()
    {
        return function ($object){
            return $object->getId();
        };

    }
}


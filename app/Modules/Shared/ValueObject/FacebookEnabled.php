<?php

namespace App\Modules\Shared\ValueObject;

class FacebookEnabled
{
    public function __construct(public bool $enabled)
    {
    }
}

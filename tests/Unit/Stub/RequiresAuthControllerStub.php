<?php

namespace App\Tests\Unit\Stub;

use App\Attribute\RequiresAuth;

class RequiresAuthControllerStub
{
    public function public()
    {
    }

    #[RequiresAuth]
    public function protected()
    {
    }
}
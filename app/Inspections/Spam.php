<?php

namespace App\Inspections;

use Exception;
use App\Inspections\KeyHeldDown;
use App\Inspections\InvalidKeywords;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    public function detect($body)
    {
        // foreach ($this->keywords as $keyword) {
            if (in_array($body, $this->keywords) == true) {
                throw new Exception("Your reply contains spam");
            }
        // }
    }
}
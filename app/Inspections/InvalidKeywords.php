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
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) == false) {
                throw new Exception("Your reply contains spam");
            }
        }
    }
    
    protected function detectInvalidKeywords($body)
    {

    }

    protected function detectKeyHeldDown($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception("Your reply contains spam");
        }
    }
}
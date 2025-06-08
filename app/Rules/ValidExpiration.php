<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidExpiration implements Rule
{
    protected $customMessage;

    public function __construct($customMessage = null)
    {
        $this->customMessage = $customMessage;
    }

    public function passes($attribute, $value)
    {
        return $this->isValidDate($value);
    }

    public function message()
    {
        return $this->customMessage ?: 'The :attribute must be a valid date or "N/A".';
    }

    private function isValidDate($value)
    {   
        if(empty($value)){
            return true;
        } 
        
        return strtotime($value) !== false && date('Y-m-d', strtotime($value)) === $value;
    }
}


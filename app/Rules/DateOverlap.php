<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DateOverlap implements Rule
{
    private $roomId;
    private $checkInDate;
    private $checkOutDate;
    private $id;

    public function __construct($roomId, $checkInDate, $checkOutDate, $id = null)
    {
        $this->roomId = $roomId;
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->id = $id; 
    }

    public function passes($attribute, $value)
    {
        $checkIn = date_create($this->checkInDate);
        $checkOut = date_create($this->checkOutDate);
        
        $ocuppied = DB::table('reservations')
            ->where('room_id', $this->roomId)
            ->where('id', '!=', $this->id) 
            ->where('status', '!=', 0) 
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where(function($query) use ($checkIn, $checkOut) {
                    $query->where('check_in_date', '<=', $checkOut)
                          ->where('check_out_date', '>', $checkIn);
                });
            })
            ->exists(); 

        return !$ocuppied;
    }

    public function message(){
        return __('rules.dates_occupied');
    }
}


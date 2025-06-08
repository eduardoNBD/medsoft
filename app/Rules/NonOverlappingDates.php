<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NonOverlappingDates implements Rule
{
    private $roomId;
    private $startDate;
    private $endDate;
    private $id;
    private $message;

    public function __construct($roomId, $startDate, $endDate, $id = null, $message = null)
    {
        $this->roomId = $roomId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->id = $id; 
        $this->message = $message ?? 'The dates overlap with an existing range.';
    }

    public function passes($attribute, $value)
    {
        $start = date_create_from_format('m-d', substr($this->startDate,5));
        $end = date_create_from_format('m-d', substr($this->endDate,5));

        if ($end < $start) {
            $end->modify('+1 year');
        }
 
        $dates = DB::table('special_dates')
            ->where('room_id', $this->roomId)
            ->where('id', '!=', $this->id)
            ->get(['start_date', 'end_date']);

        foreach ($dates as $date) { 
            $existingStart = date_create_from_format('m-d', $date->start_date);
            $existingEnd = date_create_from_format('m-d', $date->end_date);
            
            if ($existingEnd < $existingStart) {
                $existingEnd->modify('+1 year');
            }
            
            if (($start <= $existingEnd && $end >= $existingStart) || ($existingStart <= $end && $existingEnd >= $start)) {
                return false;
            }
        } 

        return true;
    }

    public function message()
    {
        return __('rules.non_overlapping_dates');
    }
}

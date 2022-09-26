<?php

namespace EventManagementSystem\App\Http\Requests;

use EventManagementSystem\Framework\Foundation\RequestGuard;

class EventRequest extends RequestGuard
{
    public static $rules = [
        'title' => 'required',
        'location' => 'required',
        'startingDate' => 'required',
        'startingTime'  => 'required',
        'endingDate' => 'required',
        'endingTime' => 'required',
        'limit' =>  'required',
        'location' => 'required',
        'deadline' =>   'required'

    ];

    public static $messages = [
        'title.required' => "Title is required",
        'location.required' => "Location is required",
        'startingDate.required' => "Starting date  is required",
        'startingTime.required' => "Starting time  is required",
        'endingDate.required' => "Ending date is required",
        'endingTime.required' => "Ending time is required",
        'limit.required'    => "Limit is required",
        'location.required'    => "Event location is required",
        'deadline.required'    => "Deadline required",
    ];
}

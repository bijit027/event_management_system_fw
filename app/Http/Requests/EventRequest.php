<?php

namespace EventManagementSystem\App\Http\Requests;

use EventManagementSystem\Framework\Foundation\RequestGuard;

class EventRequest extends RequestGuard
{
    public static $rules = [
        'title' => 'required',
        'location' => 'required',
        'startingDate' => 'required',
        'endingDate' => 'required'
    ];

    public static $messages = [
        'title.required' => "Title is required",
        'location.required' => "Location is required",
        'startingDate.required' => "Starting date  is required",
        'endingDate.required' => "Ending date is required",
    ];
}

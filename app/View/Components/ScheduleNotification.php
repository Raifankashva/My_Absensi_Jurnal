<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\Schedule;

class ScheduleNotification extends Component
{
    public $schedules;
    public $currentDay;
    public $currentTime;

    public function __construct()
    {
        $this->currentDay = Carbon::now()->format('l');
        $this->currentTime = Carbon::now()->format('H:i');
        
        // Assuming you have a Schedule model with day, time, and title columns
        $this->schedules = Schedule::where('day', $this->currentDay)
            ->orderBy('time')
            ->get();
    }

    public function render()
    {
        return view('components.schedule-notification');
    }
}
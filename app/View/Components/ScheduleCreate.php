<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class ScheduleCreate extends Component
{
    public function render()
    {
        return view('components.schedule-create');
    }
    public function boot()
{
    Blade::component('schedule-create', ScheduleCreate::class);
}
}
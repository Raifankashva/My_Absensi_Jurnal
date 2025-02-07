<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        Schedule::create($validated);

        return redirect()->back()->with('success', 'Schedule created successfully!');
    }
}
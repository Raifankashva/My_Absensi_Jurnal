<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Ambil semua data tugas
        $tasks = Task::orderBy('due_date', 'asc')->get();

        // Kirim data ke view dashboard admin
        return view('admin.dashboard', compact('tasks'));
    }
}

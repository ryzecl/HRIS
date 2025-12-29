<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::count();
        $department = Department::count();
        $payroll = Payroll::count();
        $presence = Presence::count();

        $tasks = Task::with('employee')->has('employee')->latest()->take(5)->get();

        return view('dashboard.index', compact('employee', 'department', 'payroll', 'presence', 'tasks'));
    }
}

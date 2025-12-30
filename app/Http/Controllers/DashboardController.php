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

    public function presence()
    {
        $data = Presence::where('status', 'present')
            ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
            ->groupBy('month', 'year')
            ->orderBy('month', 'asc')
            ->get();

        // Inisialisasi array 12 bulan dengan nilai 0
        $result = array_fill(0, 12, 0);

        // Isi data ke posisi bulan yang benar (index 0 = January, index 11 = December)
        foreach ($data as $item) {
            $result[$item->month - 1] = $item->total_present;
        }

        return response()->json($result);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }

        // dd($tasks);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit(Task $task)
    {
        $employees = Employee::all();
        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function done(int $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'status' => 'done',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done successfully');
    }

    public function pending(int $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'status' => 'pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending successfully');
    }

    public function show(Task $task)
    {
        $employees = Employee::all();
        return view('tasks.show', compact('task', 'employees'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}

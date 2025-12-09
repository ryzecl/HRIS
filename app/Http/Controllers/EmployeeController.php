<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|max:255',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required',
            'role_id' => 'required',
            'status' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'departments', 'roles'));
    }

    public function update(Employee $employee, Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|max:255',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required',
            'role_id' => 'required',
            'status' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    public function show(Employee $employee)
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.show', compact('employee', 'departments', 'roles'));
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}

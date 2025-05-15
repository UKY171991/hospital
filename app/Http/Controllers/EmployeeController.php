<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // You can pass employees data here later
        return view('employee_manage');
    }

    public function create()
    {
        return view('employee_form');
    }

    public function store(Request $request)
    {
        // TODO: Implement employee creation logic here
        return redirect()->route('employee.manage')->with('success', 'Employee created successfully.');
    }
}

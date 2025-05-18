<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = \App\Models\Employee::with('hospital')->get();
        return view('employee_manage', compact('employees'));
        return view('employee_manage');
    }

    public function create()
    {
        return view('employee_form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'relative_name' => 'nullable|string|max:255',
            'mobile_no' => 'required|string|max:15',
            'alternate_mobile_no' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:employees,email',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'aadhar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'experience_year' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'role' => 'required|string',
            'department' => 'required|string',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:20',
            'account_holder_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:20',
            'opening_balance' => 'nullable|numeric',
            'salary' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        \App\Models\Employee::create($validatedData);
        return redirect()->route('employee.manage')->with('success', 'Employee created successfully.');
    }
}

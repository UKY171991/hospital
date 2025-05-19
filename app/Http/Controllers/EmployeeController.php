<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = \App\Models\Employee::with('hospital')->get();
        return view('employee_manage', compact('employees'));
    }
    public function edit($id)
    {
        $employee = \App\Models\Employee::findOrFail($id);
        $hospitals = \App\Models\Hospital::all();
        return view('employee_form', compact('employee', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'relative_name' => 'nullable|string|max:255',
            'mobile_no' => 'required|string|max:15',
            'alternate_mobile_no' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:employees,email,' . $id,
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

        $employee = \App\Models\Employee::findOrFail($id);
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }
        $employee->update($validatedData);
        return redirect()->route('employee.manage')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = \App\Models\Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.manage')->with('success', 'Employee deleted successfully.');
    }

    public function create()
    {
        $hospitals = \App\Models\Hospital::all();
        return view('employee_form', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'relative_name' => 'nullable|string|max:255',
            'mobile_no' => ['required', 'regex:/^[0-9]{10}$/'],
            'alternate_mobile_no' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'email' => 'required|email|unique:employees,email',
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'position' => 'required|string|max:255',
            'hospital_id' => 'required|integer|exists:hospitals,id',
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

    public function show($id)
    {
        $employee = \App\Models\Employee::with('hospital')->findOrFail($id);
        return response()->json($employee);
    }
}

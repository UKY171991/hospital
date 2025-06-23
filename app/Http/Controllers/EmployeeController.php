<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return $row->photo ? '<img src="/storage/employee_photos/' . $row->photo . '" class="img-thumbnail" style="max-width:60px;">' : '<span class="text-muted">No Photo</span>';
                })
                ->addColumn('status', function($row){
                    $icon = $row->status === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                    $nextStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<a href="#" class="toggleStatus" data-id="'.$row->id.'" data-status="'.$nextStatus.'"><i class="fas '.$icon.'"></i></a>';
                })
                ->addColumn('action', function($row){
                    return '<div class="btn-group" role="group">'
                        .'<button type="button" class="btn btn-sm btn-info editBtn" data-id="'.$row->id.'" title="Edit">'
                        .'<i class="fas fa-edit"></i></button>'
                        .'<button type="button" class="btn btn-sm btn-primary viewBtn" data-id="'.$row->id.'" title="View">'
                        .'<i class="fas fa-eye"></i></button>'
                        .'<button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'" title="Delete">'
                        .'<i class="fas fa-trash"></i></button>'
                        .'</div>';
                })
                ->rawColumns(['photo','status','action'])
                ->make(true);
        }
        return view('employee.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'relative_name' => 'nullable|string|max:255',
            'mobile_no' => 'required|string|max:255',
            'alternate_mobile_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'aadhar_no' => 'nullable|string|max:255',
            'pan_no' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:20',
            'education' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'experience_year' => 'nullable|string|max:10',
            'role' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'salary_per_day' => 'required|numeric',
            'opening_balance' => 'nullable|numeric',
            'status' => 'nullable|string|max:50',
        ]);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee_photos', 'public');
            $data['photo'] = basename($path);
        }
        Employee::create($data);
        return response()->json(['success' => true, 'message' => 'Employee created successfully.']);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $employee->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'relative_name' => 'nullable|string|max:255',
            'mobile_no' => 'required|string|max:255',
            'alternate_mobile_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'aadhar_no' => 'nullable|string|max:255',
            'pan_no' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:20',
            'education' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'experience_year' => 'nullable|string|max:10',
            'role' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'salary_per_day' => 'required|numeric',
            'opening_balance' => 'nullable|numeric',
            'status' => 'nullable|string|max:50',
        ]);
        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete('employee_photos/'.$employee->photo);
            }
            $path = $request->file('photo')->store('employee_photos', 'public');
            $data['photo'] = basename($path);
        }
        $employee->update($data);
        return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        if ($employee->photo) {
            Storage::disk('public')->delete('employee_photos/'.$employee->photo);
        }
        $employee->delete();
        return response()->json(['success' => true, 'message' => 'Employee deleted successfully.']);
    }

    public function toggleStatus($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Employee status updated successfully.'
        ]);
    }
}

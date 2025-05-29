<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Doctor;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Attendance::query();
            if ($request->type) {
                $query->where('type', $request->type);
            }
            if ($request->from_date) {
                $query->where('date', '>=', $request->from_date);
            }
            if ($request->to_date) {
                $query->where('date', '<=', $request->to_date);
            }
            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('name', function($row) {
                    if ($row->type === 'Doctor Wise') {
                        $doctor = \App\Models\Doctor::find($row->reference_id);
                        return $doctor ? $doctor->name : '';
                    } else {
                        $employee = \App\Models\Employee::find($row->reference_id);
                        return $employee ? $employee->name : '';
                    }
                })
                ->make(true);
        }
        return view('attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('AttendanceController@store called', $request->all());
        $data = $request->validate([
            'type' => 'required',
            'duty_type' => 'required',
            'date' => 'required|date',
            'reference_id' => 'required|integer',
            'amount' => 'required|numeric',
            'duty_chart_no' => 'required|string',
        ]);
        // Lookup name from Employee or Doctor
        if ($request->type === 'Doctor Wise') {
            $person = Doctor::find($request->reference_id);
        } else {
            $person = Employee::find($request->reference_id);
        }
        $data['name'] = $person ? $person->name : '';
        \Log::info('Attendance store request', $data);
        if (empty($data['name'])) {
            return response()->json(['message' => 'Employee/Doctor name is required.'], 422);
        }
        Attendance::create($data);
        return response()->json(['success' => true, 'message' => 'Attendance added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function employees()
    {
        $employees = Employee::select('id', 'name')->get();
        return response()->json($employees);
    }

    public function doctors()
    {
        $doctors = Doctor::select('id', 'name')->get();
        return response()->json($doctors);
    }
}

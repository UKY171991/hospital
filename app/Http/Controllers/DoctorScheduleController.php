<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Models\Doctor;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $schedules = DoctorSchedule::with('doctor');
            return datatables()->of($schedules)
                ->addIndexColumn()
                ->addColumn('doctor', function($row) {
                    return $row->doctor ? $row->doctor->name : '';
                })
                ->addColumn('available_days', function($row) {
                    return str_replace(',', ' ', $row->available_days);
                })
                ->addColumn('timing', function($row) {
                    return date('h:i A', strtotime($row->start_time)) . ' To ' . date('h:i A', strtotime($row->end_time));
                })
                ->addColumn('status', function($row) {
                    return $row->status;
                })
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('schedule.index');
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
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'available_days' => 'required|array',
            'available_days.*' => 'string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $data['available_days'] = implode(',', $request->available_days);
        $data['status'] = 'Inactive';
        DoctorSchedule::create($data);
        return response()->json(['success' => true, 'message' => 'Schedule created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        return response()->json($schedule);
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
    public function update(Request $request, $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'available_days' => 'required|array',
            'available_days.*' => 'string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $data['available_days'] = implode(',', $request->available_days);
        $schedule->update($data);
        return response()->json(['success' => true, 'message' => 'Schedule updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['success' => true, 'message' => 'Schedule deleted successfully.']);
    }

    public function getDoctors()
    {
        $doctors = Doctor::all(['id', 'name']);
        return response()->json($doctors);
    }

    public function toggleStatus($id, Request $request)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->status = $request->status;
        $schedule->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}

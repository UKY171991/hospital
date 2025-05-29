<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $doctors = Doctor::query();
            return datatables()->of($doctors)
                ->addIndexColumn()
                ->addColumn('photo', function($row) {
                    $src = $row->photo ? asset('storage/doctor_photos/' . $row->photo) : 'https://via.placeholder.com/60x60?text=No+Image';
                    return '<img src="'.$src.'" class="img-thumbnail" style="max-width:60px;">';
                })
                ->addColumn('status', function($row) {
                    return $row->status;
                })
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button> '
                        .'<a href="/doctor/print/'.$row->id.'" class="btn btn-info btn-xs printBtn" target="_blank"><i class="fas fa-print"></i></a> '
                        .'<a href="/doctor/id_card/'.$row->id.'" class="btn btn-success btn-xs idCardBtn" target="_blank"><i class="fas fa-id-card"></i></a>';
                })
                ->rawColumns(['photo','status','action'])
                ->make(true);
        }
        return view('doctor.index');
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
        Log::info('Doctor store request received', ['hasFile' => $request->hasFile('photo'), 'all' => $request->all()]);
        // Photo is required for new doctor
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'gender' => 'required',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'address' => 'nullable|string',
            'aadhar_no' => 'nullable|string',
            'pan_no' => 'nullable|string',
            'account_no' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'opening_balance' => 'required|numeric',
            'photo' => 'required|image|max:2048',
        ]);
        Log::info('Doctor store request validated', $data);
        $data['doctor_id'] = Doctor::max('doctor_id') + 1;
        $data['status'] = 'Active';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('doctor_').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/doctor_photos', $filename);
            $data['photo'] = $filename;
            Log::info('Doctor photo uploaded', ['filename' => $filename]);
        }
        $doctor = Doctor::create($data);
        return response()->json(['success' => true, 'message' => 'Doctor created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
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
        $doctor = Doctor::findOrFail($id);
        // Photo is optional for update
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'gender' => 'required',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'address' => 'nullable|string',
            'aadhar_no' => 'nullable|string',
            'pan_no' => 'nullable|string',
            'account_no' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'opening_balance' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            if ($doctor->photo) {
                Storage::delete('public/doctor_photos/'.$doctor->photo);
            }
            $file = $request->file('photo');
            $filename = uniqid('doctor_').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/doctor_photos', $filename);
            $data['photo'] = $filename;
            Log::info('Doctor photo uploaded', ['filename' => $filename]);
        }
        $doctor->update($data);
        return response()->json(['success' => true, 'message' => 'Doctor updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        if ($doctor->photo) {
            Storage::delete('public/doctor_photos/'.$doctor->photo);
        }
        $doctor->delete();
        return response()->json(['success' => true, 'message' => 'Doctor deleted successfully.']);
    }

    // Status toggle
    public function toggleStatus($id, Request $request)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->status = $request->status;
        $doctor->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}

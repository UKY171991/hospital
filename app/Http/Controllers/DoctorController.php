<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DoctorController extends Controller
{
    private function hasPathologyColumn(): bool
    {
        static $hasPathologyColumn;

        if ($hasPathologyColumn === null) {
            $hasPathologyColumn = Schema::hasColumn('doctors', 'is_pathology');
        }

        return $hasPathologyColumn;
    }

    private function doctorsByScope(Request $request)
    {
        $query = Doctor::query();

        if ($this->hasPathologyColumn()) {
            $query->where('is_pathology', $this->isPathologyScope($request));
        }

        return $query;
    }

    private function isPathologyScope(Request $request): bool
    {
        return $request->routeIs('pathology.doctor.*') || $request->is('pathology/doctor*');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isPathology = $this->isPathologyScope($request);

        if ($request->ajax()) {
            $doctors = $this->doctorsByScope($request);
            return datatables()->of($doctors)
                ->addIndexColumn()
                ->addColumn('photo', function($row) {
                    return $row->photo ? '<img src="/storage/doctor_photos/' . $row->photo . '" class="img-thumbnail" style="max-width:60px;">' : '';
                })
                ->addColumn('status', function($row) {
                    $statusClass = $row->status === 'Active' ? 'success' : 'danger';
                    $newStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<button class="btn btn-'.$statusClass.' btn-xs toggleStatus" data-id="'.$row->id.'" data-status="'.$newStatus.'">'.$row->status.'</button>';
                })
                ->addColumn('action', function($row) use ($isPathology) {
                    $basePath = $isPathology ? '/pathology/doctor' : '/doctor';

                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button> '
                        .'<a href="'.$basePath.'/print/'.$row->id.'" class="btn btn-info btn-xs printBtn" target="_blank"><i class="fas fa-print"></i></a> '
                        .'<a href="'.$basePath.'/id_card/'.$row->id.'" class="btn btn-success btn-xs idCardBtn" target="_blank"><i class="fas fa-id-card"></i></a>';
                })
                ->rawColumns(['photo','status','action'])
                ->make(true);
        }
        return view('doctor.index', [
            'isPathologyDoctorPage' => $isPathology,
            'doctorBaseUrl' => $isPathology ? '/pathology/doctor' : '/doctor',
            'doctorPageTitle' => $isPathology ? 'Pathology Doctor Management' : 'Doctor Management',
            'doctorPageDescription' => $isPathology ? 'Manage pathology doctors and specialists' : 'Manage hospital doctors and medical staff',
            'doctorDirectoryTitle' => $isPathology ? 'Pathology Doctor Directory' : 'Doctor Directory',
            'doctorRecordsTitle' => $isPathology ? 'Pathology Doctor Records' : 'Doctor Records',
            'doctorBreadcrumb' => $isPathology ? 'Pathology Doctors' : 'Doctors',
        ]);
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
        $isPathology = $this->isPathologyScope($request);
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
        if ($this->hasPathologyColumn()) {
            $data['is_pathology'] = $isPathology;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('doctor_photos', 'public');
            $data['photo'] = basename($path);
            Log::info('Doctor photo uploaded', ['filename' => $data['photo']]);
        }
        $doctor = Doctor::create($data);
        return response()->json(['success' => true, 'message' => 'Doctor created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
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
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
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
                Storage::disk('public')->delete('doctor_photos/'.$doctor->photo);
            }
            $path = $request->file('photo')->store('doctor_photos', 'public');
            $data['photo'] = basename($path);
            Log::info('Doctor photo uploaded', ['filename' => $data['photo']]);
        }
        $doctor->update($data);
        return response()->json(['success' => true, 'message' => 'Doctor updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
        if ($doctor->photo) {
            Storage::delete('public/doctor_photos/'.$doctor->photo);
        }
        $doctor->delete();
        return response()->json(['success' => true, 'message' => 'Doctor deleted successfully.']);
    }

    /**
     * Toggle doctor status
     */
    public function toggleStatus($id, Request $request)
    {
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
        $doctor->status = $request->status;
        $doctor->save();
        return response()->json(['success' => true, 'message' => 'Doctor status updated successfully.']);
    }

    /**
     * Print doctor details
     */
    public function print(Request $request, $id)
    {
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
        return view('doctor.print', compact('doctor'));
    }

    /**
     * Generate doctor ID card
     */
    public function idCard(Request $request, $id)
    {
        $doctor = $this->doctorsByScope($request)->findOrFail($id);
        return view('doctor.id_card', compact('doctor'));
    }
}

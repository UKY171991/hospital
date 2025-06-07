<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Patient::query();
            if ($request->from_date) {
                $query->where('reg_date', '>=', $request->from_date);
            }
            if ($request->to_date) {
                $query->where('reg_date', '<=', $request->to_date);
            }
            $patients = $query->get();
            $data = $patients->map(function($item, $key) {
                return [
                    'sno' => $key + 1,
                    'patient_name' => $item->patient_name ?? $item->name ?? '',
                    'patient_id' => $item->patient_id ?? '',
                    'relation_name' => $item->relation_name ?? '',
                    'mobile' => $item->mobile ?? '',
                    'reg_date' => $item->reg_date ?? '',
                    'address' => $item->address ?? '',
                    'action' => '<a href="#" class="editBtn text-primary" data-id="'.$item->id.'"><i class="fas fa-edit"></i></a>'
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('reports.patient');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'patient_id' => 'nullable',
            'relation_name' => 'nullable',
            'relation_of_relative' => 'nullable',
            'relative_title' => 'nullable',
            'mobile' => 'nullable',
            'reg_date' => 'required|date',
            'address' => 'nullable',
            'status' => 'nullable',
            'gender' => 'required',
            'card_no' => 'nullable',
            'reference_doctor' => 'nullable',
            'aadhar_no' => 'nullable',
            'age' => 'nullable|integer',
            'blood_group' => 'required',
            'color_vision' => 'required',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('patient_photos', 'public');
            $data['photo'] = basename($data['photo']);
        }
        $patient = Patient::create($data);
        return response()->json(['success' => true, 'message' => 'Patient added successfully.']);
    }

    public function show($id)
    {
        return Patient::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'patient_id' => 'nullable',
            'relation_name' => 'nullable',
            'relation_of_relative' => 'nullable',
            'relative_title' => 'nullable',
            'mobile' => 'nullable',
            'reg_date' => 'required|date',
            'address' => 'nullable',
            'status' => 'nullable',
            'gender' => 'required',
            'card_no' => 'nullable',
            'reference_doctor' => 'nullable',
            'aadhar_no' => 'nullable',
            'age' => 'nullable|integer',
            'blood_group' => 'required',
            'color_vision' => 'required',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            if ($patient->photo) {
                Storage::disk('public')->delete('patient_photos/' . $patient->photo);
            }
            $data['photo'] = $request->file('photo')->store('patient_photos', 'public');
            $data['photo'] = basename($data['photo']);
        }
        $patient->update($data);
        return response()->json(['success' => true, 'message' => 'Patient updated successfully.']);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        if ($patient->photo) {
            Storage::disk('public')->delete('patient_photos/' . $patient->photo);
        }
        $patient->delete();
        return response()->json(['success' => true, 'message' => 'Patient deleted successfully.']);
    }
} 
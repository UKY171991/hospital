<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospital_manage', compact('hospitals'));
    }

    public function create()
    {
        return view('hospital_form');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Set default values for required fields if not present
        $data['userid'] = $data['userid'] ?? 'admin';
        $data['password'] = $data['password'] ?? 'password';
        $data['passcode'] = $data['passcode'] ?? '1234';
        foreach(['logo','signature','stamp','payment_qr'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('uploads', 'public');
            }
        }
        Hospital::create($data);
        return redirect()->route('hospital.manage')->with('success', 'Hospital created successfully.');
    }

    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('hospital_form', compact('hospital'));
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $data = $request->all();
        foreach(['logo','signature','stamp','payment_qr'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('uploads', 'public');
            } else {
                unset($data[$fileField]);
            }
        }
        $hospital->update($data);
        return redirect()->route('hospital.manage')->with('success', 'Hospital updated successfully.');
    }
}

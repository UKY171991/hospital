<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function($row){
                    return $row->logo;
                })
                ->addColumn('login_details', function($row){
                    return 'Userid: '.$row->username.'<br>Password: '.$row->password.'<br>Passcode: '.$row->passcode;
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-info btn-xs viewBtn" data-id="'.$row->id.'"><i class="fas fa-eye"></i></button> '
                        .'<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['logo','login_details','action'])
                ->make(true);
        }
        return view('hospital.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'passcode' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'pan_no' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'hospital_tag_line' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'gstin_no' => 'nullable|string|max:255',
            'cin_no' => 'nullable|string|max:255',
            'hospital_prefix' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'payment_qr' => 'nullable|image|max:2048',
            'letter_head' => 'nullable|image|max:2048',
            'idcard_design' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('hospital_logos', 'public');
            $data['logo'] = basename($path);
        }
        foreach(['signature','stamp','payment_qr','letter_head','idcard_design'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $path = $request->file($imgField)->store('hospital_logos', 'public');
                $data[$imgField] = basename($path);
            }
        }
        Hospital::create($data);
        return response()->json(['success' => true, 'message' => 'Hospital created successfully.']);
    }

    public function show($id)
    {
        $hospital = Hospital::findOrFail($id);
        return response()->json($hospital);
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $data = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'passcode' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'pan_no' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'hospital_tag_line' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'gstin_no' => 'nullable|string|max:255',
            'cin_no' => 'nullable|string|max:255',
            'hospital_prefix' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'payment_qr' => 'nullable|image|max:2048',
            'letter_head' => 'nullable|image|max:2048',
            'idcard_design' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('logo')) {
            if ($hospital->logo) {
                Storage::disk('public')->delete('hospital_logos/'.$hospital->logo);
            }
            $path = $request->file('logo')->store('hospital_logos', 'public');
            $data['logo'] = basename($path);
        }
        foreach(['signature','stamp','payment_qr','letter_head','idcard_design'] as $imgField) {
            if ($request->hasFile($imgField)) {
                if ($hospital->$imgField) {
                    Storage::disk('public')->delete('hospital_logos/'.$hospital->$imgField);
                }
                $path = $request->file($imgField)->store('hospital_logos', 'public');
                $data[$imgField] = basename($path);
            }
        }
        if (empty($data['password'])) {
            unset($data['password']); // keep old password
        }
        $hospital->update($data);
        return response()->json(['success' => true, 'message' => 'Hospital updated successfully.']);
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        if ($hospital->logo) {
            Storage::disk('public')->delete('hospital_logos/'.$hospital->logo);
        }
        $hospital->delete();
        return response()->json(['success' => true, 'message' => 'Hospital deleted successfully.']);
    }
} 
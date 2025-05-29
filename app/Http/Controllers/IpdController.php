<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipd;

class IpdController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ipd::query();
            if ($request->from_date) {
                $query->where('admission_date', '>=', $request->from_date);
            }
            if ($request->to_date) {
                $query->where('admission_date', '<=', $request->to_date);
            }
            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('status', function($row) {
                    return $row->status === 'Active' ? '<i class="fas fa-eye text-success"></i>' : '<i class="fas fa-eye-slash text-danger"></i>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="#" class="editBtn text-primary" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('ipd.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ipd_no' => 'nullable',
            'uhid_no' => 'nullable',
            'patient_name' => 'required',
            'attendant_name' => 'nullable',
            'attendant_mobile' => 'nullable',
            'second_attendant_name' => 'nullable',
            'second_attendant_mobile' => 'nullable',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date',
            'doctor_name' => 'required',
            'disease' => 'required',
            'department' => 'required',
            'ward_name' => 'required',
            'room_no' => 'nullable',
            'bed_no' => 'nullable',
            'employee' => 'nullable',
            'bill_no' => 'nullable',
            'insurance' => 'nullable',
            'insurance_name' => 'nullable',
            'policy_id' => 'nullable',
            'policy_holder_name' => 'nullable',
            'status' => 'nullable',
        ]);
        Ipd::create($data);
        return response()->json(['success' => true, 'message' => 'IPD record added successfully.']);
    }

    public function show($id)
    {
        return Ipd::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $ipd = Ipd::findOrFail($id);
        $data = $request->validate([
            'ipd_no' => 'nullable',
            'uhid_no' => 'nullable',
            'patient_name' => 'required',
            'attendant_name' => 'nullable',
            'attendant_mobile' => 'nullable',
            'second_attendant_name' => 'nullable',
            'second_attendant_mobile' => 'nullable',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date',
            'doctor_name' => 'required',
            'disease' => 'required',
            'department' => 'required',
            'ward_name' => 'required',
            'room_no' => 'nullable',
            'bed_no' => 'nullable',
            'employee' => 'nullable',
            'bill_no' => 'nullable',
            'insurance' => 'nullable',
            'insurance_name' => 'nullable',
            'policy_id' => 'nullable',
            'policy_holder_name' => 'nullable',
            'status' => 'nullable',
        ]);
        $ipd->update($data);
        return response()->json(['success' => true, 'message' => 'IPD record updated successfully.']);
    }

    public function destroy($id)
    {
        $ipd = Ipd::findOrFail($id);
        $ipd->delete();
        return response()->json(['success' => true, 'message' => 'IPD record deleted successfully.']);
    }
} 
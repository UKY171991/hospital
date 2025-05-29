<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;

class OpdController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Opd::query();
            if ($request->opd_type) {
                $query->where('opd_type', $request->opd_type);
            }
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
        return view('opd.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'opd_type' => 'required',
            'opd_no' => 'nullable',
            'admission_date' => 'required|date',
            'patient_id' => 'nullable',
            'name' => 'required',
            'address' => 'nullable',
            'doctor_name' => 'required',
            'disease' => 'required',
            'doctor_fee' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'nullable|numeric',
            'prepared_by' => 'required',
            'payment_mode' => 'required',
            'reference_doctor' => 'nullable',
            'status' => 'nullable',
        ]);
        Opd::create($data);
        return response()->json(['success' => true, 'message' => 'OPD record added successfully.']);
    }

    public function show($id)
    {
        return Opd::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $opd = Opd::findOrFail($id);
        $data = $request->validate([
            'opd_type' => 'required',
            'opd_no' => 'nullable',
            'admission_date' => 'required|date',
            'patient_id' => 'nullable',
            'name' => 'required',
            'address' => 'nullable',
            'doctor_name' => 'required',
            'disease' => 'required',
            'doctor_fee' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'nullable|numeric',
            'prepared_by' => 'required',
            'payment_mode' => 'required',
            'reference_doctor' => 'nullable',
            'status' => 'nullable',
        ]);
        $opd->update($data);
        return response()->json(['success' => true, 'message' => 'OPD record updated successfully.']);
    }

    public function destroy($id)
    {
        $opd = Opd::findOrFail($id);
        $opd->delete();
        return response()->json(['success' => true, 'message' => 'OPD record deleted successfully.']);
    }
} 
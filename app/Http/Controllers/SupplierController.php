<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    $src = $row->photo ? asset('storage/supplier_photos/' . $row->photo) : 'https://via.placeholder.com/60x60?text=No+Image';
                    return '<img src="'.$src.'" class="img-thumbnail" style="max-width:60px;">';
                })
                ->addColumn('status', function($row){
                    $checked = $row->status === 'Active' ? 'checked' : '';
                    return '<input type="checkbox" class="status-toggle" data-id="'.$row->id.'" '.$checked.' />';
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['photo','status','action'])
                ->make(true);
        }
        return view('suppliers.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'contact_no' => 'required|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'required|date',
            'qualification' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'pan_no' => 'nullable|string|max:20',
            'aadhar_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:30',
            'ifsc_code' => 'nullable|string|max:20',
            'opening_balance' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
        $data['status'] = 'Active';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('supplier_').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/supplier_photos', $filename);
            $data['photo'] = $filename;
        }
        Supplier::create($data);
        return response()->json(['success' => true, 'message' => 'Supplier created successfully.']);
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        // Status toggle
        if ($request->has('status') && count($request->all()) === 2) {
            $supplier->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'contact_no' => 'required|string|max:20',
            'email' => 'nullable|email',
            'dob' => 'required|date',
            'qualification' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'pan_no' => 'nullable|string|max:20',
            'aadhar_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:30',
            'ifsc_code' => 'nullable|string|max:20',
            'opening_balance' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            if ($supplier->photo) {
                Storage::disk('public')->delete('supplier_photos/'.$supplier->photo);
            }
            $file = $request->file('photo');
            $filename = uniqid('supplier_').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/supplier_photos', $filename);
            $data['photo'] = $filename;
        }
        $supplier->update($data);
        return response()->json(['success' => true, 'message' => 'Supplier updated successfully.']);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier->photo) {
            Storage::disk('public')->delete('supplier_photos/'.$supplier->photo);
        }
        $supplier->delete();
        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }
} 
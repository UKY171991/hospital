<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemMapping;

class ItemMappingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ItemMapping::query();
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
                ->editColumn('status', function($row) {
                    return $row->status === 'Active' ? '<i class="fas fa-eye text-success"></i>' : '<i class="fas fa-eye-slash text-danger"></i>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="#" class="editBtn text-primary" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('item_mapping.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required',
            'date' => 'required|date',
            'patient_name' => 'required',
            'patient_contact_no' => 'required',
            'item_name' => 'required',
            'item_code' => 'required',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'amount' => 'required|numeric',
            'status' => 'nullable',
        ]);
        ItemMapping::create($data);
        return response()->json(['success' => true, 'message' => 'Item mapping added successfully.']);
    }

    public function show($id)
    {
        return ItemMapping::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = ItemMapping::findOrFail($id);
        $data = $request->validate([
            'type' => 'required',
            'date' => 'required|date',
            'patient_name' => 'required',
            'patient_contact_no' => 'required',
            'item_name' => 'required',
            'item_code' => 'required',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'amount' => 'required|numeric',
            'status' => 'nullable',
        ]);
        $item->update($data);
        return response()->json(['success' => true, 'message' => 'Item mapping updated successfully.']);
    }

    public function destroy($id)
    {
        $item = ItemMapping::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item mapping deleted successfully.']);
    }
} 
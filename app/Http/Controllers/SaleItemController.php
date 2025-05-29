<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use DataTables;

class SaleItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SaleItem::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('items', function($row) {
                    // Always return a JSON string
                    return is_array($row->items) ? json_encode($row->items) : $row->items;
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-success btn-xs printBtn" data-id="'.$row->id.'"><i class="fas fa-print"></i></button> '
                        .'<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sale_item.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);
        $data['items'] = json_encode($data['items']);
        SaleItem::create($data);
        return response()->json(['success' => true, 'message' => 'Sale item created successfully.']);
    }

    public function show($id)
    {
        $sale = SaleItem::findOrFail($id);
        $sale->items = json_decode($sale->items, true);
        return response()->json($sale);
    }

    public function update(Request $request, $id)
    {
        $sale = SaleItem::findOrFail($id);
        $data = $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);
        $data['items'] = json_encode($data['items']);
        $sale->update($data);
        return response()->json(['success' => true, 'message' => 'Sale item updated successfully.']);
    }

    public function destroy($id)
    {
        $sale = SaleItem::findOrFail($id);
        $sale->delete();
        return response()->json(['success' => true, 'message' => 'Sale item deleted successfully.']);
    }

    public function print($id)
    {
        $sale = SaleItem::findOrFail($id);
        $sale->items = json_decode($sale->items, true);
        return view('sale_item.print', compact('sale'));
    }
} 
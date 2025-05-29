<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DataTables;

class PurchaseItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseItem::with('supplier');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('supplier_id', function($row) {
                    return $row->supplier ? $row->supplier->name : '';
                })
                ->editColumn('items', function($row) {
                    return is_array($row->items) ? json_encode($row->items) : $row->items;
                })
                ->addColumn('action', function($row){
                    return '<a href="/purchase_item/print/'.$row->id.'" class="btn btn-success btn-xs printBtn" target="_blank"><i class="fas fa-print"></i></a> '
                        .'<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $suppliers = Supplier::all();
        return view('purchase_item.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_no' => 'required|string|max:50',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_order_no' => 'nullable|string|max:100',
            'eway_bill_no' => 'nullable|string|max:100',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.unit' => 'nullable|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);
        $data['items'] = json_encode($data['items']);
        PurchaseItem::create($data);
        return response()->json(['success' => true, 'message' => 'Purchase item created successfully.']);
    }

    public function show($id)
    {
        $purchase = PurchaseItem::with('supplier')->findOrFail($id);
        $purchase->items = json_decode($purchase->items, true);
        return response()->json($purchase);
    }

    public function update(Request $request, $id)
    {
        $purchase = PurchaseItem::findOrFail($id);
        $data = $request->validate([
            'invoice_no' => 'required|string|max:50',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_order_no' => 'nullable|string|max:100',
            'eway_bill_no' => 'nullable|string|max:100',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.unit' => 'nullable|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'total_discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);
        $data['items'] = json_encode($data['items']);
        $purchase->update($data);
        return response()->json(['success' => true, 'message' => 'Purchase item updated successfully.']);
    }

    public function destroy($id)
    {
        $purchase = PurchaseItem::findOrFail($id);
        $purchase->delete();
        return response()->json(['success' => true, 'message' => 'Purchase item deleted successfully.']);
    }

    public function print($id)
    {
        $purchase = PurchaseItem::with('supplier')->findOrFail($id);
        $purchase->items = json_decode($purchase->items, true);
        return view('purchase_item.print', compact('purchase'));
    }
} 
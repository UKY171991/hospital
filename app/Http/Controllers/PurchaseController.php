<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|unique:purchases',
            'date' => 'required|date',
            'supplier_name' => 'required|string',
            'purchase_order_no' => 'nullable|string',
            'eway_bill_no' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
        ]);

        $purchase = Purchase::create($validated);
        foreach ($validated['items'] as $item) {
            $purchase->items()->create($item);
        }

        return response()->json(['success' => true, 'message' => 'Purchase added successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|unique:purchases,invoice_no,' . $id,
            'date' => 'required|date',
            'supplier_name' => 'required|string',
            'purchase_order_no' => 'nullable|string',
            'eway_bill_no' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->update($validated);
        $purchase->items()->delete();
        foreach ($validated['items'] as $item) {
            $purchase->items()->create($item);
        }

        return response()->json(['success' => true, 'message' => 'Purchase updated successfully.']);
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->json(['success' => true, 'message' => 'Purchase deleted successfully.']);
    }
}

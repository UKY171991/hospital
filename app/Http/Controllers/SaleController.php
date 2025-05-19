<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User; // Added
use App\Models\Hospital; // Added
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['user', 'hospital'])->latest()->paginate(10);
        return view('sale_manage', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::where('current_stock', '>', 0)->get(); // Only items with stock
        return view('sale_create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'total_amount' => 'required|numeric|min:0',
            'total_discount' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
            'sale_items' => 'required|array|min:1',
            'sale_items.*.item_id' => 'required|exists:items,id',
            'sale_items.*.price_at_sale' => 'required|numeric|min:0',
            'sale_items.*.quantity' => 'required|integer|min:1',
            'sale_items.*.amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'date' => $request->date,
                'client_name' => $request->client_name,
                'mobile_no' => $request->mobile_no,
                'total_amount' => $request->total_amount,
                'total_discount' => $request->total_discount ?? 0,
                'grand_total' => $request->grand_total,
                'remark' => $request->remark,
                'user_id' => Auth::id(),
                'hospital_id' => Auth::user()->hospital_id ?? Hospital::first()->id, // Assign to user's hospital or first hospital
            ]);

            foreach ($request->sale_items as $itemData) {
                $item = Item::find($itemData['item_id']);
                if (!$item || $item->current_stock < $itemData['quantity']) {
                    DB::rollBack(); // Rollback before throwing exception
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Not enough stock for item: ' . ($item ? $item->item_name : 'Unknown Item')], 422);
                    }
                    throw new \Exception('Not enough stock for item: ' . ($item ? $item->item_name : 'Unknown Item'));
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $itemData['item_id'],
                    'price_at_sale' => $itemData['price_at_sale'],
                    'quantity' => $itemData['quantity'],
                    'amount' => $itemData['amount'],
                ]);

                // Update item stock
                $item->current_stock -= $itemData['quantity'];
                $item->save();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Sale created successfully.']);
            }
            return redirect()->route('sale.manage')->with('success', 'Sale created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) { // Specifically catch validation exceptions
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to create sale: ' . $e->getMessage()], 500); // Use 500 for general server errors
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create sale: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale) // Changed string $id to Sale $sale for route model binding
    {
        $sale->load('items.item', 'user', 'hospital'); // Eager load relationships
        return view('sale_show', compact('sale')); // Assuming you will create sale_show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

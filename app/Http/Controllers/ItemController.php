<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $toggle = '<a href="#" class="toggleStatus" data-id="'.$row->id.'" data-status="'.($row->status === 'Active' ? 'Inactive' : 'Active').'"><i class="fas fa-toggle-'.($row->status === 'Active' ? 'on text-success' : 'off text-danger').'"></i></a>';
                    $edit = '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                    return $toggle.' '.$edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('item.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:50',
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:255',
            'hsn_sac_code' => 'nullable|string|max:255',
            'sales_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'unit' => 'nullable|string|max:50',
            'opening_stock' => 'required|integer',
        ]);
        $data['current_stock'] = $data['opening_stock'];
        $data['status'] = 'Active';
        Item::create($data);
        return response()->json(['success' => true, 'message' => 'Item created successfully.']);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $item->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'type' => 'required|string|max:50',
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:255',
            'hsn_sac_code' => 'nullable|string|max:255',
            'sales_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'unit' => 'nullable|string|max:50',
            'opening_stock' => 'required|integer',
        ]);
        $item->update($data);
        return response()->json(['success' => true, 'message' => 'Item updated successfully.']);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
    }
}

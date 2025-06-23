<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceSheet;
use Yajra\DataTables\DataTables;

class BalanceSheetController extends Controller
{    public function index(Request $request)
    {
        // Log for debugging
        \Log::info('BalanceSheet index called', [
            'is_ajax' => $request->ajax(),
            'headers' => $request->headers->all(),
            'request_method' => $request->method()
        ]);
        
        if ($request->ajax()) {
            try {
                $balanceSheets = BalanceSheet::query();
                
                $result = DataTables::of($balanceSheets)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    
                \Log::info('DataTables result generated', ['result_type' => get_class($result)]);
                return $result;
                
            } catch (\Exception $e) {
                \Log::error('DataTables error', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
        }

        return view('reports.balance-sheet');
    }

    // Duplicate store method removed

    public function edit($id)
    {
        $entry = BalanceSheet::findOrFail($id);
        return response()->json($entry);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_type' => 'required|string|max:255',
            'month_year' => 'required|string|max:255',
            'credit' => 'required|numeric',
            'debit' => 'required|numeric',
            'balance' => 'required|numeric',
        ]);
        $entry = BalanceSheet::findOrFail($id);
        $entry->update($validatedData);
        return response()->json(['message' => 'Balance sheet entry updated successfully.']);
    }

    public function destroy($id)
    {
        $entry = BalanceSheet::findOrFail($id);
        $entry->delete();
        return response()->json(['message' => 'Balance sheet entry deleted successfully.']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'report_type' => 'required|string|max:255',
            'month_year' => 'required|string|max:255',
            'credit' => 'required|numeric',
            'debit' => 'required|numeric',
            'balance' => 'required|numeric',
        ]);

        try {
            BalanceSheet::create($validatedData);
            return response()->json(['message' => 'Balance sheet entry saved successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save balance sheet entry.', 'error' => $e->getMessage()], 500);
        }
    }

    // Debug method to test data retrieval
    public function debug(Request $request)
    {
        $balanceSheets = BalanceSheet::all();
        return response()->json([
            'success' => true,
            'count' => $balanceSheets->count(),
            'data' => $balanceSheets,
            'request_is_ajax' => $request->ajax()
        ]);
    }
}

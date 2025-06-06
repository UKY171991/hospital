<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ledger::orderByDesc('id')->get();
            $result = $data->map(function ($entry) {
                return [
                    'id' => $entry->id,
                    'particular' => $entry->report_type,
                    'transaction_date' => $entry->transaction_date,
                    'remarks' => $entry->remarks,
                    'credit' => $entry->credit,
                    'debit' => $entry->debit,
                    'balance' => $entry->balance,
                    'action' => '<button class="btn btn-info btn-sm editBtn" data-id="'.$entry->id.'"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm deleteBtn" data-id="'.$entry->id.'"><i class="fa fa-trash"></i></button>',
                ];
            });
            return response()->json(['data' => $result]);
        }
        return view('reports.ledger');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'report_type' => 'required|string',
            'doctor_name' => 'required|string',
            'transaction_date' => 'required|date',
            'remarks' => 'nullable|string',
            'credit' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'balance' => 'nullable|numeric',
        ]);
        $ledger = Ledger::create($data);
        return response()->json(['success' => true, 'message' => 'Ledger entry created successfully.', 'data' => $ledger]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ledger = Ledger::findOrFail($id);
        return response()->json($ledger);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'report_type' => 'required|string',
            'doctor_name' => 'required|string',
            'transaction_date' => 'required|date',
            'remarks' => 'nullable|string',
            'credit' => 'nullable|numeric',
            'debit' => 'nullable|numeric',
            'balance' => 'nullable|numeric',
        ]);
        $ledger = Ledger::findOrFail($id);
        $ledger->update($data);
        return response()->json(['success' => true, 'message' => 'Ledger entry updated successfully.', 'data' => $ledger]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ledger = Ledger::findOrFail($id);
        $ledger->delete();
        return response()->json(['success' => true, 'message' => 'Ledger entry deleted successfully.']);
    }
}

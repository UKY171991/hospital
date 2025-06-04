<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show the page or return JSON for DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::query()->orderByDesc('id')->get();
            $result = $data->map(function ($entry, $i) {
                return [
                    'id' => $entry->id,
                    'sno' => $i + 1,
                    'select_type' => $entry->select_type,
                    'doctor_name' => $entry->doctor_name,
                    'date' => $entry->date,
                    'payment_ref_no' => $entry->payment_ref_no,
                    'before_due_amount' => $entry->before_due_amount,
                    'discount' => $entry->discount,
                    'paid_amount' => $entry->paid_amount,
                    'after_due_amount' => $entry->after_due_amount,
                    'transaction_ref_no' => $entry->transaction_ref_no,
                    'payment_mode' => $entry->payment_mode,
                    'payer_bank' => $entry->payer_bank,
                    'bank_account_number' => $entry->bank_account_number,
                    'ifsc_code' => $entry->ifsc_code,
                    'narration' => $entry->narration,
                    'action' => '<button class="btn btn-info btn-sm editBtn" data-id="'.$entry->id.'"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm deleteBtn" data-id="'.$entry->id.'"><i class="fa fa-trash"></i></button>',
                ];
            });
            return response()->json(['data' => $result]);
        }
        return view('payment.index');
    }

    // Store new entry
    public function store(Request $request)
    {
        $request->validate([
            'select_type' => 'required|string',
            'doctor_name' => 'nullable|string',
            'date' => 'required|date',
            'payment_ref_no' => 'nullable|string',
            'before_due_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',
            'after_due_amount' => 'nullable|numeric',
            'transaction_ref_no' => 'nullable|string',
            'payment_mode' => 'nullable|string',
            'payer_bank' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'narration' => 'nullable|string',
        ]);
        $entry = Payment::create($request->all());
        return response()->json(['success' => true, 'data' => $entry]);
    }

    // Update entry
    public function update(Request $request, $id)
    {
        $request->validate([
            'select_type' => 'required|string',
            'doctor_name' => 'nullable|string',
            'date' => 'required|date',
            'payment_ref_no' => 'nullable|string',
            'before_due_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',
            'after_due_amount' => 'nullable|numeric',
            'transaction_ref_no' => 'nullable|string',
            'payment_mode' => 'nullable|string',
            'payer_bank' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'narration' => 'nullable|string',
        ]);
        $entry = Payment::findOrFail($id);
        $entry->update($request->all());
        return response()->json(['success' => true, 'data' => $entry]);
    }

    // Show single entry for edit
    public function show($id)
    {
        $entry = Payment::findOrFail($id);
        return response()->json($entry);
    }

    // Delete entry
    public function destroy($id)
    {
        $entry = Payment::findOrFail($id);
        $entry->delete();
        return response()->json(['success' => true]);
    }
}

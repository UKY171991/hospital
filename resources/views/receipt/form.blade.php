<form id="receiptForm">
    @csrf
    <input type="hidden" name="id" id="receipt_id">
    <div class="form-group">
        <label for="select_type">Type</label>
        <input type="text" class="form-control" name="select_type" id="select_type" required>
    </div>
    <div class="form-group">
        <label for="patient_name">Patient Name</label>
        <input type="text" class="form-control" name="patient_name" id="patient_name">
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" name="date" id="date" required>
    </div>
    <div class="form-group">
        <label for="receipt_ref_no">Receipt Ref No</label>
        <input type="text" class="form-control" name="receipt_ref_no" id="receipt_ref_no">
    </div>
    <div class="form-group">
        <label for="before_due_amount">Before Due Amount</label>
        <input type="number" step="0.01" class="form-control" name="before_due_amount" id="before_due_amount">
    </div>
    <div class="form-group">
        <label for="discount">Discount</label>
        <input type="number" step="0.01" class="form-control" name="discount" id="discount">
    </div>
    <div class="form-group">
        <label for="receipt_amount">Receipt Amount</label>
        <input type="number" step="0.01" class="form-control" name="receipt_amount" id="receipt_amount" required>
    </div>
    <div class="form-group">
        <label for="after_due_amount">After Due Amount</label>
        <input type="number" step="0.01" class="form-control" name="after_due_amount" id="after_due_amount">
    </div>
    <div class="form-group">
        <label for="transaction_ref_no">Transaction Ref No</label>
        <input type="text" class="form-control" name="transaction_ref_no" id="transaction_ref_no">
    </div>
    <div class="form-group">
        <label for="receipt_mode">Receipt Mode</label>
        <input type="text" class="form-control" name="receipt_mode" id="receipt_mode">
    </div>
    <div class="form-group">
        <label for="receiver_bank">Receiver Bank</label>
        <input type="text" class="form-control" name="receiver_bank" id="receiver_bank">
    </div>
    <div class="form-group">
        <label for="bank_account_number">Bank Account Number</label>
        <input type="text" class="form-control" name="bank_account_number" id="bank_account_number">
    </div>
    <div class="form-group">
        <label for="ifsc_code">IFSC Code</label>
        <input type="text" class="form-control" name="ifsc_code" id="ifsc_code">
    </div>
    <div class="form-group">
        <label for="narration">Narration</label>
        <textarea class="form-control" name="narration" id="narration"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form> 
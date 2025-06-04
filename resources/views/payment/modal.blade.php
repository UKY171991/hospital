<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="paymentForm">
      @csrf
      <input type="hidden" name="id" id="paymentId">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="paymentModalLabel"></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-4">
              <label>Select Type <span class="text-danger">*</span></label>
              <select name="select_type" id="select_type" class="form-control" required>
                <option value="Doctor Wise">Doctor Wise</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Doctor Name</label>
              <input type="text" name="doctor_name" id="doctor_name" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Date <span class="text-danger">*</span></label>
              <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label>Payment Ref No</label>
              <input type="text" name="payment_ref_no" id="payment_ref_no" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Before Payment Due Amt</label>
              <input type="number" name="before_due_amount" id="before_due_amount" class="form-control" value="0">
            </div>
            <div class="form-group col-md-4">
              <label>Discount</label>
              <input type="number" name="discount" id="discount" class="form-control" value="0">
            </div>
            <div class="form-group col-md-4">
              <label>Paid Amount <span class="text-danger">*</span></label>
              <input type="number" name="paid_amount" id="paid_amount" class="form-control" required value="0">
            </div>
            <div class="form-group col-md-4">
              <label>After Received Due Amount</label>
              <input type="number" name="after_due_amount" id="after_due_amount" class="form-control" value="0">
            </div>
            <div class="form-group col-md-4">
              <label>Transaction Ref No</label>
              <input type="text" name="transaction_ref_no" id="transaction_ref_no" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Payment Mode</label>
              <select name="payment_mode" id="payment_mode" class="form-control">
                <option value="CASH">CASH</option>
                <option value="BANK">BANK</option>
                <option value="UPI">UPI</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Payer Bank</label>
              <input type="text" name="payer_bank" id="payer_bank" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Bank Account Number</label>
              <input type="text" name="bank_account_number" id="bank_account_number" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>IFSC Code</label>
              <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label>Narration</label>
              <textarea name="narration" id="narration" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div> 
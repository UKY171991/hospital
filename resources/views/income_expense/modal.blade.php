<div class="modal fade" id="incomeExpenseModal" tabindex="-1" role="dialog" aria-labelledby="incomeExpenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="incomeExpenseForm">
      @csrf
      <input type="hidden" name="entry_id" id="entry_id">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="incomeExpenseModalLabel"></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Date <span class="text-danger">*</span></label>
              <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Type <span class="text-danger">*</span></label>
              <select name="type" id="type" class="form-control" required>
                <option value="Income">Income</option>
                <option value="Expenses">Expenses</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Category <span class="text-danger">*</span></label>
              <input type="text" name="category" id="category" class="form-control" required placeholder="Enter Category">
            </div>
            <div class="form-group col-md-6">
              <label>Item <span class="text-danger">*</span></label>
              <select name="item_id" id="item_id" class="form-control" required>
                <option value="">Select Item</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Amount <span class="text-danger">*</span></label>
              <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Description</label>
              <textarea name="description" id="description" class="form-control"></textarea>
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
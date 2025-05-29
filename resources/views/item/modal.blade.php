<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form id="itemForm">
      @csrf
      <input type="hidden" name="id" id="itemId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="itemModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-2">
              <label>Type <span class="text-danger">*</span></label>
              <select name="type" id="type" class="form-control" required>
                <option value="">Select</option>
                <option value="Service">Service</option>
                <option value="Product">Product</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Item Name <span class="text-danger">*</span></label>
              <input type="text" name="item_name" id="item_name" class="form-control" required>
            </div>
            <div class="form-group col-md-2">
              <label>Item Code/Bar Code</label>
              <input type="text" name="item_code" id="item_code" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label>HSN/SAC Code</label>
              <input type="text" name="hsn_sac_code" id="hsn_sac_code" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label>Sale Price <span class="text-danger">*</span></label>
              <input type="number" name="sales_price" id="sales_price" class="form-control" required>
            </div>
            <div class="form-group col-md-2">
              <label>Purchase Price <span class="text-danger">*</span></label>
              <input type="number" name="purchase_price" id="purchase_price" class="form-control" required>
            </div>
            <div class="form-group col-md-2">
              <label>Unit</label>
              <input type="text" name="unit" id="unit" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label>Opening Stock <span class="text-danger">*</span></label>
              <input type="number" name="opening_stock" id="opening_stock" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div> 
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="userForm">
      @csrf
      <input type="hidden" name="id" id="userId">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="userModalLabel"></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label>User Name <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Passcode <span class="text-danger">*</span></label>
              <input type="text" name="passcode" id="passcode" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>User Type <span class="text-danger">*</span></label>
              <select name="user_type" id="user_type" class="form-control" required>
                <option value="Admin">Admin</option>
                <option value="Doctor">Doctor</option>
                <option value="Employee">Employee</option>
                <option value="Receptionist">Receptionist</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Status <span class="text-danger">*</span></label>
              <select name="status" id="status" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Deactivate">Deactivate</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Mobile No <span class="text-danger">*</span></label>
              <input type="text" name="mobile_no" id="mobile_no" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Email <span class="text-danger">*</span></label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
              <small class="form-text text-muted">Leave blank to keep the current password.</small>
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
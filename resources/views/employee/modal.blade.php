<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form id="employeeForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="employeeId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="employeeModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Employee Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Relative Name</label>
              <input type="text" name="relative_name" id="relative_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Mobile Number <span class="text-danger">*</span></label>
              <input type="text" name="mobile_no" id="mobile_no" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Alternate Mobile No</label>
              <input type="text" name="alternate_mobile_no" id="alternate_mobile_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Employee Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Date Of Birth</label>
              <input type="date" name="dob" id="dob" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Gender <span class="text-danger">*</span></label>
              <select name="gender" id="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Aadhar Number</label>
              <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Pan Number</label>
              <input type="text" name="pan_no" id="pan_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Current Address <span class="text-danger">*</span></label>
              <input type="text" name="current_address" id="current_address" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Permanent Address</label>
              <input type="text" name="permanent_address" id="permanent_address" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Marital Status</label>
              <select name="marital_status" id="marital_status" class="form-control">
                <option value="">Select</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Blood Group</label>
              <select name="blood_group" id="blood_group" class="form-control">
                <option value="">Select</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="Not Know">Not Know</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Education</label>
              <input type="text" name="education" id="education" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Joining Date</label>
              <input type="date" name="joining_date" id="joining_date" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Leaving Date</label>
              <input type="date" name="leaving_date" id="leaving_date" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Experience Year</label>
              <input type="text" name="experience_year" id="experience_year" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Role <span class="text-danger">*</span></label>
              <input type="text" name="role" id="role" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Department <span class="text-danger">*</span></label>
              <input type="text" name="department" id="department" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <input type="text" name="bank_name" id="bank_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Account Number</label>
              <input type="text" name="account_no" id="account_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Account Holder Name</label>
              <input type="text" name="account_holder_name" id="account_holder_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Salary (One Day) <span class="text-danger">*</span></label>
              <input type="number" name="salary_per_day" id="salary_per_day" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Opening Balance</label>
              <input type="number" name="opening_balance" id="opening_balance" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Status</label>
              <select name="status" id="status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Employee Photo</label>
              <input type="file" name="photo" class="form-control">
              <img id="photoPreview" src="" style="max-height:40px; margin-top:5px;">
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

<!-- View Modal -->
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form>
      <input type="hidden" id="viewEmployeeId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewEmployeeModalLabel">View Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Employee Name</label>
              <input type="text" id="view_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Relative Name</label>
              <input type="text" id="view_relative_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Mobile Number</label>
              <input type="text" id="view_mobile_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Alternate Mobile No</label>
              <input type="text" id="view_alternate_mobile_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Employee Email</label>
              <input type="text" id="view_email" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Date Of Birth</label>
              <input type="text" id="view_dob" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Gender</label>
              <input type="text" id="view_gender" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Aadhar Number</label>
              <input type="text" id="view_aadhar_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Pan Number</label>
              <input type="text" id="view_pan_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Current Address</label>
              <input type="text" id="view_current_address" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Permanent Address</label>
              <input type="text" id="view_permanent_address" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Marital Status</label>
              <input type="text" id="view_marital_status" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Blood Group</label>
              <input type="text" id="view_blood_group" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Education</label>
              <input type="text" id="view_education" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Joining Date</label>
              <input type="text" id="view_joining_date" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Leaving Date</label>
              <input type="text" id="view_leaving_date" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Experience Year</label>
              <input type="text" id="view_experience_year" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Role</label>
              <input type="text" id="view_role" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Department</label>
              <input type="text" id="view_department" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <input type="text" id="view_bank_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Account Number</label>
              <input type="text" id="view_account_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Account Holder Name</label>
              <input type="text" id="view_account_holder_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" id="view_ifsc_code" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Salary (One Day)</label>
              <input type="text" id="view_salary_per_day" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Opening Balance</label>
              <input type="text" id="view_opening_balance" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Status</label>
              <input type="text" id="view_status" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Employee Photo</label>
              <img id="view_photoPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div> 
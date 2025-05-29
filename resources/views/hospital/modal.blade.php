<div class="modal fade" id="hospitalModal" tabindex="-1" role="dialog" aria-labelledby="hospitalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form id="hospitalForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="hospitalId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hospitalModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Hospital Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>UserID <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Password <span class="text-danger">*</span></label>
              <input type="text" name="password" id="password" class="form-control">
              <small class="form-text text-muted">Leave blank to keep the current password.</small>
            </div>
            <div class="form-group col-md-3">
              <label>Passcode <span class="text-danger">*</span></label>
              <input type="text" name="passcode" id="passcode" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Contact No <span class="text-danger">*</span></label>
              <input type="text" name="contact_no" id="contact_no" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Email Address</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Hospital Tag Line</label>
              <input type="text" name="hospital_tag_line" id="hospital_tag_line" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>PAN Number</label>
              <input type="text" name="pan_no" id="pan_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Address <span class="text-danger">*</span></label>
              <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <select name="bank_name" id="bank_name" class="form-control">
                <option value="">Select Bank</option>
                <option value="ICICI BANK LIMITED">ICICI BANK LIMITED</option>
                <option value="STATE BANK OF INDIA">STATE BANK OF INDIA</option>
                <option value="HDFC BANK">HDFC BANK</option>
                <option value="AXIS BANK">AXIS BANK</option>
                <option value="PUNJAB NATIONAL BANK">PUNJAB NATIONAL BANK</option>
                <!-- Add more banks as needed -->
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Branch Name</label>
              <input type="text" name="branch_name" id="branch_name" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Account No</label>
              <input type="text" name="account_no" id="account_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>GSTIN Number</label>
              <input type="text" name="gstin_no" id="gstin_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>CIN Number</label>
              <input type="text" name="cin_no" id="cin_no" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Hospital Prefix</label>
              <input type="text" name="hospital_prefix" id="hospital_prefix" class="form-control">
            </div>
            <!-- Images/Uploads -->
            <div class="form-group col-md-3">
              <label>Logo</label>
              <input type="file" name="logo" class="form-control">
              <img id="logoPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Signature</label>
              <input type="file" name="signature" class="form-control">
              <img id="signaturePreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Stamp</label>
              <input type="file" name="stamp" class="form-control">
              <img id="stampPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Payment QR Code</label>
              <input type="file" name="payment_qr" class="form-control">
              <img id="paymentQrPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Letter Head (720*200)</label>
              <input type="file" name="letter_head" class="form-control">
              <img id="letterHeadPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>IdCard Design (570*900)</label>
              <input type="file" name="idcard_design" class="form-control">
              <img id="idcardDesignPreview" src="" style="max-height:40px; margin-top:5px;">
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
<div class="modal fade" id="viewHospitalModal" tabindex="-1" role="dialog" aria-labelledby="viewHospitalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form>
      <input type="hidden" id="viewHospitalId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewHospitalModalLabel">View Hospital</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label>Hospital Name</label>
              <input type="text" id="view_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>UserID</label>
              <input type="text" id="view_username" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Passcode</label>
              <input type="text" id="view_passcode" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Contact No</label>
              <input type="text" id="view_contact_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Email Address</label>
              <input type="text" id="view_email" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Hospital Tag Line</label>
              <input type="text" id="view_hospital_tag_line" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>PAN Number</label>
              <input type="text" id="view_pan_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Address</label>
              <input type="text" id="view_address" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Bank Name</label>
              <input type="text" id="view_bank_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Branch Name</label>
              <input type="text" id="view_branch_name" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>IFSC Code</label>
              <input type="text" id="view_ifsc_code" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Account No</label>
              <input type="text" id="view_account_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>GSTIN Number</label>
              <input type="text" id="view_gstin_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>CIN Number</label>
              <input type="text" id="view_cin_no" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Hospital Prefix</label>
              <input type="text" id="view_hospital_prefix" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Logo</label><br>
              <img id="view_logoPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Signature</label><br>
              <img id="view_signaturePreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Stamp</label><br>
              <img id="view_stampPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Payment QR Code</label><br>
              <img id="view_paymentQrPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>Letter Head (720*200)</label><br>
              <img id="view_letterHeadPreview" src="" style="max-height:40px; margin-top:5px;">
            </div>
            <div class="form-group col-md-3">
              <label>IdCard Design (570*900)</label><br>
              <img id="view_idcardDesignPreview" src="" style="max-height:40px; margin-top:5px;">
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
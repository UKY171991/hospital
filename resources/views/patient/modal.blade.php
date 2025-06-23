<!-- Add/Edit Patient Modal -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="patientModalLabel">
          <i class="fas fa-user-injured mr-2"></i>Add/Update Patient
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="patientForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="patient_id">
        <div class="modal-body">
          <div class="row">
            <!-- Column 1: Basic Information -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-user mr-2"></i>Basic Information
              </h6>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Patient Type</label>
                <select name="patient_type" id="patient_type" class="form-control">
                  <option value="General (OPD)">General (OPD)</option>
                  <option value="IPD">IPD</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Title</label>
                <select name="relative_title" id="relative_title" class="form-control">
                  <option value="Mr.">Mr.</option>
                  <option value="Mrs.">Mrs.</option>
                  <option value="Miss">Miss</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Patient Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Relative Name</label>
                <input type="text" name="relation_name" id="relation_name" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Relation of Relative</label>
                <select name="relation_of_relative" id="relation_of_relative" class="form-control">
                  <option value="S/O">S/O</option>
                  <option value="D/O">D/O</option>
                  <option value="W/O">W/O</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Reference Doctor/Hospital Name</label>
                <input type="text" name="reference_doctor" id="reference_doctor" class="form-control">
              </div>
            </div>
            
            <!-- Column 2: Contact & Physical Details -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-address-card mr-2"></i>Contact & Physical Details
              </h6>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Contact No</label>
                <input type="text" name="mobile" id="mobile" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Registration Date</label>
                <input type="date" name="reg_date" id="reg_date" class="form-control" value="{{ date('Y-m-d') }}">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Gender <span class="text-danger">*</span></label>
                <select name="gender" id="gender" class="form-control" required>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Address</label>
                <textarea name="address" id="address" class="form-control" rows="2"></textarea>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Age</label>
                <input type="number" name="age" id="age" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Aadhar No</label>
                <input type="text" name="aadhar_no" id="aadhar_no" class="form-control">
              </div>
            </div>
            
            <!-- Column 3: Medical & Documents -->
            <div class="col-md-4">
              <h6 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-notes-medical mr-2"></i>Medical Details
              </h6>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Card No</label>
                <input type="text" name="card_no" id="card_no" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Height (in CM)</label>
                <input type="number" name="height_cm" id="height_cm" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Weight (in KG)</label>
                <input type="number" name="weight_kg" id="weight_kg" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Blood Group <span class="text-danger">*</span></label>
                <select name="blood_group" id="blood_group" class="form-control" required>
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Color Vision <span class="text-danger">*</span></label>
                <select name="color_vision" id="color_vision" class="form-control" required>
                  <option value="Normal">Normal</option>
                  <option value="Abnormal">Abnormal</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label class="font-weight-bold">Patient Photo</label>
                <input type="file" name="photo" id="photo" class="form-control-file" accept="image/*">
                <div class="mt-2">
                  <img id="photo_preview" src="" alt="Photo Preview" class="img-thumbnail" style="max-width:120px; max-height:120px; display:none;">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>Close
          </button>
          <button type="button" class="btn btn-outline-warning" onclick="$('#patientForm')[0].reset(); $('#photo_preview').hide();">
            <i class="fas fa-undo mr-2"></i>Reset
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save mr-2"></i>Save Patient
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
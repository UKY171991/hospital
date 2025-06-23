<!-- Supplier Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="supplierForm" enctype="multipart/form-data">
                <input type="hidden" id="supplierId" name="id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="supplierModalLabel">
                        <i class="fas fa-truck me-2"></i>Add Supplier
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Gender <span class="text-danger">*</span></label>
                                <select id="gender" name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Contact No <span class="text-danger">*</span></label>
                                <input type="text" id="contact_no" name="contact_no" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" id="dob" name="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Qualification</label>
                                <input type="text" id="qualification" name="qualification" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <textarea id="address" name="address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        
                        <!-- Document Information -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">PAN No</label>
                                <input type="text" id="pan_no" name="pan_no" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Aadhar No</label>
                                <input type="text" id="aadhar_no" name="aadhar_no" class="form-control">
                            </div>
                        </div>
                        
                        <!-- Bank Information -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Bank Name</label>
                                <input type="text" id="bank_name" name="bank_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Account No</label>
                                <input type="text" id="account_no" name="account_no" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Account Holder Name</label>
                                <input type="text" id="account_holder_name" name="account_holder_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">IFSC Code</label>
                                <input type="text" id="ifsc_code" name="ifsc_code" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Opening Balance <span class="text-danger">*</span></label>
                                <input type="number" id="opening_balance" name="opening_balance" class="form-control" step="0.01" required>
                            </div>
                        </div>
                        
                        <!-- Photo and Status -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Supplier Photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <div class="mt-2">
                                <img id="photoPreview" src="" class="img-thumbnail" style="max-width:120px; display:none;" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-warning" id="resetButton">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Supplier Modal -->
<div class="modal fade" id="viewSupplierModal" tabindex="-1" role="dialog" aria-labelledby="viewSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewSupplierModalLabel">
                    <i class="fas fa-eye me-2"></i>View Supplier Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="viewSupplierId">
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" id="view_name" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Gender</label>
                            <input type="text" id="view_gender" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Contact No</label>
                            <input type="text" id="view_contact_no" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" id="view_email" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <input type="text" id="view_dob" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Qualification</label>
                            <input type="text" id="view_qualification" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea id="view_address" class="form-control" rows="2" readonly></textarea>
                        </div>
                    </div>
                    
                    <!-- Document Information -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">PAN No</label>
                            <input type="text" id="view_pan_no" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Aadhar No</label>
                            <input type="text" id="view_aadhar_no" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <!-- Bank Information -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Bank Name</label>
                            <input type="text" id="view_bank_name" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Account No</label>
                            <input type="text" id="view_account_no" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Account Holder Name</label>
                            <input type="text" id="view_account_holder_name" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">IFSC Code</label>
                            <input type="text" id="view_ifsc_code" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Opening Balance</label>
                            <input type="text" id="view_opening_balance" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <!-- Photo and Status -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Supplier Photo</label>
                            <div class="mt-2">
                                <img id="view_photoPreview" src="" class="img-thumbnail" style="max-width:120px; display:none;" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <input type="text" id="view_status" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

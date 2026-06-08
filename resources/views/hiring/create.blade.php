
<x-auth>
  <style>
    .form-section {
      background: #f8f9fa;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-section h4 {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #e9ecef;
      color: #4a5568;
    }

    .required:after {
      content: " *";
      color: #dc3545;
    }

    .price-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 16px;
      padding: 15px 25px;
      text-align: center;
      display: inline-block;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .price-amount {
      font-size: 28px;
      font-weight: bold;
    }

    .btn-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 12px;
      font-size: 18px;
      font-weight: 600;
      border-radius: 12px;
      transition: 0.3s;
    }

    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
      color: white;
    }
  </style>

  <div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> Agent Apply Form</h4>
          </div>
          <div class="card-body p-4">
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
              </div>
            @endif

            <form method="POST" action="{{ route('hiring.store') }}" enctype="multipart/form-data">
              @csrf

              <!-- Personal Details -->
              <div class="form-section">
                <h4><i class="fas fa-user-circle me-2"></i> Personal Details</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="required">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="required">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="required">Email ID</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="required">PAN Card Number</label>
                    <input type="text" name="pancard_number" class="form-control" value="{{ old('pancard_number') }}"
                      required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="required">PAN Card Image</label>
                    <input type="file" name="pancard_image" class="form-control" accept="image/*" required>
                  </div>
                </div>
              </div>

              <!-- Expected Work Date -->
              <div class="form-section">
                <h4><i class="fas fa-calendar-alt me-2"></i> Expected Work Date</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="required">Date</label>
                    <input type="date" name="expected_date" id="expected_date" class="form-control" required>
                  </div>
                </div>
              </div>

              <!-- Referred Executive -->
              <div class="form-section">
                <h4><i class="fas fa-user-tie me-2"></i> Referred Retainer</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="referred_executive_name" class="form-control"
                      value="{{ old('referred_executive_name') }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Mobile</label>
                    <input type="text" name="referred_executive_mobile" class="form-control"
                      value="{{ old('referred_executive_mobile') }}">
                  </div>
                </div>
              </div>

              <!-- Relationship Manager (name + optional mobile) -->
              <div class="form-section">
                <h4><i class="fas fa-handshake me-2"></i> Agent Manager</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="relationship_manager_name" class="form-control"
                      value="{{ old('relationship_manager_name') }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Mobile (Optional)</label>
                    <input type="text" name="relationship_manager_mobile" class="form-control"
                      value="{{ old('relationship_manager_mobile') }}">
                  </div>
                </div>
              </div>

              <!-- Amount & Terms -->
              <div class="text-center my-4">
                <div class="price-card">
                  <div class="price-amount">₹ 91</div>
                  <small>Application Fee (non‑refundable)</small>
                </div>
              </div>

              <div class="form-check mb-4">
                <input type="checkbox" name="terms_accepted" id="terms" class="form-check-input" value="1" required>
                <label for="terms" class="form-check-label">I have read and agree to the <a href="#"
                    data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a></label>
              </div>

              <button type="submit" class="btn btn-gradient w-100">
                <i class="fas fa-credit-card me-2"></i> Agent ₹91
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Terms Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Terms & Conditions</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <ul>
            <li>This advance income facility is optional and solely at company's discretion.</li>
            <li>Minimum 7 days of attendance required to apply.</li>
            <li>Within 4 days of joining, at least 3 HR Executives must be onboarded and active.</li>
            <li>Advance amount shall not exceed 30% of monthly income.</li>
            <li>Verification takes 4‑5 working days.</li>
            <li>Approved amount disbursed within 3 working days.</li>
            <li>Application fee of ₹91 is non‑refundable.</li>
            <li>Company reserves the right to reject any application without assigning any reason.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<x-slot name="scripts">
  <script>
    // Auto-fill today's date (editable)
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('expected_date').value = formattedDate;
  </script>
   </x-slot>
</x-auth>
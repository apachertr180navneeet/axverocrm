@extends('layouts.app')

<style>

/* ===== Google Font ===== */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

/* ===== Base ===== */
html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
}

/* ===== Page BG ===== */
.offer-page-bg {
    height: 100vh;
    background: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    overflow: hidden;
}

/* ===== Card ===== */
.offer-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    padding: 28px 36px 22px;
    width: 100%;
    max-width: 860px;
}

/* ===== Title ===== */
.offer-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
    letter-spacing: -0.3px;
}

/* ===== Labels ===== */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

/* ===== Inputs & Selects ===== */
.form-control {
    height: 42px !important;
    border-radius: 8px !important;
    border: 1.5px solid #d1d5db !important;
    background: #ffffff !important;
    color: #111827 !important;
    font-size: 14px !important;
    font-family: 'DM Sans', sans-serif;
    padding: 0 14px !important;
    transition: border-color 0.18s, box-shadow 0.18s;
    width: 100%;
}

.form-control:focus {
    border-color: #5b4fd8 !important;
    box-shadow: 0 0 0 3px rgba(91,79,216,0.12) !important;
    outline: none !important;
}

/* ===== Select Arrow ===== */
select.form-control {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px !important;
    padding-right: 36px !important;
    cursor: pointer;
}

/* ===== Row Spacing ===== */
.form-row-gap {
    row-gap: 12px;
}

/* ===== Divider before buttons ===== */
.btn-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 18px 0 14px;
}

/* ===== Buttons ===== */
.btn-offer-cancel,
.btn-offer-preview {
    height: 42px;
    border-radius: 8px;
    padding: 0 22px;
    font-size: 14px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    border: 1.5px solid #d1d5db;
    background: #ffffff;
    color: #374151;
    transition: background 0.15s, border-color 0.15s, color 0.15s;
    cursor: pointer;
}

.btn-offer-cancel:hover,
.btn-offer-preview:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
}

.btn-offer-update {
    height: 42px;
    border-radius: 8px;
    padding: 0 24px;
    font-size: 14px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    background: #4f46e5;
    border: none;
    color: #ffffff;
    transition: background 0.15s, transform 0.1s;
    cursor: pointer;
}

.btn-offer-update:hover {
    background: #4338ca;
    transform: translateY(-1px);
}

.btn-offer-update:active {
    transform: translateY(0);
}

/* ===== Dark Mode ===== */
body.dark .offer-page-bg   { background: #0f1117; }
body.dark .offer-card      { background: #1c1f2e; box-shadow: 0 4px 24px rgba(0,0,0,0.35); }
body.dark .offer-card h3   { color: #f9fafb; }
body.dark .form-label      { color: #9ca3af; }
body.dark .form-control    { background: #111827 !important; border-color: #374151 !important; color: #f3f4f6 !important; }
body.dark .btn-divider     { border-color: #374151; }
body.dark .btn-offer-cancel,
body.dark .btn-offer-preview { background: #1c1f2e; border-color: #374151; color: #d1d5db; }
body.dark .btn-offer-cancel:hover,
body.dark .btn-offer-preview:hover { background: #374151; color: #f9fafb; }

/* ===== Mobile ===== */
@media (max-width: 576px) {
    .offer-page-bg { height: auto; min-height: 100vh; overflow: auto; align-items: flex-start; padding: 20px 12px; }
    .offer-card    { padding: 22px 16px 18px; }
    .offer-card h3 { font-size: 17px; margin-bottom: 16px; }
    .btn-area      { flex-direction: column !important; gap: 10px !important; }
    .btn-offer-cancel, .btn-offer-preview, .btn-offer-update { width: 100% !important; height: 44px; border-radius: 10px; }
}

</style>

@section('content')

{{-- ══ Form ════════════════════════════════════════════════════════════════ --}}

<div class="offer-page-bg">
    <div class="offer-card">

        <h3>Edit Offer Letter</h3>

        <form method="POST" action="{{ route('offer-letters.update', $offer->id) }}" id="offerForm">
            @csrf
            @method('POST')

            <div class="row form-row-gap">

                {{-- Gender --}}
                <div class="col-md-3 col-12">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male"   {{ $offer->gender == 'Male'   ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $offer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other"  {{ $offer->gender == 'Other'  ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Full Name --}}
                <div class="col-md-9 col-12">
                    <label class="form-label">Candidate Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name"
                           value="{{ old('full_name', $offer->full_name) }}">
                </div>

                {{-- Email --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Candidate Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com"
                           value="{{ old('email', $offer->email) }}">
                </div>

                {{-- Spacer (desktop only) --}}
                <div class="col-md-6 d-none d-md-block"></div>
                {{-- Employment Type --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Employment Type</label>
                    <select name="employment_type" class="form-control">
                        <option value="">-- Select Type --</option>
                        <option value="Internship" {{ old('employment_type', $offer->employment_type) == 'Internship' ? 'selected' : '' }}>Retainer</option>
                        <option value="Employee"  {{ old('employment_type', $offer->employment_type) == 'Employee'  ? 'selected' : '' }}>Employee</option>
                    </select>
                </div>

                {{-- Designation --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Designation</label>
                    <select name="designation" class="form-control">
                        <option value="">-- Select Designation --</option>
                        @foreach(['Sales Manager','Assistant Sales Manager','Agent Relationship Manager','HR Manager','HR Executive','IT Executive','Sales Executive','IT Sales Manager','IT Manager','Social Media Manager','Trainer', 'Agent Manager','Retainer'] as $d)
                            <option value="{{ $d }}" {{ old('designation', $offer->designation) == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Salary --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Monthly Salary (INR)</label>
                    <input type="number" name="salary" class="form-control" placeholder="e.g. 50000"
                           value="{{ old('salary', $offer->salary) }}">
                </div>

                {{-- Joining Date --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" class="form-control"
                           value="{{ old('joining_date', $offer->joining_date->format('Y-m-d')) }}">
                </div>

            </div>

            {{-- Laravel validation errors --}}
            @if($errors->any())
            <div class="mt-3">
                @foreach($errors->all() as $error)
                    <small class="text-danger d-block" style="font-size:12px;">⚠ {{ $error }}</small>
                @endforeach
            </div>
            @endif

            {{-- Divider --}}
            <hr class="btn-divider">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-end align-items-center btn-area flex-wrap" style="gap: 10px;">

                <a href="{{ route('letter.list') }}" class="btn-offer-cancel" style="text-decoration:none; display:inline-flex; align-items:center;">
                    Cancel
                </a>

                <button type="submit" class="btn-offer-update" id="updateBtn">
                    Update
                </button>

            </div>

        </form>

    </div>
</div>

<script>

document.getElementById('offerForm').addEventListener('submit', function () {
    const btn = document.getElementById('updateBtn');
    btn.disabled    = true;
    btn.textContent = 'Updating...';
    btn.style.opacity = '0.75';
});

</script>

@endsection
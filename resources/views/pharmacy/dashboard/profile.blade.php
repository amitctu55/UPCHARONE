@extends('pharmacy.dashboard.layout')

@section('title', 'Pharmacy Profile & Compliance | UPCHAR Chemist Portal')

@section('content')
<style>
.section-nav-tabs {
    display: flex;
    gap: 8px;
    background: #FFFFFF;
    padding: 8px;
    border-radius: 12px;
    border: 1px solid var(--border-color, #E2E8F0);
    margin-bottom: 24px;
    overflow-x: auto;
    white-space: nowrap;
}

.section-tab-btn {
    border: none;
    background: transparent;
    padding: 9px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.section-tab-btn:hover {
    color: var(--primary-navy, #08364B);
    background: rgba(0, 168, 255, 0.06);
}

.section-tab-btn.active {
    background: var(--primary-navy, #08364B);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(8, 54, 75, 0.15);
}

.section-tab-btn.active i {
    color: var(--accent-cyan, #00A8FF) !important;
}

.section-panel {
    display: none;
}

.section-panel.active {
    display: block;
    animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

.show-all-mode .section-panel {
    display: block !important;
}

.btn-save-partial {
    background: linear-gradient(135deg, var(--primary-navy, #08364B) 0%, #0d4661 100%);
    color: #FFFFFF !important;
    font-weight: 700;
    font-size: 13.5px;
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-save-partial:hover {
    box-shadow: 0 4px 14px rgba(8, 54, 75, 0.25);
    transform: translateY(-1px);
}
</style>

<div class="row g-4">
    <!-- Header Summary Card -->
    <div class="col-12">
        <div class="card p-4 d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 56px; height: 56px; border-radius: 14px; background: rgba(0, 168, 255, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.8rem;">
                    <i class="bi bi-hospital"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1" id="bladeHeroStoreName" style="color: var(--primary-navy);">{{ $pharmacy->fname ?? ($pharmacy->store_name ?? 'Sanjivani 24x7 Chemist') }}</h4>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-patch-check-fill text-success me-1"></i> Form 20/21 Licensed Pharmacy &bull;
                        DL: <strong class="text-dark" id="bladeHeroDl">{{ $pharmacy->dl_20 ?? 'UP-VNS-20B-88391' }}</strong> &bull;
                        GSTIN: <strong class="text-dark">{{ $pharmacy->gstin ?? '09AABCU9603R1ZM' }}</strong>
                    </p>
                </div>
            </div>
            <div>
                <span class="badge px-3 py-2 fs-6 rounded-pill" style="background: rgba(155, 192, 60, 0.15); color: #628214; border: 1px solid var(--success-green);">
                    <i class="bi bi-shield-check me-1"></i> KYC Verified Licensed Retail Chemist
                </span>
            </div>
        </div>
    </div>

    <!-- 5-Section Navigation Tab Strip -->
    <div class="col-12">
        <div class="section-nav-tabs">
            <button type="button" class="section-tab-btn active" onclick="switchBladeTab('identity', this)">
                <i class="bi bi-person-badge-fill text-primary"></i>
                <span>1. Store & Pharmacist Identity</span>
            </button>
            <button type="button" class="section-tab-btn" onclick="switchBladeTab('compliance', this)">
                <i class="bi bi-file-earmark-medical-fill text-primary"></i>
                <span>2. Drug License & Tax Compliance</span>
            </button>
            <button type="button" class="section-tab-btn" onclick="switchBladeTab('affiliation', this)">
                <i class="bi bi-hospital-fill text-primary"></i>
                <span>3. Hospital & Doctor Affiliation</span>
            </button>
            <button type="button" class="section-tab-btn" onclick="switchBladeTab('operations', this)">
                <i class="bi bi-sliders text-primary"></i>
                <span>4. Operational Controls & SLAs</span>
            </button>
            <button type="button" class="section-tab-btn" onclick="switchBladeTab('location', this)">
                <i class="bi bi-geo-alt-fill text-danger"></i>
                <span>5. Location & Coordinates</span>
            </button>
            <button type="button" class="section-tab-btn ms-auto" onclick="switchBladeTab('all', this)">
                <i class="bi bi-view-list"></i>
                <span>View All Sections</span>
            </button>
        </div>
    </div>

    <!-- Main Profile Sections (Left Column) -->
    <div class="col-lg-8" id="bladeSectionsHost">

        <!-- ========================================== -->
        <!-- SECTION 1: Pharmacy Store & Pharmacist Identity -->
        <!-- ========================================== -->
        <div class="section-panel active" id="blade_panel_identity">
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--primary-navy);">
                        <i class="bi bi-shop text-primary"></i> 1. Pharmacy Store & Pharmacist Identity
                    </h5>
                    <span class="badge bg-light text-secondary border"><i class="bi bi-check2-circle text-success me-1"></i> Partial Save</span>
                </div>

                <form class="blade-partial-form" method="POST" action="{{ route('pharmacy.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="identity">
                    <input type="hidden" name="store_id" value="{{ $pharmacy->id ?? 1 }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Trade / Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="fname" class="form-control" value="{{ $pharmacy->fname ?? ($pharmacy->store_name ?? 'Sanjivani 24x7 Chemist') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Registered Pharmacist In-Charge <span class="text-danger">*</span></label>
                            <input type="text" name="pharmacist_name" class="form-control" value="{{ $pharmacy->pharmacist_name ?? 'Rameshwar Verma, B.Pharm' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Helpline Contact Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control" value="{{ $pharmacy->mobile ?? '9876543210' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Support Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $pharmacy->email ?? 'sanjivani@upchar.health' }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Pharmacy Council Reg. No.</label>
                            <input type="text" name="regd_no" class="form-control font-monospace" value="{{ $pharmacy->regd_no ?? 'PCI-UP-482910' }}" readonly style="background: #f8fafc;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-partial">
                            <i class="bi bi-save me-1"></i> Save Store & Pharmacist Identity
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 2: Drug License & Tax Compliance -->
        <!-- ========================================== -->
        <div class="section-panel" id="blade_panel_compliance">
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--primary-navy);">
                        <i class="bi bi-file-earmark-medical text-primary"></i> 2. Drug License (Form 20/21) & Tax Compliance
                    </h5>
                    <span class="badge bg-light text-secondary border"><i class="bi bi-shield-check text-primary me-1"></i> Statutory Compliance</span>
                </div>

                <form class="blade-partial-form" method="POST" action="{{ route('pharmacy.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="compliance">
                    <input type="hidden" name="store_id" value="{{ $pharmacy->id ?? 1 }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Drug License Form 20 (Allopathic) <span class="text-danger">*</span></label>
                            <input type="text" name="dl_20" class="form-control text-uppercase font-monospace" value="{{ $pharmacy->dl_20 ?? 'UP-VNS-20B-88391' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Drug License Form 21 (Schedule C/C1) <span class="text-danger">*</span></label>
                            <input type="text" name="dl_21" class="form-control text-uppercase font-monospace" value="{{ $pharmacy->dl_21 ?? 'UP-VNS-21B-88392' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">GSTIN (15 Digits) <span class="text-danger">*</span></label>
                            <input type="text" name="gstin" class="form-control text-uppercase font-monospace" value="{{ $pharmacy->gstin ?? '09AABCU9603R1ZM' }}" maxlength="15" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Master License Number</label>
                            <input type="text" name="drug_license_no" class="form-control font-monospace" value="{{ $pharmacy->drug_license_no ?? 'UP-VNS-20B-88391' }}">
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background: rgba(8, 54, 75, 0.04); border: 1px dashed #cbd5e1;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                        <div>
                                            <div class="fw-semibold small">Form 20/21 Combined Certificate.pdf</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Verified by UP FDA &bull; Retail Chemist License</div>
                                        </div>
                                    </div>
                                    <input type="file" name="drug_license_file" class="form-control form-control-sm w-auto" accept=".pdf,image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-partial">
                            <i class="bi bi-save me-1"></i> Save Drug License & Tax Compliance
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 3: Hospital & Doctor Affiliation -->
        <!-- ========================================== -->
        <div class="section-panel" id="blade_panel_affiliation">
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--primary-navy);">
                        <i class="bi bi-hospital-fill text-info"></i> 3. Hospital & Doctor Affiliation
                    </h5>
                    <span class="badge bg-light text-secondary border"><i class="bi bi-shuffle text-info me-1"></i> Outpatient Routing</span>
                </div>

                <form class="blade-partial-form" method="POST" action="{{ route('pharmacy.profile.update') }}">
                    @csrf
                    <input type="hidden" name="section" value="affiliation">
                    <input type="hidden" name="store_id" value="{{ $pharmacy->id ?? 1 }}">

                    <p class="text-muted small mb-3">
                        Linking your pharmacy to an adjacent clinic or hospital provides top algorithmic search ranking when doctors at that facility prescribe medications to outpatients.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Adjacent Hospital / Medical Center</label>
                            <select name="associated_hospital_id" class="form-select">
                                <option value="">-- No Hospital Tagging (Standalone Chemist) --</option>
                                @foreach($hospitals as $hosp)
                                    <option value="{{ $hosp->id }}" {{ ($pharmacy->associated_hospital_id ?? 11) == $hosp->id ? 'selected' : '' }}>
                                        {{ $hosp->name }} ({{ $hosp->location ?? 'Varanasi' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Attached Primary Consulting Doctor</label>
                            <select name="associated_doctor_id" class="form-select">
                                <option value="">-- No Specific Doctor Tagging --</option>
                                <option value="1" selected>Dr. Alok Nath, MBBS, MD</option>
                                <option value="2">Dr. Priya Singh, MS (Ortho)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-partial">
                            <i class="bi bi-save me-1"></i> Save Hospital & Doctor Affiliation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 4: Operational Controls & Dispatch SLAs -->
        <!-- ========================================== -->
        <div class="section-panel" id="blade_panel_operations">
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--primary-navy);">
                        <i class="bi bi-sliders text-primary"></i> 4. Operational Controls & Dispatch SLAs
                    </h5>
                    <span class="badge bg-light text-secondary border"><i class="bi bi-clock-history text-primary me-1"></i> Dispatch Rules</span>
                </div>

                <form class="blade-partial-form" method="POST" action="{{ route('pharmacy.profile.update') }}">
                    @csrf
                    <input type="hidden" name="section" value="operations">
                    <input type="hidden" name="store_id" value="{{ $pharmacy->id ?? 1 }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Daily Operating Hours <span class="text-danger">*</span></label>
                            <input type="text" name="operating_hours" class="form-control" value="{{ $pharmacy->operating_hours ?? '08:00 AM - 11:00 PM (24x7 Emergency)' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Delivery Dispatch Service Radius <span class="text-danger">*</span></label>
                            <select name="dispatch_radius_km" class="form-select">
                                <option value="3" {{ ($pharmacy->dispatch_radius_km ?? 5) == 3 ? 'selected' : '' }}>3 km (Ultra Fast 15-min)</option>
                                <option value="5" {{ ($pharmacy->dispatch_radius_km ?? 5) == 5 ? 'selected' : '' }}>5 km (Standard Delivery)</option>
                                <option value="10" {{ ($pharmacy->dispatch_radius_km ?? 5) == 10 ? 'selected' : '' }}>10 km (Extended City Hub)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Maximum Active Packing Queue</label>
                            <input type="number" name="max_queue_limit" class="form-control font-monospace" min="5" max="100" value="{{ $pharmacy->max_queue_limit ?? 25 }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="p-3 rounded border w-100" style="background: #fef2f2; border-color: #fecaca !important;">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="is_emergency_closed" value="1" id="bladeEmergencyClosed" {{ !empty($pharmacy->is_emergency_closed) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-danger small" for="bladeEmergencyClosed">Emergency Store Closure (Pause Incoming)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-partial">
                            <i class="bi bi-save me-1"></i> Save Operational Controls & SLAs
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 5: Location & Dispatch Coordinates -->
        <!-- ========================================== -->
        <div class="section-panel" id="blade_panel_location">
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--primary-navy);">
                        <i class="bi bi-geo-alt-fill text-danger"></i> 5. Location & Dispatch Coordinates
                    </h5>
                    <span class="badge bg-light text-secondary border"><i class="bi bi-pin-map text-danger me-1"></i> GPS Pinning</span>
                </div>

                <form class="blade-partial-form" method="POST" action="{{ route('pharmacy.profile.update') }}">
                    @csrf
                    <input type="hidden" name="section" value="location">
                    <input type="hidden" name="store_id" value="{{ $pharmacy->id ?? 1 }}">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Physical Store Street Address <span class="text-danger">*</span></label>
                            <input type="text" name="street" class="form-control" value="{{ $pharmacy->street ?? 'Shop 4, Durgakund Road, Near Kabir Mandir, Varanasi' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ $pharmacy->city ?? 'Varanasi' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pincode <span class="text-danger">*</span></label>
                            <input type="text" name="pincode" class="form-control font-monospace" value="{{ $pharmacy->pincode ?? '221005' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Store Latitude</label>
                            <input type="number" step="0.0000001" name="lat" id="bladeStoreLat" class="form-control font-monospace" value="{{ $pharmacy->lat ?? '25.3176000' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Store Longitude</label>
                            <input type="number" step="0.0000001" name="lng" id="bladeStoreLng" class="form-control font-monospace" value="{{ $pharmacy->lng ?? '82.9739000' }}" required>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="getBladeGeo()"><i class="bi bi-crosshair me-1"></i> Detect Current GPS Coordinates</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-partial">
                            <i class="bi bi-save me-1"></i> Save Location & Coordinates
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Right Column: Verification Badges & Quick Stats -->
    <div class="col-lg-4">
        <!-- Trust & Compliance Card -->
        <div class="card p-4 mb-4" style="border-left: 4px solid var(--accent-cyan);">
            <h6 class="fw-bold mb-3" style="color: var(--primary-navy);"><i class="bi bi-shield-lock-fill text-info me-1"></i> Regulatory Compliance Status</h6>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: rgba(155, 192, 60, 0.1);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-semibold">Form 20 Drug License</span>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: rgba(155, 192, 60, 0.1);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-semibold">Form 21 Drug License</span>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: rgba(155, 192, 60, 0.1);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-semibold">GSTIN Tax Audit</span>
                    </div>
                    <span class="badge bg-success">Verified</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background: rgba(0, 168, 255, 0.1);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-snow2 text-info"></i>
                        <span class="small fw-semibold">Cold-Chain Certification</span>
                    </div>
                    <span class="badge bg-info text-dark">Approved</span>
                </div>
            </div>
        </div>

        <!-- Rapid Dispatch Coverage -->
        <div class="card p-4 mb-4">
            <h6 class="fw-bold mb-2" style="color: var(--primary-navy);"><i class="bi bi-radar text-primary me-1"></i> Dispatch Fleet Coverage</h6>
            <p class="text-muted small">UPCHAR fleet riders in your perimeter:</p>
            <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <div style="font-size: 2rem; color: var(--accent-cyan);">
                    <i class="bi bi-bicycle"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: var(--primary-navy);">8 Active Riders</h5>
                    <div class="text-muted small">Average pickup SLA: <strong>8.2 mins</strong></div>
                </div>
            </div>
        </div>

        <!-- Help & Support -->
        <div class="card p-4" style="background: linear-gradient(135deg, var(--primary-navy), #041822); color: #fff;">
            <h6 class="fw-bold mb-2 text-white"><i class="bi bi-headset me-1 text-info"></i> Pharmacist Helpdesk</h6>
            <p class="small text-white-50 mb-3">Need assistance updating legal licenses or linking new medical centers? Contact UPCHAR Pharmacy Relations team.</p>
            <a href="tel:1800123456" class="btn btn-sm btn-outline-light w-100"><i class="bi bi-telephone me-1"></i> Toll-Free: 1800-UPCHAR-RX</a>
        </div>
    </div>
</div>

<script>
function switchBladeTab(tabName, btn) {
    document.querySelectorAll('.section-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const host = document.getElementById('bladeSectionsHost');
    if (tabName === 'all') {
        host.classList.add('show-all-mode');
        document.querySelectorAll('.section-panel').forEach(p => p.classList.add('active'));
    } else {
        host.classList.remove('show-all-mode');
        document.querySelectorAll('.section-panel').forEach(p => p.classList.remove('active'));
        const target = document.getElementById('blade_panel_' + tabName);
        if (target) target.classList.add('active');
    }
}

function getBladeGeo() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('bladeStoreLat').value = pos.coords.latitude.toFixed(7);
            document.getElementById('bladeStoreLng').value = pos.coords.longitude.toFixed(7);
            alert('Coordinates detected: ' + pos.coords.latitude.toFixed(5) + ', ' + pos.coords.longitude.toFixed(5));
        }, function(err) {
            alert('Unable to retrieve location. Using default GPS.');
        });
    } else {
        alert('Geolocation is not supported by your browser.');
    }
}

document.querySelectorAll('.blade-partial-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        const origText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check2 me-1"></i> Saved!';
            alert(data.message || 'Section updated successfully!');
            setTimeout(() => { submitBtn.innerHTML = origText; }, 2500);
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = origText;
            alert('Saved successfully!');
        });
    });
});
</script>
@endsection

@extends('pharmacy.dashboard.layout')

@section('title', 'Physical Presence & Cold-Chain Gallery | UPCHAR Chemist Portal')

@section('content')
<div class="row g-4">
    <!-- Top Information Banner -->
    <div class="col-12">
        <div class="card p-4 d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 56px; height: 56px; border-radius: 14px; background: rgba(0, 168, 255, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.8rem;">
                    <i class="bi bi-camera-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--primary-navy);">Physical Presence & Cold-Chain Inspection Gallery</h4>
                    <p class="text-muted small mb-0">Upload high-resolution photographic proof of your storefront, license display board, storage racks, and refrigeration units.</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Inspection Photo
            </button>
        </div>
    </div>

    <!-- 4 Mandatory KYC Categories Info Cards -->
    <div class="col-md-3">
        <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--accent-cyan);">
            <div class="fs-1 text-primary mb-2"><i class="bi bi-shop-window"></i></div>
            <h6 class="fw-bold mb-1" style="color: var(--primary-navy);">1. Storefront Exterior</h6>
            <p class="text-muted small mb-2">Clear signage showing pharmacy name, entrance, and road access.</p>
            <span class="badge bg-success bg-opacity-10 text-success">Mandatory for KYC</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--primary-navy);">
            <div class="fs-1 text-navy mb-2"><i class="bi bi-award-fill" style="color: var(--primary-navy);"></i></div>
            <h6 class="fw-bold mb-1" style="color: var(--primary-navy);">2. License Board Display</h6>
            <p class="text-muted small mb-2">Form 20/21 prominently displayed behind the counter as per Drugs Act.</p>
            <span class="badge bg-success bg-opacity-10 text-success">Statutory Rule 65</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--success-green);">
            <div class="fs-1 text-success mb-2"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <h6 class="fw-bold mb-1" style="color: var(--primary-navy);">3. Medicine Storage Racks</h6>
            <p class="text-muted small mb-2">Organized, pest-controlled shelving following FEFO categorizations.</p>
            <span class="badge bg-success bg-opacity-10 text-success">Quality Assurance</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--accent-cyan);">
            <div class="fs-1 text-info mb-2"><i class="bi bi-snow2"></i></div>
            <h6 class="fw-bold mb-1" style="color: var(--primary-navy);">4. Cold-Chain Unit (2°C - 8°C)</h6>
            <p class="text-muted small mb-2">Calibrated pharmaceutical refrigerator for insulins, vaccines, and biologics.</p>
            <span class="badge bg-info bg-opacity-10 text-info">Cold-Chain Certified</span>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="col-12">
        <div class="card p-4">
            <h5 class="fw-bold mb-4" style="color: var(--primary-navy);"><i class="bi bi-images text-primary me-2"></i> Verified Inspection Proofs</h5>
            
            <div class="row g-4">
                <!-- Sample Photo 1: Storefront -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 overflow-hidden shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div style="height: 180px; background: linear-gradient(135deg, #08364B, #041822); display: flex; align-items: center; justify-content: center; color: #fff;">
                            <div class="text-center">
                                <i class="bi bi-shop fs-1 text-cyan"></i>
                                <div class="small fw-semibold mt-2">Storefront Signboard</div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-primary">STOREFRONT</span>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Verified</span>
                            </div>
                            <h6 class="fw-bold small mb-1" style="color: var(--primary-navy);">Front Elevation & Entrance</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Verified on 12 Jan 2024 by Super Admin KYC team.</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Photo 2: License Board -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 overflow-hidden shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div style="height: 180px; background: linear-gradient(135deg, #1e293b, #0f172a); display: flex; align-items: center; justify-content: center; color: #fff;">
                            <div class="text-center">
                                <i class="bi bi-file-earmark-medical fs-1 text-info"></i>
                                <div class="small fw-semibold mt-2">Form 20/21 Board</div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-secondary">LICENSE_BOARD</span>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Verified</span>
                            </div>
                            <h6 class="fw-bold small mb-1" style="color: var(--primary-navy);">Official Regulatory Certificates</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">FDA UP state drug license board copy.</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Photo 3: Cold-Chain Unit -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 overflow-hidden shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div style="height: 180px; background: linear-gradient(135deg, #0284c7, #0369a1); display: flex; align-items: center; justify-content: center; color: #fff;">
                            <div class="text-center">
                                <i class="bi bi-snow2 fs-1 text-white"></i>
                                <div class="small fw-semibold mt-2">Digital Temp: 3.8°C</div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-info text-dark">COLD_CHAIN</span>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Certified</span>
                            </div>
                            <h6 class="fw-bold small mb-1" style="color: var(--primary-navy);">Medical Grade Refrigerator</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Equipped with battery backup & live temperature logger.</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Photo 4: Storage Racks -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 overflow-hidden shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div style="height: 180px; background: linear-gradient(135deg, #334155, #1e293b); display: flex; align-items: center; justify-content: center; color: #fff;">
                            <div class="text-center">
                                <i class="bi bi-grid-3x3-gap fs-1 text-success"></i>
                                <div class="small fw-semibold mt-2">FEFO Labeled Aisles</div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-dark">STORAGE_RACKS</span>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Verified</span>
                            </div>
                            <h6 class="fw-bold small mb-1" style="color: var(--primary-navy);">Clean Shelving & Dispensing Bay</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Adheres to Good Pharmacy Practice standards.</p>
                        </div>
                    </div>
                </div>

                <!-- Dynamically Uploaded Images -->
                @foreach($galleryImages as $img)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 overflow-hidden shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div style="height: 180px; background: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image fs-1 text-secondary"></i>
                        </div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-primary">{{ $img->category ?? 'STOREFRONT' }}</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Under Review</span>
                            </div>
                            <h6 class="fw-bold small mb-1" style="color: var(--primary-navy);">{{ $img->shot_description ?? 'Inspection Proof' }}</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Uploaded {{ date('d M Y', strtotime($img->date ?? now())) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--primary-navy); color: #fff;">
                <h5 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-up me-2"></i> Upload Verification Photo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pharmacy.gallery.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Photo Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="STOREFRONT">1. Storefront Exterior / Signage</option>
                            <option value="LICENSE_BOARD">2. Drug License Form 20/21 Board</option>
                            <option value="STORAGE_RACKS">3. Medicine Storage Racks & Formularies</option>
                            <option value="COLD_CHAIN_FRIDGE">4. Cold-Chain Refrigerator (2°C - 8°C)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Select Photo File (JPEG/PNG, Max 5MB) *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Short Label / Caption</label>
                        <input type="text" name="short_description" class="form-control" placeholder="e.g., Main counter license plaque" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold">Additional Inspection Notes (Optional)</label>
                        <textarea name="long_description" class="form-control" rows="2" placeholder="e.g., Refrigerator calibrated on 10th Jan; temp logged at 3.5 deg C."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Upload Proof</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

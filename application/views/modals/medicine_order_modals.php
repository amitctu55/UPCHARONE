<!-- UPCHAR Medicine Delivery & Prescription Modals Suite -->
<style>
    .upchar-modal-header {
        background: #08364B;
        color: #FFFFFF;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        padding: 16px 24px;
    }
    .upchar-modal-header .close {
        color: #FFFFFF;
        opacity: 0.85;
        font-size: 28px;
        font-weight: 300;
        line-height: 1;
        padding: 8px 12px;
        margin: -8px -8px -8px auto;
        min-width: 44px;
        min-height: 44px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s ease, opacity 0.2s ease;
    }
    .upchar-modal-header .close:hover,
    .upchar-modal-header .close:focus {
        opacity: 1;
        background: rgba(255, 255, 255, 0.15);
        outline: none;
    }
    .upchar-modal-title {
        font-weight: 800;
        font-size: 18px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .rx-dropzone {
        border: 2px dashed #00A8FF;
        background: #F0F9FF;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .rx-dropzone:hover {
        background: #E0F2FE;
        border-color: #0284C7;
    }
    .store-compare-card {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 16px;
        background: #FFFFFF;
        transition: all 0.2s ease;
    }
    .store-compare-card:hover {
        border-color: #00A8FF;
        box-shadow: 0 4px 12px rgba(0, 168, 255, 0.12);
    }
    .store-compare-card.doctor-pinned-store {
        border: 2px solid #00A8FF;
        background: #F8FCFF;
        position: relative;
    }
    .doctor-pinned-badge {
        position: absolute;
        top: -10px;
        right: 14px;
        background: #08364B;
        color: #00A8FF;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 10px;
        border-radius: 12px;
        border: 1px solid #00A8FF;
        letter-spacing: 0.5px;
    }
    .tracking-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 30px 0 20px;
    }
    .tracking-timeline::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 20px;
        right: 20px;
        height: 4px;
        background: #E2E8F0;
        z-index: 1;
    }
    .tracking-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .tracking-step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 3px solid #CBD5E1;
        margin: 0 auto 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #64748B;
        font-weight: bold;
    }
    .tracking-step.completed .tracking-step-circle {
        background: #10B981;
        border-color: #10B981;
        color: #FFFFFF;
    }
    .tracking-step.active .tracking-step-circle {
        background: #00A8FF;
        border-color: #00A8FF;
        color: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(0, 168, 255, 0.25);
    }
    .tracking-step-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }
    .tracking-otp-box {
        background: #FEF3C7;
        border: 2px dashed #F59E0B;
        border-radius: 10px;
        padding: 14px 20px;
        text-align: center;
        margin-top: 20px;
    }
</style>

<!-- 1. Prescription Upload Modal -->
<div class="modal fade" id="upcharRxUploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header upchar-modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title upchar-modal-title">
                    <i class="fas fa-file-medical"></i> Upload Doctor's Prescription
                </h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 13.5px; color: #475569; line-height: 1.5;">
                    Indian drug regulations require valid prescriptions for Schedule H and H1 medications. Upload your prescription to route it to your nearest licensed partner pharmacy for pharmacist validation.
                </p>

                <div class="rx-dropzone" onclick="$('#rxFileInput').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 44px; color: #00A8FF; margin-bottom: 10px;"></i>
                    <h5 style="margin: 0 0 6px; font-weight: 800; color: #08364B;">Click or Drag to Upload Prescription</h5>
                    <p style="margin: 0; font-size: 12px; color: #64748B;">
                        Supports JPG, PNG, WebP or PDF (Max Size: 5MB)
                    </p>
                    <input type="file" id="rxFileInput" style="display: none;" accept="image/*,.pdf" onchange="handleRxFileSelect(this)">
                </div>

                <div id="rxSelectedFileInfo" style="display: none; margin-top: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px 14px; align-items: center; justify-content: space-between;">
                    <span id="rxSelectedFileName" style="font-weight: 600; font-size: 13px; color: #08364B;"></span>
                    <button type="button" class="btn btn-xs btn-danger" onclick="clearRxFile()">Remove</button>
                </div>

                <div id="rxUploadSuccessBanner" style="display: none; margin-top: 14px;" class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <strong>Prescription Uploaded!</strong> Reference ID: #<span id="uploadedRxId"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnUploadRxAction" onclick="submitPrescriptionUpload()" style="background: #08364B; border-color: #08364B; font-weight: 700;">
                    <i class="fas fa-upload"></i> Upload & Route to Pharmacy
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Pharmacy Comparison & Medicine Stock Modal -->
<div class="modal fade" id="upcharMedicineCompareModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header upchar-modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title upchar-modal-title">
                    <i class="fas fa-pills" style="color: #00A8FF;"></i> Check Medicine Stock & Local Pharmacies
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px 24px;">
                <!-- Search bar in modal -->
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            <input type="text" id="modalMedKeyword" class="form-control" placeholder="Search Brand or Salt (e.g. Paracetamol, Augmentin, Pan-D, Dolo)..." value="Paracetamol">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-block" onclick="runMedicineCompare()" style="background: #00A8FF; color: #FFF; font-weight: 700;">
                            <i class="fas fa-sync-alt"></i> Check Availability
                        </button>
                    </div>
                </div>

                <div id="modalCompareLoading" class="text-center" style="display: none; padding: 40px 0;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #00A8FF;"></i>
                    <p style="margin-top: 10px; color: #64748B;">Searching partner pharmacies and live stock...</p>
                </div>

                <!-- Stores List Container -->
                <div id="modalStoresList"></div>

                <!-- Doorstep Checkout Confirmation Drawer -->
                <div id="modalDoorstepCheckout" style="display: none; background: #FFFFFF; border: 1.5px solid #00A8FF; border-radius: 12px; padding: 20px; margin-top: 16px; box-shadow: 0 8px 24px rgba(0, 168, 255, 0.12);">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px; margin-bottom: 14px;">
                        <h4 style="margin: 0; font-weight: 800; color: #08364B; font-size: 16px;">
                            <i class="fas fa-shopping-bag" style="color: #9BC03C;"></i> Confirm Doorstep Medicine Order
                        </h4>
                        <button type="button" class="btn btn-xs btn-default" onclick="cancelDoorstepCheckout()" style="font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Change Pharmacy
                        </button>
                    </div>

                    <!-- Selected Pharmacy & Medicine Summary -->
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 16px; margin-bottom: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="color: #08364B; font-size: 15px;" id="checkoutBrandName">Medicine Name</strong>
                            <span class="badge" style="background: #00A8FF; font-size: 11px;" id="checkoutStoreBadge">Sanjivani 24x7 Chemist</span>
                        </div>
                        <div style="font-size: 12.5px; color: #64748B;">
                            <i class="fas fa-store" style="color: #00A8FF;"></i> <span id="checkoutStoreName">Sanjivani 24x7 Chemist & Druggists</span> &bull; 
                            <i class="fas fa-bolt" style="color: #059669;"></i> <span id="checkoutEta">Est. Delivery 20 - 30 mins</span>
                        </div>
                    </div>

                    <!-- Quantity & Price Calculator -->
                    <div class="row" style="margin-bottom: 14px; background: #FFF; padding: 10px 4px; border-radius: 8px;">
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #475569; display:block; margin-bottom:4px;">Quantity</label>
                            <div class="input-group" style="width: 120px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" type="button" onclick="adjustCheckoutQty(-1)"><i class="fas fa-minus"></i></button>
                                </span>
                                <input type="number" id="checkoutQty" class="form-control input-sm text-center" value="1" min="1" max="20" readonly style="font-weight: 700; font-size: 14px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" type="button" onclick="adjustCheckoutQty(1)"><i class="fas fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 text-right">
                            <div style="font-size: 12px; color: #64748B;">Item Total: <span style="font-weight: 700; color: #08364B;">₹<span id="checkoutItemTotal">0.00</span></span></div>
                            <div style="font-size: 12px; color: #64748B;">Doorstep Delivery: <span style="font-weight: 700; color: #059669;">₹40.00</span></div>
                            <div style="font-size: 15px; font-weight: 800; color: #08364B; margin-top: 2px;">
                                Grand Total: ₹<span id="checkoutGrandTotal">0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Contact & Address Inputs -->
                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 12px;">
                            <label for="checkoutCustomerName" style="font-size: 12px; font-weight: 700; color: #475569;">Patient Name <span style="color:#E63946;">*</span></label>
                            <input type="text" id="checkoutCustomerName" class="form-control input-sm" placeholder="Full Name" value="Patient">
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 12px;">
                            <label for="checkoutCustomerPhone" style="font-size: 12px; font-weight: 700; color: #475569;">Contact Mobile (for OTP) <span style="color:#E63946;">*</span></label>
                            <input type="tel" id="checkoutCustomerPhone" class="form-control input-sm" placeholder="10-digit mobile" value="9839112233" maxlength="10">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label for="checkoutAddress" style="font-size: 12px; font-weight: 700; color: #475569;">Doorstep Delivery Address <span style="color:#E63946;">*</span></label>
                        <input type="text" id="checkoutAddress" class="form-control input-sm" placeholder="House/Flat No., Landmark, Area, City" value="Sigra, Varanasi, Uttar Pradesh">
                    </div>

                    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 12.5px; color: #065F46; font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: #10B981;"></i> Payment Mode: <strong>Cash on Delivery (COD) / UPI QR at Doorstep</strong>
                        </span>
                        <span class="badge" style="background: #10B981; font-size: 10px;">Zero Online Risk</span>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="btn btn-default" onclick="cancelDoorstepCheckout()">Cancel</button>
                        <button type="button" class="btn" id="btnConfirmDoorstepOrder" onclick="executeDoorstepOrder()" style="background: #9BC03C; color: #FFFFFF; font-weight: 800; border-radius: 6px; padding: 9px 24px; font-size: 14px; box-shadow: 0 4px 12px rgba(155, 192, 60, 0.35);">
                            <i class="fas fa-motorcycle"></i> Confirm &amp; Dispatch Order
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                <small style="color: #64748B;">
                    <i class="fas fa-shield-alt" style="color: #9BC03C;"></i> 100% Genuine Medicines &bull; Registered Pharmacist Verification
                </small>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Live Order Tracking Modal -->
<div class="modal fade" id="upcharOrderTrackingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header upchar-modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title upchar-modal-title">
                    <i class="fas fa-map-marker-alt" style="color: #00A8FF;"></i> Live Medicine Order Tracking
                </h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 12px;">
                    <div>
                        <span style="font-size: 12px; color: #64748B;">ORDER CODE:</span>
                        <h4 style="margin: 2px 0; font-weight: 800; color: #08364B;" id="trackOrderCode">UPM-260910-4412</h4>
                    </div>
                    <div>
                        <span class="label label-info" id="trackStatusBadge" style="font-size: 12px; padding: 4px 12px; border-radius: 12px;">IN_TRANSIT</span>
                    </div>
                </div>

                <!-- 4-Stage Progress Timeline -->
                <div class="tracking-timeline">
                    <div class="tracking-step completed" id="stepPlaced">
                        <div class="tracking-step-circle"><i class="fas fa-check"></i></div>
                        <div class="tracking-step-title">Order Placed</div>
                    </div>
                    <div class="tracking-step completed" id="stepRx">
                        <div class="tracking-step-circle"><i class="fas fa-check"></i></div>
                        <div class="tracking-step-title">Rx Verified</div>
                    </div>
                    <div class="tracking-step completed" id="stepPacked">
                        <div class="tracking-step-circle"><i class="fas fa-check"></i></div>
                        <div class="tracking-step-title">Packed</div>
                    </div>
                    <div class="tracking-step active" id="stepTransit">
                        <div class="tracking-step-circle"><i class="fas fa-motorcycle"></i></div>
                        <div class="tracking-step-title">Out for Delivery</div>
                    </div>
                    <div class="tracking-step" id="stepDelivered">
                        <div class="tracking-step-circle"><i class="fas fa-home"></i></div>
                        <div class="tracking-step-title">Delivered</div>
                    </div>
                </div>

                <!-- Rider & Pharmacy Details -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px; margin-top: 18px;">
                    <div style="font-size: 13px; margin-bottom: 6px;">
                        <strong>Dispensing Store:</strong> <span id="trackStoreName">Apex Care Medicos & Chemist</span>
                    </div>
                    <div style="font-size: 13px; margin-bottom: 6px;">
                        <strong>Delivery Rider:</strong> <span id="trackRiderName">Rahul Yadav (UP-65-AX-4412)</span>
                    </div>
                    <div style="font-size: 13px;">
                        <strong>Estimated Arrival:</strong> <span id="trackEta" style="color: #10B981; font-weight: bold;">Within 25 mins</span>
                    </div>
                </div>

                <!-- Delivery OTP Box -->
                <div class="tracking-otp-box">
                    <span style="font-size: 12px; font-weight: bold; color: #92400E; text-transform: uppercase;">
                        <i class="fas fa-key"></i> Doorstep Delivery OTP
                    </span>
                    <div style="font-size: 32px; font-weight: 900; letter-spacing: 8px; color: #08364B; margin: 6px 0;" id="trackOtpDisplay">
                        8492
                    </div>
                    <small style="color: #78350F;">
                        Share this secret 4-digit code with your UPCHAR rider only after inspecting the unbroken package seal.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAffiliatedDoctorId = null;
let currentPrescriptionId = null;

function openPrescriptionModal() {
    $('#upcharRxUploadModal').modal('show');
}

function openMedicineCompareModal(doctorId = null, keyword = null) {
    if (typeof doctorId === 'number' || (typeof doctorId === 'string' && !isNaN(parseInt(doctorId)) && parseInt(doctorId) > 0)) {
        currentAffiliatedDoctorId = parseInt(doctorId);
    } else if (typeof doctorId === 'string' && isNaN(parseInt(doctorId))) {
        keyword = doctorId;
        currentAffiliatedDoctorId = null;
    } else {
        currentAffiliatedDoctorId = null;
    }
    if (keyword && typeof keyword === 'string') {
        $('#modalMedKeyword').val(keyword);
    }
    $('#upcharMedicineCompareModal').modal('show');
    runMedicineCompare();
}

function handleRxFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        $('#rxSelectedFileName').text(file.name + ' (' + Math.round(file.size/1024) + ' KB)');
        $('#rxSelectedFileInfo').css('display', 'flex');
    }
}

function clearRxFile() {
    $('#rxFileInput').val('');
    $('#rxSelectedFileInfo').hide();
}

function submitPrescriptionUpload() {
    const fileInput = document.getElementById('rxFileInput');
    if (!fileInput.files || !fileInput.files[0]) {
        alert('Please select or drag a prescription file first.');
        return;
    }

    const formData = new FormData();
    formData.append('prescription_file', fileInput.files[0]);

    $('#btnUploadRxAction').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

    $.ajax({
        url: '<?=base_url("api/v1/prescriptions/upload");?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp) {
            $('#btnUploadRxAction').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload & Route to Pharmacy');
            if (resp.status === 'success') {
                currentPrescriptionId = resp.data.prescription_id;
                $('#uploadedRxId').text(currentPrescriptionId);
                $('#rxUploadSuccessBanner').show();
                clearRxFile();
                setTimeout(function() {
                    $('#upcharRxUploadModal').modal('hide');
                    // Automatically open compare modal with prescription attached
                    openMedicineCompareModal(currentAffiliatedDoctorId);
                }, 1500);
            }
        },
        error: function(xhr) {
            $('#btnUploadRxAction').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload & Route to Pharmacy');
            const err = xhr.responseJSON ? xhr.responseJSON.message : 'Upload failed. Please try again.';
            alert('Upload Error: ' + err);
        }
    });
}

function runMedicineCompare() {
    const keyword = $('#modalMedKeyword').val().trim();
    $('#modalCompareLoading').show();
    $('#modalStoresList').empty();

    let url = '<?=base_url("api/v1/medicines/compare");?>?keyword=' + encodeURIComponent(keyword) + '&user_lat=25.3176&user_lng=82.9739&radius_km=10';
    if (currentAffiliatedDoctorId) {
        url += '&doctor_id=' + currentAffiliatedDoctorId;
    }

    $.getJSON(url, function(resp) {
        $('#modalCompareLoading').hide();
        if (!resp.data || resp.data.length === 0) {
            $('#modalStoresList').html(`
                <div class="text-center" style="padding: 30px; color: #64748B;">
                    <i class="fas fa-pills" style="font-size: 36px; color: #CBD5E1; margin-bottom: 10px;"></i>
                    <p>No partner pharmacies currently have "<strong>${keyword}</strong>" in local stock within 10 km.</p>
                </div>
            `);
            return;
        }

        let html = '';
        resp.data.forEach(function(item) {
            const isDoctorPinned = item.is_pinned_doctor;
            const discountBadge = item.pricing.discount_percentage > 0 
                ? `<span class="badge" style="background: #E63946; font-size: 11px;">${item.pricing.discount_percentage}% OFF</span>` 
                : '';

            html += `
                <div class="store-compare-card ${isDoctorPinned ? 'doctor-pinned-store' : ''}">
                    ${isDoctorPinned ? '<div class="doctor-pinned-badge"><i class="fas fa-star"></i> DOCTOR AFFILIATED CHEMIST</div>' : ''}
                    <div class="row" style="margin: 0; display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-sm-6" style="padding: 0;">
                            <h4 style="margin: 0 0 6px; font-weight: 700; font-size: 16px; color: #08364B; line-height: 1.3;">
                                ${item.store_name}
                            </h4>
                            <div style="font-size: 13px; color: #475569; margin-bottom: 6px; line-height: 1.4;">
                                <i class="fas fa-map-marker-alt" style="color: #00A8FF;"></i> ${item.address}, ${item.city} &bull; <strong>${item.distance_km} km away</strong>
                            </div>
                            <div style="font-size: 13px; color: #059669; font-weight: 600;">
                                <i class="fas fa-bolt"></i> Est. Delivery: ${item.estimated_delivery_time}
                            </div>
                        </div>

                        <div class="col-sm-3" style="padding: 0; text-align: center;">
                            <div style="font-size: 13px; color: #475569; margin-bottom: 4px; font-weight: 500;">${item.medicine.brand_name} (${item.medicine.dosage_form})</div>
                            <div style="font-size: 18px; font-weight: 800; color: #08364B;">
                                ₹${item.pricing.selling_price.toFixed(2)}
                                <small style="text-decoration: line-through; color: #94A3B8; font-size: 13px;">₹${item.pricing.mrp.toFixed(2)}</small>
                            </div>
                            <div>${discountBadge}</div>
                        </div>

                        <div class="col-sm-3" style="padding: 0; text-align: right;">
                            <button type="button" 
                                    class="btn btn-sm btn-order-doorstep" 
                                    data-pharmacy-id="${item.pharmacy_id}" 
                                    data-medicine-id="${item.medicine.id}" 
                                    data-price="${item.pricing.selling_price}" 
                                    data-brand-name="${escapeHtml(item.medicine.brand_name)} (${escapeHtml(item.medicine.dosage_form || 'Tablet')})" 
                                    data-store-name="${escapeHtml(item.store_name)}" 
                                    data-eta="${escapeHtml(item.estimated_delivery_time)}"
                                    style="background: #9BC03C; color: #FFF; font-weight: 700; border-radius: 6px; padding: 7px 16px; box-shadow: 0 2px 6px rgba(155, 192, 60, 0.4);">
                                <i class="fas fa-shopping-bag"></i> Order Doorstep
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#modalStoresList').html(html);
    });
}

let activeCheckoutData = null;

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Event Delegation for "Order Doorstep" Button Click
$(document).on('click', '.btn-order-doorstep', function(e) {
    e.preventDefault();
    const btn = $(this);
    const pharmacyId = parseInt(btn.data('pharmacy-id'));
    const medicineId = parseInt(btn.data('medicine-id'));
    const price = parseFloat(btn.data('price')) || 0.00;
    const brandName = btn.data('brand-name') || 'Medicine';
    const storeName = btn.data('store-name') || 'Partner Pharmacy';
    const eta = btn.data('eta') || '20 - 30 mins';

    openDoorstepCheckout(pharmacyId, medicineId, price, brandName, storeName, eta);
});

function openDoorstepCheckout(pharmacyId, medicineId, price, brandName, storeName, eta) {
    activeCheckoutData = {
        pharmacyId: pharmacyId,
        medicineId: medicineId,
        unitPrice: price,
        brandName: brandName,
        storeName: storeName,
        eta: eta,
        qty: 1
    };

    $('#checkoutBrandName').text(brandName);
    $('#checkoutStoreName').text(storeName);
    $('#checkoutStoreBadge').text(storeName.split(' ')[0] + ' Store');
    $('#checkoutEta').text('Est. Delivery ' + eta);
    $('#checkoutQty').val(1);

    updateCheckoutPrices();

    // Slide up list and show checkout drawer
    $('#modalStoresList').slideUp(200);
    $('#modalDoorstepCheckout').slideDown(250);
}

function cancelDoorstepCheckout() {
    $('#modalDoorstepCheckout').slideUp(200);
    $('#modalStoresList').slideDown(250);
    activeCheckoutData = null;
}

function adjustCheckoutQty(delta) {
    if (!activeCheckoutData) return;
    let currentQty = parseInt($('#checkoutQty').val()) || 1;
    currentQty += delta;
    if (currentQty < 1) currentQty = 1;
    if (currentQty > 20) currentQty = 20;

    $('#checkoutQty').val(currentQty);
    activeCheckoutData.qty = currentQty;
    updateCheckoutPrices();
}

function updateCheckoutPrices() {
    if (!activeCheckoutData) return;
    const qty = activeCheckoutData.qty || 1;
    const itemTotal = (activeCheckoutData.unitPrice * qty);
    const deliveryFee = 40.00;
    const grandTotal = itemTotal + deliveryFee;

    $('#checkoutItemTotal').text(itemTotal.toFixed(2));
    $('#checkoutGrandTotal').text(grandTotal.toFixed(2));
}

function executeDoorstepOrder() {
    if (!activeCheckoutData) {
        alert('Please select a pharmacy first.');
        return;
    }

    const patientName = $('#checkoutCustomerName').val().trim() || 'Patient';
    const patientPhone = $('#checkoutCustomerPhone').val().trim() || '9839112233';
    const address = $('#checkoutAddress').val().trim() || 'Sigra, Varanasi, Uttar Pradesh';

    if (patientPhone.length < 10) {
        alert('Please enter a valid 10-digit mobile number for doorstep OTP verification.');
        $('#checkoutCustomerPhone').focus();
        return;
    }

    const qty = activeCheckoutData.qty || 1;
    const itemTotal = activeCheckoutData.unitPrice * qty;
    const deliveryFee = 40.00;
    const grandTotal = itemTotal + deliveryFee;

    const btn = $('#btnConfirmDoorstepOrder');
    const originalHtml = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Dispatching Order...');

    const payload = {
        pharmacy_id: activeCheckoutData.pharmacyId,
        prescription_id: currentPrescriptionId || null,
        customer_name: patientName,
        customer_phone: patientPhone,
        delivery_address: address,
        payment_mode: 'COD',
        item_total: itemTotal,
        delivery_fee: deliveryFee,
        total_amount: grandTotal,
        items: [
            {
                medicine_id: activeCheckoutData.medicineId,
                quantity: qty,
                unit_mrp: activeCheckoutData.unitPrice * 1.15,
                unit_price: activeCheckoutData.unitPrice,
                total_price: itemTotal
            }
        ]
    };

    $.ajax({
        url: '<?=base_url("api/v1/medicines/create-order");?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        dataType: 'json',
        success: function(resp) {
            btn.prop('disabled', false).html(originalHtml);
            if (typeof resp === 'string') {
                try { resp = JSON.parse(resp); } catch(e) {}
            }

            if (resp && resp.status === 'success' && resp.data) {
                // Populate Live Order Tracking Modal
                $('#trackOrderCode').text(resp.data.order_code || 'UPM-' + Date.now());
                $('#trackOtpDisplay').text(resp.data.delivery_otp || '1234');
                $('#trackStoreName').text(activeCheckoutData.storeName);
                $('#trackEta').text('Within ' + (activeCheckoutData.eta || '25 mins'));
                $('#trackStatusBadge').text('CONFIRMED');

                // Smoothly close compare modal and show tracking modal
                $('#upcharMedicineCompareModal').modal('hide');
                $('#upcharMedicineCompareModal').one('hidden.bs.modal', function () {
                    $('#upcharOrderTrackingModal').modal('show');
                    cancelDoorstepCheckout();
                });
            } else {
                alert((resp && resp.message) ? resp.message : 'Unable to place order. Please try again.');
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).html(originalHtml);
            let msg = 'Failed to place order. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
        }
    });
}

// Global alias for compatibility across all site pages (including medical.php)
function initiateDoorstepOrder(inventoryId, brandName, storeName, price) {
    openMedicineCompareModal(null, brandName);
}

// Direct fallback function
function placeOrderFromCompare(pharmacyId, medicineId, price, brandName, storeName, eta) {
    openDoorstepCheckout(pharmacyId, medicineId, price, brandName || 'Medicine', storeName || 'Partner Pharmacy', eta || '20 - 30 mins');
}

// Alias rxModal triggers to upcharRxUploadModal
$(document).ready(function() {
    $(document).on('click', '[data-target="#rxModal"]', function(e) {
        e.preventDefault();
        $('#upcharRxUploadModal').modal('show');
    });
    if (typeof $ !== 'undefined' && $('#rxModal').length === 0) {
        $('<div id="rxModal"></div>').appendTo('body').on('show.bs.modal', function(e) {
            e.preventDefault();
            $('#upcharRxUploadModal').modal('show');
        });
    }
});
</script>

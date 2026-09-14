<!-- UPCHAR Medicine Delivery & Prescription Modals Suite -->
<style>
    .upchar-modal-header {
        background: #08364B;
        color: #FFFFFF;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        padding: 16px 20px;
    }
    .upchar-modal-header .close {
        color: #FFFFFF;
        opacity: 0.85;
    }
    .upchar-modal-header .close:hover {
        opacity: 1;
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
        padding: 14px 18px;
        margin-bottom: 12px;
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
                            <h4 style="margin: 0 0 4px; font-weight: 800; font-size: 16px; color: #08364B;">
                                ${item.store_name}
                            </h4>
                            <div style="font-size: 12px; color: #64748B; margin-bottom: 4px;">
                                <i class="fas fa-map-marker-alt" style="color: #00A8FF;"></i> ${item.address}, ${item.city} &bull; <strong>${item.distance_km} km away</strong>
                            </div>
                            <div style="font-size: 12.5px; color: #10B981; font-weight: 600;">
                                <i class="fas fa-bolt"></i> Est. Delivery: ${item.estimated_delivery_time}
                            </div>
                        </div>

                        <div class="col-sm-3" style="padding: 0; text-align: center;">
                            <div style="font-size: 11px; color: #64748B;">${item.medicine.brand_name} (${item.medicine.dosage_form})</div>
                            <div style="font-size: 16px; font-weight: 800; color: #08364B;">
                                ₹${item.pricing.selling_price.toFixed(2)}
                                <small style="text-decoration: line-through; color: #94A3B8; font-size: 12px;">₹${item.pricing.mrp.toFixed(2)}</small>
                            </div>
                            <div>${discountBadge}</div>
                        </div>

                        <div class="col-sm-3" style="padding: 0; text-align: right;">
                            <button type="button" class="btn btn-sm" onclick="placeOrderFromCompare(${item.pharmacy_id}, ${item.medicine.id}, ${item.pricing.selling_price})" style="background: #9BC03C; color: #FFF; font-weight: 700; border-radius: 6px; padding: 7px 16px;">
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

function placeOrderFromCompare(pharmacyId, medicineId, price) {
    const qty = 1;
    const itemTotal = price * qty;
    const deliveryFee = 40.00;
    const total = itemTotal + deliveryFee;

    $.ajax({
        url: '<?=base_url("api/v1/medicines/create-order");?>',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            pharmacy_id: pharmacyId,
            prescription_id: currentPrescriptionId,
            customer_name: 'Patient (Self)',
            customer_phone: '9839112233',
            delivery_address: 'Sigra, Varanasi, UP',
            payment_mode: 'COD',
            item_total: itemTotal,
            delivery_fee: deliveryFee,
            total_amount: total,
            items: [
                {
                    medicine_id: medicineId,
                    quantity: qty,
                    unit_mrp: price * 1.15,
                    unit_price: price,
                    total_price: itemTotal
                }
            ]
        }),
        success: function(resp) {
            $('#upcharMedicineCompareModal').modal('hide');
            // Show live tracking modal
            $('#trackOrderCode').text(resp.data.order_code);
            $('#trackOtpDisplay').text(resp.data.delivery_otp);
            $('#upcharOrderTrackingModal').modal('show');
        },
        error: function(xhr) {
            alert('Failed to place order. Please try again.');
        }
    });
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

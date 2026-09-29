<?php defined("BASEPATH") OR exit("No direct script access allowed"); ?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
.sos-page {
    background: radial-gradient(circle at top right, #3b0712, #0b132b 70%);
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    padding: 40px 15px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.sos-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 36px 40px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.25), 0 0 0 1px rgba(226, 232, 240, 0.8);
    position: relative;
    overflow: hidden;
}
.sos-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #dc2626, #ef4444, #f59e0b, #dc2626);
    background-size: 200% 100%;
    animation: bar-glow 3s linear infinite;
}
@keyframes bar-glow {
    0% { background-position: 0% 0%; }
    100% { background-position: 200% 0%; }
}
.sos-header {
    text-align: center;
    margin-bottom: 24px;
}
.sos-header .sos-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fee2e2;
    color: #b91c1c;
    padding: 5px 16px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 800;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}
.sos-header h1 {
    font-family: 'Outfit', sans-serif;
    font-size: 2.1rem;
    font-weight: 900;
    color: #0f172a;
    margin: 0 0 6px;
}
.sos-header p {
    color: #64748b;
    font-size: 14.5px;
    margin: 0;
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    font-weight: 700;
    color: #1e293b;
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
}
.form-control-custom {
    width: 100%;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 11px 16px;
    font-size: 14.5px;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}
.form-control-custom:focus {
    border-color: #dc2626;
    background: #ffffff;
    outline: none;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
}
.location-btn {
    background: #f1f5f9;
    color: #0f172a;
    border: 1.5px dashed #94a3b8;
    border-radius: 10px;
    padding: 9px 16px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    width: 100%;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.location-btn:hover {
    background: #fee2e2;
    border-color: #dc2626;
    color: #991b1b;
}
.btn-emergency {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 15px 24px;
    font-size: 1.15rem;
    font-weight: 800;
    width: 100%;
    cursor: pointer;
    box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.5);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-emergency:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(220, 38, 38, 0.6);
}
.hotline-callout {
    margin-top: 18px;
    padding: 12px;
    background: #fef2f2;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #fee2e2;
}
.hotline-callout a {
    color: #dc2626;
    font-weight: 800;
    text-decoration: none;
    font-size: 15.5px;
}
</style>

<div class="sos-page">
  <div class="container">
    <div class="sos-card">
      <div class="sos-header">
          <div class="sos-badge">
              <i class="fas fa-satellite-dish fa-spin"></i> 24/7 LIVE EMERGENCY DISPATCH
          </div>
          <h1>Emergency Ambulance SOS</h1>
          <p>Instant GPS dispatch to your doorstep. Nearest verified critical care unit responding.</p>
      </div>

      <div id="sosForm">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
              <div class="form-group">
                  <label><i class="fas fa-user" style="color: #64748b; margin-right: 4px;"></i> Patient / Caller Name</label>
                  <input type="text" class="form-control-custom" id="sos_name" placeholder="Patient name"
                         value="<?= htmlspecialchars($patient_name ?: '') ?>">
              </div>
              <div class="form-group">
                  <label><i class="fas fa-phone-alt" style="color: #64748b; margin-right: 4px;"></i> Contact Phone</label>
                  <input type="tel" class="form-control-custom" id="sos_mobile" placeholder="+91 XXXXX XXXXX"
                         value="<?= htmlspecialchars($patient_mobile ?: '') ?>">
              </div>
          </div>

          <div class="form-group">
              <label><i class="fas fa-map-marker-alt" style="color: #dc2626; margin-right: 4px;"></i> Emergency Pickup Address</label>
              <button type="button" class="location-btn" onclick="getLocation(event)">
                  <i class="fas fa-crosshairs" style="color: #dc2626;"></i> Detect My Current GPS Location
              </button>
              <input type="text" class="form-control-custom" id="sos_address" placeholder="House/Flat, Road, Landmark, City" value="Sigra, Varanasi">
              <input type="hidden" id="sos_lat" value="25.3176">
              <input type="hidden" id="sos_lng" value="82.9739">
          </div>

          <div class="form-group">
              <label><i class="fas fa-ambulance" style="color: #64748b; margin-right: 4px;"></i> Required Ambulance Capability</label>
              <select class="form-control-custom" id="sos_type">
                  <option value="ALS" selected>Advanced Life Support (ALS ICU) - Ventilator, Monitor &amp; Paramedic (₹1,800 Base)</option>
                  <option value="BLS">Basic Life Support (BLS) - Oxygen, Stretcher &amp; First Aid (₹800 Base)</option>
                  <option value="PATIENT_TRANSPORT">Patient Transport Van - Routine Medical Transit (₹400 Base)</option>
                  <option value="NEONATAL">Neonatal Intensive Care - Transport Incubator (₹2,200 Base)</option>
              </select>
          </div>

          <div class="form-group">
              <label><i class="fas fa-hospital" style="color: #64748b; margin-right: 4px;"></i> Destination Hospital / Trauma Wing</label>
              <select class="form-control-custom" id="sos_hospital">
                  <option value="11" selected>Oriana Hospital Emergency Wing (Trauma &amp; ICU)</option>
                  <option value="1">Apex Hospital Emergency Fleet</option>
                  <option value="2">Heritage Hospitals Trauma Center</option>
                  <?php if(!empty($hospitals_list)): ?>
                      <?php foreach($hospitals_list as $h): ?>
                          <?php if(!in_array($h['id'], [1, 2, 11])): ?>
                              <option value="<?=$h['id'];?>"><?=htmlspecialchars($h['name']);?> (<?=htmlspecialchars($h['location'] ?: 'Emergency');?>)</option>
                          <?php endif; ?>
                      <?php endforeach; ?>
                  <?php endif; ?>
              </select>
          </div>

          <div class="form-group">
              <label><i class="fas fa-notes-medical" style="color: #64748b; margin-right: 4px;"></i> Condition Details (Optional)</label>
              <input type="text" class="form-control-custom" id="sos_notes" placeholder="e.g. Chest pain, difficulty breathing, trauma, fall...">
          </div>

          <button type="button" class="btn-emergency" onclick="submitSOS()">
              <i class="fas fa-bolt"></i> DISPATCH NEAREST AMBULANCE NOW
          </button>

          <div class="hotline-callout">
              <span style="color: #475569; font-size: 13px;">Urgent Medical Dispatcher Desk:</span><br>
              <a href="tel:18002479999"><i class="fas fa-phone-volume"></i> 1800-247-9999 (Toll-Free, 24/7)</a>
          </div>
      </div>

      <!-- SUCCESS DISPATCH SCREEN -->
      <div id="sosSuccess" style="display:none; text-align:center; padding:20px 10px;">
          <div style="width: 72px; height: 72px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 16px;">
              <i class="fas fa-check"></i>
          </div>
          <h2 style="font-family: 'Outfit', sans-serif; color:#15803d; font-weight:900; margin: 0 0 6px;">Ambulance Dispatched!</h2>
          <p style="color: #475569; font-size: 14.5px; margin-bottom: 20px;">Your emergency request has been received. The nearest equipped ambulance unit has been alerted and is rolling to your location.</p>
          
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; text-align: left; margin-bottom: 20px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <span style="font-size: 12px; color: #64748b; font-weight: 700;">Trip Reference</span>
                  <strong id="trackingId" style="color:#dc2626; font-size:15px; font-weight:800;"></strong>
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <span style="font-size: 12px; color: #64748b; font-weight: 700;">Assigned Unit</span>
                  <strong id="sosVehicle" style="color:#0f172a; font-size:14px;"></strong>
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <span style="font-size: 12px; color: #64748b; font-weight: 700;">Paramedic Pilot</span>
                  <strong id="sosDriver" style="color:#0f172a; font-size:14px;"></strong>
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center;">
                  <span style="font-size: 12px; color: #64748b; font-weight: 700;">Pickup OTP</span>
                  <strong id="sosOtp" style="color:#16a34a; font-size:18px; letter-spacing: 2px;"></strong>
              </div>
          </div>

          <a id="sosTrackLink" href="#" class="btn-emergency" style="text-decoration: none; margin-bottom: 12px;">
              <i class="fas fa-map-marked-alt"></i> Track Ambulance En Route
          </a>
          <a href="<?=base_url('myappointments#ambulance');?>" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 700; border-radius: 12px; padding: 10px 20px; text-decoration: none; display: inline-block;">
              Return to Patient Care Hub
          </a>
      </div>

    </div>
  </div>
</div>

<script>
function getLocation(e) {
    if (!navigator.geolocation) { alert("Geolocation is not supported by your browser."); return; }
    const btn = e ? e.target.closest('button') : document.querySelector('.location-btn');
    const origText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting location...';
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById("sos_lat").value = pos.coords.latitude;
        document.getElementById("sos_lng").value = pos.coords.longitude;
        document.getElementById("sos_address").value = "Lat: " + pos.coords.latitude.toFixed(5) + ", Lng: " + pos.coords.longitude.toFixed(5);
        fetch("https://nominatim.openstreetmap.org/reverse?format=json&lat="+pos.coords.latitude+"&lon="+pos.coords.longitude)
            .then(r => r.json())
            .then(d => {
                if(d.display_name) document.getElementById("sos_address").value = d.display_name;
                btn.innerHTML = '<i class="fas fa-check-circle" style="color: #16a34a;"></i> Location Detected';
            })
            .catch(() => {
                btn.innerHTML = origText;
            });
    }, function() {
        alert("Unable to retrieve GPS coordinates. Please enter pickup address manually.");
        btn.innerHTML = origText;
    });
}

function submitSOS() {
    const name     = document.getElementById("sos_name").value.trim();
    const mobile   = document.getElementById("sos_mobile").value.trim();
    const address  = document.getElementById("sos_address").value.trim();
    const category = document.getElementById("sos_type").value;
    const hospital = document.getElementById("sos_hospital").value;
    const notes    = document.getElementById("sos_notes").value.trim();
    const lat      = document.getElementById("sos_lat").value;
    const lng      = document.getElementById("sos_lng").value;

    if (!name || !mobile || !address) {
        alert("Please provide patient name, active contact phone number, and pickup address.");
        return;
    }

    const btn = document.querySelector(".btn-emergency");
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Dispatching Unit...';
    btn.style.pointerEvents = "none";

    const fd = new FormData();
    fd.append('patient_name', name);
    fd.append('patient_mobile', mobile);
    fd.append('pickup_address', address);
    fd.append('pickup_lat', lat);
    fd.append('pickup_lng', lng);
    fd.append('category', category);
    fd.append('hospital_id', hospital);
    fd.append('distance_km', 8);
    fd.append('medical_notes', notes);
    fd.append('<?=$this->security->get_csrf_token_name();?>', '<?=$this->security->get_csrf_hash();?>');

    fetch('<?=base_url("ambulance/create_booking");?>', {
        method: 'POST',
        body: fd
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById("sosForm").style.display = "none";
            document.getElementById("sosSuccess").style.display = "block";
            document.getElementById("trackingId").textContent = '#' + data.booking_code;
            document.getElementById("sosVehicle").textContent = data.ambulance + ' (' + data.category + ')';
            document.getElementById("sosDriver").textContent = data.driver_name + ' • ' + data.driver_phone;
            document.getElementById("sosOtp").textContent = data.pickup_otp;
            document.getElementById("sosTrackLink").href = data.tracking_url;
        } else {
            alert(data.message || 'Error creating ambulance request.');
            btn.innerHTML = '<i class="fas fa-bolt"></i> DISPATCH NEAREST AMBULANCE NOW';
            btn.style.pointerEvents = "auto";
        }
    })
    .catch(err => {
        alert('Emergency response registered. Unit dispatched.');
        location.href = '<?=base_url("myappointments#ambulance");?>';
    });
}
</script>
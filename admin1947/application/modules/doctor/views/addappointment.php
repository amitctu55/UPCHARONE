<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Book New Appointment</h1>
        <small style="color: #64748b; font-size: 13px;">Schedule doctor consultations, configure visit timings, and register patient details</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Add Appointment</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Toast Notification Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <div class="row">
        <!-- Left: Booking Form -->
        <div class="col-md-7 col-sm-12">
          <div class="master-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.04); margin-bottom: 24px;">
            <div class="master-card-header" style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
              <h3 class="master-card-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-calendar-plus-o" style="color: #00a896;"></i>
                <span>Appointment Booking Form</span>
              </h3>
              <a href="<?=base_url('doctor/appointment/doctorappointment')?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px; border-color: #cbd5e1; color: #475569;">
                <i class="fa fa-list"></i> View All Appointments
              </a>
            </div>

            <div class="master-card-body" style="padding: 24px;">
              <form id="app_conf_form" action="<?=base_url('doctor/appointment/bookappointment_admin');?>" method="POST">
                
                <!-- Section 1: Location & Doctor Selection -->
                <div style="margin-bottom: 24px;">
                  <div style="font-size: 13px; font-weight: 700; color: #00a896; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                    <i class="fa fa-map-marker"></i> 1. Location &amp; Practitioner Selection
                  </div>

                  <div class="row">
                    <!-- City -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">City</label>
                        <select class="form-control" id="city_name" name="city_name" style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- Select City --</option>
                          <?php 
                          $city = $this->appointmentmodel->get_city(array('status'=>'1'));
                          if(is_array($city) && !empty($city)):
                            foreach($city as $list):
                          ?>
                            <option value="<?=$list['id'];?>"><?=$list['name'];?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- Locality -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Locality / Area</label>
                        <select class="form-control" id="locality_name" name="locality_name" style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- All Localities --</option>
                        </select>
                      </div>
                    </div>

                    <!-- Specialization -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Medical Specialization</label>
                        <select class="form-control" id="specialization_name" name="specialization_name" style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- All Specializations --</option>
                          <?php 
                          if(is_array($specialization) && !empty($specialization)):
                            foreach($specialization as $list):
                          ?>
                            <option value="<?=$list['id'];?>"><?=$list['name'];?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- Hospital / Facility -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Hospital / Institution</label>
                        <select class="form-control" id="hospital_name" name="hospital_name" style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- All Hospitals --</option>
                          <?php 
                          if(is_array($hospital) && !empty($hospital)):
                            foreach($hospital as $list):
                          ?>
                            <option value="<?=$list['id'];?>"><?=$list['name'];?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- Doctor Select -->
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
                          Doctor Name <span style="color: #ef4444;">*</span>
                        </label>
                        <select class="form-control" id="app_conf_pop_doctorid" name="app_doctor" required style="border-radius: 8px; border-color: #00a896; height: 42px; font-size: 13.5px; font-weight: 600; background: #f0fdfa;">
                          <option value="">-- Choose Doctor / Clinical Practitioner --</option>
                          <?php 
                          $doctor_list = $this->appointmentmodel->doctor_list(array('type'=>'H'));
                          if(is_array($doctor_list) && !empty($doctor_list)):
                            foreach ($doctor_list as $key => $value):
                          ?>
                            <option value="<?=$value['id']; ?>">Dr. <?=trim($value['fname'] . ' ' . ($value['lname'] ?? ''));?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Section 2: Date & Slot Availability -->
                <div style="margin-bottom: 24px;">
                  <div style="font-size: 13px; font-weight: 700; color: #00a896; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                    <i class="fa fa-clock-o"></i> 2. Visit Date &amp; Timing Slot
                  </div>

                  <div class="row">
                    <!-- Date -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Appointment Date <span style="color: #ef4444;">*</span>
                        </label>
                        <select class="form-control" name="app_date" id="app_conf_pop_date" required style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- Select Doctor First --</option>
                        </select>
                      </div>
                    </div>

                    <!-- Time Slot -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Appointment Slot / Session <span style="color: #ef4444;">*</span>
                        </label>
                        <select class="form-control" name="app_time" id="app_conf_pop_time" required style="border-radius: 8px; border-color: #cbd5e1; height: 38px; font-size: 13px;">
                          <option value="">-- Select Date First --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Section 3: Patient Information -->
                <div style="margin-bottom: 24px;">
                  <div style="font-size: 13px; font-weight: 700; color: #00a896; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                    <i class="fa fa-user"></i> 3. Patient Information
                  </div>

                  <div class="row">
                    <!-- Mobile -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Mobile Number <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;"><i class="fa fa-phone"></i></span>
                          <input type="tel" id="app_conf_mobile" name="app_mobile" class="form-control" placeholder="10-digit mobile" pattern="[0-9]{10,12}" required style="border-color: #cbd5e1; height: 38px; font-size: 13px;">
                        </div>
                      </div>
                    </div>

                    <!-- Patient Name -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Patient Full Name <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;"><i class="fa fa-user"></i></span>
                          <input type="text" name="app_name" id="app_conf_name" class="form-control" placeholder="Enter patient name" required style="border-color: #cbd5e1; height: 38px; font-size: 13px;">
                        </div>
                      </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Email Address (Optional)
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;"><i class="fa fa-envelope"></i></span>
                          <input type="email" name="app_email" id="app_conf_email" class="form-control" placeholder="patient@example.com" style="border-color: #cbd5e1; height: 38px; font-size: 13px;">
                        </div>
                      </div>
                    </div>

                    <!-- Age / Notes -->
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                          Patient Age (Years)
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;"><i class="fa fa-birthday-cake"></i></span>
                          <input type="number" name="app_age" id="app_conf_age" class="form-control" placeholder="e.g. 35" min="1" max="120" style="border-color: #cbd5e1; height: 38px; font-size: 13px;">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Submit Action Buttons -->
                <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                  <button type="submit" id="app_conf_submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 10px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);">
                    <i class="fa fa-check-circle"></i> Confirm &amp; Book Appointment
                  </button>
                  <button type="reset" class="btn btn-default" style="font-weight: 600; padding: 10px 20px; border-radius: 8px; color: #64748b; border-color: #cbd5e1;">
                    <i class="fa fa-refresh"></i> Reset Form
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <!-- Right: Live Doctor & Facility Summary Card -->
        <div class="col-md-5 col-sm-12">
          
          <!-- Doctor Summary Card -->
          <div class="master-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.04); margin-bottom: 20px;">
            <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
              <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-user-md" style="color: #00a896;"></i> Selected Doctor Summary
              </h4>
            </div>
            <div class="master-card-body" style="padding: 20px;">
              <div id="app_conf_pop_doctor">
                <div style="text-align: center; padding: 24px 10px; color: #94a3b8;">
                  <i class="fa fa-stethoscope fa-2x" style="display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                  <p style="margin: 0; font-size: 13px; font-weight: 500;">Select a doctor from the form to view qualifications and specialty profile.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Facility & Chamber Info Card -->
          <div class="master-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.04); margin-bottom: 20px;">
            <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
              <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-hospital-o" style="color: #00a896;"></i> Practice Chamber &amp; Fee Details
              </h4>
            </div>
            <div class="master-card-body" style="padding: 20px;">
              <div id="app_conf_pop_institute">
                <div style="text-align: center; padding: 24px 10px; color: #94a3b8;">
                  <i class="fa fa-clock-o fa-2x" style="display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                  <p style="margin: 0; font-size: 13px; font-weight: 500;">Select date and slot to load chamber location, fee, and available OPD capacity.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Fast Guidance Card -->
          <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 18px 20px;">
            <h5 style="font-size: 13px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0; display: flex; align-items: center; gap: 6px;">
              <i class="fa fa-info-circle" style="color: #00a896;"></i> Booking &amp; Notification Flow
            </h5>
            <ul style="margin: 0; padding-left: 18px; font-size: 12px; color: #64748b; line-height: 1.6;">
              <li>Patients are automatically mapped by their 10-digit mobile number.</li>
              <li>Booking confirmation is dispatched via SMS &amp; Email to both doctor and patient.</li>
              <li>Counter bookings (COC) can be marked completed inside the doctor or hospital portal.</li>
            </ul>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function() {

    // Helper: Show toast
    function showToast(message, type) {
        var bg = type === 'success' ? '#10b981' : '#ef4444';
        var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        var toast = $('<div style="background: ' + bg + '; color: #ffffff; padding: 12px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px; pointer-events: auto;"><i class="fa ' + icon + '"></i> ' + message + '</div>');
        $('#toast-container').append(toast);
        setTimeout(function() { toast.fadeOut(300, function() { $(this).remove(); }); }, 3500);
    }

    // 1. City Change -> Load Localities and Hospitals
    $('#city_name').on('change', function() {
        var val = $(this).val();
        if (val) {
            $.ajax({
                url: '<?=base_url();?>doctor/appointment/get_locality_by_city_id',
                data: { city_id: val },
                success: function(data) { $('#locality_name').html(data); }
            });
            $.ajax({
                url: '<?=base_url();?>doctor/appointment/get_hospital_by_city_id',
                data: { city_id: val },
                success: function(data) { $('#hospital_name').html(data); }
            });
        } else {
            $('#locality_name').html('<option value="">-- All Localities --</option>');
            $('#hospital_name').html('<option value="">-- All Hospitals --</option>');
        }
    });

    // 2. Locality Change -> Filter Hospitals
    $('#locality_name').on('change', function() {
        var locId = $(this).val();
        var cityId = $('#city_name').val();
        if (locId && cityId) {
            $.ajax({
                url: '<?=base_url();?>doctor/appointment/get_hospital_by_locality_id',
                data: { city_id: cityId, locality_id: locId },
                success: function(data) { $('#hospital_name').html(data); }
            });
        }
    });

    // 3. Specialization Change -> Filter Doctors
    $('#specialization_name').on('change', function() {
        var specId = $(this).val();
        if (specId) {
            $.ajax({
                url: '<?=base_url();?>doctor/appointment/get_doctor_by_specialization_id',
                data: { specialization_id: specId },
                success: function(data) { 
                    $('#app_conf_pop_doctorid').html(data);
                    $('#app_conf_pop_doctorid').trigger('change');
                }
            });
        }
    });

    // 4. Hospital Change -> Filter Doctors
    $('#hospital_name').on('change', function() {
        var hospId = $(this).val();
        if (hospId) {
            $.ajax({
                url: '<?=base_url();?>doctor/appointment/get_doctor_by_hospital_id',
                data: { hospital_id: hospId },
                success: function(data) { 
                    $('#app_conf_pop_doctorid').html(data);
                    $('#app_conf_pop_doctorid').trigger('change');
                }
            });
        }
    });

    // 5. Doctor Change -> Load Doctor Preview & Available Dates
    $('#app_conf_pop_doctorid').on('change', function() {
        var did = $(this).val();
        $('#app_conf_pop_date').html('<option value="">-- Loading Dates... --</option>');
        $('#app_conf_pop_time').html('<option value="">-- Select Date First --</option>');
        $('#app_conf_pop_institute').html('<div style="text-align: center; padding: 20px; color: #94a3b8;"><p style="margin: 0; font-size: 13px;">Select date and slot above.</p></div>');

        if (did) {
            $.ajax({
                type: "GET",
                url: "<?=base_url();?>doctor/appointment/app_conf_hospital_doctor",
                data: { doctor: did },
                success: function(data) {
                    $('#app_conf_pop_doctor').html(data);
                }
            });
            $.ajax({
                type: "GET",
                url: "<?=base_url();?>doctor/appointment/app_conf_pop_date",
                data: { doctor: did },
                success: function(data) {
                    $('#app_conf_pop_date').html(data);
                }
            });
        } else {
            $('#app_conf_pop_doctor').html('<div style="text-align: center; padding: 24px 10px; color: #94a3b8;"><p style="margin: 0; font-size: 13px;">Select a doctor from the form.</p></div>');
            $('#app_conf_pop_date').html('<option value="">-- Select Doctor First --</option>');
        }
    });

    // 6. Date Change -> Load Time Slots
    $('#app_conf_pop_date').on('change', function() {
        var date = $(this).val();
        var did = $('#app_conf_pop_doctorid').val();
        $('#app_conf_pop_time').html('<option value="">-- Loading Slots... --</option>');

        if (date && did) {
            $.ajax({
                type: "GET",
                url: "<?=base_url();?>doctor/appointment/app_conf_pop_time",
                data: { doctor: did, date: date },
                success: function(data) {
                    $('#app_conf_pop_time').html(data);
                }
            });
        } else {
            $('#app_conf_pop_time').html('<option value="">-- Select Date First --</option>');
        }
    });

    // 7. Time Slot Change -> Load Hospital / Chamber & Fee
    $('#app_conf_pop_time').on('change', function() {
        var time = $(this).val();
        var date = $('#app_conf_pop_date').val();
        var did = $('#app_conf_pop_doctorid').val();

        if (time && date && did) {
            $.ajax({
                type: "GET",
                url: "<?=base_url();?>doctor/appointment/app_conf_hospital_institute",
                data: { doctor: did, date: date, time: time },
                success: function(data) {
                    $('#app_conf_pop_institute').html(data);
                }
            });
        }
    });

    // 8. Form Submit
    $('#app_conf_form').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#app_conf_submit');
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing Booking...');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: "POST",
            success: function(response) {
                btn.prop('disabled', false).html(originalText);
                if (response.trim() === 'OK') {
                    showToast('Appointment booked! Redirecting to confirmation...', 'success');
                    setTimeout(function() {
                        window.location = "<?=base_url();?>doctor/appointment/acheckout_admin";
                    }, 800);
                } else if (response.trim() === 'Not Available') {
                    showToast('Selected appointment slot is full. Please choose another slot.', 'error');
                } else {
                    showToast('Booking failed. Please check the form fields and try again.', 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                showToast('Server error while processing booking. Please try again.', 'error');
            }
        });
    });

});
</script>
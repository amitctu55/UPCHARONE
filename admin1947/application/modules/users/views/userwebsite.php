<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Unified User &amp; Patient Onboarding Hub
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">
          Seamlessly provision clinical patients, standard website users, and administrative staff with automatic notification and dossier synchronization.
        </p>
      </div>
      
      <!-- Departmental Isolation Quick-Switch Links -->
      <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('users/patient')?>" class="btn" style="background: #E0F2FE; color: #0369A1; font-weight: 600; padding: 7px 14px; border-radius: 8px; border: 1px solid #BAE6FD; text-decoration: none; font-size: 12.5px;">
          <i class="fa fa-folder-open-o"></i> Clinical Dossiers
        </a>
        <a href="<?=base_url('users/userlogincreate/gmail_users')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 7px 14px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; font-size: 12.5px;">
          <i class="fa fa-google" style="color: #EA4335;"></i> Google Users
        </a>
        <a href="<?=base_url('users/userlogincreate/facebook_users')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 7px 14px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; font-size: 12.5px;">
          <i class="fa fa-facebook" style="color: #1877F2;"></i> Facebook Users
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Interactive Navigation Tabs -->
    <ul class="nav nav-tabs" style="border-bottom: 2px solid #E2E8F0; margin-bottom: 20px;">
      <li class="active">
        <a href="#tab-onboard" data-toggle="tab" style="font-weight: 700; color: #0d9488; font-size: 14px; border-radius: 8px 8px 0 0; padding: 10px 20px;">
          <i class="fa fa-user-plus" style="margin-right: 6px;"></i> Onboard New Account
        </a>
      </li>
      <li>
        <a href="#tab-directory" data-toggle="tab" style="font-weight: 600; color: #64748B; font-size: 14px; border-radius: 8px 8px 0 0; padding: 10px 20px;">
          <i class="fa fa-list" style="margin-right: 6px;"></i> Registered Web Patients Directory (<?=count($userlogin);?>)
        </a>
      </li>
    </ul>

    <div class="tab-content">
      
      <!-- ============================================================== -->
      <!-- TAB 1: DYNAMIC ONBOARDING FORM                                 -->
      <!-- ============================================================== -->
      <div class="tab-pane active" id="tab-onboard">
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          
          <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-address-card-o" style="color: #0d9488; margin-right: 8px;"></i> Dynamic Onboarding Engine
            </h3>
            <span id="role-badge" style="background: #CCFBF1; color: #0F766E; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px;">
              Clinical Patient Mode
            </span>
          </div>

          <form action="<?=base_url('users/userlogincreate/create_unified')?>" method="post" id="unified-onboard-form" style="padding: 24px;">
            
            <!-- SECTION 1: ROLE SELECTION -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px;">
              <label style="display: block; font-size: 13.5px; font-weight: 700; color: #1E293B; margin-bottom: 6px;">
                Select Target Account Department / Role <span style="color: #EF4444;">*</span>
              </label>
              <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; color: #0F172A; cursor: pointer;">
                  <input type="radio" name="role_type" value="patient" checked style="accent-color: #0d9488; transform: scale(1.2);"> 
                  🏥 Clinical Patient <small style="color: #64748B; font-weight: 400;">(Auto-generates dossier, vitals &amp; wallet)</small>
                </label>
                <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; color: #0F172A; cursor: pointer;">
                  <input type="radio" name="role_type" value="website_user" style="accent-color: #0d9488; transform: scale(1.2);"> 
                  🌐 Website User <small style="color: #64748B; font-weight: 400;">(Standard web portal access)</small>
                </label>
                <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; color: #0F172A; cursor: pointer;">
                  <input type="radio" name="role_type" value="staff" style="accent-color: #0d9488; transform: scale(1.2);"> 
                  🛡️ Administrative Staff <small style="color: #64748B; font-weight: 400;">(Internal desk/portal access)</small>
                </label>
              </div>
            </div>

            <!-- SECTION 2: CORE IDENTITY FIELDS (Always Visible) -->
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; margin: 0 0 14px 0;">
              1. Basic Credentials &amp; Contact
            </h4>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 24px;">
              <div>
                <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px;">First Name <span style="color:#EF4444;">*</span></label>
                <input type="text" name="fname" required class="form-control" placeholder="e.g. Rajesh" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1;">
              </div>
              <div>
                <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px;">Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="e.g. Kumar" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1;">
              </div>
              <div>
                <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px;">10-Digit Mobile <span style="color:#EF4444;">*</span></label>
                <input type="tel" name="mobile" required maxlength="10" class="form-control" placeholder="9876543210" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1;">
              </div>
              <div>
                <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px;">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="user@upchar.info" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1;">
              </div>
              <div>
                <label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px;">Login Password <span style="color:#EF4444;">*</span></label>
                <div class="input-group">
                  <input type="text" name="password" id="input-password" required class="form-control" placeholder="Min 6 characters" style="height: 40px; border-radius: 8px 0 0 8px; border: 1px solid #CBD5E1;">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" onclick="generateSecurePassword()" style="height: 40px; border-radius: 0 8px 8px 0; border: 1px solid #CBD5E1; font-weight: 600;">
                      <i class="fa fa-random"></i> Generate
                    </button>
                  </span>
                </div>
              </div>
            </div>

            <!-- SECTION 3: CONDITIONAL CLINICAL PATIENT FIELDS -->
            <div id="section-patient-clinical" style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
              <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #166534; letter-spacing: 0.5px; margin: 0 0 14px 0;">
                <i class="fa fa-heartbeat"></i> 2. Clinical Dossier &amp; Medical Metrics
              </h4>
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Date of Birth <span style="color:#EF4444;">*</span></label>
                  <input type="date" name="dob" id="input-dob" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                </div>
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Gender</label>
                  <select name="gender" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Blood Group</label>
                  <select name="blood_group" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                    <option value="">Unknown</option>
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
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Height (cm)</label>
                  <input type="number" name="height" class="form-control" placeholder="175" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                </div>
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Weight (kg)</label>
                  <input type="number" name="weight" class="form-control" placeholder="70" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                </div>
              </div>

              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-top: 14px;">
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Emergency Contact Person</label>
                  <input type="text" name="emergency_contact_name" class="form-control" placeholder="e.g. Suman Kumar (Spouse)" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                </div>
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Emergency Phone Number</label>
                  <input type="tel" name="emergency_contact_phone" class="form-control" placeholder="10-digit mobile" style="height: 40px; border-radius: 8px; border: 1px solid #86EFAC;">
                </div>
              </div>

              <div style="margin-top: 14px;">
                <label style="font-size: 12.5px; font-weight: 600; color: #166534; margin-bottom: 4px;">Known Allergies &amp; Chronic Notes</label>
                <textarea name="allergies" rows="2" class="form-control" placeholder="e.g. Penicillin allergy, Diabetes Type-2..." style="border-radius: 8px; border: 1px solid #86EFAC;"></textarea>
              </div>
            </div>

            <!-- SECTION 4: CONDITIONAL ADMINISTRATIVE STAFF FIELDS -->
            <div id="section-staff-admin" style="display: none; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
              <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #1E40AF; letter-spacing: 0.5px; margin: 0 0 14px 0;">
                <i class="fa fa-shield"></i> 2. Security Roles &amp; Administrative Permissions
              </h4>
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #1E40AF; margin-bottom: 4px;">Staff Username <small>(Optional, defaults to email)</small></label>
                  <input type="text" name="staff_username" class="form-control" placeholder="staff_rajesh" style="height: 40px; border-radius: 8px; border: 1px solid #93C5FD;">
                </div>
                <div>
                  <label style="font-size: 12.5px; font-weight: 600; color: #1E40AF; margin-bottom: 4px;">Permission Role Level</label>
                  <select name="staff_role" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #93C5FD;">
                    <option value="2">Standard Hospital Staff / Receptionist</option>
                    <option value="1">Executive Super Administrator</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- SECTION 5: OUTGOING NOTIFICATION TRIGGERS -->
            <div style="border-top: 1px solid #F1F5F9; padding-top: 16px; margin-bottom: 20px;">
              <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; margin: 0 0 10px 0;">
                3. Automated Dispatch Hooks
              </h4>
              <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #334155; cursor: pointer;">
                  <input type="checkbox" name="notify_email" value="1" checked style="accent-color: #0d9488;">
                  <i class="fa fa-envelope" style="color: #0d9488;"></i> Trigger Welcome Email via SMTP Gateway
                </label>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #334155; cursor: pointer;">
                  <input type="checkbox" name="notify_sms" value="1" checked style="accent-color: #0d9488;">
                  <i class="fa fa-comment" style="color: #0284c7;"></i> Dispatch Instant SMS / WhatsApp Alert
                </label>
              </div>
            </div>

            <!-- SUBMIT BUTTONS -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #F1F5F9; padding-top: 16px;">
              <button type="reset" class="btn" style="background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #CBD5E1;">
                Reset
              </button>
              <button type="submit" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 700; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
                <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Complete Account Onboarding
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- ============================================================== -->
      <!-- TAB 2: REGISTERED PATIENTS DIRECTORY                          -->
      <!-- ============================================================== -->
      <div class="tab-pane" id="tab-directory">
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
              <i class="fa fa-globe" style="color: #0d9488; margin-right: 8px;"></i> Registered Direct Patients &amp; Web Users
            </h3>
          </div>

          <div class="table-responsive" style="padding: 16px;">
            <table class="table table-hover" id="users-directory-table" style="width: 100%;">
              <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                  <th>Medical ID</th>
                  <th>Full Name</th>
                  <th>Mobile Number</th>
                  <th>Email Address</th>
                  <th>Date of Birth</th>
                  <th>Blood Group</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($userlogin)) { foreach($userlogin as $p) { ?>
                  <tr>
                    <td style="font-weight: 700; color: #0369A1;">#UPC-PAT-<?=str_pad($p->USERID, 5, '0', STR_PAD_LEFT);?></td>
                    <td style="font-weight: 600; color: #0F172A;"><?=$p->FNAME . ' ' . $p->LNAME;?></td>
                    <td><?=$p->MOBILE;?></td>
                    <td><?=$p->EMAIL ?: '<span style="color:#94A3B8;">None</span>';?></td>
                    <td><?=$p->DOB ?: '<span style="color:#94A3B8;">-</span>';?></td>
                    <td>
                      <?php if(!empty($p->BGROUP)) { ?>
                        <span style="background: #FEE2E2; color: #B91C1C; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 11px;">
                          <?=$p->BGROUP;?>
                        </span>
                      <?php } else { echo '-'; } ?>
                    </td>
                    <td>
                      <span class="label label-<?=$p->STATUS == '1' ? 'success' : 'danger';?>">
                        <?=$p->STATUS == '1' ? 'ACTIVE' : 'BLOCKED';?>
                      </span>
                    </td>
                    <td>
                      <a href="<?=base_url('users/patient?keyword='.$p->USERID)?>" class="btn btn-xs btn-info" style="border-radius: 4px;" title="View Dossier">
                        <i class="fa fa-folder-open-o"></i> Dossier
                      </a>
                    </td>
                  </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Dynamic Form Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  // Initialize DataTables
  if ($.fn.DataTable.isDataTable('#users-directory-table')) {
    $('#users-directory-table').DataTable().destroy();
  }
  $('#users-directory-table').DataTable({
    pageLength: 25,
    responsive: true
  });

  // Dynamic Role Toggle Handler
  $('input[name="role_type"]').on('change', function() {
    var selectedRole = $(this).val();

    if (selectedRole === 'patient') {
      $('#section-patient-clinical').slideDown(200);
      $('#section-staff-admin').slideUp(200);
      $('#input-dob').prop('required', true);
      $('#role-badge').text('Clinical Patient Mode').css({'background': '#CCFBF1', 'color': '#0F766E'});
    } else if (selectedRole === 'website_user') {
      $('#section-patient-clinical').slideUp(200);
      $('#section-staff-admin').slideUp(200);
      $('#input-dob').prop('required', false);
      $('#role-badge').text('Standard Web User Mode').css({'background': '#F1F5F9', 'color': '#334155'});
    } else if (selectedRole === 'staff') {
      $('#section-patient-clinical').slideUp(200);
      $('#section-staff-admin').slideDown(200);
      $('#input-dob').prop('required', false);
      $('#role-badge').text('Administrative Staff Mode').css({'background': '#DBEAFE', 'color': '#1E40AF'});
    }
  });
});

// Secure Password Generator Helper
function generateSecurePassword() {
  var chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$%";
  var pass = "";
  for (var i = 0; i < 10; i++) {
    pass += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  $('#input-password').val(pass);
}
</script>
<?=$this->load->view('inc/footer');?>

<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Patient & App User Registration
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Create new patient login accounts, edit profile details, and manage access credentials</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>users/userlogincreate/userview" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-users"></i> View All Patients
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 960px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-user-plus" style="color: #0d9488; margin-right: 8px;"></i> Patient Account Information
        </h3>
      </div>

      <form action="<?=base_url()?>users/Userlogincreate/create" method="post" style="padding: 24px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
          
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">First Name</label>
            <input type="text" class="form-control" id="username" name="fname" placeholder="Enter first name..." style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Last Name</label>
            <input type="text" class="form-control" id="useraddress" name="lname" placeholder="Enter last name..." style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Mobile Number</label>
            <input type="text" class="form-control" id="usermobile" name="mobile" placeholder="10-digit mobile..." onkeypress="return isNumber(event)" maxlength="10" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Email Address</label>
            <input type="email" class="form-control" id="useremail" name="email" placeholder="patient@example.com" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Create secret password..." style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Date of Birth</label>
            <input type="text" class="form-control datepicker" id="userdob" name="dob" placeholder="YYYY-MM-DD" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Gender</label>
            <div style="display: flex; gap: 20px; align-items: center; height: 42px;">
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                <input type="radio" class="activeradio" id="activeyes" name="activeradio" value="Male" checked style="accent-color: #0d9488;"> Male
              </label>
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                <input type="radio" class="activeradio" id="activeno" name="activeradio" value="Female" style="accent-color: #0d9488;"> Female
              </label>
            </div>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Blood Group</label>
            <input type="text" class="form-control" name="blood" placeholder="e.g. O+, A+, B-" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Height (cm)</label>
            <input type="text" class="form-control" name="height" placeholder="e.g. 175" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Weight (kg)</label>
            <input type="text" class="form-control" name="weight" placeholder="e.g. 68" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; border-top: 1px solid #F1F5F9; padding-top: 18px;">
          <a href="<?=base_url();?>users/usercreate" class="btn" style="background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none;">Reset</a>
          <button type="submit" class="btn" id="submit" name="submit" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
            <i class="fa fa-user-plus" style="margin-right: 6px;"></i> Create Patient Account
          </button>
        </div>
      </form>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}
</script>
<?=$this->load->view('inc/footer');?>

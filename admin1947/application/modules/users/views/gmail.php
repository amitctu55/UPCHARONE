<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          <i class="fa fa-google" style="color: #EA4335;"></i> Google / Gmail Social Auth Users
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Patients and platform users registered and authenticated via Google / Gmail OAuth</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>users/userlogincreate/userview" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-users"></i> All Users
        </a>
        <a href="<?=base_url()?>users/userlogincreate/facebook_users" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-facebook" style="color: #1877F2;"></i> Facebook Users
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Summary KPI Cards -->
    <?php
      $total_gmail = is_array($userlogin) ? count($userlogin) : 0;
      $active_count = 0;
      $total_appts = 0;
      if (!empty($userlogin)) {
        foreach ($userlogin as $u) {
          if ($u->STATUS == '1') $active_count++;
          $total_appts += (int)@$u->total_appointments;
        }
      }
    ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px;">
      <div style="background: #FFFFFF; border-radius: 10px; border: 1px solid #E2E8F0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <div style="width: 46px; height: 46px; border-radius: 10px; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; font-size: 20px;">
          <i class="fa fa-google"></i>
        </div>
        <div>
          <div style="font-size: 12px; color: #64748B; font-weight: 600; text-transform: uppercase;">Total Google Users</div>
          <div style="font-size: 22px; font-weight: 800; color: #0F172A;"><?=$total_gmail;?></div>
        </div>
      </div>

      <div style="background: #FFFFFF; border-radius: 10px; border: 1px solid #E2E8F0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <div style="width: 46px; height: 46px; border-radius: 10px; background: #DCFCE7; color: #16A34A; display: flex; align-items: center; justify-content: center; font-size: 20px;">
          <i class="fa fa-check-circle"></i>
        </div>
        <div>
          <div style="font-size: 12px; color: #64748B; font-weight: 600; text-transform: uppercase;">Active Accounts</div>
          <div style="font-size: 22px; font-weight: 800; color: #0F172A;"><?=$active_count;?></div>
        </div>
      </div>

      <div style="background: #FFFFFF; border-radius: 10px; border: 1px solid #E2E8F0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <div style="width: 46px; height: 46px; border-radius: 10px; background: #E0F2FE; color: #0284C7; display: flex; align-items: center; justify-content: center; font-size: 20px;">
          <i class="fa fa-calendar-check-o"></i>
        </div>
        <div>
          <div style="font-size: 12px; color: #64748B; font-weight: 600; text-transform: uppercase;">Appointments Booked</div>
          <div style="font-size: 22px; font-weight: 800; color: #0F172A;"><?=$total_appts;?></div>
        </div>
      </div>
    </div>

    <!-- Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-list" style="color: #EA4335; margin-right: 8px;"></i> Google Auth Users List (<?=$total_gmail;?>)
        </h3>
        <span style="font-size: 12px; color: #64748B;">Instant Login &amp; SSO Enabled</span>
      </div>

      <div class="table-responsive" style="padding: 16px;">
        <table class="table table-hover" id="gmailUsersTable" style="width: 100%; vertical-align: middle;">
          <thead>
            <tr style="background: #F8FAFC; font-size: 11.5px; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">
              <th style="width: 70px;">User ID</th>
              <th>Patient / Profile</th>
              <th>Google UID (GUID)</th>
              <th>Email Address</th>
              <th>Mobile</th>
              <th>Appts / Wallet</th>
              <th>Registered</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($userlogin)) {
              foreach($userlogin as $p) { 
                $avatar = !empty($p->IMAGE) && filter_var($p->IMAGE, FILTER_VALIDATE_URL) ? $p->IMAGE : base_url('images/dummydr.jpg');
                $is_active = ($p->STATUS == '1');
            ?>
              <tr>
                <td style="font-weight: 700; color: #64748B; font-size: 13px;">
                  #<?=$p->USERID;?>
                </td>
                <td>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?=$avatar;?>" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 1px solid #E2E8F0;" onerror="this.src='https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100';">
                    <div>
                      <strong style="font-size: 13.5px; color: #0F172A; display: block;">
                        <?=html_escape($p->FNAME . ' ' . $p->LNAME);?>
                      </strong>
                      <span style="font-size: 11px; color: #059669; font-weight: 600;">
                        <i class="fa fa-check-circle"></i> Google SSO
                      </span>
                    </div>
                  </div>
                </td>
                <td style="font-size: 12px; color: #64748B; font-family: monospace;">
                  <span style="background: #F1F5F9; padding: 2px 6px; border-radius: 4px; border: 1px solid #E2E8F0;">
                    <?=substr($p->GUID, 0, 15);?>...
                  </span>
                </td>
                <td style="font-size: 13px; color: #334155; font-weight: 500;">
                  <a href="mailto:<?=html_escape($p->EMAIL);?>" style="color: #2563EB; text-decoration: none;">
                    <?=html_escape($p->EMAIL);?>
                  </a>
                </td>
                <td style="font-size: 13px; color: #475569;">
                  <?=$p->MOBILE ?: '<span style="color:#94A3B8;">Not set</span>';?>
                </td>
                <td>
                  <span class="badge" style="background: #E0F2FE; color: #0369A1; font-size: 11px; font-weight: 600;">
                    <?=(int)@$p->total_appointments;?> Bookings
                  </span>
                  <?php if (!empty($p->wallet_points)): ?>
                    <span class="badge" style="background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 600; margin-left: 4px;">
                      <?=(float)$p->wallet_points;?> Pts
                    </span>
                  <?php endif; ?>
                </td>
                <td style="font-size: 12px; color: #64748B;">
                  <?=!empty($p->REG_DATE) ? date('d M Y', strtotime($p->REG_DATE)) : '-';?>
                </td>
                <td>
                  <a href="<?=base_url('users/userlogincreate/toggle_user_status?USERID=' . $p->USERID);?>" class="label label-<?=$is_active ? 'success' : 'danger';?>" title="Click to toggle status" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-decoration: none;">
                    <?=$is_active ? 'ACTIVE' : 'BLOCKED';?>
                  </a>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <a href="<?=base_url('users/userlogincreate/delete?USERID=' . $p->USERID);?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this user account?')" style="border-radius: 4px;" title="Delete User">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="9" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                  No Google / Gmail registered users found.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  if ($.fn.DataTable.isDataTable('#gmailUsersTable')) {
    $('#gmailUsersTable').DataTable().destroy();
  }
  $('#gmailUsersTable').DataTable({
    pageLength: 25,
    responsive: true,
    order: [[0, 'desc']]
  });
});
</script>
<?=$this->load->view('inc/footer');?>

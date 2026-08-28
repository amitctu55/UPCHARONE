<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Facebook Social Auth Registrations
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Patients and mobile app users logged in via Facebook Connect</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>users/userlogincreate/app_download_users" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-globe"></i> Direct Users
        </a>
        <a href="<?=base_url()?>users/userlogincreate/gmail_users" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-google" style="color: #EA4335;"></i> Google Users
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-facebook" style="color: #1877F2; margin-right: 8px;"></i> Facebook Auth Users
        </h3>
      </div>

      <div class="table-responsive" style="padding: 16px;">
        <table class="table table-hover" id="example" style="width: 100%; border-collapse: separate; border-spacing: 0;">
          <thead>
            <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
              <th style="padding: 12px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 80px;">User ID</th>
              <th style="padding: 12px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Full Name</th>
              <th style="padding: 12px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Facebook UID</th>
              <th style="padding: 12px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($userlogin)) {
              foreach($userlogin as $p) { ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 12px 16px; font-weight: 600; color: #64748B; font-size: 13px;">
                  #<?=$p->USERID;?>
                </td>
                <td style="padding: 12px 16px; font-weight: 600; color: #0F172A; font-size: 14px;">
                  <?=$p->FNAME;?>
                </td>
                <td style="padding: 12px 16px; font-size: 12px; color: #64748B; font-family: monospace;">
                  <?=$p->FBUID;?>
                </td>
                <td style="padding: 12px 16px; font-size: 13px; color: #475569;">
                  <?=$p->EMAIL;?>
                </td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="4" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                  No Facebook Auth registrations found.
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
  if ($.fn.DataTable.isDataTable('#example')) {
    $('#example').DataTable().destroy();
  }
  $('#example').DataTable({
    pageLength: 25,
    responsive: true
  });
});
</script>
<?=$this->load->view('inc/footer');?>

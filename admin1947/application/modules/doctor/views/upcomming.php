<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Upcoming Appointments
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View and filter scheduled future patient consultations across hospitals and clinics</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>doctor/appointment/todayappointment" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-calendar-check-o"></i> Today's Schedule
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <!-- Filter Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px;">
      <?php echo form_open("doctor/appointment/upcomming/", 'id="search_form" method="get"'); ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; align-items: flex-end;">
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Records Per Page</label>
            <div><?php echo display_record_per_page();?></div>
          </div>
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Hospital Name</label>
            <input type="text" class="form-control" name="hospital_name" value="<?php echo $this->input->get_post('hospital_name');?>" placeholder="Filter hospital..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
          </div>
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Doctor Name</label>
            <input type="text" class="form-control" name="doctor_name" value="<?php echo $this->input->get_post('doctor_name');?>" placeholder="Filter doctor..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
          </div>
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Patient Name</label>
            <input type="text" class="form-control" name="paient_name" value="<?php echo $this->input->get_post('paient_name');?>" placeholder="Filter patient..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
          </div>
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Patient Phone</label>
            <input type="text" class="form-control" name="paient_phone" value="<?php echo $this->input->get_post('paient_phone');?>" placeholder="Phone number..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
          </div>
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Patient Email</label>
            <input type="text" class="form-control" name="paient_email" value="<?php echo $this->input->get_post('paient_email');?>" placeholder="Email..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px;">
          <a href="<?=base_url();?>doctor/appointment/upcomming" class="btn" style="background: #F1F5F9; color: #64748B; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px; text-decoration: none;">
            Clear Filters
          </a>
          <button type="submit" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 8px 20px; border-radius: 8px; border: none; font-size: 13px; box-shadow: 0 2px 4px rgba(13,148,136,0.25);">
            <i class="fa fa-search" style="margin-right: 4px;"></i> Search Schedule
          </button>
        </div>
      <?php echo form_close();?>
    </div>

    <?=$this->session->flashdata('flashmsg');?>

    <!-- Data Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <?php $att=array('class'=>'form-horizontal form-label-left','name'=>'myform');
      echo form_open_multipart("doctor/appointment/upcomming", $att);?>
        <div class="table-responsive">
          <table class="table table-hover" style="margin: 0; border-collapse: separate; border-spacing: 0;">
            <thead>
              <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                <th style="width: 40px; padding: 14px 16px; text-align: center;">
                  <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" style="accent-color: #0d9488;">
                </th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Schedule Date & Time</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Patient Info</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Doctor</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Hospital / Clinic</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Fee</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(!empty($data)) {
                foreach($data as $p) { ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                  <td style="padding: 14px 16px; text-align: center;">
                    <input type="checkbox" name="arr_ids[]" value="<?php echo $p->id;?>" style="accent-color: #0d9488;">
                  </td>
                  <td style="padding: 14px 16px;">
                    <div style="font-weight: 700; color: #0F172A; font-size: 13px;">
                      <i class="fa fa-calendar" style="color: #0d9488; margin-right: 6px;"></i> <?=$p->apdate;?>
                    </div>
                    <div style="font-size: 12px; color: #64748B; margin-top: 2px;">
                      <i class="fa fa-clock-o" style="margin-right: 4px;"></i> <?=$p->aptime;?>
                    </div>
                  </td>
                  <td style="padding: 14px 16px;">
                    <div style="font-weight: 600; color: #0F172A; font-size: 14px;"><?=$p->pname;?></div>
                    <div style="font-size: 12px; color: #64748B; margin-top: 2px;">
                      <i class="fa fa-phone" style="margin-right: 4px;"></i> <?=$p->pmobile;?>
                    </div>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 600; color: #334155; font-size: 13px;">
                    Dr. <?=$p->dname;?>
                  </td>
                  <td style="padding: 14px 16px; font-size: 13px; color: #475569;">
                    <?=$p->hname;?>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 700; color: #0d9488; font-size: 14px;">
                    ₹<?=$p->fee;?>
                  </td>
                  <td style="padding: 14px 16px; text-align: right;">
                    <a href="<?=base_url()?>doctor/appointment/delete_upcomming/<?=$p->id;?>" onclick="return confirm('Are you sure you want to remove this appointment?');" class="btn btn-sm" style="background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; border-radius: 6px; padding: 5px 10px; font-size: 12px; font-weight: 600;">
                      <i class="fa fa-trash"></i> Cancel
                    </a>
                  </td>
                </tr>
              <?php } } else { ?>
                <tr>
                  <td colspan="7" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                    No upcoming appointments scheduled.
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; padding: 16px 20px; border-top: 1px solid #F1F5F9; gap: 12px;">
          <div>
            <input name="status_action" type="submit" value="Delete Selected" class="btn btn-danger btn-sm" style="border-radius: 6px; font-weight: 600; padding: 6px 14px;" onClick="return confirm('Are you sure you want to delete selected items?');">
          </div>
          <div class="pagination" style="margin: 0;">
            <?php echo $page_links; ?>
          </div>
        </div>
      <?php echo form_close();?>
    </div>
  </section>
</div>

<script type="text/javascript">       
function check_uncheck_checkbox(isChecked) {
  $('input[name="arr_ids[]"]').each(function() { this.checked = isChecked; });
}
</script>
<?=$this->load->view('inc/footer');?>

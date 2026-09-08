<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-hospital-o" style="color: #00a896;"></i> Hospital &amp; Doctor Affiliation Directory
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 13px;">
          Manage doctor practice affiliations, consultation fees, and opd time schedules across medical facilities.
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-primary" style="font-weight: 700; border-radius: 8px; background: #00a896; border-color: #00a896; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
          <i class="fa fa-user-plus"></i> Assign Doctor to Facility
        </a>
        <a href="<?=base_url('doctor/clinicreg/viewhospital');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
          <i class="fa fa-building-o"></i> View Hospitals
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 0 30px 40px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Filter Card -->
    <?php 
      $hospital_id = $this->uri->segment(4);
      $action_url = "doctor/clinicreg/hospital_doctor" . ($hospital_id ? "/".$hospital_id : "");
    ?>
    <div style="background: #ffffff; border-radius: 12px; padding: 20px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; margin-bottom: 25px;">
      <form id="search_form" action="<?=base_url($action_url);?>" method="get" class="form-inline" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        
        <div class="form-group" style="margin: 0; flex: 1; min-width: 260px;">
          <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Search Keyword</label>
          <div class="input-group" style="width: 100%;">
            <span class="input-group-addon" style="background: #f8fafc; border-color: #cbd5e1;"><i class="fa fa-search text-muted"></i></span>
            <input type="text" name="keyword" class="form-control" placeholder="Search by doctor name, hospital, phone..." value="<?=htmlspecialchars($this->input->get('keyword') ?: '');?>" style="border-radius: 0 6px 6px 0; border-color: #cbd5e1;">
          </div>
        </div>

        <div class="form-group" style="margin: 0; min-width: 160px;">
          <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Facility Type</label>
          <select name="type" class="form-control" style="width: 100%; border-radius: 6px; border-color: #cbd5e1;">
            <option value="">All Facility Types</option>
            <option value="H" <?=$this->input->get('type') === 'H' ? 'selected' : '';?>>Hospital</option>
            <option value="C" <?=$this->input->get('type') === 'C' ? 'selected' : '';?>>Clinic</option>
          </select>
        </div>

        <div class="form-group" style="margin: 0; min-width: 140px;">
          <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Per Page</label>
          <select name="pagesize" class="form-control" style="width: 100%; border-radius: 6px; border-color: #cbd5e1;" onchange="$('#search_form').submit();">
            <?php 
              $cur_ps = (int)$this->input->get('pagesize') ?: 10;
              foreach ([10, 25, 50, 100] as $ps):
            ?>
              <option value="<?=$ps;?>" <?=$cur_ps === $ps ? 'selected' : '';?>><?=$ps;?> per page</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div style="display: flex; gap: 8px; margin-top: 20px;">
          <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 7px 18px;">
            <i class="fa fa-filter"></i> Apply Filter
          </button>
          <?php if ($this->input->get('keyword') || $this->input->get('type')): ?>
            <a href="<?=base_url($action_url);?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; padding: 7px 14px;">
              <i class="fa fa-times"></i> Clear
            </a>
          <?php endif; ?>
        </div>

      </form>
    </div>

    <!-- Practice Table Card -->
    <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden;">
      <?php echo form_open_multipart($action_url, array('name' => 'myform', 'id' => 'practiceTableForm')); ?>
        <div class="table-responsive" style="margin: 0;">
          <table class="table table-hover" style="margin: 0; vertical-align: middle;">
            <thead>
              <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="width: 40px; text-align: center; vertical-align: middle;">
                  <input type="checkbox" id="checkall" onclick="check_uncheck_checkbox(this.checked);" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                </th>
                <th style="width: 70px; color: #475569; font-size: 12.5px; font-weight: 700;">ID</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700;">Doctor Name &amp; Speciality</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700;">Facility / Institution</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700;">Location / City</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700;">Doctor Contact</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700;">Consultation Fee</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700; text-align: center;">Status</th>
                <th style="color: #475569; font-size: 12.5px; font-weight: 700; text-align: center; width: 180px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($doctor) && is_array($doctor)): foreach ($doctor as $val): ?>
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                  <td style="text-align: center; vertical-align: middle;">
                    <input type="checkbox" name="arr_ids[]" value="<?=$val['id'];?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                  </td>
                  <td style="font-weight: 600; color: #64748b; vertical-align: middle;">#<?=$val['id'];?></td>
                  <td style="vertical-align: middle;">
                    <div style="font-weight: 700; color: #1e293b; font-size: 14px;">
                      Dr. <?=htmlspecialchars($val['fname'].' '.$val['lname']);?>
                    </div>
                    <?php if (!empty($val['speciality'])): ?>
                      <span class="label" style="background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; font-size: 11px; margin-top: 3px; display: inline-block;">
                        <?=htmlspecialchars($val['speciality']);?>
                      </span>
                    <?php else: ?>
                      <span class="label label-default" style="font-size: 10.5px;">General Practitioner</span>
                    <?php endif; ?>
                  </td>
                  <td style="vertical-align: middle;">
                    <div style="font-weight: 600; color: #334155; font-size: 13.5px;">
                      <?=htmlspecialchars($val['facility_name']);?>
                    </div>
                    <span class="label <?=($val['type'] === 'C') ? 'label-warning' : 'label-info';?>" style="font-size: 10.5px; padding: 2px 7px; border-radius: 4px;">
                      <?=($val['type'] === 'C') ? 'Clinic' : 'Hospital';?>
                    </span>
                  </td>
                  <td style="vertical-align: middle;">
                    <span style="color: #475569; font-size: 13px;">
                      <i class="fa fa-map-marker text-danger"></i> <?=getCityName($val['city']);?>
                    </span>
                  </td>
                  <td style="vertical-align: middle;">
                    <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($val['mobile']);?></div>
                    <div style="font-size: 12px; color: #64748b;"><i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($val['email']);?></div>
                  </td>
                  <td style="vertical-align: middle; font-weight: 700; color: #059669; font-size: 14px;">
                    Rs. <?=number_format(floatval($val['fee']), 2);?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <?php if ($val['status'] == 1): ?>
                      <span class="label label-success" style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; font-size: 11.5px; padding: 4px 9px; border-radius: 12px;">
                        <i class="fa fa-check"></i> Active
                      </span>
                    <?php else: ?>
                      <span class="label label-warning" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 11.5px; padding: 4px 9px; border-radius: 12px;">
                        <i class="fa fa-clock-o"></i> Pending
                      </span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$val['id']);?>" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 6px; padding: 5px 10px; color: #0284c7; border-color: #cbd5e1;" title="Doctor Fee &amp; OPD Time Slots">
                      <i class="fa fa-clock-o"></i> Timing &amp; Slots
                    </a>
                    <a href="<?=base_url('doctor/clinicreg/delete_affiliation/'.$val['id']);?>" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 6px; padding: 5px 8px; color: #ef4444; border-color: #cbd5e1; margin-left: 4px;" onclick="return confirm('Are you sure you want to unlink this doctor affiliation?');" title="Unlink Affiliation">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; else: ?>
                <tr>
                  <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.4;"></i>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">No practice affiliations found matching your query.</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Bulk Action & Pagination Footer -->
        <div style="padding: 16px 24px; background: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
          <div style="display: flex; gap: 8px;">
            <input name="status_action" type="submit" value="Activate" class="btn btn-sm btn-success" style="font-weight: 600; border-radius: 6px;" onclick="return validcheckstatus('arr_ids[]','Activate','Record');">
            <input name="status_action" type="submit" value="Deactivate" class="btn btn-sm btn-warning" style="font-weight: 600; border-radius: 6px;" onclick="return validcheckstatus('arr_ids[]','Deactivate','Record');">
            <input name="status_action" type="submit" value="Delete" class="btn btn-sm btn-danger" style="font-weight: 600; border-radius: 6px;" onclick="return validcheckstatus('arr_ids[]','Delete','Record');">
          </div>
          <div class="pagination" style="margin: 0;">
            <?=$page_links;?>
          </div>
        </div>
      <?php echo form_close(); ?>
    </div>

  </section>
</div>

<script type="text/javascript">
function check_uncheck_checkbox(isChecked) {
  $('input[name="arr_ids[]"]').prop('checked', isChecked);
}

function validcheckstatus(name, action, text) {
  var chObj = document.getElementsByName(name);
  var result = false;
  for (var i = 0; i < chObj.length; i++) {
    if (chObj[i].checked) {
      result = true;
      break;
    }
  }
  if (!result) {
    alert("Please select at least one " + text + " to " + action + ".");
    return false;
  }
  return confirm("Are you sure you want to " + action + " selected records?");
}
</script>

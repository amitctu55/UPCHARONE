<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Management Master
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage dashboard functional modules, navigation links, and controller routing</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <span style="font-size: 13px; color: #64748B;">Admin Master Operations</span>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Two Column Master Grid Layout -->
    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 24px; align-items: flex-start;">
      
      <!-- Left Column: Sticky Add/Edit Form -->
      <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; position: sticky; top: 20px;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
          <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fa fa-sitemap" style="color: #0d9488; margin-right: 8px;"></i> Add / Edit Management Module
          </h3>
        </div>

        <form action="<?=base_url()?>masters/management/create" method="post" id="myform" style="padding: 20px;">
          <div style="display: flex; flex-direction: column; gap: 14px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Section / Parent Group</label>
              <select name="section_id" id="section_id" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                <option value="0">-- Select Parent Section --</option>
                <?php 
                $sections = $this->db->get_where('master_sections', array('isStatus'=>'1'))->result_array(); 
                if(is_array($sections) && !empty($sections)) {
                  foreach($sections as $sec) { ?>
                    <option value="<?php echo $sec['section_id'];?>"><?php echo $sec['section_name'];?></option>
                <?php } } ?>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Management / Module Name <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="management" placeholder="e.g., Doctor Management" name="management" data-validation="required" data-validation-error-msg="Name is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Module Folder <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="module_folder" placeholder="e.g., doctor" name="module_folder" data-validation="required" data-validation-error-msg="Folder is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Module Controller <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="module_controller" placeholder="e.g., doctorview" name="module_controller" data-validation="required" data-validation-error-msg="Controller is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Module Action Method <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="module_action" placeholder="e.g., index" name="module_action" data-validation="required" data-validation-error-msg="Action is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">FontAwesome Icon Class <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="module_icon" placeholder="e.g., fa-user-md" name="module_icon" data-validation="required" data-validation-error-msg="Icon is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <input type="hidden" id="eid" name="eid">

            <div style="display: flex; gap: 10px; margin-top: 10px;">
              <button type="reset" id="reset" class="btn" style="flex: 1; background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1;">Reset</button>
              <button type="submit" id="submit" name="submit" class="btn" style="flex: 1.5; background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">Add Module</button>
            </div>
          </div>
        </form>
      </div>

      <!-- Right Column: Data Table Card -->
      <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
          <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fa fa-list" style="color: #0d9488; margin-right: 8px;"></i> Registered Management Modules
          </h3>
        </div>

        <div class="table-responsive" style="padding: 16px;">
          <table class="table table-hover" id="mydata" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
              <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 60px;">#</th>
                <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Module Name</th>
                <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Route Target</th>
                <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $getlists = $this->db->get_where('master_management');
              $i = 1;
              foreach($getlists->result() as $rowdata) {
                $status = $rowdata->isStatus;
                $statusclass = ($status == 1) ? 'background: #DCFCE7; color: #15803D;' : 'background: #FEE2E2; color: #B91C1C;';
                $statusvalue = ($status == 1) ? 'Active' : 'Inactive';
              ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 12px 14px; font-weight: 600; color: #64748B; font-size: 13px;"><?=$i;?></td>
                <td style="padding: 12px 14px; font-weight: 600; color: #0F172A; font-size: 14px;">
                  <i class="fa <?=$rowdata->module_icon;?>" style="color: #0d9488; margin-right: 6px; width: 16px;"></i> <?=$rowdata->module_name;?>
                </td>
                <td style="padding: 12px 14px; font-size: 12px; color: #64748B; font-family: monospace;">
                  <?=$rowdata->module_folder;?>/<?=$rowdata->module_controller;?>/<?=$rowdata->module_action;?>
                </td>
                <td style="padding: 12px 14px;">
                  <a href="javascript:void(0);" class="statuscng" data-uid="<?=$rowdata->module_id;?>" style="text-decoration: none;">
                    <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; <?=$statusclass?>">
                      <?=$statusvalue?>
                    </span>
                  </a>
                </td>
                <td style="padding: 12px 14px; text-align: right;">
                  <a href="javascript:void(0);" class="select btn btn-sm" data-uid="<?=base64_encode($rowdata->module_id)?>" data-section="<?=$rowdata->section_id;?>" data-name="<?=$rowdata->module_name;?>" data-folder="<?=$rowdata->module_folder;?>" data-controller="<?=$rowdata->module_controller;?>" data-action="<?=$rowdata->module_action;?>" data-icon="<?=$rowdata->module_icon;?>" style="background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; border-radius: 6px; padding: 4px 10px; font-weight: 600; font-size: 12px;">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                </td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script> $.validate({}); </script>
<script>
$(document).ready(function() {
  if ($.fn.DataTable.isDataTable('#mydata')) {
    $('#mydata').DataTable().destroy();
  }
  $('#mydata').DataTable({
    pageLength: 25,
    responsive: true
  });

  $(".statuscng").click(function() {
    var uid = $(this).attr('data-uid');
    var uri = '<?=base_url()?>masters/management/statusupdate';
    $.ajax({
      type: "post",
      url: uri,
      data: {uid: uid},
      success: function(result) {
        location.reload();
      }
    });
  });

  $(".select").click(function() {
    var uid = $(this).attr('data-uid');
    var section = $(this).attr('data-section');
    var name = $(this).attr('data-name');
    var folder = $(this).attr('data-folder');
    var controller = $(this).attr('data-controller');
    var action = $(this).attr('data-action');
    var icon = $(this).attr('data-icon');
    $("#eid").val(uid);
    $("#section_id").val(section);
    $("#management").val(name);
    $("#module_folder").val(folder);
    $("#module_controller").val(controller);
    $("#module_action").val(action);
    $("#module_icon").val(icon);
    $("#submit").html('Update Module');
    window.scrollTo({top: 0, behavior: 'smooth'});
  });

  $("#reset").click(function() {
    $("#eid").val('');
    $("#section_id").val('0');
    $("#management").val('');
    $("#module_folder").val('');
    $("#module_controller").val('');
    $("#module_action").val('');
    $("#module_icon").val('');
    $("#submit").html('Add Module');
  });
});
</script>
<?=$this->load->view('inc/footer');?>

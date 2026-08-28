<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Premium Membership Plans
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage subscription tiers, pricing, benefits, and user entitlements</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url();?>users/premium/add" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; box-shadow: 0 2px 4px rgba(13,148,136,0.25);">
          <i class="fa fa-plus"></i> Add New Plan
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <!-- Filter Bar Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 18px 20px; margin-bottom: 20px;">
      <?php echo form_open("users/premium/", 'id="search_form" method="get" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;"'); ?>
        <div style="min-width: 140px;">
          <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Records Per Page</label>
          <div style="height: 38px;">
            <?php echo display_record_per_page();?>
          </div>
        </div>

        <div style="flex: 1; min-width: 220px;">
          <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Search Plan Title</label>
          <input type="text" class="form-control" name="title" value="<?php echo $this->input->get_post('title');?>" placeholder="Filter by plan name..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
        </div>

        <div style="display: flex; gap: 8px;">
          <button type="submit" class="btn" style="height: 38px; background: #0d9488; color: #fff; font-weight: 600; padding: 0 16px; border-radius: 8px; border: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
            <i class="fa fa-search"></i> Filter
          </button>
          <?php if($this->input->get_post('title') != '') { ?>
            <a href="<?=base_url();?>users/premium/" class="btn" style="height: 38px; background: #F1F5F9; color: #64748B; font-weight: 600; padding: 0 14px; border-radius: 8px; border: 1px solid #CBD5E1; display: inline-flex; align-items: center; gap: 4px; font-size: 13px;">
              <i class="fa fa-times"></i> Clear
            </a>
          <?php } ?>
        </div>
      <?php echo form_close();?>
    </div>

    <?=$this->session->flashdata('flashmsg');?>

    <!-- Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <?php $att=array('class'=>'form-horizontal form-label-left','name'=>'myform');
      echo form_open_multipart("users/premium/", $att);?>
        <div class="table-responsive">
          <table class="table table-hover" style="margin: 0; border-collapse: separate; border-spacing: 0;">
            <thead>
              <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                <th style="width: 40px; padding: 14px 16px; text-align: center;">
                  <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" style="accent-color: #0d9488;">
                </th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Plan Title</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Price</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Image</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Approved</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Created Date</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(is_array($result) && !empty($result)) {
                foreach($result as $val) { ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                  <td style="padding: 14px 16px; text-align: center;">
                    <input type="checkbox" name="arr_ids[]" value="<?php echo $val['premium_id'];?>" style="accent-color: #0d9488;">
                  </td>
                  <td style="padding: 14px 16px; font-weight: 600; color: #0F172A; font-size: 14px;">
                    <?php echo $val['title']?>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 700; color: #0d9488; font-size: 14px;">
                    ₹<?php echo number_format((float)$val['price'], 2); ?>
                  </td>
                  <td style="padding: 14px 16px; font-size: 13px; color: #64748B;">
                    <?php if(!empty($val['description'])) { ?>
                      <a data-toggle="modal" data-target="#myModal<?php echo $val['premium_id'];?>" style="color: #0d9488; cursor: pointer; font-weight: 600;">
                        <i class="fa fa-file-text-o"></i> View Details
                      </a>
                      <div class="modal fade" id="myModal<?php echo $val['premium_id'];?>">
                        <div class="modal-dialog">
                          <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
                            <div class="modal-header" style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 16px 20px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" style="font-weight: 700; font-size: 16px; color: #1E293B;"><?php echo $val['title'];?> - Description</h4>
                            </div>
                            <div class="modal-body" style="padding: 20px; font-size: 14px; color: #334155; line-height: 1.6;">
                              <?php echo nl2br($val['description']);?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } else { echo '<span style="color: #94A3B8;">None</span>'; } ?>
                  </td>
                  <td style="padding: 14px 16px;">
                    <?php if(!empty($val['image'])) { ?>
                      <a data-toggle="modal" data-target="#myModalImg<?php echo $val['premium_id'];?>" style="color: #0d9488; cursor: pointer; font-weight: 600;">
                        <i class="fa fa-picture-o"></i> View Banner
                      </a>
                      <div class="modal fade" id="myModalImg<?php echo $val['premium_id'];?>">
                        <div class="modal-dialog">
                          <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
                            <div class="modal-header" style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 16px 20px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" style="font-weight: 700; font-size: 16px;"><?php echo $val['title'];?> Banner</h4>
                            </div>
                            <div class="modal-body" style="padding: 20px; text-align: center;">
                              <img src="<?=base_url()?>public/assets/upload/<?=$val['image']?>" style="max-width: 100%; border-radius: 8px;">
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } else { echo '<span style="color: #94A3B8;">No Image</span>'; } ?>
                  </td>
                  <td style="padding: 14px 16px;">
                    <?php if($val['status'] == '1') { ?>
                      <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #DCFCE7; color: #15803D;">Active</span>
                    <?php } else { ?>
                      <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #FEE2E2; color: #B91C1C;">Inactive</span>
                    <?php } ?>
                  </td>
                  <td style="padding: 14px 16px;">
                    <?php if($val['approved'] == '1') { ?>
                      <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #E0F2FE; color: #0369A1;">Approved</span>
                    <?php } else { ?>
                      <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #FEF3C7; color: #B45309;">Pending</span>
                    <?php } ?>
                  </td>
                  <td style="padding: 14px 16px; font-size: 13px; color: #64748B;">
                    <?php echo formatedate($val['creat_date']); ?>
                  </td>
                  <td style="padding: 14px 16px; text-align: right;">
                    <a href="<?=base_url();?>users/premium/update/<?=$val['premium_id']?>" class="btn btn-sm" style="background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; border-radius: 6px; padding: 5px 10px; font-weight: 600; font-size: 12px;">
                      <i class="fa fa-edit"></i> Edit
                    </a>
                  </td>
                </tr>
              <?php } } else { ?>
                <tr>
                  <td colspan="9" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                    No premium membership plans found.
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; padding: 16px 20px; border-top: 1px solid #F1F5F9; gap: 12px;">
          <div>
            <input name="status_action" type="submit" value="Delete Selected" class="btn btn-danger btn-sm" style="border-radius: 6px; font-weight: 600; padding: 6px 14px;" onClick="return validcheckstatus('arr_ids[]','Record','Record');">
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
function validcheckstatus(name, action, text) {
  var chObj = document.getElementsByName(name);
  var result = false;	
  for(var i=0; i<chObj.length; i++) {
    if(chObj[i].checked) { result = true; break; }
  }
  if(!result) {
    alert("Please select at least one record to delete.");
    return false;
  }
  return confirm("Are you sure you want to delete the selected items?");
}
</script>
<?=$this->load->view('inc/footer');?>

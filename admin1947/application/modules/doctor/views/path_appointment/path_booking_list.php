<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Pathology Test Bookings
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage diagnostic test appointments, sample collections, lab assignments, and payments</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <button type="button" id="bulk-delete-booking-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
          <i class="fa fa-trash"></i> Delete Selected (<span id="booking-selected-count">0</span>)
        </button>
        <a href="<?=base_url();?>doctor/path_appointment/book_test" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-plus"></i> Book Lab Test
        </a>
      </div>
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

      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-flask" style="color: #00a896;"></i>
            <span>Lab Diagnostic Bookings Directory</span>
          </h3>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/path_appointment/')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 200px;">
                <input type="text" class="form-control input-sm" name="paient_name" value="<?=$this->input->get_post('paient_name');?>" placeholder="Filter patient..." style="height: 34px; border-radius: 6px;">
              </div>

              <div style="width: 150px;">
                <input type="date" class="form-control input-sm" name="date_from" value="<?=$this->input->get_post('date_from');?>" style="height: 34px; border-radius: 6px;">
              </div>

              <div style="width: 150px;">
                <input type="date" class="form-control input-sm" name="date_to" value="<?=$this->input->get_post('date_to');?>" style="height: 34px; border-radius: 6px;">
              </div>

              <button type="submit" class="btn btn-sm btn-primary" style="height: 34px; background: #00a896; border-color: #00a896; color: #fff; font-weight: 600; padding: 0 16px; border-radius: 6px;">
                <i class="fa fa-search"></i> Filter
              </button>

              <?php if($this->input->get_post('paient_name') != '' || $this->input->get_post('date_from') != '') { ?>
                <a href="<?=base_url();?>doctor/path_appointment/" class="btn btn-sm btn-default" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php } ?>
            </div>
          </form>

          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="booking-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-bookings" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 80px; text-align: center;">#ID</th>
                  <th>Patient Details</th>
                  <th>Pathology Lab</th>
                  <th>Total Amount</th>
                  <th style="width: 100px; text-align: center;">Payment</th>
                  <th style="width: 100px; text-align: center;">Status</th>
                  <th style="width: 110px; text-align: center;">Date</th>
                  <th style="width: 100px; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)): foreach($data as $p): 
                  $bid = $p->booking_id;
                  $pname = $p->patient_name;
                  $pmobile = $p->patient_mobile;
                  $pemail = $p->patient_email;
                  $labname = $p->pathlab_name;
                  $amount = $p->total_amount;
                  $paymentStatus = $p->payment_status;
                  $status = $p->status;
                ?>
                  <tr id="row-<?=$bid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="booking-checkbox" value="<?=$bid;?>" data-name="<?=htmlspecialchars($pname);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">#<?=$bid;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($pname);?></strong>
                      <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                        <i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($pmobile);?>
                      </div>
                      <?php if(!empty($pemail)): ?>
                        <div style="font-size: 11.5px; color: #94a3b8;">
                          <i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($pemail);?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #334155; font-size: 13px;"><i class="fa fa-hospital-o text-muted"></i> <?=htmlspecialchars($labname);?></strong>
                      <div style="font-size: 11.5px; color: #94a3b8;"><?=htmlspecialchars($p->city_name);?></div>
                    </td>
                    <td style="vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                      ₹<?=number_format($amount, 2);?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <?php if($paymentStatus == '1'): ?>
                        <span class="label label-success" style="font-size: 11px;">Paid</span>
                      <?php elseif($paymentStatus == '0'): ?>
                        <span class="label label-warning" style="font-size: 11px;">Pending</span>
                      <?php else: ?>
                        <span class="label label-danger" style="font-size: 11px;">Failed</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge-pill-status <?=$status=='1'?'badge-status-active':'badge-status-inactive';?>">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$status=='1'?'Completed':'Pending';?></span>
                      </span>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($p->book_date));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/path_appointment/booking_details/'.$bid);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Details">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/path_appointment/delete_booking/'.$bid);?>" class="btn-icon-action btn-action-delete delete-booking-btn" data-id="<?=$bid;?>" data-name="<?=htmlspecialchars($pname);?>" title="Delete Booking">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No lab test bookings found.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Footer -->
          <?php if(!empty($page_links)): ?>
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 18px;">
              <div class="pagination-wrapper">
                <?=$page_links;?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteBookingModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Pathology Booking</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete booking for <strong id="delete-booking-name" style="color: #1e293b;">this patient</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-booking-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteBookingModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Bookings</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-booking-count" style="color: #dc2626;">0</strong> selected pathology bookings? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-booking-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete Selected
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showToast(message, type) {
  var bg = (type === 'success') ? '#10b981' : ((type === 'danger') ? '#ef4444' : '#00a896');
  var icon = (type === 'success') ? 'fa-check-circle' : ((type === 'danger') ? 'fa-exclamation-triangle' : 'fa-info-circle');
  var toastId = 'toast-' + Date.now();
  
  var toastHtml = '<div id="' + toastId + '" style="pointer-events: auto; background: #ffffff; color: #1e293b; border-left: 4px solid ' + bg + '; padding: 12px 18px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; min-width: 280px; transition: all 0.3s ease;">' +
    '<i class="fa ' + icon + '" style="color: ' + bg + '; font-size: 16px;"></i>' +
    '<span style="flex-grow: 1;">' + message + '</span>' +
    '<i class="fa fa-times" onclick="$(\'#' + toastId + '\').remove();" style="cursor: pointer; color: #94a3b8; font-size: 12px;"></i>' +
  '</div>';
  
  $('#toast-container').append(toastHtml);
  setTimeout(function(){
    $('#' + toastId).fadeOut(400, function(){ $(this).remove(); });
  }, 4000);
}

function updateBookingBulkState() {
  var checkedBoxes = $('.booking-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.booking-checkbox').length;

  $('#booking-selected-count').text(count);
  $('#bulk-booking-count').text(count);

  if (count > 0) {
    $('#bulk-delete-booking-btn').fadeIn(200);
  } else {
    $('#bulk-delete-booking-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-bookings').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-bookings').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-bookings').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-bookings', function(){
    var isChecked = $(this).prop('checked');
    $('.booking-checkbox').prop('checked', isChecked);
    updateBookingBulkState();
  });

  $(document).on('change', '.booking-checkbox', function(){
    updateBookingBulkState();
  });

  $(document).on('click', '#bulk-delete-booking-btn', function(){
    if ($('.booking-checkbox:checked').length === 0) return;
    $('#bulkDeleteBookingModal').modal('show');
  });

  $('#confirm-bulk-delete-booking-btn').click(function(){
    var selectedIds = [];
    $('.booking-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/path_appointment/bulk_delete_booking')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteBookingModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#booking-table tbody tr').length === 0) {
              $('#booking-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No lab test bookings found.</p></td></tr>');
            }
          });
        });

        updateBookingBulkState();
        showToast(res.message || 'Selected bookings deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting bookings.', 'danger');
      }
    });
  });

  // Delete Single Booking
  var activeDeleteBookingId = null;
  $(document).on('click', '.delete-booking-btn', function(e){
    e.preventDefault();
    activeDeleteBookingId = $(this).data('id');
    var name = $(this).data('name') || 'this booking';
    $('#delete-booking-name').text('"' + name + '"');
    $('#deleteBookingModal').modal('show');
  });

  $('#confirm-delete-booking-btn').click(function(){
    if(!activeDeleteBookingId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/path_appointment/delete_booking')?>',
      dataType: 'json',
      data: { id: activeDeleteBookingId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteBookingModal').modal('hide');
        $('#row-' + activeDeleteBookingId).fadeOut(400, function(){
          $(this).remove();
          if ($('#booking-table tbody tr').length === 0) {
            $('#booking-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No lab test bookings found.</p></td></tr>');
          }
          updateBookingBulkState();
        });
        showToast(res.message || 'Pathology booking deleted successfully.', 'success');
        activeDeleteBookingId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/path_appointment/delete_booking/')?>' + activeDeleteBookingId;
      }
    });
  });
});
</script>

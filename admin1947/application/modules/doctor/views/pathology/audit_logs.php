<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          System Audit Trail &amp; Footprint Ledger
        </h1>
        <small style="color: #64748b; font-size: 13px;">Immutable audit footprints of lab onboarding, credentials, pricing changes, status transitions, and custody handovers</small>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
        <a href="<?=base_url('doctor/pathlabreg/index')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-hospital-o"></i> Partner Labs
        </a>
        <a href="<?=base_url('doctor/pathology/index')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-link"></i> Assigned Tests
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px 40px;">
    <div class="container-fluid" style="padding: 0;">
      
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;">
        
        <!-- Filter Toolbar -->
        <div style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
          <form action="<?=base_url('doctor/pathology/audit_logs')?>" method="get" id="audit-filter-form" style="margin: 0;">
            <div class="row" style="align-items: center;">
              
              <!-- Entity Type -->
              <div class="col-md-2 form-group" style="margin-bottom: 8px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Entity Scope</label>
                <select name="entity_type" class="form-control input-sm" style="height: 34px; border-radius: 6px; font-weight: 600;" onchange="$('#audit-filter-form').submit();">
                  <option value="">-- All Entities --</option>
                  <option value="lab" <?=@$filters['entity_type']=='lab' ? 'selected' : ''?>>Pathology Lab</option>
                  <option value="test_mapping" <?=@$filters['entity_type']=='test_mapping' ? 'selected' : ''?>>Lab-Test Assignment</option>
                  <option value="master_test" <?=@$filters['entity_type']=='master_test' ? 'selected' : ''?>>Master Test Catalog</option>
                  <option value="booking" <?=@$filters['entity_type']=='booking' ? 'selected' : ''?>>Diagnostic Booking</option>
                  <option value="specimen" <?=@$filters['entity_type']=='specimen' ? 'selected' : ''?>>Specimen Custody</option>
                </select>
              </div>

              <!-- Action Type -->
              <div class="col-md-2 form-group" style="margin-bottom: 8px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Action</label>
                <select name="action" class="form-control input-sm" style="height: 34px; border-radius: 6px; font-weight: 600;" onchange="$('#audit-filter-form').submit();">
                  <option value="">-- All Actions --</option>
                  <option value="CREATED" <?=@$filters['action']=='CREATED' ? 'selected' : ''?>>CREATED</option>
                  <option value="UPDATED" <?=@$filters['action']=='UPDATED' ? 'selected' : ''?>>UPDATED</option>
                  <option value="STATUS_UPDATED" <?=@$filters['action']=='STATUS_UPDATED' ? 'selected' : ''?>>STATUS_UPDATED</option>
                  <option value="PRICE_CHANGED" <?=@$filters['action']=='PRICE_CHANGED' ? 'selected' : ''?>>PRICE_CHANGED</option>
                  <option value="HANDOVER" <?=@$filters['action']=='HANDOVER' ? 'selected' : ''?>>HANDOVER</option>
                  <option value="CREDENTIALS_PROVISIONED" <?=@$filters['action']=='CREDENTIALS_PROVISIONED' ? 'selected' : ''?>>CREDENTIALS_PROVISIONED</option>
                  <option value="DELETED" <?=@$filters['action']=='DELETED' ? 'selected' : ''?>>DELETED</option>
                </select>
              </div>

              <!-- Keyword -->
              <div class="col-md-3 form-group" style="margin-bottom: 8px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Entity ID or Keyword</label>
                <input type="text" name="keyword" class="form-control input-sm" placeholder="Remarks, IP, user role..." value="<?=htmlspecialchars(@$filters['keyword'] ?? '');?>" style="height: 34px; border-radius: 6px;">
              </div>

              <!-- Date From -->
              <div class="col-md-2 form-group" style="margin-bottom: 8px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">From Date</label>
                <input type="date" name="from_date" class="form-control input-sm" value="<?=htmlspecialchars(@$filters['from_date'] ?? '');?>" style="height: 34px; border-radius: 6px;">
              </div>

              <!-- Date To & Submit -->
              <div class="col-md-3 form-group" style="margin-bottom: 8px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">To Date</label>
                <div style="display: flex; gap: 6px;">
                  <input type="date" name="to_date" class="form-control input-sm" value="<?=htmlspecialchars(@$filters['to_date'] ?? '');?>" style="height: 34px; border-radius: 6px;">
                  <button type="submit" class="btn btn-sm btn-primary" style="height: 34px; background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 0 14px;">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                  <?php if(!empty($filters['entity_type']) || !empty($filters['action']) || !empty($filters['keyword']) || !empty($filters['from_date'])): ?>
                    <a href="<?=base_url('doctor/pathology/audit_logs')?>" class="btn btn-sm btn-default" style="height: 34px; line-height: 20px; border-radius: 6px;" title="Clear Filters">
                      <i class="fa fa-times text-danger"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </div>

            </div>
          </form>
        </div>

        <!-- Footprints Table -->
        <div class="table-responsive" style="margin: 0;">
          <table class="table table-hover table-striped" style="margin: 0; font-size: 13px;">
            <thead>
              <tr style="background: #f8fafc; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                <th style="width: 70px; text-align: center;">Log #</th>
                <th style="width: 150px;">Timestamp</th>
                <th style="width: 130px;">Action</th>
                <th style="width: 140px;">Entity Target</th>
                <th>Remarks &amp; Audit Context</th>
                <th style="width: 140px;">Actor / Role</th>
                <th style="width: 110px;">Client IP</th>
                <th style="width: 80px; text-align: center;">Payload</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($footprints)): foreach($footprints as $fp): 
                $act = $fp->action;
                $actBg = ($act == 'CREATED') ? '#dcfce7; color: #15803d;' : (($act == 'DELETED') ? '#fee2e2; color: #dc2626;' : (($act == 'PRICE_CHANGED') ? '#e0f2fe; color: #0369a1;' : (($act == 'STATUS_UPDATED') ? '#fef3c7; color: #b45309;' : '#f1f5f9; color: #334155;')));
              ?>
                <tr>
                  <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: middle;">
                    #<?=$fp->id;?>
                  </td>
                  <td style="vertical-align: middle; color: #334155; font-size: 12px; white-space: nowrap;">
                    <?=date('d M Y, h:i:s A', strtotime($fp->created_at));?>
                  </td>
                  <td style="vertical-align: middle;">
                    <span class="badge" style="background: <?=$actBg;?> font-size: 10.5px; font-weight: 700; padding: 4px 8px;">
                      <?=$act;?>
                    </span>
                  </td>
                  <td style="vertical-align: middle;">
                    <strong style="color: #0f172a; text-transform: uppercase; font-size: 12px;"><?=$fp->entity_type;?></strong>
                    <span style="color: #64748b; font-family: monospace;">#<?=$fp->entity_id;?></span>
                  </td>
                  <td style="vertical-align: middle; color: #334155;">
                    <?=htmlspecialchars($fp->remarks ?: 'No remarks recorded');?>
                  </td>
                  <td style="vertical-align: middle;">
                    <div style="font-weight: 600; color: #0f172a; font-size: 12.5px;">User #<?=$fp->user_id ?: 1;?></div>
                    <small style="color: #64748b; text-transform: uppercase; font-size: 10px; font-weight: 700;"><?=$fp->user_role ?: 'SUPER_ADMIN';?></small>
                  </td>
                  <td style="vertical-align: middle; font-family: monospace; font-size: 12px; color: #64748b;">
                    <?=$fp->ip_address ?: '127.0.0.1';?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <?php if(!empty($fp->payload_before) || !empty($fp->payload_after)): ?>
                      <button type="button" class="btn btn-xs btn-default" onclick="inspectPayload(<?=htmlspecialchars(json_encode($fp->payload_before));?>, <?=htmlspecialchars(json_encode($fp->payload_after));?>, '<?=$fp->action;?>', '<?=$fp->entity_type;?> #<?=$fp->entity_id;?>')" style="border-radius: 4px; font-weight: 600;" title="Inspect JSON State Diff">
                        <i class="fa fa-code"></i> Diff
                      </button>
                    <?php else: ?>
                      <span style="color: #cbd5e1;">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; else: ?>
                <tr>
                  <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa fa-history fa-3x" style="opacity: 0.4; margin-bottom: 8px; display: block;"></i>
                    No audit trail footprints match the selected criteria.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination Footer -->
        <?php if(!empty($page_links)): ?>
          <div style="display: flex; justify-content: flex-end; align-items: center; padding: 14px 20px; border-top: 1px solid #f1f5f9;">
            <div class="pagination-wrapper">
              <?=$page_links;?>
            </div>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>
</div>

<!-- Modal: JSON Payload Diff Viewer -->
<div class="modal fade" id="modal-payload-diff" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="margin-top: 60px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18); overflow: hidden;">
      <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 15px;">
          <i class="fa fa-code text-warning"></i> Audit State Payloads — <span id="diff-target-label"></span>
        </h4>
      </div>
      <div class="modal-body" style="padding: 20px;">
        <div class="row">
          <div class="col-md-6">
            <h5 style="font-weight: 700; color: #dc2626; font-size: 12px; text-transform: uppercase; margin-top: 0;">
              <i class="fa fa-minus-circle"></i> Payload Before (Prior State)
            </h5>
            <pre id="diff-payload-before" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 12px; font-size: 11.5px; max-height: 360px; overflow-y: auto; color: #991b1b;"></pre>
          </div>
          <div class="col-md-6">
            <h5 style="font-weight: 700; color: #16a34a; font-size: 12px; text-transform: uppercase; margin-top: 0;">
              <i class="fa fa-plus-circle"></i> Payload After (Current State)
            </h5>
            <pre id="diff-payload-after" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 12px; font-size: 11.5px; max-height: 360px; overflow-y: auto; color: #166534;"></pre>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px;">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function inspectPayload(before, after, action, target) {
  $('#diff-target-label').text(action + ' on ' + target);
  
  var beforeStr = 'null';
  if (before) {
    try {
      beforeStr = (typeof before === 'string') ? JSON.stringify(JSON.parse(before), null, 2) : JSON.stringify(before, null, 2);
    } catch(e) { beforeStr = String(before); }
  }
  $('#diff-payload-before').text(beforeStr);

  var afterStr = 'null';
  if (after) {
    try {
      afterStr = (typeof after === 'string') ? JSON.stringify(JSON.parse(after), null, 2) : JSON.stringify(after, null, 2);
    } catch(e) { afterStr = String(after); }
  }
  $('#diff-payload-after').text(afterStr);

  $('#modal-payload-diff').modal('show');
}
</script>

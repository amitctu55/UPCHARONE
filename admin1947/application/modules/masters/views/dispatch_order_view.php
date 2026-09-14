<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #08364b; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-truck" style="color: #16a34a;"></i> Manual Dispatch &amp; Rider Assignment Console
        </h1>
        <p style="color: #64748b; font-size: 13px; margin: 5px 0 0 0;">
          Assign delivery fleet riders to customer medicine orders, re-route in-transit shipments, and audit dispatch queues.
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('masters/pharmacy_fleet?tab=dispatch'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-arrow-left"></i> Back to Dispatch Queue
        </a>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; float: none; margin: 12px 0 0 0; background: transparent; padding: 0; font-size: 12px;">
      <li><a href="<?= base_url('masters/dashboard'); ?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('masters/pharmacy_fleet?tab=dispatch'); ?>" style="color: #64748b;">Pharmacy &amp; Fleet</a></li>
      <li class="active" style="color: #08364b; font-weight: 600;">Manual Dispatch</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 0 30px 30px 30px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Flash Notifications -->
      <?php if ($this->session->flashdata('error') || $this->session->flashdata('error_msg')): ?>
      <div class="alert alert-danger alert-dismissible" style="border-radius: 8px; margin-bottom: 20px;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 style="font-size: 15px; font-weight: 700; margin: 0 0 5px 0;"><i class="fa fa-exclamation-circle"></i> Error:</h4>
        <div style="font-size: 13px;"><?= $this->session->flashdata('error') ?: $this->session->flashdata('error_msg'); ?></div>
      </div>
      <?php endif; ?>

      <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin: 0 auto 30px; background: #ffffff; overflow: hidden;">
        
        <div style="background: #08364b; color: #ffffff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
          <div>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-exchange"></i> Order Dispatch &amp; Fleet Logistics Controller
            </h3>
            <span style="font-size: 12px; color: #93c5fd;">Re-allocate riders for active medicine deliveries</span>
          </div>
          <?php if (!empty($selected_order)): ?>
            <span class="badge" style="background: #16a34a; font-size: 12px; padding: 6px 12px;">Order #<?= html_escape($selected_order['order_code']); ?></span>
          <?php endif; ?>
        </div>

        <!-- Form starts here -->
        <form action="<?= base_url('masters/pharmacy_fleet/reassign_order'); ?>" method="POST" id="dispatchForm">

          <div class="box-body" style="padding: 28px 30px;">

            <!-- SECTION 1: ORDER DETAILS -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">1</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Customer Medicine Order Information</h4>
              </div>

              <?php if (!empty($selected_order)): ?>
                <input type="hidden" name="order_id" value="<?= (int)$selected_order['id']; ?>">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 16px;">
                  <div class="row">
                    <div class="col-md-3">
                      <small class="text-muted" style="display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">Order Code</small>
                      <strong style="font-size: 16px; font-family: monospace; color: #0f172a;">#<?= html_escape($selected_order['order_code']); ?></strong>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted" style="display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">Customer Contact</small>
                      <strong style="color: #0f172a;"><?= html_escape($selected_order['customer_name']); ?></strong><br>
                      <small><i class="fa fa-phone"></i> <?= html_escape($selected_order['customer_phone']); ?></small>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted" style="display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">Order Bill Value</small>
                      <strong style="color: #16a34a; font-size: 16px;">₹<?= number_format($selected_order['total_amount'], 2); ?></strong>
                      <span style="font-size: 11px; color: #64748b;">(<?= $selected_order['payment_mode']; ?>)</span>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted" style="display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">Fulfilling Pharmacy</small>
                      <strong style="color: #08364b;"><?= html_escape($selected_order['store_name'] ?? 'Partner Pharmacy'); ?></strong>
                    </div>
                  </div>
                  <?php if (!empty($selected_order['delivery_address'])): ?>
                  <div style="margin-top: 12px; padding-top: 10px; border-top: 1px dashed #cbd5e1; font-size: 12.5px; color: #475569;">
                    <i class="fa fa-map-marker text-danger"></i> <strong>Delivery Address:</strong> <?= html_escape($selected_order['delivery_address']); ?>
                  </div>
                  <?php endif; ?>
                </div>
              <?php else: ?>
                <div class="form-group">
                  <label style="font-weight: 600; color: #334155;">Select Active Order to Dispatch <span style="color: #dc2626;">*</span></label>
                  <select name="order_id" class="form-control" required style="height: 42px; border-radius: 6px;">
                    <option value="">-- Choose Order from Active Queue --</option>
                    <?php if (!empty($active_orders)): foreach($active_orders as $ord): ?>
                    <option value="<?= $ord['id']; ?>">
                      #<?= $ord['order_code']; ?> &bull; <?= html_escape($ord['customer_name'] ?? 'Customer'); ?> &bull; ₹<?= number_format($ord['total_amount'], 2); ?> (<?= $ord['order_status']; ?>)
                    </option>
                    <?php endforeach; endif; ?>
                  </select>
                  <small class="text-muted">Lists orders currently in PACKED, ASSIGNED, or IN_TRANSIT status.</small>
                </div>
              <?php endif; ?>
            </div>

            <!-- SECTION 2: FLEET RIDER TARGET SELECTION -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">2</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Target Delivery Fleet Rider</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Assign / Reassign to Rider <span style="color: #dc2626;">*</span></label>
                  <select name="new_rider_id" class="form-control" required style="height: 42px; border-radius: 6px;">
                    <option value="">-- Select Available Delivery Fleet Rider --</option>
                    <?php if (!empty($all_riders)): foreach($all_riders as $r): ?>
                    <option value="<?= $r['id']; ?>" <?= (!empty($selected_order['rider_id']) && $selected_order['rider_id'] == $r['id']) ? 'selected' : ''; ?>>
                      <?= html_escape($r['name'] ?: $r['rider_name']); ?> &bull; <?= $r['vehicle_number']; ?> (<?= $r['status']; ?>)
                    </option>
                    <?php endforeach; endif; ?>
                  </select>
                  <small class="text-muted">Riders marked AVAILABLE (Idle) will be assigned immediately.</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Dispatch Reason / Operational Note</label>
                  <input type="text" name="reason" class="form-control" value="Manual Reassignment by Dispatch Super Admin" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Recorded in the delivery audit log for SLA compliance.</small>
                </div>
              </div>
            </div>

          </div>

          <!-- Form Footer Buttons -->
          <div class="box-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=dispatch'); ?>" class="btn btn-default" style="padding: 10px 20px; font-weight: 600; border-radius: 6px;">
              <i class="fa fa-times"></i> Cancel
            </a>
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 700; border-radius: 6px; background: #00a8ff; border-color: #00a8ff; box-shadow: 0 2px 4px rgba(0,168,255,0.3);">
                <i class="fa fa-exchange"></i> Dispatch / Reassign Rider Now
              </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>

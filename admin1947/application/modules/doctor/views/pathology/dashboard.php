<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          Pathology &amp; Diagnostic Network Operating System
        </h1>
        <small style="color: #64748b; font-size: 13px;">Super Admin Central Command: Labs, Master Catalog, Chain of Custody &amp; Audit Trail</small>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathlabreg/index')?>" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 7px 14px;">
          <i class="fa fa-hospital-o"></i> Partner Labs
        </a>
        <a href="<?=base_url('doctor/pathology/add')?>" class="btn btn-sm btn-default" style="background: #ffffff; color: #1e293b; font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1; padding: 7px 14px;">
          <i class="fa fa-plus-circle text-primary"></i> Add Master Test
        </a>
        <a href="<?=base_url('doctor/pathology/assign_test')?>" class="btn btn-sm btn-default" style="background: #ffffff; color: #1e293b; font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1; padding: 7px 14px;">
          <i class="fa fa-link text-success"></i> Assign Tests
        </a>
        <a href="<?=base_url('doctor/pathology/custody')?>" class="btn btn-sm btn-warning" style="background: #f59e0b; border-color: #f59e0b; color: #ffffff; font-weight: 600; border-radius: 6px; padding: 7px 14px;">
          <i class="fa fa-truck"></i> Custody Handover Desk
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px 40px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 16px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Executive KPI Cards -->
      <div class="row" style="margin: 0 -8px 20px;">
        <!-- Partner Labs -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0 8px; margin-bottom: 12px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div>
              <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Partner Labs</div>
              <div style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 4px 0 2px;">
                <?=number_format($metrics['total_labs'] ?? 0);?>
              </div>
              <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 10px;">
                <?=number_format($metrics['approved_labs'] ?? 0);?> Approved
              </span>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa fa-flask"></i>
            </div>
          </div>
        </div>

        <!-- Master Tests -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0 8px; margin-bottom: 12px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div>
              <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Master Test Catalog</div>
              <div style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 4px 0 2px;">
                <?=number_format($metrics['total_tests'] ?? 0);?>
              </div>
              <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 10px;">
                Master Tests
              </span>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa fa-list-alt"></i>
            </div>
          </div>
        </div>

        <!-- Active Assignments -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0 8px; margin-bottom: 12px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div>
              <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Active Lab Mappings</div>
              <div style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 4px 0 2px;">
                <?=number_format($metrics['active_assignments'] ?? 0);?>
              </div>
              <span class="badge" style="background: #dcfce7; color: #16a34a; font-size: 10px;">
                <?=number_format($metrics['total_assignments'] ?? 0);?> Total Assigned
              </span>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa fa-link"></i>
            </div>
          </div>
        </div>

        <!-- Specimen Logistics Pipeline -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 0 8px; margin-bottom: 12px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div>
              <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Specimens In Transit</div>
              <div style="font-size: 24px; font-weight: 800; color: #0284c7; margin: 4px 0 2px;">
                <?=number_format($metrics['in_transit'] ?? 0);?>
              </div>
              <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 10px;">
                <?=number_format($metrics['received_at_lab'] ?? 0);?> at Lab Desk
              </span>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa fa-truck"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Navigation Grid -->
      <div class="row" style="margin: 0 -8px 24px;">
        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathlabreg/index')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-hospital-o"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Partner Pathology Labs</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Onboard labs, provision portal user credentials, manage platform commissions and accreditations.</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathology/add')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-plus-circle"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Master Test Catalog</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Create tests with vacutainer tube color codes, fasting requirements, TAT SLAs, and parameters.</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathology/assign_test')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-calculator"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Assignment &amp; Margin Engine</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Map tests to labs with automated formula: Lab Base Price + Platform Fee = Consumer Price.</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathology/index')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-th-list"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Assigned Tests Directory</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Live search, filter by lab/department, toggle active states inline, and execute bulk operations.</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathology/custody')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-qrcode"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Chain of Custody Handover</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Phlebotomist assignment, vial barcode scans, cold-chain temp, and OTP lab handover handshake.</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-6" style="padding: 0 8px; margin-bottom: 14px;">
          <a href="<?=base_url('doctor/pathology/audit_logs')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
              <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                  <i class="fa fa-history"></i>
                </div>
                <div>
                  <h4 style="margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #0f172a;">Audit Trail &amp; Footprints</h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.4;">Immutable tamper-evident ledger tracking price changes, status updates, logins, and custody steps.</p>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Specimen Custody Pipeline Stream & Recent Audit Footprints -->
      <div class="row" style="margin: 0 -8px;">
        
        <!-- Left: Specimen Custody Queue Preview -->
        <div class="col-md-6" style="padding: 0 8px; margin-bottom: 16px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
            <div style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; align-items: center; justify-content: space-between;">
              <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                <i class="fa fa-truck text-primary"></i> Live Specimen Custody Queue
              </h4>
              <a href="<?=base_url('doctor/pathology/custody')?>" style="font-size: 12px; font-weight: 700; color: #00a896; text-decoration: none;">
                View All Queue &rarr;
              </a>
            </div>
            
            <div class="table-responsive" style="margin: 0;">
              <table class="table table-hover" style="margin: 0; font-size: 12.5px;">
                <thead>
                  <tr style="background: #f8fafc; color: #64748b; font-size: 11px; text-transform: uppercase;">
                    <th>Booking</th>
                    <th>Patient</th>
                    <th>Lab Destination</th>
                    <th>Stage</th>
                    <th style="text-align: right;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($recent_bookings)): foreach($recent_bookings as $bk): 
                    $stage = $bk->order_stage ?: 'BOOKED';
                    $stageBg = ($stage == 'IN_TRANSIT') ? '#e0f2fe; color: #0284c7;' : (($stage == 'RECEIVED_AT_LAB') ? '#dcfce7; color: #16a34a;' : (($stage == 'REPORT_READY'||$stage=='COMPLETED') ? '#f3e8ff; color: #7e22ce;' : '#fef3c7; color: #d97706;'));
                  ?>
                    <tr>
                      <td style="font-weight: 700; color: #1e293b;">#<?=$bk->booking_id;?></td>
                      <td>
                        <div style="font-weight: 600; color: #0f172a;"><?=$bk->patient_name;?></div>
                        <small style="color: #64748b;"><?=$bk->patient_mobile;?></small>
                      </td>
                      <td style="color: #334155;"><?=$bk->lab_name ?: 'Partner Lab';?></td>
                      <td>
                        <span class="badge" style="background: <?=$stageBg;?> font-size: 10px; font-weight: 700;">
                          <?=$stage;?>
                        </span>
                      </td>
                      <td style="text-align: right;">
                        <a href="<?=base_url('doctor/pathology/custody_timeline/'.$bk->booking_id);?>" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 4px;" title="View Chain of Custody Timeline">
                          <i class="fa fa-line-chart"></i> Timeline
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="5" style="text-align: center; padding: 24px; color: #94a3b8;">
                        No active specimen bookings in queue.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Right: Recent Audit Footprints Ledger -->
        <div class="col-md-6" style="padding: 0 8px; margin-bottom: 16px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
            <div style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; align-items: center; justify-content: space-between;">
              <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                <i class="fa fa-history text-warning"></i> Recent System Audit Footprints
              </h4>
              <a href="<?=base_url('doctor/pathology/audit_logs')?>" style="font-size: 12px; font-weight: 700; color: #00a896; text-decoration: none;">
                Full Ledger &rarr;
              </a>
            </div>

            <div class="table-responsive" style="margin: 0;">
              <table class="table table-hover" style="margin: 0; font-size: 12px;">
                <thead>
                  <tr style="background: #f8fafc; color: #64748b; font-size: 11px; text-transform: uppercase;">
                    <th>Action</th>
                    <th>Entity</th>
                    <th>Remarks</th>
                    <th style="text-align: right;">Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($metrics['recent_footprints'])): foreach($metrics['recent_footprints'] as $fp): 
                    $actBg = ($fp->action == 'CREATED') ? '#dcfce7; color: #15803d;' : (($fp->action == 'DELETED') ? '#fee2e2; color: #dc2626;' : (($fp->action == 'PRICE_CHANGED') ? '#e0f2fe; color: #0369a1;' : '#fef3c7; color: #b45309;'));
                  ?>
                    <tr>
                      <td>
                        <span class="badge" style="background: <?=$actBg;?> font-size: 10px; font-weight: 700;">
                          <?=$fp->action;?>
                        </span>
                      </td>
                      <td>
                        <strong><?=strtoupper($fp->entity_type);?></strong> #<?=$fp->entity_id;?>
                      </td>
                      <td style="color: #475569; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?=htmlspecialchars($fp->remarks ?: '-');?>
                      </td>
                      <td style="text-align: right; color: #94a3b8; font-size: 11px; white-space: nowrap;">
                        <?=date('H:i, d M', strtotime($fp->created_at));?>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="4" style="text-align: center; padding: 24px; color: #94a3b8;">
                        No audit footprints logged yet.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>

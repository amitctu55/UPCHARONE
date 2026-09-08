<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-clock-o" style="color: #00a896;"></i> Doctor Consultation Fee &amp; OPD Timings
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 13px;">
          Manage doctor consultation pricing, OPD shift hours, patient capacity, and weekly recurring clinic schedules.
        </p>
      </div>
      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-arrow-left"></i> Affiliated Doctors List
        </a>
        <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-user-plus text-primary"></i> Assign Doctor
        </a>
        <?php if (!empty($practice_id)): ?>
          <button type="button" class="btn btn-primary" onclick="openTimingModalFromCurrent()" style="background-color: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
            <i class="fa fa-calendar-plus-o"></i> Set / Update OPD Timing
          </button>
        <?php endif; ?>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; background: transparent; padding: 12px 0 0 0; margin: 0; font-size: 12px;">
      <li><a href="<?=base_url('masters/dashboard');?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" style="color: #64748b;">Affiliated Doctors</a></li>
      <li class="active" style="color: #0f172a; font-weight: 600;">OPD Timing &amp; Fee</li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 0 30px 30px 30px;">
    
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 20px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <!-- Practice / Doctor Highlight Profile Card (if practice_info is loaded) -->
    <?php if (!empty($practice_info)): ?>
      <?php 
        $doc_full_name = trim((!empty($practice_info['fname']) ? $practice_info['fname'] : '') . ' ' . (!empty($practice_info['lname']) ? $practice_info['lname'] : ''));
        if (empty($doc_full_name)) {
          $doc_full_name = 'Doctor #' . (!empty($practice_info['doctor_id']) ? $practice_info['doctor_id'] : 'Unknown');
        }
        $f_city = !empty($practice_info['facility_city']) ? (function_exists('getCityName') ? getCityName($practice_info['facility_city']) : $practice_info['facility_city']) : 'Not Specified';
      ?>
      <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 24px; overflow: hidden; background: #ffffff;">
        <div style="background: linear-gradient(135deg, #0284c7 0%, #00a896 100%); padding: 18px 24px; color: #ffffff;">
          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 24px; color: #ffffff; border: 2px solid rgba(255,255,255,0.4);">
                <i class="fa fa-user-md"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                  <?=$doc_full_name;?>
                  <span class="label" style="background: rgba(255,255,255,0.25); font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px;">
                    Practice Affiliation #<?=$practice_info['practice_id'];?>
                  </span>
                </h3>
                <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">
                  <i class="fa fa-stethoscope"></i> <?=!empty($practice_info['speciality']) ? $practice_info['speciality'] : 'General Practitioner';?> 
                  &nbsp;&bull;&nbsp; 
                  <i class="fa fa-hospital-o"></i> <?=$practice_info['facility_name'];?> (<?=$f_city;?>)
                </p>
              </div>
            </div>
            <div>
              <button type="button" class="btn btn-default" onclick="openTimingModalFromCurrent()" style="background: #ffffff; color: #0f172a; font-weight: 600; border-radius: 8px; padding: 8px 16px; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa fa-pencil text-primary"></i> Edit Fee &amp; Shifts
              </button>
            </div>
          </div>
        </div>
        <div style="padding: 16px 24px; background: #ffffff; display: flex; gap: 24px; flex-wrap: wrap; font-size: 13px; color: #475569; border-bottom: 1px solid #f1f5f9;">
          <div>
            <strong style="color: #0f172a;"><i class="fa fa-money text-success"></i> Consultation Fee:</strong> 
            <span style="font-weight: 700; color: #00a896; font-size: 14px;">₹<?=number_format((float)($practice_info['fee'] ?? 0), 2);?></span>
          </div>
          <div>
            <strong style="color: #0f172a;"><i class="fa fa-phone text-primary"></i> Phone:</strong> 
            <?=!empty($practice_info['mobile']) ? $practice_info['mobile'] : 'Not Available';?>
          </div>
          <div>
            <strong style="color: #0f172a;"><i class="fa fa-envelope-o text-warning"></i> Email:</strong> 
            <?=!empty($practice_info['email']) ? $practice_info['email'] : 'Not Available';?>
          </div>
          <div>
            <strong style="color: #0f172a;"><i class="fa fa-check-circle text-info"></i> Status:</strong> 
            <?php if (($practice_info['status'] ?? 0) == 1): ?>
              <span class="label label-success" style="background-color: #10b981;">Active Affiliation</span>
            <?php else: ?>
              <span class="label label-danger" style="background-color: #ef4444;">Inactive</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Filter & Search Bar -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; background: #ffffff;">
      <div class="box-body" style="padding: 18px 24px;">
        <form method="get" action="<?=base_url('doctor/clinicreg/doctor_fee_time' . (!empty($practice_id) ? '/' . $practice_id : ''));?>" id="search_form" class="form-horizontal">
          <div class="row" style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px 0;">
            <div class="col-md-3 col-sm-6">
              <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 4px; display: block;">Doctor or Hospital Search</label>
              <div class="input-group" style="width: 100%;">
                <span class="input-group-addon" style="background: #f8fafc; border-color: #e2e8f0;"><i class="fa fa-search text-muted"></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Search doctor, hospital, clinic..." value="<?=$this->input->get_post('keyword');?>" style="border-color: #e2e8f0; border-radius: 0 6px 6px 0;">
              </div>
            </div>
            <div class="col-md-2 col-sm-6">
              <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 4px; display: block;">Records Per Page</label>
              <select name="pagesize" class="form-control" style="border-color: #e2e8f0; border-radius: 6px;" onchange="$('#search_form').submit();">
                <option value="15" <?=$this->input->get_post('pagesize') == 15 ? 'selected' : '';?>>15 records</option>
                <option value="30" <?=$this->input->get_post('pagesize') == 30 ? 'selected' : '';?>>30 records</option>
                <option value="50" <?=$this->input->get_post('pagesize') == 50 ? 'selected' : '';?>>50 records</option>
                <option value="100" <?=$this->input->get_post('pagesize') == 100 ? 'selected' : '';?>>100 records</option>
              </select>
            </div>
            <div class="col-md-4 col-sm-12" style="margin-top: 22px; display: flex; gap: 8px;">
              <button type="submit" class="btn btn-primary" style="background-color: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 6px 18px;">
                <i class="fa fa-filter"></i> Apply Filter
              </button>
              <?php if ($this->input->get_post('keyword') || $this->input->get_post('pagesize')): ?>
                <a href="<?=base_url('doctor/clinicreg/doctor_fee_time' . (!empty($practice_id) ? '/' . $practice_id : ''));?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; border-color: #e2e8f0;">
                  <i class="fa fa-times text-danger"></i> Clear Filter
                </a>
              <?php endif; ?>
              <?php if (!empty($practice_id)): ?>
                <a href="<?=base_url('doctor/clinicreg/doctor_fee_time');?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; border-color: #e2e8f0;" title="View all doctor timings across all facilities">
                  <i class="fa fa-list"></i> View All Timings
                </a>
              <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-12 text-right" style="margin-top: 22px;">
              <span style="font-size: 13px; color: #64748b; font-weight: 500;">
                Showing <?=is_array($doctor) ? count($doctor) : 0;?> shift records
              </span>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- OPD Shift Timings & Fee Table -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #ffffff; overflow: hidden;">
      <div class="box-header with-border" style="padding: 16px 24px; background: #ffffff; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">
          <i class="fa fa-calendar text-primary"></i> OPD Shift Schedules &amp; Consultation Pricing
        </h3>
        <?php if (!empty($practice_id)): ?>
          <span class="label label-info" style="font-size: 12px; padding: 5px 10px; border-radius: 6px; background-color: #0284c7;">
            Filtered by ID #<?=$practice_id;?>
          </span>
        <?php endif; ?>
      </div>

      <div class="box-body no-padding">
        <div class="table-responsive">
          <table class="table table-hover" style="margin-bottom: 0; vertical-align: middle;">
            <thead>
              <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                <th style="padding: 14px 16px; width: 40px; text-align: center;">
                  <input type="checkbox" id="checkall" onclick="check_uncheck_checkbox(this.checked);" style="cursor: pointer;">
                </th>
                <th style="padding: 14px 16px;">Doctor Details</th>
                <th style="padding: 14px 16px;">Facility / Hospital</th>
                <th style="padding: 14px 16px;">OPD Shift Hours</th>
                <th style="padding: 14px 16px; text-align: center;">Consultation Fee</th>
                <th style="padding: 14px 16px; text-align: center;">Patient Cap</th>
                <th style="padding: 14px 16px; min-width: 260px;">Weekly Days Available</th>
                <th style="padding: 14px 16px; text-align: center;">Status</th>
                <th style="padding: 14px 16px; text-align: center; width: 120px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($doctor) && !empty($doctor)): ?>
                <?php foreach ($doctor as $row): ?>
                  <?php
                    $d_name = trim((!empty($row['fname']) ? $row['fname'] : '') . ' ' . (!empty($row['lname']) ? $row['lname'] : ''));
                    if (empty($d_name)) {
                      $d_name = 'Doctor #' . (!empty($row['doctor_id']) ? $row['doctor_id'] : (!empty($row['doctor_user_id']) ? $row['doctor_user_id'] : 'N/A'));
                    }
                    $h_name = !empty($row['facility_name']) ? $row['facility_name'] : (!empty($row['name']) ? $row['name'] : 'Healthcare Facility');
                    $c_city = !empty($row['city']) ? (function_exists('getCityName') ? getCityName($row['city']) : $row['city']) : '';
                    $row_p_id = !empty($row['practice_id']) ? $row['practice_id'] : (!empty($row['practice_id_raw']) ? $row['practice_id_raw'] : 0);
                    $row_u_id = !empty($row['doctor_user_id']) ? $row['doctor_user_id'] : (!empty($row['doctor_id']) ? $row['doctor_id'] : 0);
                    $row_t_id = !empty($row['timing_id']) ? $row['timing_id'] : 0;
                    $row_fee  = !empty($row['consultation_fee']) ? floatval($row['consultation_fee']) : 0.00;
                    $from_t   = !empty($row['from_timing']) ? $row['from_timing'] : '';
                    $to_t     = !empty($row['to_timing']) ? $row['to_timing'] : '';
                    $max_p    = !empty($row['max_patient']) ? (int)$row['max_patient'] : 20;

                    $days_map = array(
                      'Mon' => !empty($row['M']),
                      'Tue' => !empty($row['T']),
                      'Wed' => !empty($row['W']),
                      'Thu' => !empty($row['TH']),
                      'Fri' => !empty($row['F']),
                      'Sat' => !empty($row['SA']),
                      'Sun' => !empty($row['S']),
                    );
                  ?>
                  <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                      <input type="checkbox" name="arr_ids[]" value="<?=$row_p_id;?>" class="row-checkbox" style="cursor: pointer;">
                    </td>
                    <td style="padding: 14px 16px; vertical-align: middle;">
                      <div style="font-weight: 700; color: #0f172a; font-size: 14px;">
                        <?=$d_name;?>
                      </div>
                      <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                        <span class="label label-default" style="background: #f1f5f9; color: #475569; font-weight: 500;">
                          <?=!empty($row['speciality']) ? $row['speciality'] : 'Specialist';?>
                        </span>
                        <?php if (!empty($row['mobile'])): ?>
                          <span style="margin-left: 5px;"><i class="fa fa-phone"></i> <?=$row['mobile'];?></span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td style="padding: 14px 16px; vertical-align: middle;">
                      <div style="font-weight: 600; color: #334155; font-size: 13px;">
                        <i class="fa fa-hospital-o text-muted"></i> <?=$h_name;?>
                      </div>
                      <?php if (!empty($c_city)): ?>
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                          <i class="fa fa-map-marker"></i> <?=$c_city;?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 14px 16px; vertical-align: middle;">
                      <?php if (!empty($from_t) && !empty($to_t)): ?>
                        <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #e0f2fe; color: #0369a1; border-radius: 6px; font-weight: 600; font-size: 12px;">
                          <i class="fa fa-clock-o"></i> <?=$from_t;?> &ndash; <?=$to_t;?>
                        </div>
                      <?php else: ?>
                        <span class="label label-warning" style="background: #fef3c7; color: #92400e; font-weight: 600; border: 1px solid #fde68a;">
                          Timing Not Configured
                        </span>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                      <span style="font-weight: 700; color: #00a896; font-size: 14px;">
                        ₹<?=number_format($row_fee, 2);?>
                      </span>
                    </td>
                    <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                      <span class="badge" style="background-color: #f1f5f9; color: #334155; font-size: 12px; font-weight: 600; border: 1px solid #cbd5e1;">
                        <?=$max_p;?> slots
                      </span>
                    </td>
                    <td style="padding: 14px 16px; vertical-align: middle;">
                      <div style="display: flex; gap: 3px; flex-wrap: wrap;">
                        <?php foreach ($days_map as $d_label => $is_avail): ?>
                          <?php if ($is_avail): ?>
                            <span class="label label-success" style="background-color: #10b981; font-weight: 600; font-size: 11px; padding: 3px 6px; border-radius: 4px;" title="<?=$d_label;?>: Available">
                              <?=$d_label;?>
                            </span>
                          <?php else: ?>
                            <span class="label" style="background-color: #f1f5f9; color: #94a3b8; font-weight: 500; font-size: 11px; padding: 3px 6px; border-radius: 4px; border: 1px solid #e2e8f0;" title="<?=$d_label;?>: Not Available">
                              <?=$d_label;?>
                            </span>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    </td>
                    <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                      <?php if (($row['timing_status'] ?? 1) == 1): ?>
                        <span class="label label-success" style="background-color: #10b981; font-weight: 600; border-radius: 4px; font-size: 11px;">Active</span>
                      <?php else: ?>
                        <span class="label label-default" style="background-color: #94a3b8; font-weight: 600; border-radius: 4px; font-size: 11px;">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                      <button type="button" class="btn btn-sm btn-default" 
                        onclick="openTimingModal({
                          practice_id: '<?=$row_p_id;?>',
                          user_id: '<?=$row_u_id;?>',
                          timing_id: '<?=$row_t_id;?>',
                          doc_name: '<?=addslashes($d_name);?>',
                          facility_name: '<?=addslashes($h_name);?>',
                          fee: '<?=$row_fee;?>',
                          from_timing: '<?=addslashes($from_t);?>',
                          to_timing: '<?=addslashes($to_t);?>',
                          max_patient: '<?=$max_p;?>',
                          m: <?=!empty($row['M']) ? 1 : 0;?>,
                          t: <?=!empty($row['T']) ? 1 : 0;?>,
                          w: <?=!empty($row['W']) ? 1 : 0;?>,
                          th: <?=!empty($row['TH']) ? 1 : 0;?>,
                          f: <?=!empty($row['F']) ? 1 : 0;?>,
                          sa: <?=!empty($row['SA']) ? 1 : 0;?>,
                          s: <?=!empty($row['S']) ? 1 : 0;?>
                        })" 
                        style="font-weight: 600; border-radius: 6px; color: #0284c7; border-color: #cbd5e1;" 
                        title="Configure OPD Timings & Fee">
                        <i class="fa fa-pencil"></i> Configure
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa fa-calendar-times-o fa-3x" style="display: block; margin-bottom: 10px; opacity: 0.4;"></i>
                    <h4 style="font-weight: 600; color: #64748b; margin-bottom: 5px;">No OPD Timing Records Found</h4>
                    <p style="font-size: 13px; max-width: 450px; margin: 0 auto 15px auto;">
                      There are no active shift schedules recorded for this filter or affiliation.
                    </p>
                    <?php if (!empty($practice_id)): ?>
                      <button type="button" class="btn btn-primary" onclick="openTimingModalFromCurrent()" style="background-color: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px;">
                        <i class="fa fa-plus"></i> Configure OPD Timing for Practice #<?=$practice_id;?>
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Footer & Pagination -->
      <div class="box-footer" style="padding: 16px 24px; background: #ffffff; border-top: 1px solid #f1f5f9;">
        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
          <div class="col-md-6 col-sm-12">
            <span style="font-size: 13px; color: #64748b;">
              Total Affiliations in System: <strong><?=$config['total_rows'] ?? (is_array($doctor) ? count($doctor) : 0);?></strong>
            </span>
          </div>
          <div class="col-md-6 col-sm-12 text-right">
            <div class="pagination" style="margin: 0;">
              <?=$page_links;?>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

<!-- ========================================== -->
<!-- CONFIGURE OPD TIMING & FEE MODAL -->
<!-- ========================================== -->
<div class="modal fade" id="timingModal" tabindex="-1" role="dialog" aria-labelledby="timingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);">
      <form method="post" action="<?=base_url('doctor/clinicreg/save_fee_time');?>" id="timing_form">
        <input type="hidden" name="practice_id" id="modal_practice_id" value="<?=$practice_id ?? 0;?>">
        <input type="hidden" name="user_id" id="modal_user_id" value="<?=$practice_info['doctor_id'] ?? 0;?>">

        <div class="modal-header" style="background: linear-gradient(135deg, #0284c7 0%, #00a896 100%); color: #ffffff; padding: 18px 24px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8; font-size: 24px;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="timingModalLabel" style="font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-clock-o"></i> Configure OPD Shift Timing &amp; Fee
          </h4>
          <p id="modal_subtitle" style="margin: 4px 0 0 0; font-size: 12px; opacity: 0.9;">
            Update consultation fee, daily shift timings, and weekly days available.
          </p>
        </div>

        <div class="modal-body" style="padding: 24px;">
          
          <!-- Doctor & Facility Preview inside Modal -->
          <div id="modal_doc_facility_box" style="padding: 12px 16px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <div style="font-weight: 700; color: #0f172a; font-size: 14px;" id="modal_doc_name_display">
              <?=!empty($practice_info['fname']) ? $practice_info['fname'] . ' ' . $practice_info['lname'] : 'Doctor Configuration';?>
            </div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;" id="modal_facility_display">
              <?=!empty($practice_info['facility_name']) ? $practice_info['facility_name'] : '';?>
            </div>
          </div>

          <!-- Consultation Fee -->
          <div class="form-group" style="margin-bottom: 18px;">
            <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
              <i class="fa fa-money text-success"></i> Consultation Fee (₹) <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-addon" style="background: #f8fafc; font-weight: 700; color: #00a896; border-color: #cbd5e1;">₹</span>
              <input type="number" step="0.01" min="0" name="consultation_fee" id="modal_fee" class="form-control input-lg" placeholder="e.g. 500.00" required style="border-color: #cbd5e1; font-weight: 700; font-size: 16px; color: #0f172a;">
            </div>
            <small class="text-muted" style="font-size: 11px;">Standard consultation charge for OPD appointments at this facility.</small>
          </div>

          <!-- Shift Hours (From - To) -->
          <div class="row" style="margin-bottom: 18px;">
            <div class="col-xs-6">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                <i class="fa fa-sun-o text-warning"></i> From Timing <span class="text-danger">*</span>
              </label>
              <input type="text" name="from_timing" id="modal_from_timing" class="form-control" placeholder="e.g. 09:00 AM" required style="border-color: #cbd5e1; border-radius: 6px;">
              <small class="text-muted" style="font-size: 11px;">Example: 09:00 AM, 10:30 AM</small>
            </div>
            <div class="col-xs-6">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                <i class="fa fa-moon-o text-primary"></i> To Timing <span class="text-danger">*</span>
              </label>
              <input type="text" name="to_timing" id="modal_to_timing" class="form-control" placeholder="e.g. 01:00 PM" required style="border-color: #cbd5e1; border-radius: 6px;">
              <small class="text-muted" style="font-size: 11px;">Example: 01:00 PM, 06:00 PM</small>
            </div>
          </div>

          <!-- Max Patients Slot Capacity -->
          <div class="form-group" style="margin-bottom: 20px;">
            <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
              <i class="fa fa-users text-info"></i> Maximum Patients per Shift
            </label>
            <input type="number" min="1" max="200" name="max_patient" id="modal_max_patient" class="form-control" value="20" style="border-color: #cbd5e1; border-radius: 6px;">
            <small class="text-muted" style="font-size: 11px;">Maximum appointment booking capacity per OPD session.</small>
          </div>

          <!-- Days of the Week Selection -->
          <div class="form-group" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin: 0;">
                <i class="fa fa-calendar-check-o text-success"></i> Weekly Availability Days
              </label>
              <div style="display: flex; gap: 5px;">
                <button type="button" class="btn btn-xs btn-default" onclick="setPresetDays('all')">All Days</button>
                <button type="button" class="btn btn-xs btn-default" onclick="setPresetDays('weekdays')">Mon-Fri</button>
                <button type="button" class="btn btn-xs btn-default" onclick="setPresetDays('weekends')">Sat-Sun</button>
                <button type="button" class="btn btn-xs btn-default" onclick="setPresetDays('none')">Clear</button>
              </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; background: #f8fafc; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_m" id="day_m" value="1"> Monday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_t" id="day_t" value="1"> Tuesday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_w" id="day_w" value="1"> Wednesday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_th" id="day_th" value="1"> Thursday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_f" id="day_f" value="1"> Friday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_sa" id="day_sa" value="1"> Saturday
              </label>
              <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; margin: 0;">
                <input type="checkbox" name="day_s" id="day_s" value="1"> Sunday
              </label>
            </div>
          </div>

        </div>

        <div class="modal-footer" style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px;">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary" style="background-color: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 6px 20px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
            <i class="fa fa-save"></i> Save OPD Schedule &amp; Fee
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function check_uncheck_checkbox(isChecked) {
  $('input[name="arr_ids[]"]').prop('checked', isChecked);
}

function setPresetDays(preset) {
  var allDays = ['day_m', 'day_t', 'day_w', 'day_th', 'day_f', 'day_sa', 'day_s'];
  var weekdays = ['day_m', 'day_t', 'day_w', 'day_th', 'day_f'];
  var weekends = ['day_sa', 'day_s'];

  allDays.forEach(function(d) {
    $('#' + d).prop('checked', false);
  });

  if (preset === 'all') {
    allDays.forEach(function(d) { $('#' + d).prop('checked', true); });
  } else if (preset === 'weekdays') {
    weekdays.forEach(function(d) { $('#' + d).prop('checked', true); });
  } else if (preset === 'weekends') {
    weekends.forEach(function(d) { $('#' + d).prop('checked', true); });
  }
}

function openTimingModal(data) {
  $('#modal_practice_id').val(data.practice_id || '0');
  $('#modal_user_id').val(data.user_id || '0');
  $('#modal_fee').val(data.fee || '0');
  $('#modal_from_timing').val(data.from_timing || '09:00 AM');
  $('#modal_to_timing').val(data.to_timing || '01:00 PM');
  $('#modal_max_patient').val(data.max_patient || 20);

  if (data.doc_name) {
    $('#modal_doc_name_display').text(data.doc_name);
  }
  if (data.facility_name) {
    $('#modal_facility_display').text(data.facility_name);
  }

  $('#day_m').prop('checked', data.m == 1);
  $('#day_t').prop('checked', data.t == 1);
  $('#day_w').prop('checked', data.w == 1);
  $('#day_th').prop('checked', data.th == 1);
  $('#day_f').prop('checked', data.f == 1);
  $('#day_sa').prop('checked', data.sa == 1);
  $('#day_s').prop('checked', data.s == 1);

  $('#timingModal').modal('show');
}

function openTimingModalFromCurrent() {
  <?php if (!empty($practice_info)): ?>
    openTimingModal({
      practice_id: '<?=$practice_info['practice_id'] ?? $practice_id;?>',
      user_id: '<?=$practice_info['doctor_id'] ?? 0;?>',
      doc_name: '<?=addslashes($doc_full_name ?? '');?>',
      facility_name: '<?=addslashes($practice_info['facility_name'] ?? '');?>',
      fee: '<?=$practice_info['fee'] ?? 0;?>',
      from_timing: '09:00 AM',
      to_timing: '01:00 PM',
      max_patient: 20,
      m: 1, t: 1, w: 1, th: 1, f: 1, sa: 0, s: 0
    });
  <?php else: ?>
    openTimingModal({
      practice_id: '<?=$practice_id ?? 0;?>',
      user_id: 0,
      doc_name: 'Affiliation #<?=$practice_id ?? 0;?>',
      facility_name: 'Healthcare Facility',
      fee: 0,
      from_timing: '09:00 AM',
      to_timing: '01:00 PM',
      max_patient: 20,
      m: 1, t: 1, w: 1, th: 1, f: 1, sa: 0, s: 0
    });
  <?php endif; ?>
}
</script>

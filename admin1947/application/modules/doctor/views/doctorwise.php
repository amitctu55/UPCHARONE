<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Doctor Wise Appointments</h1>
        <small style="color: #64748b; font-size: 13px;">Manage consulting doctors and track patient appointment bookings per doctor</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Doctor Wise</li>
      </ol>
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

      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden;">
        
        <!-- Header -->
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
          <h3 class="master-card-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-user-md" style="color: #00a896;"></i>
            <span>Consulting Doctors &amp; Patient Bookings</span>
          </h3>
          <div>
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 12px;">
              Total: <?=count($doctor);?> Doctors
            </span>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/appointment/doctorwise')?>" method="get" id="search_form" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;">
            <div class="row" style="margin: 0 -6px;">
              
              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 8px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Doctor Name</label>
                <input type="text" class="form-control input-sm" name="doctor_name" placeholder="Doctor name..." value="<?=html_escape($this->input->get_post('doctor_name'));?>" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
              </div>

              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 8px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Email Address</label>
                <input type="text" class="form-control input-sm" name="doctor_email" placeholder="Doctor email..." value="<?=html_escape($this->input->get_post('doctor_email'));?>" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
              </div>

              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 8px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Phone Number</label>
                <input type="text" class="form-control input-sm" name="doctor_phone" placeholder="10-digit phone..." value="<?=html_escape($this->input->get_post('doctor_phone'));?>" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
              </div>

              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 8px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">City Location</label>
                <select class="form-control input-sm" name="city_name" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Cities</option>
                  <?php if(!empty($city)): foreach ($city as $val): ?>
                    <option value="<?=$val['id']; ?>" <?=($this->input->get_post('city_name') == $val['id']) ? 'selected' : '';?>>
                      <?=html_escape($val['name']); ?>
                    </option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <div class="col-md-12" style="padding: 0 6px; display: flex; gap: 8px; justify-content: flex-end; margin-top: 4px;">
                <button type="submit" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 6px; padding: 6px 18px;">
                  <i class="fa fa-search"></i> Search Doctors
                </button>

                <?php if($this->input->get_post('doctor_name')!='' || $this->input->get_post('doctor_email')!='' || $this->input->get_post('doctor_phone')!='' || $this->input->get_post('city_name')!=''): ?>
                  <a href="<?=base_url('doctor/appointment/doctorwise')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
                    <i class="fa fa-times text-danger"></i> Clear Filter
                  </a>
                <?php endif; ?>
              </div>

            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="doctorwise-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Doctor Profile</th>
                  <th>Specialization &amp; Experience</th>
                  <th>Contact Details</th>
                  <th>City Location</th>
                  <th style="width: 140px; text-align: center;">Total Appointments</th>
                  <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($doctor)): foreach($doctor as $p): 
                  $drName = trim(($p->fname ?? '') . ' ' . ($p->lname ?? ''));
                  $drDisplay = (stripos($drName, 'Dr.') === 0 || stripos($drName, 'Dr ') === 0) ? $drName : ('Dr. ' . $drName);
                  $cityName = !empty($p->city_name) ? $p->city_name : (function_exists('getCityName') ? getCityName($p->city) : 'Varanasi');
                  $appCount = (int) ($p->total_appointments ?? 0);
                  $drImg = ($p->drimage && file_exists('admin1947/public/assets/upload/'.$p->drimage)) 
                          ? base_url('public/assets/upload/'.$p->drimage) 
                          : base_url('public/assets/upload/dummydr.jpg');
                ?>
                  <tr>
                    <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$p->id;?></td>
                    
                    <!-- Doctor Profile Avatar & Name -->
                    <td style="vertical-align: middle;">
                      <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="<?=$drImg;?>" alt="<?=$drDisplay;?>" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;">
                        <div>
                          <strong style="color: #0f172a; font-size: 13.5px; display: block;"><?=$drDisplay;?></strong>
                          <span style="font-size: 11.5px; color: #64748b;">Reg: <?=html_escape($p->regd_no ?: 'N/A');?></span>
                        </div>
                      </div>
                    </td>

                    <!-- Specialization & Exp -->
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <i class="fa fa-stethoscope"></i> <?=html_escape($p->about ? substr($p->about, 0, 30).'...' : 'General Specialist');?>
                      </span>
                      <?php if(!empty($p->exp)): ?>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">Exp: <?=$p->exp;?> Years</div>
                      <?php endif; ?>
                    </td>

                    <!-- Contact -->
                    <td style="vertical-align: middle;">
                      <?php if($p->mobile): ?>
                        <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape($p->mobile);?></div>
                      <?php endif; ?>
                      <?php if($p->email): ?>
                        <div style="font-size: 12px; color: #64748b;"><i class="fa fa-envelope-o" style="color: #64748b;"></i> <?=html_escape($p->email);?></div>
                      <?php endif; ?>
                    </td>

                    <!-- City -->
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-map-marker" style="color: #ef4444;"></i> <?=html_escape($cityName);?>
                      </span>
                    </td>

                    <!-- Total Bookings Badge -->
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background: <?=$appCount > 0 ? '#dcfce7' : '#f1f5f9';?>; color: <?=$appCount > 0 ? '#15803d' : '#64748b';?>; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 12px; border: 1px solid <?=$appCount > 0 ? '#bbf7d0' : '#e2e8f0';?>;">
                        <i class="fa fa-calendar-check-o"></i> <?=$appCount;?> Bookings
                      </span>
                    </td>

                    <!-- Actions -->
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/appointment/patient/'.$p->id);?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 6px; padding: 5px 12px; text-decoration: none;" title="View Patient Appointments">
                        <i class="fa fa-eye"></i> View Patients
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No consulting doctors found matching criteria.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#doctorwise-table')) {
        $('#doctorwise-table').DataTable().destroy();
    }
    $('#doctorwise-table').DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 15,
        "language": {
            "search": "Filter in table:",
            "paginate": {
                "previous": "&larr; Prev",
                "next": "Next &rarr;"
            }
        }
    });
});
</script>

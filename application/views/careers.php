<?php $this->load->view("includes/header.php"); ?>

<style>
/* Modern Career Portal Custom Styles */
:root {
  --career-primary: #00a896;
  --career-primary-dark: #028072;
  --career-primary-light: #e6f7f5;
  --career-navy: #043d5b;
  --career-navy-dark: #02263a;
  --career-gray-bg: #f8fafc;
  --career-border: #e2e8f0;
  --career-text-dark: #0f172a;
  --career-text-muted: #64748b;
}

.career-hero {
  background: linear-gradient(135deg, #043d5b 0%, #065b87 60%, #00a896 100%);
  color: #ffffff;
  padding: 60px 0 70px;
  position: relative;
  overflow: hidden;
  margin-top: 50px;
}

.career-hero::before {
  content: "";
  position: absolute;
  top: -50%;
  right: -10%;
  width: 550px;
  height: 550px;
  background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%);
  border-radius: 50%;
  pointer-events: none;
}

.career-hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(8px);
  padding: 6px 14px;
  border-radius: 30px;
  font-size: 13px;
  font-weight: 600;
  color: #e6f7f5;
  margin-bottom: 16px;
  border: 1px solid rgba(255, 255, 255, 0.25);
}

.career-hero-title {
  font-size: 38px;
  font-weight: 800;
  line-height: 1.25;
  margin-bottom: 16px;
  letter-spacing: -0.5px;
}

.career-hero-subtitle {
  font-size: 16px;
  line-height: 1.65;
  color: #e2e8f0;
  max-width: 680px;
  margin-bottom: 25px;
}

.career-perk-card {
  background: #ffffff;
  border-radius: 12px;
  padding: 24px;
  border: 1px solid var(--career-border);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  height: 100%;
}

.career-perk-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
  border-color: #cbd5e1;
}

.career-perk-icon {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  background: var(--career-primary-light);
  color: var(--career-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-bottom: 14px;
}

.dept-filter-btn {
  padding: 8px 18px;
  border-radius: 25px;
  border: 1px solid #cbd5e1;
  background: #ffffff;
  color: #475569;
  font-size: 13px;
  font-weight: 600;
  margin: 4px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.dept-filter-btn:hover, .dept-filter-btn.active {
  background: var(--career-primary);
  color: #ffffff;
  border-color: var(--career-primary);
  box-shadow: 0 4px 10px rgba(0, 168, 150, 0.25);
}

.job-card {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid var(--career-border);
  padding: 24px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
  transition: all 0.25s ease;
  position: relative;
}

.job-card:hover {
  border-color: #00a896;
  box-shadow: 0 10px 25px rgba(0, 168, 150, 0.08);
}

.job-dept-tag {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 4px 10px;
  border-radius: 6px;
  background: #e0f2fe;
  color: #0369a1;
  display: inline-block;
  margin-bottom: 10px;
}

.job-title {
  font-size: 20px;
  font-weight: 700;
  color: var(--career-text-dark);
  margin: 0 0 10px;
}

.job-meta-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: var(--career-text-muted);
  margin-right: 18px;
  margin-bottom: 8px;
}

.job-meta-item i {
  color: var(--career-primary);
}

.job-salary-pill {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  background: #f0fdf4;
  color: #166534;
  font-size: 12px;
  font-weight: 700;
  border: 1px solid #bbf7d0;
  margin-bottom: 12px;
}

.btn-apply-job {
  background: var(--career-primary);
  color: #ffffff !important;
  font-weight: 700;
  padding: 9px 24px;
  border-radius: 8px;
  border: none;
  font-size: 14px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  cursor: pointer;
}

.btn-apply-job:hover {
  background: var(--career-primary-dark);
  box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
  transform: translateY(-1px);
}

.btn-view-job-details {
  background: transparent;
  color: #0369a1;
  border: 1px solid #bae6fd;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  margin-right: 8px;
  transition: all 0.2s ease;
}

.btn-view-job-details:hover {
  background: #f0f9ff;
  border-color: #0284c7;
}

/* Modal styling */
.career-modal .modal-content {
  border-radius: 14px;
  border: none;
  overflow: hidden;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.career-modal .modal-header {
  background: linear-gradient(135deg, #043d5b 0%, #00a896 100%);
  color: #ffffff;
  padding: 20px 24px;
  border: none;
}

.career-form-control {
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  padding: 10px 14px;
  height: auto;
  font-size: 14px;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  width: 100%;
}

.career-form-control:focus {
  border-color: #00a896;
  box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
  outline: none;
}

.file-upload-zone {
  border: 2px dashed #cbd5e1;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  background: #f8fafc;
  cursor: pointer;
  transition: all 0.2s ease;
}

.file-upload-zone:hover {
  border-color: #00a896;
  background: #f0fdfa;
}
</style>

<!-- Hero Section -->
<section class="career-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8 col-sm-12">
        <div class="career-hero-badge">
          <i class="fa fa-hospital-o"></i> We Are Hiring Across All Specialties
        </div>
        <h1 class="career-hero-title">Shape the Future of Healthcare with Upchar</h1>
        <p class="career-hero-subtitle">
          Join our multidisciplinary healthcare team dedicated to patient-first clinical excellence, advanced diagnostics, compassionate nursing, and health technology in Gorakhpur and beyond.
        </p>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
          <a href="#open-positions" class="btn btn-apply-job" style="padding: 11px 28px; font-size: 15px;">
            <i class="fa fa-search"></i> Explore Active Openings
          </a>
          <button type="button" class="btn btn-default btn-open-spontaneous" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 11px 24px; font-weight: 600;">
            <i class="fa fa-paper-plane-o"></i> Send Open Application
          </button>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 hidden-xs text-center" style="margin-top: 15px;">
        <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(12px); border-radius: 16px; padding: 25px; border: 1px solid rgba(255,255,255,0.2); text-align: left;">
          <h4 style="color: #fff; font-weight: 700; margin: 0 0 15px;"><i class="fa fa-shield text-success"></i> Why Upchar Healthcare?</h4>
          <div style="margin-bottom: 10px; font-size: 13px; color: #e2e8f0;"><i class="fa fa-check-circle" style="color: #4ade80;"></i> Patient-Centric Clinical Culture</div>
          <div style="margin-bottom: 10px; font-size: 13px; color: #e2e8f0;"><i class="fa fa-check-circle" style="color: #4ade80;"></i> Fully-Equipped Modern Facilities</div>
          <div style="margin-bottom: 10px; font-size: 13px; color: #e2e8f0;"><i class="fa fa-check-circle" style="color: #4ade80;"></i> Regular Training & Growth Tracks</div>
          <div style="margin-bottom: 0; font-size: 13px; color: #e2e8f0;"><i class="fa fa-check-circle" style="color: #4ade80;"></i> Fast Application Review (48 Hours)</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values & Perks Section -->
<section style="padding: 50px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0;">
  <div class="container">
    <div class="text-center" style="margin-bottom: 35px;">
      <h2 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Life & Career at Upchar Hospital</h2>
      <p style="color: #64748b; font-size: 14px; max-width: 600px; margin: 0 auto;">We believe world-class patient care begins by nurturing and empowering our medical, nursing, and operational team.</p>
    </div>

    <div class="row">
      <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
        <div class="career-perk-card">
          <div class="career-perk-icon"><i class="fa fa-stethoscope"></i></div>
          <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px;">Clinical Excellence</h4>
          <p style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0;">Work alongside accomplished senior doctors and specialists using modern diagnostic and ICU setups.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
        <div class="career-perk-card">
          <div class="career-perk-icon"><i class="fa fa-money"></i></div>
          <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px;">Competitive Rewards</h4>
          <p style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0;">Best-in-class compensation benchmarks, health benefits, PF/ESI, and timely appraisal cycles.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
        <div class="career-perk-card">
          <div class="career-perk-icon"><i class="fa fa-graduation-cap"></i></div>
          <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px;">Continuous Growth</h4>
          <p style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0;">Regular medical seminars, CME accreditations, clinical skills enhancement, and internal promotions.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
        <div class="career-perk-card">
          <div class="career-perk-icon"><i class="fa fa-heartbeat"></i></div>
          <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px;">Holistic Well-Being</h4>
          <p style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0;">Health coverage for your family, safe sanitised workspaces, and collaborative leadership.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Job Openings Section -->
<section id="open-positions" style="padding: 60px 0; background: #f8fafc;">
  <div class="container">
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 25px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <div class="row align-items-end" style="margin-bottom: 30px;">
      <div class="col-md-7 col-sm-12">
        <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
          <i class="fa fa-briefcase" style="color: #00a896; margin-right: 6px;"></i> Current Job Vacancies
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">Discover your next opportunity to make an impactful difference in patient lives.</p>
      </div>
      <div class="col-md-5 col-sm-12" style="margin-top: 15px;">
        <div class="input-group" style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
          <input type="text" id="job-search-input" class="form-control" placeholder="Search by job title or keyword..." style="height: 42px; border-radius: 8px 0 0 8px; border: 1px solid #cbd5e1; font-size: 13px;">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" style="height: 42px; background: #00a896; color: #fff; border: 1px solid #00a896; border-radius: 0 8px 8px 0; padding: 0 18px;">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </div>
    </div>

    <!-- Department Filters -->
    <div style="margin-bottom: 30px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
      <span style="font-size: 13px; font-weight: 700; color: #475569; margin-right: 8px;"><i class="fa fa-filter"></i> Department:</span>
      <button type="button" class="dept-filter-btn active" data-dept="all">All Specialties</button>
      <?php if(!empty($departments)): foreach($departments as $dept): ?>
        <button type="button" class="dept-filter-btn" data-dept="<?=htmlspecialchars($dept)?>"><?=htmlspecialchars($dept)?></button>
      <?php endforeach; endif; ?>
    </div>

    <!-- Jobs Cards Container -->
    <div id="jobs-cards-container">
      <?php if(!empty($jobs)): foreach($jobs as $job): 
        $jid       = $job['job_id'];
        $jtitle    = $job['title'];
        $jdept     = $job['department'];
        $jtype     = $job['job_type'] ?: 'Full Time';
        $jloc      = $job['location'] ?: 'Gorakhpur, UP';
        $jexp      = $job['experience_required'] ?: '1-3 Years';
        $jopenings = $job['openings'] ?: 1;
        $jsalary   = $job['salary_range'] ?: 'Best in Industry';
        $jdesc     = $job['description'] ?: 'Exciting healthcare role at Upchar Hospital.';
        $jreqs     = $job['requirements'] ?: 'Relevant medical qualifications.';
      ?>
        <div class="job-card" data-dept="<?=htmlspecialchars($jdept)?>" data-title="<?=htmlspecialchars(strtolower($jtitle . ' ' . $jdept . ' ' . $jreqs))?>">
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-12">
              <span class="job-dept-tag"><?=htmlspecialchars($jdept)?></span>
              <h3 class="job-title"><?=htmlspecialchars($jtitle)?></h3>
              
              <div style="margin-bottom: 8px;">
                <span class="job-meta-item"><i class="fa fa-map-marker"></i> <?=htmlspecialchars($jloc)?></span>
                <span class="job-meta-item"><i class="fa fa-clock-o"></i> <?=htmlspecialchars($jtype)?></span>
                <span class="job-meta-item"><i class="fa fa-briefcase"></i> Exp: <?=htmlspecialchars($jexp)?></span>
                <span class="job-meta-item"><i class="fa fa-users"></i> <?=htmlspecialchars($jopenings)?> Opening(s)</span>
              </div>

              <div>
                <span class="job-salary-pill"><i class="fa fa-inr"></i> <?=htmlspecialchars($jsalary)?></span>
              </div>

              <!-- Collapsible Job Details -->
              <div id="details-box-<?=$jid?>" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e2e8f0;">
                <div style="margin-bottom: 12px;">
                  <strong style="color: #1e293b; font-size: 13px; display: block; margin-bottom: 4px;">Role Overview:</strong>
                  <p style="color: #475569; font-size: 13px; line-height: 1.6; margin: 0;"><?=nl2br(htmlspecialchars($jdesc))?></p>
                </div>
                <div>
                  <strong style="color: #1e293b; font-size: 13px; display: block; margin-bottom: 4px;">Key Requirements:</strong>
                  <p style="color: #475569; font-size: 13px; line-height: 1.6; margin: 0;"><?=nl2br(htmlspecialchars($jreqs))?></p>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-12 text-right text-left-xs" style="margin-top: 15px;">
              <button type="button" class="btn-view-job-details" data-id="<?=$jid?>">
                <i class="fa fa-info-circle"></i> <span>View Details</span>
              </button>
              <button type="button" class="btn-apply-job btn-apply-trigger" 
                      data-id="<?=$jid?>" 
                      data-title="<?=htmlspecialchars($jtitle)?>" 
                      data-dept="<?=htmlspecialchars($jdept)?>">
                <i class="fa fa-paper-plane"></i> Apply Now
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div style="background: #ffffff; border-radius: 12px; padding: 40px; text-align: center; border: 1px solid #e2e8f0;">
          <i class="fa fa-briefcase fa-3x" style="color: #cbd5e1; margin-bottom: 12px;"></i>
          <h4 style="font-weight: 700; color: #475569; margin: 0 0 6px;">No Active Openings At This Moment</h4>
          <p style="color: #94a3b8; font-size: 13px; margin: 0 0 15px;">Check back soon or submit a spontaneous application to be considered for upcoming roles.</p>
          <button type="button" class="btn btn-apply-job btn-open-spontaneous">Submit General CV</button>
        </div>
      <?php endif; ?>

      <!-- No match fallback message -->
      <div id="no-filter-match" style="display: none; background: #ffffff; border-radius: 12px; padding: 40px; text-align: center; border: 1px solid #e2e8f0;">
        <i class="fa fa-search fa-2x" style="color: #cbd5e1; margin-bottom: 10px;"></i>
        <h4 style="font-weight: 700; color: #475569; margin: 0 0 6px;">No Matching Positions Found</h4>
        <p style="color: #94a3b8; font-size: 13px; margin: 0 0 15px;">Try searching for different terms or select "All Specialties".</p>
        <button type="button" class="btn btn-sm btn-default btn-open-spontaneous" style="border-radius: 6px; font-weight: 600;">
          Send Us Your Resume Anyway
        </button>
      </div>
    </div>

    <!-- Spontaneous Application Banner -->
    <div style="background: linear-gradient(135deg, #043d5b 0%, #065b87 100%); border-radius: 14px; padding: 30px 35px; color: #ffffff; margin-top: 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
      <div>
        <h3 style="margin: 0 0 6px; font-size: 20px; font-weight: 800; color: #fff;">Don't See Your Exact Specialty?</h3>
        <p style="margin: 0; color: #e2e8f0; font-size: 14px; max-width: 600px;">
          We are continuously growing our clinical, nursing, diagnostic, and operations teams. Submit your profile and we will get in touch when a matching role opens up.
        </p>
      </div>
      <div>
        <button type="button" class="btn btn-open-spontaneous" style="background: #00a896; color: #fff; font-weight: 700; padding: 12px 28px; border-radius: 8px; border: none; font-size: 14px;">
          <i class="fa fa-envelope-o"></i> Submit General Application
        </button>
      </div>
    </div>

  </div>
</section>

<!-- ============================================== -->
<!-- JOB APPLICATION MODAL -->
<!-- ============================================== -->
<div class="modal fade career-modal" id="jobApplicationModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 24px;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" style="font-weight: 800; font-size: 18px; margin: 0;">
          <i class="fa fa-id-card-o" style="margin-right: 8px;"></i> Apply for Position
        </h4>
        <div id="modal-role-badge" style="display: inline-block; background: rgba(255,255,255,0.2); padding: 3px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; margin-top: 6px;">
          General Application
        </div>
      </div>

      <form id="careerApplicationForm" action="<?=base_url('Home/career')?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="job_id" id="apply-job-id" value="">
        <input type="hidden" name="designation" id="apply-designation" value="">
        <input type="hidden" name="is_ajax" value="1">

        <div class="modal-body" style="padding: 24px;">
          
          <!-- Alert feedback in modal -->
          <div id="modal-alert-box" style="display: none; margin-bottom: 16px;"></div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="career-form-control" placeholder="Dr. / Mr. / Ms. Full Name" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="career-form-control" placeholder="yourname@domain.com" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" maxlength="10" pattern="[0-9]{10}" class="career-form-control" placeholder="10-digit mobile number" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Highest Qualification <span class="text-danger">*</span></label>
                <input type="text" name="qualification" class="career-form-control" placeholder="e.g. MBBS, B.Sc Nursing, DMLT" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Total Experience</label>
                <select name="experience" class="career-form-control">
                  <option value="Fresher / Entry Level">Fresher / Entry Level</option>
                  <option value="1 - 2 Years">1 - 2 Years</option>
                  <option value="3 - 5 Years">3 - 5 Years</option>
                  <option value="5 - 8 Years">5 - 8 Years</option>
                  <option value="8+ Years (Senior Specialist)">8+ Years (Senior Specialist)</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group" id="custom-designation-group" style="display: none;">
                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Desired Role / Department</label>
                <input type="text" id="custom-designation-input" class="career-form-control" placeholder="e.g. ICU Nurse, Duty Doctor">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Brief Note / Cover Message</label>
            <textarea name="message" class="career-form-control" rows="3" placeholder="Tell us about your clinical experience, specialties, or why you want to join Upchar..."></textarea>
          </div>

          <!-- Resume Upload -->
          <div class="form-group" style="margin-bottom: 0;">
            <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #475569;">Attach Resume / Curriculum Vitae <span class="text-danger">*</span></label>
            <div class="file-upload-zone" onclick="$('#resume-file-input').click();">
              <i class="fa fa-cloud-upload fa-2x" style="color: #00a896; margin-bottom: 6px;"></i>
              <div style="font-weight: 600; color: #334155; font-size: 14px;" id="file-upload-label">
                Click or tap here to upload Resume
              </div>
              <small style="color: #94a3b8; font-size: 12px;">Supported: PDF, DOC, DOCX, RTF, TXT (Max 5MB)</small>
              <input type="file" name="uploadimage" id="resume-file-input" style="display: none;" accept=".pdf,.doc,.docx,.rtf,.txt" required>
            </div>
          </div>

        </div>

        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
          <button type="submit" id="btn-submit-career-app" class="btn btn-apply-job">
            <i class="fa fa-paper-plane"></i> <span>Submit Application</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->load->view('includes/footer.php'); ?>

<script>
$(document).ready(function() {
  
  // Department filter buttons
  $('.dept-filter-btn').on('click', function() {
    $('.dept-filter-btn').removeClass('active');
    $(this).addClass('active');

    var selectedDept = $(this).data('dept');
    filterJobs();
  });

  // Keyword search input
  $('#job-search-input').on('keyup', function() {
    filterJobs();
  });

  function filterJobs() {
    var activeDept = $('.dept-filter-btn.active').data('dept') || 'all';
    var searchTerm = ($('#job-search-input').val() || '').toLowerCase().trim();
    var visibleCount = 0;

    $('.job-card').each(function() {
      var cardDept = $(this).data('dept');
      var cardText = $(this).data('title') || '';

      var matchesDept = (activeDept === 'all' || cardDept === activeDept);
      var matchesSearch = (searchTerm === '' || cardText.indexOf(searchTerm) !== -1);

      if (matchesDept && matchesSearch) {
        $(this).fadeIn(200);
        visibleCount++;
      } else {
        $(this).hide();
      }
    });

    if (visibleCount === 0) {
      $('#no-filter-match').fadeIn(200);
    } else {
      $('#no-filter-match').hide();
    }
  }

  // Toggle View Details in Job Cards
  $(document).on('click', '.btn-view-job-details', function() {
    var jid = $(this).data('id');
    var $box = $('#details-box-' + jid);
    var $btnText = $(this).find('span');

    if ($box.is(':visible')) {
      $box.slideUp(200);
      $btnText.text('View Details');
    } else {
      $box.slideDown(200);
      $btnText.text('Hide Details');
    }
  });

  // Open Application Modal for Specific Job
  $(document).on('click', '.btn-apply-trigger', function() {
    var jid = $(this).data('id');
    var jtitle = $(this).data('title');
    var jdept = $(this).data('dept');

    $('#careerApplicationForm')[0].reset();
    $('#modal-alert-box').hide().empty();
    $('#file-upload-label').text('Click or tap here to upload Resume');

    $('#apply-job-id').val(jid);
    $('#apply-designation').val(jtitle);
    $('#modal-role-badge').text(jtitle + ' (' + jdept + ')').show();
    $('#custom-designation-group').hide();

    $('#jobApplicationModal').modal('show');
  });

  // Open Spontaneous / General Application Modal
  $('.btn-open-spontaneous').on('click', function() {
    $('#careerApplicationForm')[0].reset();
    $('#modal-alert-box').hide().empty();
    $('#file-upload-label').text('Click or tap here to upload Resume');

    $('#apply-job-id').val('');
    $('#apply-designation').val('');
    $('#modal-role-badge').text('General / Spontaneous Application').show();
    $('#custom-designation-group').show();

    $('#jobApplicationModal').modal('show');
  });

  // File Upload Input label update
  $('#resume-file-input').on('change', function() {
    if (this.files && this.files.length > 0) {
      var file = this.files[0];
      var fileName = file.name;
      var fileSizeMb = (file.size / (1024 * 1024)).toFixed(2);

      if (file.size > 5 * 1024 * 1024) {
        alert('File size exceeds 5MB limit. Please upload a smaller file.');
        $(this).val('');
        $('#file-upload-label').text('Click or tap here to upload Resume');
        return;
      }

      $('#file-upload-label').html('<i class="fa fa-file-text-o text-success"></i> ' + fileName + ' (' + fileSizeMb + ' MB)');
    }
  });

  // Submit Application Form via AJAX
  $('#careerApplicationForm').on('submit', function(e) {
    e.preventDefault();

    // If spontaneous, copy custom designation
    if ($('#custom-designation-group').is(':visible')) {
      var customRole = $('#custom-designation-input').val().trim();
      $('#apply-designation').val(customRole || 'General Spontaneous Application');
    }

    var $btn = $('#btn-submit-career-app');
    var origText = $btn.html();
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

    var formData = new FormData(this);

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html(origText);
        if (res.status === 'success') {
          $('#modal-alert-box').html('<div class="alert alert-success" style="border-radius: 8px; font-weight: 600;"><i class="fa fa-check-circle"></i> ' + res.message + '</div>').fadeIn(200);
          $('#careerApplicationForm')[0].reset();
          $('#file-upload-label').text('Click or tap here to upload Resume');
          setTimeout(function() {
            $('#jobApplicationModal').modal('hide');
          }, 2500);
        } else {
          $('#modal-alert-box').html('<div class="alert alert-danger" style="border-radius: 8px; font-weight: 600;"><i class="fa fa-exclamation-circle"></i> ' + (res.message || 'Submission failed') + '</div>').fadeIn(200);
        }
      },
      error: function() {
        $btn.prop('disabled', false).html(origText);
        $('#modal-alert-box').html('<div class="alert alert-danger" style="border-radius: 8px; font-weight: 600;"><i class="fa fa-exclamation-circle"></i> An unexpected server error occurred. Please check your internet connection and try again.</div>').fadeIn(200);
      }
    });
  });

});
</script>
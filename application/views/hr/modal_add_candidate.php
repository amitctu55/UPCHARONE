<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$ci =& get_instance();
$modalJobs = !empty($jobs) ? $jobs : ($ci->db ? $ci->db->order_by('job_id', 'desc')->get('career_jobs')->result_array() : []);
$selJobId = $selected_job_id ?? ($ci->input->get('job_id') ? intval($ci->input->get('job_id')) : '');
$currRedirect = current_url() . ($ci->input->server('QUERY_STRING') ? '?' . $ci->input->server('QUERY_STRING') : '');
?>

<!-- ========================================================================= -->
<!-- SHARED MODAL: FAST ADD / INTAKE CANDIDATE                                 -->
<!-- ========================================================================= -->
<div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog" aria-labelledby="addCandidateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 720px; margin: 30px auto;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden;">
            <form id="globalAddCandidateForm" action="<?=base_url('admin1947/hr/save_candidate');?>" method="POST">
                <input type="hidden" name="redirect_to" id="candidate_modal_redirect_to" value="<?=html_escape($currRedirect);?>">
                <?php if (isset($ci->security)): ?>
                    <input type="hidden" name="<?=$ci->security->get_csrf_token_name();?>" value="<?=$ci->security->get_csrf_hash();?>">
                <?php endif; ?>

                <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 26px; border: none; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(0, 168, 150, 0.2); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <div>
                            <h4 class="modal-title" id="addCandidateModalTitle" style="font-weight: 800; font-size: 17px; margin: 0; color: #ffffff;">
                                Fast Intake New Candidate
                            </h4>
                            <small style="color: #94a3b8; font-size: 12px;">Add candidate profile to Upchar talent pipeline</small>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" onclick="closeAddCandidateModal()" style="color: #ffffff; opacity: 0.8; font-size: 24px; margin-top: -4px;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 24px 26px; background: #ffffff;">
                    <!-- Row 1: Name & Mobile -->
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Candidate Full Name <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" name="name" id="modal_cand_name" class="form-control" placeholder="e.g. Dr. Rajesh Nair, Sunita Sharma" required style="border-radius: 9px; height: 42px; font-weight: 600; font-size: 13.5px; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Mobile Phone Number <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" name="mobile" id="modal_cand_mobile" class="form-control" placeholder="10-digit mobile number" required style="border-radius: 9px; height: 42px; font-weight: 600; font-size: 13.5px; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <!-- Row 2: Email & Requisition Opening -->
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Email Address
                            </label>
                            <input type="email" name="email" id="modal_cand_email" class="form-control" placeholder="e.g. candidate@example.com" style="border-radius: 9px; height: 42px; font-size: 13px; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Target Job Opening / Department
                            </label>
                            <select name="job_id" id="candidate_modal_job_id" class="form-control" style="border-radius: 9px; height: 42px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="">-- General Application / Talent Pool (No Specific Job) --</option>
                                <?php if (!empty($modalJobs)): foreach ($modalJobs as $j): ?>
                                    <option value="<?=$j['job_id'];?>" <?=(intval($selJobId) == intval($j['job_id'])) ? 'selected' : '';?>>
                                        <?=html_escape($j['title']);?> (<?=$j['department'];?>) <?=($j['status'] === 'closed') ? '— [Closed]' : '';?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Row 3: Qualification, Experience, Initial Stage -->
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-4">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Highest Qualification
                            </label>
                            <input type="text" name="qualification" id="modal_cand_qual" class="form-control" placeholder="e.g. MBBS, DMLT, GNM, B.Sc" style="border-radius: 9px; height: 42px; font-size: 13px; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-4">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Work Experience
                            </label>
                            <input type="text" name="experience" id="modal_cand_exp" class="form-control" placeholder="e.g. 2.5 Yrs at Max Hospital" style="border-radius: 9px; height: 42px; font-size: 13px; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-4">
                            <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                                Pipeline Stage
                            </label>
                            <select name="status_stage" id="modal_cand_stage" class="form-control" style="border-radius: 9px; height: 42px; font-weight: 700; font-size: 13px; border: 1px solid #cbd5e1;">
                                <option value="applied" selected>📥 1. Applied</option>
                                <option value="screened">🔍 2. Screened</option>
                                <option value="interview_scheduled">🗓️ 3. Interviewing</option>
                                <option value="offered">💼 4. Offered</option>
                                <option value="hired">🏆 5. Hired</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 4: Cover Note / Candidate Summary -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
                            Candidate Profile Summary / Referral Remarks
                        </label>
                        <textarea name="message" id="modal_cand_message" class="form-control" rows="2" placeholder="Clinical expertise, shift preference, expected salary, notice period..." style="border-radius: 9px; font-size: 13px; border: 1px solid #cbd5e1;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 26px; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeAddCandidateModal()" style="border-radius: 9px; font-weight: 600; padding: 9px 20px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 9px; padding: 9px 26px; font-weight: 700; font-size: 13.5px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);">
                        <i class="fa fa-save" style="margin-right: 6px;"></i> Save Candidate to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddCandidateModal(preselectedJobId) {
    var selJob = preselectedJobId || '<?=$selJobId ? $selJobId : "";?>';
    if (selJob && document.getElementById('candidate_modal_job_id')) {
        document.getElementById('candidate_modal_job_id').value = selJob;
    }
    if (typeof $.fn.modal === 'function') {
        $('#addCandidateModal').modal('show');
    } else {
        $('#addCandidateModal').addClass('in').show();
        if (!$('.modal-backdrop').length) {
            $('body').addClass('modal-open').append('<div class="modal-backdrop fade in" onclick="closeAddCandidateModal()"></div>');
        }
    }
}

function closeAddCandidateModal() {
    if (typeof $.fn.modal === 'function') {
        $('#addCandidateModal').modal('hide');
    }
    $('#addCandidateModal').removeClass('in').hide();
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
}
</script>

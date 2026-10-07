<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.affil-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.affil-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.affil-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.affil-table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}

.affil-table {
    width: 100%;
    margin-bottom: 0;
}

.affil-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--upchar-border) !important;
    padding: 14px 16px;
}

.affil-table td {
    padding: 16px;
    vertical-align: middle !important;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.doc-avatar-box {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    flex-shrink: 0;
}

.doc-avatar-placeholder {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #f0fdfa;
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    border: 2px solid #ccfbf1;
    flex-shrink: 0;
}

.btn-verify-affil {
    background: #10b981;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 7px 14px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-verify-affil:hover {
    background: #059669;
}

.btn-reject-affil {
    background: #fef2f2;
    color: #ef4444 !important;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 7px 12px;
    border: 1px solid #fecaca;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none !important;
}

.btn-reject-affil:hover {
    background: #fee2e2;
}
</style>

<div class="contentpanel affil-page-wrap">
    <div class="row">
        <div class="col-md-12">

            <!-- Header Card -->
            <div class="affil-header-card">
                <div>
                    <h1><i class="fa fa-handshake-o text-aqua" style="margin-right: 8px;"></i> Doctor Affiliation Requests</h1>
                    <p style="color: var(--upchar-gray); font-size: 13px; margin: 0;">
                        Review, verify, and approve visiting doctors requesting clinical affiliation with your hospital.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-user-md"></i> All Hospital Doctors
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div id="affil_alert_area" style="display: none; margin-bottom: 16px;"></div>

            <!-- Affiliation Requests Table -->
            <div class="affil-table-card">
                <?php if(!empty($requests)): ?>
                <div class="table-responsive">
                    <table class="table affil-table">
                        <thead>
                            <tr>
                                <th>Doctor Info</th>
                                <th>Specialization &amp; Degree</th>
                                <th>Contact Information</th>
                                <th>Proposed Fee</th>
                                <th>Requested On</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($requests as $r): 
                                $doc_name = 'Dr. ' . trim($r->fname . ' ' . $r->lname);
                                $img_src = '';
                                if(!empty($r->drimage)) {
                                    $img_src = base_url('uploads/doctor/' . $r->drimage);
                                }
                            ?>
                            <tr id="row_link_<?=$r->link_id;?>">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if(!empty($img_src)): ?>
                                            <img src="<?=$img_src;?>" class="doc-avatar-box" alt="<?=$doc_name;?>">
                                        <?php else: ?>
                                            <div class="doc-avatar-placeholder"><i class="fa fa-user-md"></i></div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 800; color: #0f172a; font-size: 14px;"><?=$doc_name;?></div>
                                            <div style="font-size: 12px; color: #64748b;"><?=htmlspecialchars($r->designation ?: 'Consultant Physician');?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; color: #334155; font-size: 11.5px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                                        <?=htmlspecialchars($r->qualification ?: 'MBBS');?>
                                    </span>
                                </td>
                                <td>
                                    <div><i class="fa fa-phone text-muted" style="width: 14px;"></i> <?=htmlspecialchars($r->mobile ?: 'N/A');?></div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;"><i class="fa fa-envelope-o text-muted" style="width: 14px;"></i> <?=htmlspecialchars($r->email ?: 'N/A');?></div>
                                </td>
                                <td>
                                    <strong style="color: #043d5b; font-size: 14px;">₹<?=number_format($r->proposed_fee, 2);?></strong>
                                    <div style="font-size: 11px; color: #94a3b8;">per consultation</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #475569;"><?=date('d M Y', strtotime($r->request_date));?></div>
                                    <div style="font-size: 11px; color: #94a3b8;"><?=date('h:i A', strtotime($r->request_date));?></div>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <button type="button" class="btn-verify-affil btn-action-verify" data-id="<?=$r->link_id;?>" data-name="<?=htmlspecialchars($doc_name, ENT_QUOTES, 'UTF-8');?>">
                                        <i class="fa fa-check"></i> Verify &amp; Approve
                                    </button>
                                    <button type="button" class="btn-reject-affil btn-action-reject" data-id="<?=$r->link_id;?>" style="margin-left: 6px;">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                    <i class="fa fa-check-circle" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                    <h3 style="font-size: 17px; font-weight: 800; color: #334155; margin: 0 0 6px 0;">All Affiliations Up to Date</h3>
                    <p style="font-size: 13px; color: #64748b; max-width: 420px; margin: 0 auto;">
                        There are no pending doctor affiliation requests at this moment. When a doctor requests visiting rights with your hospital, their profile will appear here for verification.
                    </p>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
$(document).ready(function() {
    // Approve Affiliation via AJAX
    $(document).on('click', '.btn-action-verify', function(e) {
        e.preventDefault();
        var linkId = $(this).attr('data-id');
        var docName = $(this).attr('data-name');
        var $btn = $(this);
        var $row = $('#row_link_' + linkId);

        if (!confirm('Are you sure you want to approve affiliation for ' + docName + '? They will be listed under your hospital for patient appointments.')) {
            return;
        }

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');

        $.ajax({
            url: '<?=base_url("hospitalpanel/verify_affiliation");?>/' + linkId,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.affil-table tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                    showAlert('success', res.message || (docName + ' has been verified successfully.'));
                } else {
                    $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Verify &amp; Approve');
                    showAlert('danger', res.message || 'Failed to verify doctor.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Verify &amp; Approve');
                showAlert('danger', 'Server error. Please try again.');
            }
        });
    });

    // Reject Affiliation via AJAX
    $(document).on('click', '.btn-action-reject', function(e) {
        e.preventDefault();
        var linkId = $(this).attr('data-id');
        var $btn = $(this);
        var $row = $('#row_link_' + linkId);

        if (!confirm('Are you sure you want to reject this affiliation request?')) {
            return;
        }

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?=base_url("hospitalpanel/reject_affiliation");?>/' + linkId,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.affil-table tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                    showAlert('info', res.message || 'Affiliation request rejected.');
                } else {
                    $btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject');
                    showAlert('danger', res.message || 'Failed to reject request.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject');
                showAlert('danger', 'Server error. Please try again.');
            }
        });
    });

    function showAlert(type, msg) {
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible" role="alert" style="border-radius: 8px;">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<strong>' + (type === 'success' ? 'Success: ' : 'Notice: ') + '</strong>' + msg +
            '</div>';
        $('#affil_alert_area').html(alertHtml).fadeIn(200);
    }
});
</script>

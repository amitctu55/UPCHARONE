<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.practice-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.practice-kpi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease;
}

.practice-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
}

.badge-active-p {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
}

.badge-pending-p {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
}

.btn-add-p {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 10px 22px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    text-decoration: none !important;
}

.btn-add-p:hover {
    background: var(--upchar-teal-dark);
}

.action-pill {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>

<div class="pag_cstm practice-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Page Title Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-medkit text-aqua" style="margin-right: 8px;"></i> Manage Practice &amp; Consultation Locations
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Configure all private clinics and affiliated hospital practice chambers, set consultation fees, and manage timings.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('addpractice');?>" class="btn-add-p">
                        <i class="fa fa-plus"></i> Add New Practice
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Stats Row -->
            <?php 
            $clinic_count = count($clinic);
            $hospital_count = count($hospital);
            $total_practices = $clinic_count + $hospital_count;
            ?>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="practice-kpi-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Practice Locations</div>
                            <div style="font-size: 26px; font-weight: 800; color: #00a896; margin: 4px 0 2px 0;"><?=$total_practices;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Active consulting chambers</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="practice-kpi-card" style="border-left: 4px solid #3b82f6;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Private Clinics</div>
                            <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin: 4px 0 2px 0;"><?=$clinic_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Own &amp; partner chambers</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="practice-kpi-card" style="border-left: 4px solid #10b981;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Affiliated Hospitals</div>
                            <div style="font-size: 26px; font-weight: 800; color: #059669; margin: 4px 0 2px 0;"><?=$hospital_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Visiting consultant setups</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-building-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Practices Table Card -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid var(--upchar-border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa fa-list text-aqua"></i> Practice Chambers &amp; Hospitals
                    </h3>
                    <span style="font-size: 12px; color: #64748b;"><?=$total_practices;?> Location(s) Linked</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 14px 18px; width: 60px;">#</th>
                                <th style="padding: 14px 18px;">Establishment / Chamber</th>
                                <th style="padding: 14px 18px;">Type</th>
                                <th style="padding: 14px 18px;">Address &amp; Location</th>
                                <th style="padding: 14px 18px;">Consultation Fee</th>
                                <th style="padding: 14px 18px;">Status</th>
                                <th style="padding: 14px 18px; text-align: right;">Quick Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <!-- Clinics -->
                            <?php if(!empty($clinic)): ?>
                                <?php foreach($clinic as $p): ?>
                                <tr>
                                    <td style="padding: 14px 18px; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$i;?></td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14.5px;">
                                            <i class="fa fa-hospital-o text-aqua" style="margin-right: 6px;"></i> <?=htmlspecialchars($p->name);?>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <span class="label label-primary" style="font-size: 11px;">Private Clinic</span>
                                    </td>
                                    <td style="padding: 14px 18px; color: #334155; vertical-align: middle;">
                                        <div><i class="fa fa-map-marker text-danger" style="margin-right: 4px;"></i> <?=htmlspecialchars($p->address ?: 'Address not specified');?></div>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                            ₹<?=number_format($p->practicefee, 2);?>
                                        </div>
                                        <a href="javascript:void(0);" class="open-fee-modal-btn" data-id="<?=$p->practice_id;?>" data-name="<?=htmlspecialchars($p->name, ENT_QUOTES, 'UTF-8');?>" data-fee="<?=$p->practicefee;?>" style="font-size: 11px; color: #00a896; font-weight: 600;">
                                            <i class="fa fa-pencil"></i> Change Fee
                                        </a>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <?php if($p->practice_status == '1'): ?>
                                            <span class="badge-active-p"><i class="fa fa-check-circle"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge-pending-p"><i class="fa fa-clock-o"></i> Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 18px; text-align: right; vertical-align: middle;">
                                        <a href="<?=base_url('doctorpanel/datetime');?>" class="action-pill btn-default" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; margin-right: 4px;">
                                            <i class="fa fa-clock-o"></i> Timings
                                        </a>
                                        <a href="<?=base_url('doctorpanel/delete_practice/'.$p->practice_id);?>" onclick="return confirm('Are you sure you want to remove this practice location?');" class="action-pill btn-default" style="background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            <?php endif; ?>

                            <!-- Hospitals -->
                            <?php if(!empty($hospital)): ?>
                                <?php foreach($hospital as $p): ?>
                                <tr>
                                    <td style="padding: 14px 18px; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$i;?></td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14.5px;">
                                            <i class="fa fa-building text-primary" style="margin-right: 6px;"></i> <?=htmlspecialchars($p->name);?>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <span class="label label-success" style="font-size: 11px;">Visiting Hospital</span>
                                    </td>
                                    <td style="padding: 14px 18px; color: #334155; vertical-align: middle;">
                                        <div><i class="fa fa-map-marker text-danger" style="margin-right: 4px;"></i> <?=htmlspecialchars($p->address ?: 'Address not specified');?></div>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                            ₹<?=number_format($p->practicefee, 2);?>
                                        </div>
                                        <a href="javascript:void(0);" class="open-fee-modal-btn" data-id="<?=$p->practice_id;?>" data-name="<?=htmlspecialchars($p->name, ENT_QUOTES, 'UTF-8');?>" data-fee="<?=$p->practicefee;?>" style="font-size: 11px; color: #00a896; font-weight: 600;">
                                            <i class="fa fa-pencil"></i> Change Fee
                                        </a>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <?php if($p->practice_status == '1'): ?>
                                            <span class="badge-active-p"><i class="fa fa-check-circle"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge-pending-p"><i class="fa fa-clock-o"></i> Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 18px; text-align: right; vertical-align: middle;">
                                        <a href="<?=base_url('doctorpanel/datetime');?>" class="action-pill btn-default" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; margin-right: 4px;">
                                            <i class="fa fa-clock-o"></i> Timings
                                        </a>
                                        <a href="<?=base_url('doctorpanel/delete_practice/'.$p->practice_id);?>" onclick="return confirm('Are you sure you want to remove this practice location?');" class="action-pill btn-default" style="background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            <?php endif; ?>

                            <?php if(empty($clinic) && empty($hospital)): ?>
                                <tr>
                                    <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8;">
                                        <i class="fa fa-medkit" style="font-size: 36px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                        No practice locations linked yet. Click <strong>+ Add New Practice</strong> to configure your consultation chambers.
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

<!-- Quick Fee Update Modal -->
<div class="modal fade" id="feeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-size: 15px; font-weight: 800;"><i class="fa fa-inr"></i> Update Consultation Fee</h4>
            </div>
            <form action="<?=base_url('managepractice');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="update_fee" value="1">
                <input type="hidden" name="practice_id" id="modal_practice_id">

                <div class="modal-body" style="padding: 20px;">
                    <div style="margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Location:</span>
                        <div id="modal_inst_name" style="font-weight: 800; color: #0f172a; font-size: 14px;"></div>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">New Consultation Fee (₹) *</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="font-weight: 700; background: #f8fafc;">₹</span>
                            <input type="number" name="fee" id="modal_fee" class="form-control" min="0" required autofocus>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700;">
                        Save Fee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).on('click', '.open-fee-modal-btn', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var fee = $(this).attr('data-fee');
    $('#modal_practice_id').val(id);
    $('#modal_inst_name').text(name);
    $('#modal_fee').val(fee);
    $('#feeModal').modal('show');
});
</script>
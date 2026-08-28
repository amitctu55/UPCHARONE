<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.pathlab-card-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 22px;
}
.path-toolbar {
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    align-items: flex-end;
    flex-wrap: wrap;
}
.path-form-input {
    height: 38px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 6px 12px;
    font-size: 13px;
    color: #1e293b;
    width: 100%;
}
.path-form-input:focus {
    border-color: #00a896;
    outline: none;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-flask" style="color: #00a896;"></i> Pathology Test Catalog
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Manage diagnostic tests, customize laboratory pricing, and set turnaround timelines.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/addtest');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-plus-circle"></i> Add New Test
                    </a>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?=$this->session->flashdata('flashmsg');?>

            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-list-alt"></i> Available Diagnostic Tests
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <!-- Search Filter Toolbar -->
                    <?php echo form_open("pathlabpanel/pathtest/", 'class="path-toolbar" id="search_form" method="get"'); ?>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Search Keyword</label>
                            <input type="text" class="path-form-input" name="keyword" placeholder="Test Name, Code, Amount..." value="<?=$this->input->get_post('keyword');?>">
                        </div>
                        <div style="width: 150px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">From Date</label>
                            <input type="date" class="path-form-input" name="date_from" value="<?=$this->input->get_post('date_from');?>">
                        </div>
                        <div style="width: 150px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">To Date</label>
                            <input type="date" class="path-form-input" name="date_to" value="<?=$this->input->get_post('date_to');?>">
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" class="btn btn-primary" style="height: 38px; background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 0 18px;">
                                <i class="fa fa-search"></i> Search
                            </button>
                            <?php if($this->input->get_post('keyword') || $this->input->get_post('date_from') || $this->input->get_post('date_to')): ?>
                                <a href="<?=base_url('pathlabpanel/pathtest');?>" class="btn btn-default" style="height: 38px; border-radius: 6px; line-height: 24px;">
                                    <i class="fa fa-times text-danger"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php echo form_close(); ?>

                    <!-- Tests Table -->
                    <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 50px; text-align: center;">#</th>
                                    <th>Category</th>
                                    <th>Test Name</th>
                                    <th>Short Code</th>
                                    <th>Methodology</th>
                                    <th>Turnaround</th>
                                    <th style="text-align: right;">Standard (₹)</th>
                                    <th style="text-align: right;">Lab Rate (₹)</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center; width: 90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                if(is_array($package) && !empty($package)):
                                    foreach($package as $val):
                                        $isActive = ($val['status'] == '1');
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$i;?></td>
                                    <td style="vertical-align: middle;">
                                        <span class="label label-default" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">
                                            <?=htmlspecialchars($val['category_name'] ?: 'General Panel');?>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['test_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle; color: #64748b; font-size: 12px; font-family: monospace;">
                                        <?=htmlspecialchars($val['short_name']);?>
                                    </td>
                                    <td style="vertical-align: middle; color: #64748b; font-size: 12.5px;">
                                        <?=htmlspecialchars($val['method'] ?: 'Automated Analyzer');?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12px; color: #64748b;">
                                        <?=htmlspecialchars($val['report_day'] ? $val['report_day'].' Days' : '24 Hrs');?>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle; font-size: 13px; color: #64748b;">
                                        ₹<?=number_format($val['amount'], 2);?>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($val['lab_price'], 2);?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="label <?=$isActive ? 'label-success' : 'label-danger';?>" style="font-size: 11px; padding: 4px 10px; border-radius: 12px;">
                                            <?=$isActive ? 'Active' : 'De-Active';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/edittest/'.$val['id']);?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 600; color: #00a896; border-color: #cbd5e1;">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; else: ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                        <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                        No pathology tests registered yet. Click "Add New Test" to get started.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(!empty($page_links)): ?>
                        <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <div class="pagination"><?=$page_links;?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

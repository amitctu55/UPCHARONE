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

.match-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.2s ease;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    cursor: pointer;
}

.match-card:hover, .match-card.selected {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.12);
}

.match-icon-circle {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.btn-link-cstm {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 11px 28px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-link-cstm:hover {
    background: var(--upchar-teal-dark);
    color: #ffffff;
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 88vh;">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-building-o text-aqua"></i> Matching Establishments Found
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        We found existing profiles in our healthcare directory matching your search. Select yours to claim and link, or create a new entry.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('addpractice');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-arrow-left"></i> Change Details
                    </a>
                </div>
            </div>

            <form action="<?=base_url('linkpractice');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="fee" value="<?=isset($post_data['fee']) ? intval($post_data['fee']) : 500;?>">

                <div class="row">
                    <!-- Left: Matching Items List -->
                    <div class="col-md-7 col-12">
                        <div style="background: #ffffff; border-radius: 16px; border: 1px solid var(--upchar-border); padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 20px;">
                            
                            <h4 style="font-size: 14px; font-weight: 800; color: #334155; text-transform: uppercase; margin: 0 0 16px 0; letter-spacing: 0.5px;">
                                Select Matching Clinic or Hospital:
                            </h4>

                            <!-- Clinics -->
                            <?php if(!empty($suggestedclinic)): ?>
                                <?php foreach($suggestedclinic as $clinic): ?>
                                <label class="match-card">
                                    <input type="radio" name="hospclinicid" value="C-<?=$clinic->id;?>" checked style="margin-top: 14px;">
                                    <div class="match-icon-circle" style="background: #e0f2fe; color: #0284c7;">
                                        <i class="fa fa-hospital-o"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">
                                            <?=htmlspecialchars($clinic->name);?>
                                        </div>
                                        <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">
                                            <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($clinic->address ?: 'Address on file');?>
                                        </div>
                                        <span class="label label-primary" style="font-size: 10.5px; margin-top: 6px; display: inline-block;">Private Clinic</span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Hospitals -->
                            <?php if(!empty($suggestedhospital)): ?>
                                <?php foreach($suggestedhospital as $hosp): ?>
                                <label class="match-card">
                                    <input type="radio" name="hospclinicid" value="H-<?=$hosp->id;?>" style="margin-top: 14px;">
                                    <div class="match-icon-circle" style="background: #ecfdf5; color: #059669;">
                                        <i class="fa fa-building"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">
                                            <?=htmlspecialchars($hosp->name);?>
                                        </div>
                                        <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">
                                            <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($hosp->address ?: 'Address on file');?>
                                        </div>
                                        <span class="label label-success" style="font-size: 10.5px; margin-top: 6px; display: inline-block;">Hospital / IPD</span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                                <a href="<?=base_url('addpractice');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" name="submit" class="btn-link-cstm">
                                    <i class="fa fa-check"></i> Link Selected Establishment
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Right: Force New Creation Box -->
                    <div class="col-md-5 col-12">
                        <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 20px;">
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 10px 0;">
                                Not listed above?
                            </h4>
                            <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                                If none of the suggested profiles belong to your chamber, you can bypass and register this establishment as a brand new private practice location.
                            </p>

                            <form action="<?=base_url('addpractice');?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                <input type="hidden" name="force_new" value="1">
                                <input type="hidden" name="clinicname" value="<?=htmlspecialchars(@$post_data['clinicname']);?>">
                                <input type="hidden" name="cliniccity" value="<?=htmlspecialchars(@$post_data['cliniccity']);?>">
                                <input type="hidden" name="cliniclocality" value="<?=htmlspecialchars(@$post_data['cliniclocality']);?>">
                                <input type="hidden" name="address" value="<?=htmlspecialchars(@$post_data['address']);?>">
                                <input type="hidden" name="fee" value="<?=htmlspecialchars(@$post_data['fee']);?>">
                                <input type="hidden" name="practicetype" value="<?=htmlspecialchars(@$post_data['practicetype'] ?: 'C');?>">

                                <button type="submit" name="submit" class="btn btn-warning btn-block" style="font-weight: 700; border-radius: 8px; padding: 10px;">
                                    <i class="fa fa-plus-circle"></i> Create as New Practice Chamber
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>
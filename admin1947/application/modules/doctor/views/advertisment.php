<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .ad-card-box {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }
        .ad-header-bar {
            background: linear-gradient(135deg, #605ca8 0%, #4c4699 100%);
            color: #ffffff;
            padding: 14px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ad-body-padding {
            padding: 20px;
        }
        .form-label-bold {
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 5px;
            display: block;
        }
        .cat-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .cat-medicine { background: #dbeafe; color: #1e40af; }
        .cat-medical_store { background: #fef3c7; color: #92400e; }
        .cat-hospital { background: #dcfce7; color: #166534; }
        .cat-pathology { background: #f3e8ff; color: #6b21a8; }
        .cat-equipment { background: #ffedd5; color: #9a3412; }
        .cat-general { background: #f1f5f9; color: #475569; }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Sponsored Advertisements &amp; Showcase Manager
                <small>Post advertisements for medicines, medical stores, hospitals, and pathology labs</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?=base_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Advertisements</li>
            </ol>
        </section>

        <section class="content">
            <?=$this->session->flashdata('flashmsg');?>

            <!-- Category Filter Tabs -->
            <div style="margin-bottom: 18px; display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="<?=base_url('doctor/clinicreg/advertisment');?>" class="btn btn-sm <?=empty($selected_cat) ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    All Sponsored Ads (<?=count($advertisements);?>)
                </a>
                <a href="<?=base_url('doctor/clinicreg/advertisment?category=medicine');?>" class="btn btn-sm <?=$selected_cat==='medicine' ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-medkit"></i> Sponsored Medicines
                </a>
                <a href="<?=base_url('doctor/clinicreg/advertisment?category=medical_store');?>" class="btn btn-sm <?=$selected_cat==='medical_store' ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-plus-square"></i> Medical Stores
                </a>
                <a href="<?=base_url('doctor/clinicreg/advertisment?category=hospital');?>" class="btn btn-sm <?=$selected_cat==='hospital' ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-hospital-o"></i> Hospitals &amp; Clinics
                </a>
                <a href="<?=base_url('doctor/clinicreg/advertisment?category=pathology');?>" class="btn btn-sm <?=$selected_cat==='pathology' ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-flask"></i> Pathology Labs
                </a>
                <a href="<?=base_url('doctor/clinicreg/advertisment?category=equipment');?>" class="btn btn-sm <?=$selected_cat==='equipment' ? 'btn-primary' : 'btn-default';?>" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-heartbeat"></i> Medical Devices
                </a>
            </div>

            <div class="row">
                <!-- Left Column: Add / Edit Form -->
                <div class="col-md-5">
                    <div class="ad-card-box">
                        <div class="ad-header-bar">
                            <span><i class="fa fa-bullhorn"></i> <?=$edit_ad ? 'Edit Sponsored Advertisement' : 'Post New Advertisement';?></span>
                            <?php if ($edit_ad): ?>
                                <a href="<?=base_url('doctor/clinicreg/advertisment');?>" class="btn btn-xs btn-warning" style="font-weight: 700;">+ New Ad</a>
                            <?php endif; ?>
                        </div>
                        <div class="ad-body-padding">
                            <form action="<?=base_url('doctor/clinicreg/advertisment');?>" method="post" enctype="multipart/form-data">
                                <?php if ($edit_ad): ?>
                                    <input type="hidden" name="eid" value="<?=base64_encode($edit_ad->id);?>">
                                <?php endif; ?>

                                <!-- Category Selection -->
                                <div class="form-group">
                                    <label class="form-label-bold">Sponsored Field / Category *</label>
                                    <select name="category" class="form-control input-sm" required style="border-radius: 6px; font-weight: 600;">
                                        <option value="medicine" <?=@$edit_ad->category==='medicine' ? 'selected' : '';?>>💊 Sponsored Medicine / Pharmacy</option>
                                        <option value="medical_store" <?=@$edit_ad->category==='medical_store' ? 'selected' : '';?>>🏪 Medical Store / Chemist</option>
                                        <option value="hospital" <?=@$edit_ad->category==='hospital' ? 'selected' : '';?>>🏥 Hospital / Multispeciality Clinic</option>
                                        <option value="pathology" <?=@$edit_ad->category==='pathology' ? 'selected' : '';?>>🔬 Pathology &amp; Diagnostic Lab</option>
                                        <option value="equipment" <?=@$edit_ad->category==='equipment' ? 'selected' : '';?>>🩺 Medical Equipment &amp; Devices</option>
                                        <option value="general" <?=@$edit_ad->category==='general' ? 'selected' : '';?>>🌐 General Healthcare Offer</option>
                                    </select>
                                </div>

                                <!-- Title & Sponsor Badge -->
                                <div class="form-group">
                                    <label class="form-label-bold">Advertisement Headline / Sponsor Name *</label>
                                    <input type="text" name="title" class="form-control input-sm" placeholder="e.g. Apollo Pharmacy 20% Off" value="<?=html_escape(@$edit_ad->title);?>" required style="border-radius: 6px;">
                                </div>

                                <div class="form-group">
                                    <label class="form-label-bold">Sponsor Badge Tag</label>
                                    <input type="text" name="sponsor_badge" class="form-control input-sm" placeholder="e.g. Sponsored Medicine or NABH Accredited" value="<?=html_escape(@$edit_ad->sponsor_badge ?: 'Sponsored Partner');?>" style="border-radius: 6px;">
                                </div>

                                <!-- Short & Long Description -->
                                <div class="form-group">
                                    <label class="form-label-bold">Short Offer Summary *</label>
                                    <input type="text" name="short" class="form-control input-sm" placeholder="e.g. Flat 20% off with 2-hour doorstep delivery" value="<?=html_escape(@$edit_ad->short_description);?>" required style="border-radius: 6px;">
                                </div>

                                <div class="form-group">
                                    <label class="form-label-bold">Detailed Description / Highlights</label>
                                    <textarea name="long" class="form-control input-sm" rows="3" placeholder="Enter key features, doctor credentials, or lab test inclusions" style="border-radius: 6px;"><?=html_escape(@$edit_ad->long_description);?></textarea>
                                </div>

                                <!-- Target Link & Placement -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-bold">Target CTA URL *</label>
                                            <input type="text" name="link_url" class="form-control input-sm" placeholder="https://... or /mytest" value="<?=html_escape(@$edit_ad->link_url ?: @$edit_ad->page ?: base_url());?>" required style="border-radius: 6px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-bold">Placement Zone</label>
                                            <select name="placement" class="form-control input-sm" style="border-radius: 6px;">
                                                <option value="public_dashboard" <?=@$edit_ad->placement==='public_dashboard' ? 'selected' : '';?>>Public Dashboard &amp; Home</option>
                                                <option value="patient_dashboard" <?=@$edit_ad->placement==='patient_dashboard' ? 'selected' : '';?>>Patient Dashboard</option>
                                                <option value="pathology_page" <?=@$edit_ad->placement==='pathology_page' ? 'selected' : '';?>>Pathology &amp; Lab Page</option>
                                                <option value="sidebar_banner" <?=@$edit_ad->placement==='sidebar_banner' ? 'selected' : '';?>>Sidebar Banner</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload or Direct URL -->
                                <div class="form-group">
                                    <label class="form-label-bold">Banner Image Upload</label>
                                    <input type="file" name="uploadimage" class="form-control input-sm" style="border-radius: 6px;">
                                    <small style="color: #64748b;">Or enter Direct Image URL below:</small>
                                    <input type="text" name="image_url" class="form-control input-sm" placeholder="https://images.unsplash.com/..." value="<?=filter_var(@$edit_ad->image, FILTER_VALIDATE_URL) ? html_escape(@$edit_ad->image) : '';?>" style="margin-top: 4px; border-radius: 6px;">
                                </div>

                                <!-- Active Status -->
                                <div class="form-group">
                                    <label class="form-label-bold">Display Status</label>
                                    <label class="radio-inline"><input type="radio" name="activeradio" value="1" <?=(@$edit_ad->status!=='0') ? 'checked' : '';?>> Active (Visible on Public Dashboard)</label>
                                    <label class="radio-inline"><input type="radio" name="activeradio" value="0" <?=(@$edit_ad->status==='0') ? 'checked' : '';?>> Inactive / Paused</label>
                                </div>

                                <div style="margin-top: 20px;">
                                    <button type="submit" name="submit" class="btn btn-block" style="background: #605ca8; color: #fff; font-weight: 700; border-radius: 6px; padding: 10px;">
                                        <i class="fa fa-check"></i> <?=$edit_ad ? 'Update Advertisement' : 'Publish Sponsored Advertisement';?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Active Advertisements Table -->
                <div class="col-md-7">
                    <div class="ad-card-box">
                        <div class="ad-header-bar" style="background: #0f172a;">
                            <span><i class="fa fa-list"></i> Active Sponsored Showcase Space (<?=count($advertisements);?>)</span>
                            <a href="<?=base_url();?>" target="_blank" class="btn btn-xs btn-info" style="font-weight: 700;">
                                <i class="fa fa-external-link"></i> View Public Dashboard
                            </a>
                        </div>
                        <div class="ad-body-padding" style="padding: 0;">
                            <div class="table-responsive">
                                <table class="table table-hover" style="margin: 0; vertical-align: middle;">
                                    <thead>
                                        <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase;">
                                            <th>Banner</th>
                                            <th>Sponsor &amp; Category</th>
                                            <th>Offer / Description</th>
                                            <th>Status</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($advertisements)): ?>
                                            <?php foreach ($advertisements as $ad): 
                                                $imgSrc = filter_var($ad->image, FILTER_VALIDATE_URL) ? $ad->image : (base_url('public/assets/upload/' . $ad->image));
                                                $catClass = 'cat-' . ($ad->category ?: 'general');
                                            ?>
                                            <tr>
                                                <td style="width: 80px;">
                                                    <?php if (!empty($ad->image)): ?>
                                                        <img src="<?=$imgSrc;?>" alt="Banner" style="width: 70px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=200';">
                                                    <?php else: ?>
                                                        <div style="width: 70px; height: 45px; background: #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #64748b;">No Image</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong style="font-size: 13px; color: #0f172a; display: block;">
                                                        <?=html_escape($ad->title ?: $ad->short_description);?>
                                                    </strong>
                                                    <span class="cat-pill <?=$catClass;?>">
                                                        <?=str_replace('_', ' ', $ad->category ?: 'General');?>
                                                    </span>
                                                    <small style="display: block; color: #0284c7; margin-top: 2px;">
                                                        <?=html_escape($ad->sponsor_badge);?>
                                                    </small>
                                                </td>
                                                <td style="max-width: 180px; font-size: 12px; color: #475569;">
                                                    <?=html_escape($ad->short_description);?>
                                                    <?php if (!empty($ad->link_url)): ?>
                                                        <a href="<?=html_escape($ad->link_url);?>" target="_blank" style="display: block; font-size: 11px; color: #6366f1; margin-top: 2px;">
                                                            <i class="fa fa-link"></i> <?=substr($ad->link_url, 0, 25);?>...
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?=base_url('doctor/clinicreg/toggle_ad/' . $ad->id);?>" class="label label-<?=$ad->status=='1' ? 'success' : 'danger';?>" title="Click to toggle status" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-decoration: none;">
                                                        <?=$ad->status=='1' ? 'ACTIVE' : 'PAUSED';?>
                                                    </a>
                                                </td>
                                                <td style="text-align: right; white-space: nowrap;">
                                                    <a href="<?=base_url('doctor/clinicreg/advertisment?edit=' . base64_encode($ad->id));?>" class="btn btn-xs btn-info" style="border-radius: 4px;" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?=base_url('doctor/clinicreg/delete_ad/' . $ad->id);?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this advertisement?')" style="border-radius: 4px;" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                                    No sponsored advertisements found in this category.
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

    <!-- Footer -->
    <?php $this->load->view('inc/table_footer');?>
</div>
</body>
</html>

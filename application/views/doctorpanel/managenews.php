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

.news-page-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.news-table {
    width: 100%;
    margin-bottom: 0;
}

.news-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--upchar-border) !important;
    padding: 14px 18px;
}

.news-table td {
    padding: 16px 18px;
    vertical-align: middle !important;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.thumb-preview-box {
    width: 60px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #94a3b8;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.btn-add-news {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 10px 20px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.btn-add-news:hover {
    background: var(--upchar-teal-dark);
}

.action-icon-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: all 0.15s ease;
    border: 1px solid transparent;
    text-decoration: none !important;
    margin-left: 4px;
}

.action-icon-edit {
    background: #f0fdfa;
    color: #0f766e;
    border-color: #ccfbf1;
}
.action-icon-edit:hover {
    background: var(--upchar-teal);
    color: #ffffff;
}

.action-icon-del {
    background: #fef2f2;
    color: #dc2626;
    border-color: #fecaca;
}
.action-icon-del:hover {
    background: #dc2626;
    color: #ffffff;
}

.badge-live-pill {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-draft-pill {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>

<div class="news-page-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 14px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-newspaper-o text-aqua" style="margin-right: 8px;"></i> Manage Health Articles &amp; News Updates
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Publish clinical tips, medical updates, and video guides to educate your patients.
                    </p>
                </div>
                <div>
                    <button type="button" class="btn-add-news" data-toggle="modal" data-target="#addNewsModal">
                        <i class="fa fa-plus-circle"></i> Add Article / Tip
                    </button>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <?php 
            $items = !empty($news) ? $news : (!empty($all_news) ? $all_news : array());
            $is_own = !empty($news);
            ?>

            <!-- Data Table Card -->
            <div class="card-custom">
                <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            Articles &amp; Advisory Feed (<?=count($items);?>)
                        </h3>
                    </div>
                    <?php if(!$is_own): ?>
                    <span style="font-size: 12px; color: #0284c7; background: #e0f2fe; padding: 4px 10px; border-radius: 6px; font-weight: 600;">
                        <i class="fa fa-info-circle"></i> Showing Upchar Network Feed
                    </span>
                    <?php endif; ?>
                </div>

                <?php if(!empty($items)): ?>
                <div class="table-responsive">
                    <table class="table news-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">Thumbnail</th>
                                <th>Title &amp; Summary</th>
                                <th>Format</th>
                                <th>Status</th>
                                <th>Published Date</th>
                                <th style="text-align: right; width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $p): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($p['image'])): ?>
                                        <img src="<?=base_url('admin1947/public/assets/upload/'.$p['image']);?>" class="thumb-preview-box" alt="Thumb" onerror="this.style.display='none';">
                                    <?php elseif($p['type'] == '2'): ?>
                                        <div class="thumb-preview-box" style="background: #eff6ff; color: #2563eb;">
                                            <i class="fa fa-play"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="thumb-preview-box">
                                            <i class="fa fa-file-text-o"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 14px; margin-bottom: 4px;">
                                        <?=htmlspecialchars($p['title']);?>
                                    </div>
                                    <div style="font-size: 12px; color: #64748b; line-height: 1.4; max-width: 520px;">
                                        <?=htmlspecialchars(substr(strip_tags($p['description']), 0, 110)) . (strlen($p['description']) > 110 ? '...' : '');?>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 12px; font-weight: 700; color: #0f766e; background: #f0fdfa; padding: 4px 8px; border-radius: 6px; border: 1px solid #ccfbf1;">
                                        <?=$p['type'] == '2' ? '<i class="fa fa-video-camera"></i> Video' : '<i class="fa fa-file-text-o"></i> Article';?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($p['approved'] == '1' || $p['status'] == '1'): ?>
                                        <span class="badge-live-pill"><i class="fa fa-check-circle"></i> Published</span>
                                    <?php else: ?>
                                        <span class="badge-draft-pill"><i class="fa fa-clock-o"></i> Under Review</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-size: 12.5px; color: #475569; font-weight: 600;">
                                        <?=date('d M Y', strtotime($p['creat_date']));?>
                                    </span>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <a href="<?=base_url('doctorpanel/news');?>" class="action-icon-btn action-icon-edit" title="Edit Article">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <?php if(isset($p['doctor_id']) && $p['doctor_id'] == $this->did): ?>
                                    <a href="<?=base_url('doctorpanel/delete_news/'.$p['id']);?>" onclick="return confirm('Are you sure you want to delete this article?');" class="action-icon-btn action-icon-del" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                    <i class="fa fa-newspaper-o" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                    <h4 style="font-weight: 800; color: #334155; margin: 0 0 4px 0;">No articles published yet</h4>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">Publish your first health article or video guide to help patients understand medical care.</p>
                    <button type="button" class="btn-add-news" data-toggle="modal" data-target="#addNewsModal">
                        <i class="fa fa-plus-circle"></i> Add Article
                    </button>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Add News / Health Advisory -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff; padding: 18px 22px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 800;">
                    <i class="fa fa-plus-circle"></i> Publish Health Article / Advisory
                </h4>
            </div>

            <form action="<?=base_url('doctorpanel/news');?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="submit" value="1">

                <div class="modal-body" style="padding: 22px;">
                    <!-- Title -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Article Title *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. 5 Warning Signs of Cardiovascular Strain" required style="height: 42px; border-radius: 8px;">
                    </div>

                    <!-- Type -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Publication Format *</label>
                        <select name="type" id="modal_news_type" class="form-control" style="height: 42px; border-radius: 8px;">
                            <option value="1">Standard Article with Featured Image</option>
                            <option value="2">Video Health Guide (YouTube Embed)</option>
                        </select>
                    </div>

                    <!-- Video URL (Hidden by default unless selected) -->
                    <div class="form-group" id="video_url_wrap" style="margin-bottom: 16px; display: none;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">YouTube Video URL</label>
                        <input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." style="height: 42px; border-radius: 8px;">
                    </div>

                    <!-- Featured Image -->
                    <div class="form-group" id="image_upload_wrap" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Featured Cover Image</label>
                        <input type="file" name="uploadimage" accept="image/*" class="form-control" style="height: 42px; border-radius: 8px;">
                        <span style="font-size: 11px; color: #94a3b8; margin-top: 4px; display: block;">Supported formats: JPG, PNG, WEBP (Max 5MB).</span>
                    </div>

                    <!-- Description -->
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Clinical Content &amp; Details *</label>
                        <textarea name="description" rows="5" class="form-control" placeholder="Write medical advisory, tips, or symptoms guidance for patients..." required style="border-radius: 8px; font-size: 13px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700;">
                        <i class="fa fa-paper-plane"></i> Publish Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).ready(function() {
    // Relocate modal to body to prevent backdrop z-index overlay issues
    $('#addNewsModal').appendTo('body');

    $('#modal_news_type').on('change', function() {
        if ($(this).val() === '2') {
            $('#video_url_wrap').slideDown(150);
            $('#image_upload_wrap').slideUp(150);
        } else {
            $('#video_url_wrap').slideUp(150);
            $('#image_upload_wrap').slideDown(150);
        }
    });
});
</script>

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

.news-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.news-header-card {
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

.news-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.news-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.news-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    max-width: 800px;
}

.news-card-header {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 8px;
}

.news-card-body {
    padding: 28px;
}

.form-group-field {
    margin-bottom: 20px;
}

.form-group-field label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-group-field .ctrl-input {
    width: 100%;
    height: 42px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-group-field textarea.ctrl-input {
    height: 95px;
    resize: vertical;
}

.form-group-field .ctrl-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.file-dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.15s ease;
}

.file-dropzone-box:hover {
    border-color: #00a896;
    background: #f0fdfa;
}

.btn-publish-news {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 13.5px;
    padding: 10px 24px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-publish-news:hover {
    background: #008f80;
    transform: translateY(-1px);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="news-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="news-header-card">
            <div>
                <h1><i class="fa fa-bullhorn" style="color: #00a896; margin-right: 8px;"></i> Hospital News &amp; Announcements</h1>
                <p>Broadcast free health checkup camps, medical seminars, doctor visiting schedules, and patient bulletins.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managenews');?>" class="btn-publish-news" style="background: #043d5b;">
                    <i class="fa fa-newspaper-o"></i> View Published News
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="news-form-card">
            <div class="news-card-header">
                <i class="fa fa-pencil-square-o"></i> Publish New Announcement
            </div>

            <div class="news-card-body">
                <form action="<?=base_url('hospitalpanel/news');?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                    <div class="form-group-field">
                        <label>Announcement Headline / Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" class="ctrl-input" name="name" placeholder="e.g. Free Cardiology Checkup Camp This Sunday" required>
                    </div>

                    <div class="form-group-field">
                        <label>Detailed Announcement Information <span style="color: #ef4444;">*</span></label>
                        <textarea class="ctrl-input" name="description" placeholder="Provide event timings, venue details, participating specialists..." required></textarea>
                    </div>

                    <div class="form-group-field">
                        <label>Media Attachment Type <span style="color: #ef4444;">*</span></label>
                        <select name="type" class="ctrl-input" id="newsTypeSelect" onchange="toggleMediaType(this.value);" required>
                            <option value="">-- Select Media Format --</option>
                            <option value="1" selected>Image / Banner Poster</option>
                            <option value="2">Video URL (YouTube / Vimeo)</option>
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group-field" id="imageGroup">
                        <label>Upload Banner / Poster</label>
                        <div class="file-dropzone-box" onclick="$('#newsFileInput').click();">
                            <i class="fa fa-file-image-o" style="font-size: 28px; color: #00a896; margin-bottom: 6px;"></i>
                            <div style="font-weight: 700; color: #334155; font-size: 13px;" id="newsFileText">Click to select banner image</div>
                            <span style="font-size: 11.5px; color: #94a3b8;">JPG, PNG or WEBP format</span>
                        </div>
                        <input type="file" id="newsFileInput" name="uploadimage" style="display: none;" onchange="$('#newsFileText').text(this.files[0] ? this.files[0].name : 'Click to select banner image');">
                    </div>

                    <!-- Video URL -->
                    <div class="form-group-field" id="videoGroup" style="display: none;">
                        <label>Video Stream URL</label>
                        <input type="url" class="ctrl-input" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div style="margin-top: 24px; display: flex; gap: 12px;">
                        <button type="submit" name="submit" class="btn-publish-news">
                            <i class="fa fa-paper-plane"></i> Publish Announcement
                        </button>
                        <button type="reset" class="btn-publish-news" style="background: #f1f5f9; color: #475569; box-shadow: none;">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function toggleMediaType(typeVal) {
    if (typeVal === '2') {
        $('#imageGroup').hide();
        $('#videoGroup').show();
    } else {
        $('#imageGroup').show();
        $('#videoGroup').hide();
    }
}
</script>
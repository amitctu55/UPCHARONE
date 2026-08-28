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

.publish-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.publish-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    padding: 32px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.type-pill-label {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 10px;
    padding: 12px 20px;
    cursor: pointer;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s;
    flex: 1;
}

.type-pill-label:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.type-pill-label input[type="radio"]:checked + span {
    color: var(--upchar-teal);
    font-weight: 700;
}

.btn-publish-submit {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 12px 32px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-publish-submit:hover {
    background: var(--upchar-teal-dark);
}
</style>

<div class="pag_cstm publish-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-pencil-square-o text-aqua" style="margin-right: 8px;"></i> Write &amp; Publish Health Article
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Publish clinical awareness articles, preventive health tips, or YouTube medical videos on UPCHAR.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/managenews');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-arrow-left"></i> Back to Articles List
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Form Column -->
                <div class="col-md-8 col-12">
                    <div class="publish-card">
                        <form action="<?=base_url('doctorpanel/news');?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="submit" value="1">

                            <!-- Article Media Type -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label-cstm">Publication Format *</label>
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    <label class="type-pill-label">
                                        <input type="radio" name="type" value="1" checked onchange="toggleMediaType(1)">
                                        <span><i class="fa fa-image text-aqua"></i> Featured Image Article</span>
                                    </label>
                                    <label class="type-pill-label">
                                        <input type="radio" name="type" value="2" onchange="toggleMediaType(2)">
                                        <span><i class="fa fa-youtube-play text-danger"></i> YouTube Video Tip</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Article / Health Topic Headline *</label>
                                <input type="text" name="name" class="form-input-cstm" placeholder="e.g. Managing Hypertension &amp; Lifestyle Habits in 2026" required autofocus>
                            </div>

                            <!-- Image Upload Box -->
                            <div class="form-group" id="image_upload_section" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Featured Cover Image</label>
                                <input type="file" name="uploadimage" class="form-control" accept="image/*" style="border-radius: 8px; height: 44px; padding: 8px;">
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">Recommended size: 1200x630 px (JPG, PNG, WebP up to 5MB).</span>
                            </div>

                            <!-- Video URL Box -->
                            <div class="form-group" id="video_url_section" style="margin-bottom: 18px; display: none;">
                                <label class="form-label-cstm">YouTube Video Link</label>
                                <input type="url" name="video_url" class="form-input-cstm" placeholder="e.g. https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">Paste any standard YouTube video URL or embed link.</span>
                            </div>

                            <!-- Description -->
                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">Article Content &amp; Clinical Guidance *</label>
                                <textarea name="description" class="form-control" rows="8" placeholder="Write your clinical advice, symptoms to watch, diet tips, and precautions..." style="border-radius: 10px; border-color: var(--upchar-border); padding: 12px; font-size: 13.5px;" required></textarea>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?=base_url('doctorpanel/managenews');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" class="btn-publish-submit">
                                    <i class="fa fa-paper-plane"></i> Publish Health Article
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-md-4 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                            <i class="fa fa-lightbulb-o text-yellow"></i> Author Guidelines
                        </h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            Medical articles authored by verified practitioners are featured on the UPCHAR Patient Health Portal and help build trust.
                        </p>

                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9; margin-bottom: 12px;">
                            <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;"><i class="fa fa-check text-aqua"></i> Evidence-Based Advice</div>
                            <div style="font-size: 11.5px; color: #64748b;">Keep medical terminology simple and accessible for patients and families.</div>
                        </div>

                        <div style="background: #ecfdf5; border-radius: 10px; padding: 14px; border: 1px solid #d1fae5;">
                            <div style="font-size: 12px; font-weight: 700; color: #065f46; margin-bottom: 4px;"><i class="fa fa-star text-green"></i> Profile Visibility</div>
                            <div style="font-size: 11.5px; color: #047857;">Articles link back to your doctor consultation booking profile with verified credentials.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
function toggleMediaType(type) {
    if (type == 1) {
        $('#image_upload_section').show();
        $('#video_url_section').hide();
    } else {
        $('#image_upload_section').hide();
        $('#video_url_section').show();
    }
}
</script>
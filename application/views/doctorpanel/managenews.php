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

.news-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.news-card-item {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.news-card-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0, 168, 150, 0.12);
    border-color: var(--upchar-teal);
}

.news-media-box {
    width: 100%;
    height: 180px;
    background: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.news-media-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-content-box {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.btn-publish {
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

.btn-publish:hover {
    background: var(--upchar-teal-dark);
}

.badge-live {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
}

.badge-draft {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 12px;
}
</style>

<div class="pag_cstm news-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-newspaper-o text-aqua" style="margin-right: 8px;"></i> Medical News, Health Tips &amp; Articles
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Publish clinical insights, public health advisories, and video health tips to educate patients and boost your profile credibility.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/news');?>" class="btn-publish">
                        <i class="fa fa-plus-circle"></i> Publish New Article
                    </a>
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

            <?php if(!$is_own && !empty($items)): ?>
            <div class="alert alert-info" style="border-radius: 10px; border: none; background: #e0f2fe; color: #0369a1; font-weight: 600;">
                <i class="fa fa-info-circle"></i> Showing recent healthcare publications across Upchar. Click <strong>+ Publish New Article</strong> above to post your own articles.
            </div>
            <?php endif; ?>

            <!-- Articles Grid -->
            <div class="row">
                <?php if(!empty($items)): ?>
                    <?php foreach($items as $p): ?>
                    <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 24px;">
                        <div class="news-card-item">
                            <!-- Media Box -->
                            <div class="news-media-box">
                                <?php if($p['type'] == '2' && !empty($p['video_url'])): ?>
                                    <iframe width="100%" height="180" src="<?=htmlspecialchars($p['video_url']);?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php elseif(!empty($p['image'])): ?>
                                    <img src="<?=base_url('admin1947/public/assets/upload/'.$p['image']);?>" alt="Article Thumbnail" onerror="this.src='<?=base_url('assets/images/user.jpg');?>';">
                                <?php else: ?>
                                    <div style="color: #64748b; font-size: 36px; display: flex; align-items: center; justify-content: center; height: 100%;">
                                        <i class="fa fa-newspaper-o"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content Box -->
                            <div class="news-content-box">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-size: 11px; color: #64748b; font-weight: 600;">
                                            <i class="fa fa-calendar"></i> <?=date('d M Y', strtotime($p['creat_date']));?>
                                        </span>
                                        <?php if($p['approved'] == '1' || $p['status'] == '1'): ?>
                                            <span class="badge-live"><i class="fa fa-check-circle"></i> Live &amp; Published</span>
                                        <?php else: ?>
                                            <span class="badge-draft"><i class="fa fa-clock-o"></i> Pending Review</span>
                                        <?php endif; ?>
                                    </div>

                                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; line-height: 1.4;">
                                        <?=htmlspecialchars($p['title']);?>
                                    </h4>

                                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">
                                        <?=htmlspecialchars(substr(strip_tags($p['description']), 0, 140)) . (strlen($p['description']) > 140 ? '...' : '');?>
                                    </p>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 8px;">
                                    <span style="font-size: 11.5px; font-weight: 700; color: #00a896;">
                                        <?=$p['type'] == '2' ? '<i class="fa fa-play-circle"></i> Video Tip' : '<i class="fa fa-file-text-o"></i> Article';?>
                                    </span>
                                    <?php if(isset($p['doctor_id']) && $p['doctor_id'] == $this->did): ?>
                                    <a href="<?=base_url('doctorpanel/delete_news/'.$p['id']);?>" onclick="return confirm('Are you sure you want to delete this article?');" class="btn btn-xs btn-danger" style="border-radius: 4px;" title="Delete">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12" style="text-align: center; padding: 60px; color: #94a3b8;">
                        <i class="fa fa-newspaper-o" style="font-size: 48px; display: block; margin-bottom: 12px; color: #cbd5e1;"></i>
                        <h4 style="font-weight: 700; color: #64748b;">No medical articles published yet</h4>
                        <p style="font-size: 13px;">Publish your first health article or video guide to help patients understand preventive healthcare.</p>
                        <a href="<?=base_url('doctorpanel/news');?>" class="btn-publish" style="margin-top: 12px;">
                            <i class="fa fa-plus-circle"></i> Publish Article
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

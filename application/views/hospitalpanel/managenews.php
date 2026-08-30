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

.news-list-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.news-list-header {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.news-list-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.news-list-header p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-news {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-add-news:hover {
    background: #008f80;
    transform: translateY(-1px);
}

/* News Cards Grid */
.news-grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 22px;
}

.news-item-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    transition: all 0.2s ease;
}

.news-item-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.news-media-wrap {
    height: 180px;
    background: #043d5b;
    overflow: hidden;
    position: relative;
}

.news-media-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-card-body {
    padding: 18px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.news-card-title {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.news-card-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 16px 0;
    flex: 1;
}

.news-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}

.badge-news-active {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 9px;
    border-radius: 12px;
}

.badge-news-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 9px;
    border-radius: 12px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="news-list-wrap">

        <!-- Header -->
        <div class="news-list-header">
            <div>
                <h1><i class="fa fa-newspaper-o" style="color: #00a896; margin-right: 8px;"></i> Hospital News &amp; Bulletins</h1>
                <p>Manage all hospital press releases, health updates, and live event announcements.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/news');?>" class="btn-add-news">
                    <i class="fa fa-plus-circle"></i> Create Announcement
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- News Grid -->
        <?php if(!empty($news)): ?>
            <div class="news-grid-cards">
                <?php foreach($news as $p): 
                    $newsTitle = !empty($p['title']) ? $p['title'] : (!empty($p['name']) ? $p['name'] : 'Hospital News Announcement');
                    $newsDesc  = !empty($p['description']) ? $p['description'] : '';
                ?>
                    <div class="news-item-card">
                        <div class="news-media-wrap">
                            <?php if(!empty($p['image'])): ?>
                                <img src="<?=base_url('admin1947/public/assets/upload/'.$p['image']);?>" alt="<?=html_escape($newsTitle);?>" onerror="this.src='<?=base_url();?>images/default-news.jpg';">
                            <?php else: ?>
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ffffff;">
                                    <i class="fa fa-bullhorn" style="font-size: 48px; opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="news-card-body">
                            <div>
                                <h3 class="news-card-title"><?=html_escape($newsTitle);?></h3>
                                <p class="news-card-desc"><?=html_escape($newsDesc);?></p>
                            </div>
                            
                            <div class="news-card-footer">
                                <div>
                                    <?php if(isset($p['status']) && $p['status'] == 'A'): ?>
                                        <span class="badge-news-active"><i class="fa fa-check-circle"></i> Published Live</span>
                                    <?php else: ?>
                                        <span class="badge-news-pending"><i class="fa fa-clock-o"></i> Active</span>
                                    <?php endif; ?>
                                </div>

                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <?php if(!empty($p['video_url'])): ?>
                                        <a href="<?=$p['video_url'];?>" target="_blank" style="color: #0284c7; font-size: 12px; font-weight: 700; text-decoration: none;">
                                            <i class="fa fa-play-circle"></i> Video
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?=base_url('hospitalpanel/delete_news/'.$p['id']);?>" onclick="return confirm('Are you sure you want to delete this announcement?');" class="btn btn-xs btn-danger" style="background: #ef4444; border: none; color: #fff; padding: 3px 8px; border-radius: 6px;">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 64px 20px; background: #ffffff; border-radius: 12px; border: 1px solid var(--upchar-border);">
                <i class="fa fa-newspaper-o" style="font-size: 44px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                <h3 style="font-size: 16px; font-weight: 700; color: #64748b; margin: 0 0 6px 0;">No Announcements Published</h3>
                <p style="font-size: 13px; color: #94a3b8; margin: 0 0 18px 0;">Publish your hospital's latest medical camps, specialist visiting schedules, or facilities.</p>
                <a href="<?=base_url('hospitalpanel/news');?>" class="btn-add-news">
                    <i class="fa fa-plus-circle"></i> Publish First Announcement
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

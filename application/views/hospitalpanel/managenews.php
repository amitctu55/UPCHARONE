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

/* Page Header */
.news-list-header {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
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
    display: flex;
    align-items: center;
    gap: 10px;
}

.news-list-header p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-news {
    background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-add-news:hover {
    background: linear-gradient(135deg, #008f80 0%, #00776b 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* Summary Stats */
.news-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.news-stat-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: transform 0.15s ease;
}

.news-stat-card:hover {
    transform: translateY(-2px);
}

.news-stat-info h3 {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 2px 0;
    line-height: 1.2;
}

.news-stat-info p {
    font-size: 12px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.news-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.news-stat-icon.teal { background: #ccfbf1; color: #0d9488; }
.news-stat-icon.green { background: #dcfce7; color: #16a34a; }
.news-stat-icon.purple { background: #f3e8ff; color: #7e22ce; }

/* Filter Bar */
.news-filter-bar {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 14px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}

.news-search-wrap {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.news-search-wrap i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.news-search-input {
    width: 100%;
    height: 40px;
    padding: 8px 14px 8px 38px;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    font-size: 13.5px;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.15s ease;
}

.news-search-input:focus {
    background: #ffffff;
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

/* News Cards Grid */
.news-grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 22px;
}

.news-item-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
}

.news-item-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
    border-color: #cbd5e1;
}

.news-media-wrap {
    height: 190px;
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.news-media-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.news-item-card:hover .news-media-wrap img {
    transform: scale(1.06);
}

.news-media-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.video-play-btn {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(4, 61, 91, 0.35);
    transition: all 0.2s ease;
}

.video-play-btn i {
    width: 52px;
    height: 52px;
    background: rgba(239, 68, 68, 0.95);
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    padding-left: 3px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease;
}

.news-item-card:hover .video-play-btn i {
    transform: scale(1.1);
}

.news-card-body {
    padding: 18px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.news-card-title {
    font-size: 15.5px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.news-card-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 14px 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-card-meta {
    font-size: 11.5px;
    color: #94a3b8;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.news-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}

.badge-news-live {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-news-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-card-action {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none !important;
    transition: all 0.15s ease;
    cursor: pointer;
}

.btn-card-action:hover {
    background: #dc2626;
    color: #ffffff !important;
}

/* Modals */
.news-modal {
    display: none;
    position: fixed;
    z-index: 999999;
    inset: 0;
    background: rgba(15, 23, 42, 0.88);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.news-modal.show {
    display: flex;
}

.news-modal-content {
    background: #ffffff;
    border-radius: 16px;
    max-width: 800px;
    width: 100%;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    animation: modalPop 0.2s ease-out;
}

@keyframes modalPop {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.modal-media-frame {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    background: #000;
}

.modal-media-frame iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

.modal-info-body {
    padding: 20px 24px;
}

.modal-info-body h3 {
    font-size: 18px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 6px 0;
}

.modal-info-body p {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.6;
    margin: 0 0 12px 0;
}

.modal-close-btn {
    background: #f1f5f9;
    border: none;
    color: #475569;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
}

.modal-close-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="news-list-wrap">

        <!-- Page Header -->
        <div class="news-list-header">
            <div>
                <h1>
                    <i class="fa fa-bullhorn" style="color: #00a896;"></i>
                    Hospital News &amp; Bulletins
                </h1>
                <p>Publish health checkup camps, OPD visiting schedules, medical milestones, and video press announcements.</p>
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

        <?php 
            $totalNews = !empty($news) ? count($news) : 0;
            $liveNews = 0;
            $videoCount = 0;
            if(!empty($news)) {
                foreach($news as $n) {
                    $isLive = (isset($n['status']) && ($n['status'] == '1' || $n['status'] == 'A')) && (!isset($n['approved']) || $n['approved'] == '1');
                    if($isLive) $liveNews++;
                    if(!empty($n['video_url']) || (isset($n['type']) && $n['type'] == 2)) $videoCount++;
                }
            }
        ?>

        <!-- Summary Stat Cards -->
        <div class="news-stats-grid">
            <div class="news-stat-card">
                <div class="news-stat-info">
                    <h3><?=$totalNews;?></h3>
                    <p>Total Bulletins</p>
                </div>
                <div class="news-stat-icon teal">
                    <i class="fa fa-newspaper-o"></i>
                </div>
            </div>

            <div class="news-stat-card">
                <div class="news-stat-info">
                    <h3><?=$liveNews;?></h3>
                    <p>Published Live</p>
                </div>
                <div class="news-stat-icon green">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>

            <div class="news-stat-card">
                <div class="news-stat-info">
                    <h3><?=$videoCount;?> Videos / <?=($totalNews - $videoCount);?> Posters</h3>
                    <p>Media Breakdown</p>
                </div>
                <div class="news-stat-icon purple">
                    <i class="fa fa-video-camera"></i>
                </div>
            </div>
        </div>

        <!-- Filter / Search Bar -->
        <?php if(!empty($news)): ?>
            <div class="news-filter-bar">
                <div class="news-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" id="newsSearchInput" class="news-search-input" placeholder="Search announcements by headline or keywords..." onkeyup="filterNewsCards();">
                </div>
                <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                    Showing <span id="visibleNewsCount"><?=$totalNews;?></span> of <?=$totalNews;?> bulletins
                </div>
            </div>
        <?php endif; ?>

        <!-- News Grid -->
        <?php if(!empty($news)): ?>
            <div class="news-grid-cards" id="newsCardsGrid">
                <?php foreach($news as $p): 
                    $title = !empty($p['title']) ? $p['title'] : (!empty($p['name']) ? $p['name'] : 'Hospital News Announcement');
                    $desc  = !empty($p['description']) ? $p['description'] : '';
                    $hasVideo = !empty($p['video_url']);
                    $imgUrl = !empty($p['image']) ? base_url('admin1947/public/assets/upload/'.$p['image']) : '';
                    $isLive = (isset($p['status']) && ($p['status'] == '1' || $p['status'] == 'A')) && (!isset($p['approved']) || $p['approved'] == '1');
                    $dateFormatted = !empty($p['creat_date']) ? date('M d, Y', strtotime($p['creat_date'])) : '';
                ?>
                    <div class="news-item-card" data-title="<?=strtolower(html_escape($title));?>" data-desc="<?=strtolower(html_escape($desc));?>">
                        
                        <!-- Media Header -->
                        <div class="news-media-wrap" onclick="<?=$hasVideo ? "openVideoModal('".addslashes($p['video_url'])."', '".addslashes(html_escape($title))."');" : (!empty($imgUrl) ? "openPosterModal('".addslashes($imgUrl)."', '".addslashes(html_escape($title))."', '".addslashes(html_escape($desc))."');" : "");?>">
                            <?php if(!empty($imgUrl)): ?>
                                <img src="<?=$imgUrl;?>" alt="<?=html_escape($title);?>" onerror="this.src='<?=base_url();?>images/default-news.jpg';">
                            <?php else: ?>
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #ffffff;">
                                    <i class="fa fa-newspaper-o" style="font-size: 44px; opacity: 0.4; margin-bottom: 6px;"></i>
                                    <span style="font-size: 12px; font-weight: 600; opacity: 0.8;">Press Announcement</span>
                                </div>
                            <?php endif; ?>

                            <?php if($hasVideo): ?>
                                <div class="video-play-btn">
                                    <i class="fa fa-play"></i>
                                </div>
                                <div class="news-media-badge" style="background: rgba(2, 132, 199, 0.85);">
                                    <i class="fa fa-video-camera"></i> Video Stream
                                </div>
                            <?php else: ?>
                                <div class="news-media-badge">
                                    <i class="fa fa-picture-o"></i> Banner Poster
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="news-card-body">
                            <div>
                                <h3 class="news-card-title"><?=html_escape($title);?></h3>
                                <p class="news-card-desc"><?=html_escape($desc);?></p>
                            </div>

                            <?php if(!empty($dateFormatted)): ?>
                                <div class="news-card-meta">
                                    <i class="fa fa-clock-o"></i> Published <?=html_escape($dateFormatted);?>
                                </div>
                            <?php endif; ?>

                            <div class="news-card-footer">
                                <div>
                                    <?php if($isLive): ?>
                                        <span class="badge-news-live"><i class="fa fa-check-circle"></i> Published Live</span>
                                    <?php else: ?>
                                        <span class="badge-news-pending"><i class="fa fa-clock-o"></i> Under Review</span>
                                    <?php endif; ?>
                                </div>

                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <?php if($hasVideo): ?>
                                        <button type="button" class="btn-card-action" style="background: #e0f2fe; color: #0284c7;" onclick="openVideoModal('<?=addslashes($p['video_url']);?>', '<?=addslashes(html_escape($title));?>');">
                                            <i class="fa fa-play-circle"></i> Watch
                                        </button>
                                    <?php elseif(!empty($imgUrl)): ?>
                                        <button type="button" class="btn-card-action" style="background: #e0f2fe; color: #0284c7;" onclick="openPosterModal('<?=addslashes($imgUrl);?>', '<?=addslashes(html_escape($title));?>', '<?=addslashes(html_escape($desc));?>');">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    <?php endif; ?>

                                    <a href="<?=base_url('hospitalpanel/delete_news/'.$p['id']);?>" onclick="return confirm('Are you sure you want to delete this news bulletin?');" class="btn-card-action">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 64px 20px; background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);">
                <div style="width: 72px; height: 72px; background: #ccfbf1; color: #00a896; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 16px auto;">
                    <i class="fa fa-bullhorn"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">No Hospital News or Announcements</h3>
                <p style="font-size: 13.5px; color: #64748b; max-width: 520px; margin: 0 auto 22px auto; line-height: 1.5;">
                    Keep local patients informed by broadcasting free medical camps, community health checkups, visiting super-specialists, and new hospital service inaugurations.
                </p>
                <a href="<?=base_url('hospitalpanel/news');?>" class="btn-add-news">
                    <i class="fa fa-plus-circle"></i> Publish First Announcement
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Video Stream Modal -->
<div class="news-modal" id="videoViewerModal" onclick="if(event.target === this) closeVideoModal();">
    <div class="news-modal-content">
        <div class="modal-media-frame" id="videoFrameContainer">
            <!-- Iframe inserted dynamically -->
        </div>
        <div class="modal-info-body">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 id="videoModalTitle">Video Announcement</h3>
                <button type="button" class="modal-close-btn" onclick="closeVideoModal();">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Poster Modal -->
<div class="news-modal" id="posterModal" onclick="if(event.target === this) closePosterModal();">
    <div class="news-modal-content">
        <div style="max-height: 480px; background: #0f172a; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <img id="posterModalImg" src="" alt="Full view" style="max-height: 480px; width: 100%; object-fit: contain;">
        </div>
        <div class="modal-info-body">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <h3 id="posterModalTitle">Announcement Poster</h3>
                <button type="button" class="modal-close-btn" onclick="closePosterModal();">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
            <p id="posterModalDesc"></p>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function getYouTubeEmbedUrl(url) {
    if (!url) return '';
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[2].length == 11) {
        return 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1';
    }
    // Vimeo check
    var vimeoMatch = url.match(/(?:vimeo)\.com.*(?:videos|video|channels|)\/([\d]+)/i);
    if (vimeoMatch && vimeoMatch[1]) {
        return 'https://player.vimeo.com/video/' + vimeoMatch[1] + '?autoplay=1';
    }
    return url;
}

function openVideoModal(url, title) {
    var embedUrl = getYouTubeEmbedUrl(url);
    var container = document.getElementById('videoFrameContainer');
    container.innerHTML = '<iframe src="' + embedUrl + '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    document.getElementById('videoModalTitle').innerText = title;
    document.getElementById('videoViewerModal').classList.add('show');
}

function closeVideoModal() {
    document.getElementById('videoFrameContainer').innerHTML = '';
    document.getElementById('videoViewerModal').classList.remove('show');
}

function openPosterModal(imgUrl, title, desc) {
    document.getElementById('posterModalImg').src = imgUrl;
    document.getElementById('posterModalTitle').innerText = title;
    document.getElementById('posterModalDesc').innerText = desc;
    document.getElementById('posterModal').classList.add('show');
}

function closePosterModal() {
    document.getElementById('posterModal').classList.remove('show');
}

// Close on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
        closePosterModal();
    }
});

// Client search filter
function filterNewsCards() {
    var filter = document.getElementById('newsSearchInput').value.toLowerCase().trim();
    var cards = document.querySelectorAll('#newsCardsGrid .news-item-card');
    var visible = 0;

    cards.forEach(function(card) {
        var title = card.getAttribute('data-title') || '';
        var desc = card.getAttribute('data-desc') || '';
        if (title.indexOf(filter) > -1 || desc.indexOf(filter) > -1) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    var countElem = document.getElementById('visibleNewsCount');
    if (countElem) countElem.innerText = visible;
}
</script>

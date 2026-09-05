<?php 
$article = !empty($news_details) ? $news_details[0] : null;
$page_title = $article ? htmlspecialchars($article->title) : 'Health Article';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$page_title;?> | Upchar Healthcare</title>
    <meta name="description" content="<?=$article ? htmlspecialchars(substr(strip_tags($article->description), 0, 160)) : 'Healthcare news and insights from Upchar.';?>">
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <style>
        /* Article Page Styles */
        :root {
            --up-navy: #0A2540;
            --up-teal: #00A896;
            --up-teal-hover: #028072;
            --up-light-bg: #F8FAFC;
            --up-border: #E2E8F0;
            --up-slate: #64748B;
            --up-dark: #1E293B;
        }

        body {
            background-color: var(--up-light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--up-dark);
            line-height: 1.6;
        }

        .article-breadcrumbs {
            padding: 16px 0 8px;
            font-size: 13px;
            color: var(--up-slate);
        }
        .article-breadcrumbs a {
            color: var(--up-teal);
            text-decoration: none;
            font-weight: 500;
        }
        .article-breadcrumbs a:hover {
            text-decoration: underline;
        }
        .article-breadcrumbs span {
            margin: 0 8px;
            color: #CBD5E1;
        }

        .article-main-card {
            background: #FFFFFF;
            border: 1px solid var(--up-border);
            border-radius: 16px;
            padding: 32px 36px;
            margin-bottom: 32px;
            box-shadow: 0 4px 20px -2px rgba(10, 37, 64, 0.05);
        }

        .article-meta-header {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .badge-category {
            background: rgba(0, 168, 150, 0.12);
            color: var(--up-teal);
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-verified-info {
            background: #F1F5F9;
            color: var(--up-slate);
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .article-headline {
            font-size: 30px;
            font-weight: 800;
            color: var(--up-navy);
            line-height: 1.3;
            margin: 0 0 20px 0;
            letter-spacing: -0.5px;
        }

        /* Author Strip */
        .article-author-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: #F8FAFC;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .author-info-flex {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--up-teal), #0A2540);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 18px;
            object-fit: cover;
            border: 2px solid #FFFFFF;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .author-details h5 {
            margin: 0;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--up-navy);
        }
        .author-details p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--up-slate);
        }
        .author-consult-btn {
            background: #FFFFFF;
            border: 1px solid var(--up-teal);
            color: var(--up-teal);
            font-size: 12.5px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .author-consult-btn:hover {
            background: var(--up-teal);
            color: #FFFFFF !important;
        }

        /* Media Container */
        .article-media-box {
            margin-bottom: 28px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .article-hero-img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            display: block;
        }
        .article-hero-gradient {
            background: linear-gradient(135deg, #0A2540 0%, #1D2A44 60%, #005F73 100%);
            color: #FFFFFF;
            padding: 44px 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .hero-gradient-icon {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            background: rgba(0, 168, 150, 0.25);
            border: 1px solid rgba(0, 168, 150, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #2DD4BF;
            flex-shrink: 0;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 12px;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Content Typography */
        .article-body-text {
            font-size: 16.5px;
            line-height: 1.8;
            color: #334155;
            margin-bottom: 28px;
        }
        .article-body-text p {
            margin-bottom: 18px;
        }

        /* Key Takeaways Callout */
        .key-takeaway-box {
            background: #F0FDFA;
            border-left: 4px solid var(--up-teal);
            border-radius: 0 12px 12px 0;
            padding: 20px 24px;
            margin: 28px 0;
        }
        .key-takeaway-box h4 {
            margin: 0 0 10px;
            font-size: 16px;
            font-weight: 700;
            color: #0F766E;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .key-takeaway-box ul {
            margin: 0;
            padding-left: 20px;
            color: #134E4A;
            font-size: 14.5px;
        }
        .key-takeaway-box li {
            margin-bottom: 6px;
        }

        /* Share Bar */
        .article-share-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--up-border);
            border-bottom: 1px solid var(--up-border);
            padding: 16px 0;
            margin: 32px 0;
            flex-wrap: wrap;
            gap: 12px;
        }
        .share-label {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--up-navy);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .share-btn-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .share-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF !important;
            font-size: 14px;
            text-decoration: none !important;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .share-icon-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        .btn-whatsapp { background: #25D366; }
        .btn-facebook { background: #1877F2; }
        .btn-twitter  { background: #1DA1F2; }
        .btn-copylink { background: #475569; cursor: pointer; }

        /* Sidebar Cards */
        .sidebar-widget {
            background: #FFFFFF;
            border: 1px solid var(--up-border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(10, 37, 64, 0.04);
        }
        .sidebar-widget-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--up-navy);
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-widget-title i {
            color: var(--up-teal);
        }

        .cta-consult-card {
            background: linear-gradient(135deg, #0A2540 0%, #163859 100%);
            color: #FFFFFF;
            border-radius: 14px;
            padding: 26px 22px;
            margin-bottom: 24px;
            text-align: center;
        }
        .cta-consult-card h4 {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 10px;
        }
        .cta-consult-card p {
            font-size: 13px;
            color: #CBD5E1;
            margin-bottom: 18px;
            line-height: 1.5;
        }
        .btn-cta-doctors {
            background: var(--up-teal);
            color: #FFFFFF !important;
            font-weight: 700;
            font-size: 13.5px;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            text-decoration: none !important;
            width: 100%;
            transition: background 0.2s ease;
        }
        .btn-cta-doctors:hover {
            background: var(--up-teal-hover);
        }

        /* Recent News List in Sidebar */
        .recent-news-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #F1F5F9;
            text-decoration: none !important;
        }
        .recent-news-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .recent-news-thumb {
            width: 65px;
            height: 60px;
            border-radius: 8px;
            background: #E2E8F0;
            object-fit: cover;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--up-teal);
            font-size: 20px;
        }
        .recent-news-info h6 {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 700;
            color: var(--up-navy);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .recent-news-info p {
            margin: 0;
            font-size: 11.5px;
            color: var(--up-slate);
        }
        .recent-news-item:hover h6 {
            color: var(--up-teal);
        }

        /* Helpline Widget */
        .helpline-box {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .helpline-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #F59E0B;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .helpline-text h6 {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: #92400E;
            text-transform: uppercase;
        }
        .helpline-text p {
            margin: 2px 0 0;
            font-size: 16px;
            font-weight: 800;
            color: #78350F;
        }
        .helpline-text p a {
            color: inherit;
            text-decoration: none;
        }

        /* Empty / 404 state */
        .article-not-found {
            text-align: center;
            padding: 60px 20px;
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid var(--up-border);
        }
        .article-not-found i {
            font-size: 54px;
            color: #CBD5E1;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
<?php include ("includes/header.php"); ?>
<div class="clearfix"></div>

<!-- Search Bar -->
<form action='<?=base_url('search');?>' method='GET'>
    <div class="box-form">
        <div class="col-sm-2 col-sm-offset-1">
            <div class="input-group shadow">
                <span class="input-group-addon"><i class="fa fa-map-marker">&nbsp;&nbsp;</i></span>
                <input type="text" class="form-control ui-autocomplete-input" name="location" placeholder="Location" id="hintcity" autocomplete="off">
                <input type="hidden" class="form-control" name="city" id="city">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="input-group shadow">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" placeholder="Search Hospitals/Doctors/Clinics etc" autocomplete="off">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group shadow">
                <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                <select class="form-control" name="spl">
                    <option value="">-Specialization-</option>
                    <?php if(!empty($specialization)){ foreach($specialization as $s){ ?>
                    <option value='<?=$s->id;?>'><?=$s->name;?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-1">
            <button class="careplus-booking-btn careplus-bgcolor-two" id="searchBTN" style="width: 100%; border: none; background: #043d5b; color: white; padding: 12px;"><i class="fa fa-search"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<div class="container" style="margin-top: 15px; margin-bottom: 40px;">
    <!-- Breadcrumbs -->
    <div class="article-breadcrumbs">
        <a href="<?=base_url();?>"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="<?=base_url('news');?>">Health Insights &amp; Updates</a>
        <span>/</span>
        <strong><?=htmlspecialchars(substr($page_title, 0, 45));?><?=strlen($page_title)>45?'...':'';?></strong>
    </div>

    <?php if ($article): ?>
    <div class="row">
        <!-- Main Article Column (8 Cols) -->
        <div class="col-lg-8 col-md-8 col-sm-12">
            <article class="article-main-card">
                <!-- Meta tags / category -->
                <div class="article-meta-header">
                    <span class="badge-category">
                        <i class="fas fa-heartbeat"></i> Preventive Healthcare
                    </span>
                    <span class="badge-verified-info">
                        <i class="far fa-calendar-alt"></i> <?=date('M d, Y', strtotime($article->creat_date ?: 'now'));?>
                    </span>
                    <span class="badge-verified-info">
                        <i class="far fa-clock"></i> ~2 min read
                    </span>
                    <span class="badge-verified-info" style="color: #0d9488; background: #f0fdfa;">
                        <i class="fas fa-shield-alt"></i> Medically Verified
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="article-headline"><?=htmlspecialchars($article->title);?></h1>

                <!-- Author Profile Byline -->
                <div class="article-author-bar">
                    <div class="author-info-flex">
                        <?php if(!empty($author_doctor) && !empty($author_doctor->drimage) && file_exists('uploads/'.$author_doctor->drimage)): ?>
                            <img src="<?=base_url('uploads/'.$author_doctor->drimage);?>" alt="Doctor" class="author-avatar">
                        <?php else: ?>
                            <div class="author-avatar"><i class="fas fa-user-md"></i></div>
                        <?php endif; ?>
                        
                        <div class="author-details">
                            <h5>
                                <?php if(!empty($author_doctor)): ?>
                                    Dr. <?=htmlspecialchars($author_doctor->fname . ' ' . $author_doctor->lname);?>
                                    <?php if(!empty($author_doctor->degree)): ?><small style="color: #64748b; font-weight: 500;">(<?=htmlspecialchars($author_doctor->degree);?>)</small><?php endif; ?>
                                <?php elseif(!empty($author_hospital)): ?>
                                    <?=htmlspecialchars($author_hospital->institute_name ?: 'Partner Hospital');?>
                                <?php else: ?>
                                    Upchar Editorial Medical Team
                                <?php endif; ?>
                            </h5>
                            <p>
                                <?php if(!empty($author_doctor)): ?>
                                    Specialist in <?=htmlspecialchars($author_doctor->specialization ?: 'General Healthcare');?> &bull; Verified Doctor
                                <?php elseif(!empty($author_hospital)): ?>
                                    Accredited Healthcare Institution
                                <?php else: ?>
                                    Verified Clinical Guidelines &bull; Upchar Network
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <?php if(!empty($author_doctor)): ?>
                        <a href="<?=base_url('doctor/'.$author_doctor->id);?>" class="author-consult-btn">
                            <i class="fas fa-calendar-check"></i> Book Doctor
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Media Visual (Hero Image / Video / Healthcare Banner) -->
                <div class="article-media-box">
                    <?php 
                    $has_custom_image = !empty($article->image) && file_exists('admin1947/public/assets/upload/' . $article->image);
                    ?>

                    <?php if ($article->type == '2' && !empty($article->video_url)): ?>
                        <!-- Video Embed -->
                        <div class="video-container">
                            <iframe src="<?=htmlspecialchars($article->video_url);?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php elseif ($has_custom_image): ?>
                        <!-- Uploaded Hero Image -->
                        <img src="<?=admin_url('public/assets/upload/' . $article->image);?>" alt="<?=htmlspecialchars($article->title);?>" class="article-hero-img">
                    <?php else: ?>
                        <!-- Stylized Modern Healthcare Banner -->
                        <div class="article-hero-gradient">
                            <div class="hero-gradient-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div>
                                <h3 style="margin: 0 0 6px; font-size: 20px; font-weight: 700; color: #FFFFFF;">Upchar Health &amp; Wellness Insights</h3>
                                <p style="margin: 0; color: #94A3B8; font-size: 13.5px;">Trusted medical guidance published for patient health education and preventive care.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Article Body Content -->
                <div class="article-body-text">
                    <?=nl2br(htmlspecialchars($article->description));?>
                </div>

                <!-- Key Takeaways Callout -->
                <div class="key-takeaway-box">
                    <h4><i class="fas fa-clipboard-check"></i> Clinical Takeaways &amp; Next Steps</h4>
                    <ul>
                        <li>Prioritize regular screenings and routine vitals monitoring (BP, Blood Sugar, Cholesterol).</li>
                        <li>Maintain consistency with balanced hydration, low sodium, and 30 minutes of daily cardio exercise.</li>
                        <li>Seek prompt medical evaluation if you experience persistent symptoms, chest tightness, or chronic fatigue.</li>
                    </ul>
                </div>

                <!-- Social Share Bar -->
                <?php 
                $share_url = current_url();
                $share_text = rawurlencode($article->title . ' - Upchar Healthcare');
                ?>
                <div class="article-share-strip">
                    <div class="share-label">
                        <i class="fas fa-share-alt" style="color: var(--up-teal);"></i> Share this medical update:
                    </div>
                    <div class="share-btn-group">
                        <a href="https://api.whatsapp.com/send?text=<?=$share_text;?>%20<?=$share_url;?>" target="_blank" class="share-icon-btn btn-whatsapp" title="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$share_url;?>" target="_blank" class="share-icon-btn btn-facebook" title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?=$share_text;?>&url=<?=$share_url;?>" target="_blank" class="share-icon-btn btn-twitter" title="Share on X">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <button type="button" class="share-icon-btn btn-copylink" id="btnCopyArticleLink" title="Copy Link" onclick="navigator.clipboard.writeText('<?=$share_url;?>'); alert('Article link copied to clipboard!');">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>

                <!-- Return Button -->
                <div>
                    <a href="<?=base_url('news');?>" style="color: var(--up-teal); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-arrow-left"></i> View All Healthcare Articles &amp; News
                    </a>
                </div>
            </article>
        </div>

        <!-- Sidebar Column (4 Cols) -->
        <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- 1. Specialist Consultation Card -->
            <div class="cta-consult-card">
                <i class="fas fa-user-md" style="font-size: 36px; color: #2DD4BF; margin-bottom: 12px; display: inline-block;"></i>
                <h4>Need Specialist Advice?</h4>
                <p>Consult verified cardiologists, physicians, and surgeons on the Upchar network with instant appointment scheduling.</p>
                <a href="<?=base_url('doctors');?>" class="btn-cta-doctors">
                    <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Find Top Doctors Near You
                </a>
            </div>

            <!-- 2. Recent Health Updates -->
            <?php if (!empty($recent_news)): ?>
            <div class="sidebar-widget">
                <h4 class="sidebar-widget-title">
                    <i class="fas fa-newspaper"></i> Recent Health Articles
                </h4>
                <div>
                    <?php foreach($recent_news as $r_item): ?>
                    <a href="<?=base_url('news/' . mybase64_encode($r_item->id));?>" class="recent-news-item">
                        <div class="recent-news-thumb">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <div class="recent-news-info">
                            <h6><?=htmlspecialchars($r_item->title);?></h6>
                            <p><i class="far fa-calendar-alt"></i> <?=date('M d, Y', strtotime($r_item->creat_date ?: 'now'));?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- 3. Emergency & Support -->
            <div class="sidebar-widget">
                <div class="helpline-box">
                    <div class="helpline-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="helpline-text">
                        <h6>24/7 Patient Care Helpline</h6>
                        <p><a href="tel:8448440603">844-844-0603</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- 404 / Missing State -->
    <div class="article-not-found">
        <i class="fas fa-newspaper"></i>
        <h2 style="font-weight: 800; color: #0A2540; margin-bottom: 8px;">Article Not Found</h2>
        <p style="color: #64748B; max-width: 480px; margin: 0 auto 20px;">The healthcare article you are looking for may have been archived or is no longer available.</p>
        <a href="<?=base_url('news');?>" class="careplus-booking-btn careplus-bgcolor-two" style="background: #00A896; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Browse All Health Articles
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Universal Modern Footer -->
<?php include ('includes/footer.php'); ?>
<div class="clearfix"></div>

</body>
</html>
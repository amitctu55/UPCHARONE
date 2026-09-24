<div class="container py-5" style="padding-top: 40px; padding-bottom: 60px;">
  <div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12" style="margin: 0 auto; float: none;">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4" style="margin-bottom: 20px;">
        <ol class="breadcrumb small" style="background: transparent; padding: 0; margin-bottom: 0; font-size: 13px;">
          <li class="breadcrumb-item" style="display: inline-block;"><a href="<?= base_url(); ?>" class="text-decoration-none" style="color: #64748b; text-decoration: none;">Home</a> <span style="margin: 0 6px; color: #cbd5e1;">/</span></li>
          <li class="breadcrumb-item" style="display: inline-block;"><a href="<?= base_url('blog'); ?>" class="text-decoration-none" style="color: #64748b; text-decoration: none;">Blog</a> <span style="margin: 0 6px; color: #cbd5e1;">/</span></li>
          <li class="breadcrumb-item active" style="display: inline-block; color: #00a896; font-weight: 600;"><?= html_escape($post['category_name']); ?></li>
        </ol>
      </nav>

      <!-- Post Header -->
      <div class="mb-4" style="margin-bottom: 25px;">
        <a href="<?= base_url('blog/category/' . $post['category_slug']); ?>" class="badge bg-primary-subtle text-primary text-decoration-none px-3 py-2 rounded-pill mb-2" style="display: inline-block; background: #e0f2fe; color: #0284c7; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 12px; text-decoration: none; margin-bottom: 12px;">
          <i class="fas fa-tag" style="margin-right: 4px;"></i> <?= html_escape($post['category_name']); ?>
        </a>
        <h1 class="fw-bold display-6 text-dark mt-2 mb-3" style="font-weight: 800; font-size: 32px; line-height: 1.3; color: #0f172a; margin-top: 8px; margin-bottom: 16px;">
          <?= html_escape($post['title']); ?>
        </h1>
        <div class="d-flex align-items-center gap-3 text-muted small" style="display: flex; align-items: center; gap: 15px; color: #64748b; font-size: 13px;">
          <span><i class="fas fa-user-circle me-1 text-primary" style="color: #00a896; margin-right: 5px;"></i> UPCHAR Medical Team</span>
          <span>&bull;</span>
          <span><i class="far fa-calendar-alt me-1" style="margin-right: 5px;"></i> <?= date('M d, Y', strtotime($post['created_at'])); ?></span>
          <span>&bull;</span>
          <span><i class="fas fa-eye me-1" style="margin-right: 5px;"></i> <?= (int)$post['views_count']; ?> views</span>
        </div>
      </div>

      <!-- Featured Image -->
      <?php if (!empty($post['featured_image'])): ?>
        <div class="mb-4 rounded-3 overflow-hidden shadow-sm" style="border-radius: 12px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
          <img src="<?= base_url('uploads/blog/' . $post['featured_image']); ?>" class="img-fluid w-100" alt="<?= html_escape($post['title']); ?>" style="width: 100%; max-height: 440px; object-fit: cover; display: block;">
        </div>
      <?php endif; ?>

      <!-- Article Rich Content -->
      <article class="article-content lh-lg text-dark mb-5" style="font-size: 16px; line-height: 1.8; color: #334155; margin-bottom: 45px;">
        <?= $post['content']; ?>
      </article>

      <!-- Hospital Consultation Banner -->
      <div class="card border-0 shadow-sm bg-light rounded-3 p-4 mb-5" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 25px; margin-bottom: 35px;">
        <div class="row align-items-center" style="display: flex; flex-wrap: wrap; align-items: center;">
          <div class="col-md-8 col-sm-12" style="margin-bottom: 15px;">
            <h4 class="fw-bold mb-1" style="font-weight: 700; font-size: 18px; color: #0f172a; margin-top: 0; margin-bottom: 6px;">
              <i class="fas fa-stethoscope text-primary" style="color: #00a896; margin-right: 8px;"></i> Need to speak with a verified doctor?
            </h4>
            <p class="text-muted small mb-md-0" style="color: #64748b; font-size: 13px; margin: 0;">
              Book OPD slots, consult specialists online, or book diagnostic tests with zero clinic wait time on UPCHAR.
            </p>
          </div>
          <div class="col-md-4 col-sm-12 text-md-end" style="text-align: right;">
            <a href="<?= base_url('doctors'); ?>" class="btn btn-primary fw-bold px-4 py-2" style="background: #00a896; border: none; font-weight: 700; border-radius: 8px; padding: 10px 20px; font-size: 14px; color: #ffffff; text-decoration: none; display: inline-block;">
              Find Doctors &rarr;
            </a>
          </div>
        </div>
      </div>

      <!-- Categories & Sharing Footer -->
      <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="<?= base_url('blog'); ?>" class="text-decoration-none text-muted" style="color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none;">
          &larr; Back to all articles
        </a>
        <a href="<?= base_url('blog/category/' . $post['category_slug']); ?>" class="btn btn-sm btn-outline-secondary" style="border: 1px solid #cbd5e1; color: #475569; border-radius: 6px; padding: 6px 12px; font-size: 12px; text-decoration: none;">
          More in <?= html_escape($post['category_name']); ?>
        </a>
      </div>
    </div>
  </div>
</div>

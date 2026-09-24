<div class="container py-5" style="padding-top: 40px; padding-bottom: 60px;">
  <!-- Page Header -->
  <div class="row mb-5 text-center" style="margin-bottom: 35px;">
    <div class="col-lg-8 col-md-10 col-sm-12" style="margin: 0 auto; float: none;">
      <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill mb-2" style="display: inline-block; background: #e0f2fe; color: #0284c7; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 12px; letter-spacing: 0.5px; margin-bottom: 12px;">UPCHAR HEALTH KNOWLEDGE</span>
      <h1 class="fw-bold text-dark" style="font-weight: 800; font-size: 32px; color: #0f172a; margin-top: 5px; margin-bottom: 10px;">
        <?= isset($current_category) ? html_escape($current_category['name']) : 'Latest Health & Medical Insights'; ?>
      </h1>
      <p class="text-muted" style="color: #64748b; font-size: 15px; max-width: 650px; margin: 0 auto;">
        <?= isset($current_category) ? html_escape($current_category['description']) : 'Expert medical advice, emergency tips, and health guides for Tier-2 and Tier-3 communities.'; ?>
      </p>
    </div>
  </div>

  <div class="row g-4">
    <!-- Left: Main Post Grid -->
    <div class="col-lg-8 col-md-8 col-sm-12">
      <?php if (!empty($posts)): ?>
        <div class="row g-4">
          <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-sm-6" style="margin-bottom: 30px;">
              <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden d-flex flex-column" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04); display: flex; flex-direction: column; height: 100%; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <?php if (!empty($post['featured_image'])): ?>
                  <a href="<?= base_url('blog/' . $post['slug']); ?>">
                    <img src="<?= base_url('uploads/blog/' . $post['featured_image']); ?>" class="card-img-top" alt="<?= html_escape($post['title']); ?>" style="height: 200px; width: 100%; object-fit: cover;">
                  </a>
                <?php else: ?>
                  <a href="<?= base_url('blog/' . $post['slug']); ?>" style="text-decoration: none;">
                    <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center;">
                      <i class="fas fa-notes-medical fa-3x" style="color: #94a3b8; font-size: 48px;"></i>
                    </div>
                  </a>
                <?php endif; ?>

                <div class="card-body d-flex flex-column" style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                  <div class="d-flex justify-content-between align-items-center mb-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <a href="<?= base_url('blog/category/' . $post['category_slug']); ?>" class="badge bg-info-subtle text-info text-decoration-none px-2 py-1 rounded" style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-decoration: none;">
                      <?= html_escape($post['category_name']); ?>
                    </a>
                    <small class="text-muted" style="color: #94a3b8; font-size: 12px;"><i class="far fa-calendar-alt me-1"></i> <?= date('M d, Y', strtotime($post['created_at'])); ?></small>
                  </div>

                  <h4 class="card-title fw-bold" style="font-weight: 700; font-size: 18px; line-height: 1.4; margin-top: 0; margin-bottom: 10px;">
                    <a href="<?= base_url('blog/' . $post['slug']); ?>" class="text-dark text-decoration-none" style="color: #1e293b; text-decoration: none;">
                      <?= html_escape($post['title']); ?>
                    </a>
                  </h4>

                  <p class="card-text text-secondary small flex-grow-1" style="color: #64748b; font-size: 13px; line-height: 1.6; margin-bottom: 16px; flex-grow: 1;">
                    <?= !empty($post['excerpt']) ? html_escape(character_limiter($post['excerpt'], 100)) : html_escape(character_limiter(strip_tags($post['content']), 100)); ?>
                  </p>

                  <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center" style="border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= base_url('blog/' . $post['slug']); ?>" class="text-primary small fw-semibold" style="color: #00a896; font-weight: 700; font-size: 13px; text-decoration: none;">
                      Read Article &rarr;
                    </a>
                    <small class="text-muted" style="color: #94a3b8; font-size: 12px;"><i class="fas fa-eye me-1"></i> <?= (int)$post['views_count']; ?></small>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-5 text-center" style="margin-top: 30px;">
          <?= $pagination; ?>
        </div>

      <?php else: ?>
        <div class="alert alert-light border text-center p-5 rounded-3" style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 50px 20px; text-align: center;">
          <i class="fas fa-newspaper fa-3x text-muted mb-3" style="color: #94a3b8; font-size: 48px; margin-bottom: 15px;"></i>
          <h4 style="color: #334155; font-weight: 700;">No Articles Found</h4>
          <p class="text-muted mb-0" style="color: #64748b;">Check back later or browse other medical topics from the sidebar.</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-4 col-md-4 col-sm-12">
      <!-- 24/7 Emergency Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4 text-white" style="background: linear-gradient(135deg, #08364B 0%, #00a896 100%); border-radius: 12px; color: #ffffff; padding: 24px; margin-bottom: 25px; box-shadow: 0 10px 25px -5px rgba(0, 168, 150, 0.3);">
        <div class="card-body p-0">
          <h4 class="fw-bold" style="font-weight: 800; font-size: 20px; color: #ffffff; margin-top: 0; margin-bottom: 8px;">
            <i class="fas fa-ambulance me-2" style="margin-right: 8px;"></i>Medical Emergency?
          </h4>
          <p class="small opacity-75" style="opacity: 0.9; font-size: 13px; line-height: 1.5; margin-bottom: 18px;">
            Dispatch verified ambulances (108 SOS) and connect with ICU trauma wards instantly.
          </p>
          <a href="tel:108" class="btn btn-danger fw-bold rounded-pill w-100" style="background: #ef4444; border: none; font-weight: 700; width: 100%; border-radius: 30px; padding: 12px; font-size: 15px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4); display: block; text-align: center; text-decoration: none; color: #fff;">
            <i class="fas fa-phone-alt"></i> Call 108 SOS Ambulance
          </a>
        </div>
      </div>

      <!-- Categories Card -->
      <div class="card border-0 shadow-sm rounded-3 mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 25px;">
        <div class="card-header bg-white py-3 border-0" style="background: #ffffff; padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
          <h5 class="fw-bold mb-0 text-dark" style="font-weight: 800; font-size: 16px; margin: 0; color: #1e293b;">
            <i class="fas fa-folder-open text-primary" style="color: #00a896; margin-right: 8px;"></i> Medical Topics
          </h5>
        </div>
        <ul class="list-group list-group-flush" style="margin: 0; padding: 0; list-style: none;">
          <li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?= base_url('blog'); ?>" class="text-decoration-none text-dark <?= !isset($current_category) ? 'fw-bold text-primary' : ''; ?>" style="color: <?= !isset($current_category) ? '#00a896' : '#334155'; ?>; font-weight: <?= !isset($current_category) ? '700' : '500'; ?>; text-decoration: none;">
              All Articles
            </a>
          </li>
          <?php if (!empty($categories)): foreach ($categories as $cat): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
              <a href="<?= base_url('blog/category/' . $cat['slug']); ?>" class="text-decoration-none text-dark <?= (isset($current_category) && $current_category['id'] == $cat['id']) ? 'fw-bold text-primary' : ''; ?>" style="color: <?= (isset($current_category) && $current_category['id'] == $cat['id']) ? '#00a896' : '#334155'; ?>; font-weight: <?= (isset($current_category) && $current_category['id'] == $cat['id']) ? '700' : '500'; ?>; text-decoration: none;">
                <?= html_escape($cat['name']); ?>
              </a>
              <span class="badge bg-light text-secondary rounded-pill" style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700;"><?= $cat['total_posts']; ?></span>
            </li>
          <?php endforeach; endif; ?>
        </ul>
      </div>

      <!-- Quick Doctor Booking Banner -->
      <div class="card border-0 shadow-sm rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
        <h5 style="font-weight: 700; font-size: 15px; color: #0f172a; margin-top: 0; margin-bottom: 8px;">
          <i class="fas fa-user-md" style="color: #00a896; margin-right: 6px;"></i> Consult Certified Doctors
        </h5>
        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 14px;">
          Book in-clinic appointments or online video consultations with top verified specialists.
        </p>
        <a href="<?= base_url('doctors'); ?>" class="btn btn-sm btn-outline-primary" style="color: #00a896; border: 1px solid #00a896; border-radius: 6px; font-weight: 600; padding: 8px 14px; text-decoration: none; display: inline-block;">
          Find Doctors Near You &rarr;
        </a>
      </div>
    </div>
  </div>
</div>

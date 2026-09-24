<div class="container-fluid py-4" style="padding: 30px 20px;">
  <div class="row">
    <div class="col-12 col-md-12">
      <div class="card border-0 shadow-sm rounded-3" style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center" style="background: #ffffff; padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
          <h4 class="fw-bold mb-0" style="margin: 0; font-weight: 800; font-size: 18px; color: #0f172a;">
            <i class="fas fa-newspaper" style="color: #00a896; margin-right: 8px;"></i> Manage Blog Posts
          </h4>
          <a href="<?= base_url('admin/blog/create'); ?>" class="btn btn-primary btn-sm fw-bold" style="background: #00a896; border: none; border-radius: 6px; padding: 8px 16px; font-weight: 700; color: #ffffff; text-decoration: none;">
            <i class="fas fa-plus"></i> Add New Article
          </a>
        </div>

        <div class="card-body p-4" style="padding: 24px;">
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" style="border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
              <i class="fas fa-check-circle me-1"></i> <?= $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($posts)): ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                  <tr style="border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 13px; text-transform: uppercase;">
                    <th style="padding: 12px;">Image</th>
                    <th style="padding: 12px;">Title</th>
                    <th style="padding: 12px;">Category</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Views</th>
                    <th style="padding: 12px;">Published On</th>
                    <th style="padding: 12px; text-align: right;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($posts as $post): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                      <td style="padding: 12px; vertical-align: middle;">
                        <?php if (!empty($post['featured_image'])): ?>
                          <img src="<?= base_url('uploads/blog/' . $post['featured_image']); ?>" style="width: 50px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;" alt="Thumb">
                        <?php else: ?>
                          <div style="width: 50px; height: 40px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fas fa-image"></i>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td style="padding: 12px; vertical-align: middle;">
                        <a href="<?= base_url('blog/' . $post['slug']); ?>" target="_blank" style="font-weight: 700; color: #0f172a; text-decoration: none; font-size: 14px;">
                          <?= html_escape($post['title']); ?>
                        </a>
                        <div style="font-size: 11px; color: #94a3b8;"><?= html_escape($post['slug']); ?></div>
                      </td>
                      <td style="padding: 12px; vertical-align: middle;">
                        <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                          <?= html_escape($post['category_name'] ?: 'Uncategorized'); ?>
                        </span>
                      </td>
                      <td style="padding: 12px; vertical-align: middle;">
                        <?php if ($post['status'] === 'published'): ?>
                          <span class="badge" style="background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Published</span>
                        <?php else: ?>
                          <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Draft</span>
                        <?php endif; ?>
                      </td>
                      <td style="padding: 12px; vertical-align: middle; color: #64748b; font-size: 13px;">
                        <i class="fas fa-eye me-1"></i> <?= (int)$post['views_count']; ?>
                      </td>
                      <td style="padding: 12px; vertical-align: middle; color: #64748b; font-size: 13px;">
                        <?= date('M d, Y', strtotime($post['created_at'])); ?>
                      </td>
                      <td style="padding: 12px; vertical-align: middle; text-align: right;">
                        <a href="<?= base_url('admin/blog/edit/' . $post['id']); ?>" class="btn btn-sm btn-outline-primary" style="padding: 4px 10px; font-size: 12px; border-radius: 4px; border: 1px solid #00a896; color: #00a896; text-decoration: none; margin-right: 4px;">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('admin/blog/delete/' . $post['id']); ?>" onclick="return confirm('Are you sure you want to delete this article?');" class="btn btn-sm btn-outline-danger" style="padding: 4px 10px; font-size: 12px; border-radius: 4px; border: 1px solid #ef4444; color: #ef4444; text-decoration: none;">
                          <i class="fas fa-trash"></i> Delete
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-center">
              <?= $pagination; ?>
            </div>
          <?php else: ?>
            <div class="text-center py-5" style="padding: 40px 0;">
              <i class="fas fa-newspaper fa-3x text-muted mb-3" style="color: #94a3b8; font-size: 48px; margin-bottom: 12px;"></i>
              <h5 style="color: #475569; font-weight: 700;">No articles created yet</h5>
              <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">Create your first medical article to share clinical insights with patients.</p>
              <a href="<?= base_url('admin/blog/create'); ?>" class="btn btn-primary" style="background: #00a896; border: none; font-weight: 700; border-radius: 6px; padding: 10px 20px; color: #fff; text-decoration: none;">
                Create First Article
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

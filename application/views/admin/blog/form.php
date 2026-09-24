<div class="container-fluid py-4" style="padding: 30px 20px;">
  <div class="row justify-content-center" style="display: flex; justify-content: center;">
    <div class="col-lg-10 col-md-11 col-sm-12">
      <div class="card border-0 shadow-sm rounded-3" style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center" style="background: #ffffff; padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
          <h4 class="fw-bold mb-0" style="margin: 0; font-weight: 800; font-size: 18px; color: #0f172a;">
            <?= isset($post) ? 'Edit Post' : 'Create New Post'; ?>
          </h4>
          <a href="<?= base_url('admin/blog'); ?>" class="btn btn-sm btn-outline-secondary" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 14px; font-weight: 600; color: #475569; text-decoration: none;">
            &larr; Back to Posts
          </a>
        </div>

        <div class="card-body p-4" style="padding: 24px;">
          <?php if (validation_errors()): ?>
            <div class="alert alert-danger" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
              <?= validation_errors(); ?>
            </div>
          <?php endif; ?>

          <?= form_open_multipart(isset($post) ? 'admin/blog/update/' . $post['id'] : 'admin/blog/store'); ?>

          <!-- Title -->
          <div class="form-group mb-3" style="margin-bottom: 18px;">
            <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Article Title <span class="text-danger" style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 14px; width: 100%; font-size: 14px;" value="<?= html_escape(set_value('title', isset($post) ? $post['title'] : '')); ?>" placeholder="e.g. 5 Warning Signs of Cardiovascular Strain" required>
          </div>

          <div class="row g-3 mb-3" style="margin-bottom: 18px; display: flex; flex-wrap: wrap; margin-left: -10px; margin-right: -10px;">
            <!-- Category -->
            <div class="col-md-6 col-sm-12" style="padding-left: 10px; padding-right: 10px; margin-bottom: 15px;">
              <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Category <span class="text-danger" style="color: #ef4444;">*</span></label>
              <select name="category_id" class="form-control form-select" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 14px; width: 100%; font-size: 14px;" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id']; ?>" <?= set_select('category_id', $cat['id'], (isset($post) && $post['category_id'] == $cat['id'])); ?>>
                    <?= html_escape($cat['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-sm-12" style="padding-left: 10px; padding-right: 10px; margin-bottom: 15px;">
              <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Publishing Status <span class="text-danger" style="color: #ef4444;">*</span></label>
              <select name="status" class="form-control form-select" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 14px; width: 100%; font-size: 14px;" required>
                <option value="draft" <?= set_select('status', 'draft', (isset($post) && $post['status'] == 'draft')); ?>>Draft</option>
                <option value="published" <?= set_select('status', 'published', (isset($post) && $post['status'] == 'published')); ?>>Published</option>
              </select>
            </div>
          </div>

          <!-- Featured Image -->
          <div class="form-group mb-3" style="margin-bottom: 18px;">
            <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Featured Image</label>
            <input type="file" name="featured_image" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 8px 12px; width: 100%;" accept="image/*">
            <?php if (!empty($post['featured_image'])): ?>
              <div class="mt-2" style="margin-top: 10px; display: flex; align-items: center;">
                <img src="<?= base_url('uploads/blog/' . $post['featured_image']); ?>" height="80" class="rounded border" style="height: 80px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;" alt="Current Image">
                <small class="text-muted ms-2" style="margin-left: 10px; color: #64748b;">Current Image</small>
              </div>
            <?php endif; ?>
          </div>

          <!-- Excerpt -->
          <div class="form-group mb-3" style="margin-bottom: 18px;">
            <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Short Excerpt (SEO Summary)</label>
            <textarea name="excerpt" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 14px; width: 100%; font-size: 14px;" rows="2" placeholder="Brief summary of 120-160 characters for search rankings"><?= html_escape(set_value('excerpt', isset($post) ? $post['excerpt'] : '')); ?></textarea>
          </div>

          <!-- Rich Text Content (TinyMCE Ready) -->
          <div class="form-group mb-4" style="margin-bottom: 25px;">
            <label class="form-label fw-bold" style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Article Content <span class="text-danger" style="color: #ef4444;">*</span></label>
            <textarea id="editor" name="content" class="form-control" rows="14" style="border-radius: 8px; border: 1px solid #cbd5e1; width: 100%;"><?= set_value('content', isset($post) ? $post['content'] : ''); ?></textarea>
          </div>

          <div class="d-flex justify-content-end gap-2" style="display: flex; justify-content: flex-end; gap: 10px;">
            <a href="<?= base_url('admin/blog'); ?>" class="btn btn-light border px-4" style="border: 1px solid #cbd5e1; background: #f8fafc; border-radius: 8px; padding: 10px 20px; font-weight: 600; text-decoration: none; color: #475569;">Cancel</a>
            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #00a896; border: none; border-radius: 8px; padding: 10px 24px; font-weight: 700; color: #ffffff;">
              <i class="fas fa-save me-1"></i> Save Article
            </button>
          </div>

          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TinyMCE Script Hook -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  if (typeof tinymce !== 'undefined') {
    tinymce.init({
      selector: '#editor',
      plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
      toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
      height: 420
    });
  }
</script>

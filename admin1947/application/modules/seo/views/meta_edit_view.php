<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit SEO Meta Tag
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Modify metadata, SEO titles, descriptions, and keywords for this target page URL</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url();?>seo/meta/index" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to SEO List
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 850px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-pencil-square-o" style="color: #0d9488; margin-right: 8px;"></i> Update Meta Information
        </h3>
      </div>

      <?php echo form_open(current_url_query_string(), 'id="form" style="padding: 24px;"');?>  
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Target Page URL Slug <span style="color: #EF4444;">*</span>
            </label>
            <div style="display: flex; align-items: center; border-radius: 8px; border: 1px solid #CBD5E1; overflow: hidden; height: 42px;">
              <span style="background: #F8FAFC; border-right: 1px solid #E2E8F0; padding: 0 14px; color: #64748B; font-size: 13px; font-family: monospace; line-height: 42px;">
                https://www.upcharr.com/
              </span>
              <input type="text" name="page_url" class="form-control" value="<?php echo set_value('page_url', isset($res['page_url']) ? $res['page_url'] : '');?>" placeholder="page-slug" style="border: none; box-shadow: none; height: 100%; font-size: 14px; padding: 0 14px;">
            </div>
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('page_url');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Meta Title Tag <span style="color: #EF4444;">*</span>
            </label>
            <textarea name="meta_title" rows="2" class="form-control" id="title" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?php echo set_value('meta_title', isset($res['meta_title']) ? $res['meta_title'] : '');?></textarea>		
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('meta_title');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Meta Description Tag <span style="color: #EF4444;">*</span>
            </label>
            <textarea name="meta_description" rows="4" class="form-control" id="description" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?php echo set_value('meta_description', isset($res['meta_description']) ? $res['meta_description'] : '');?></textarea>
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('meta_description');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Meta Keywords (Comma separated) <span style="color: #EF4444;">*</span>
            </label>
            <textarea name="meta_keyword" rows="3" class="form-control" id="keyword" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?php echo set_value('meta_keyword', isset($res['meta_keyword']) ? $res['meta_keyword'] : '');?></textarea>
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('meta_keyword');?></span>
          </div>

          <input type="hidden" name="meta_id" value="<?php echo isset($res['meta_id']) ? $res['meta_id'] : '';?>" />

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="submit" name="sub" value="Save" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Save Meta Changes
            </button>
          </div>
        </div>
      <?php echo form_close(); ?>
    </div>
  </section>
</div>

<?=$this->load->view('inc/footer');?>
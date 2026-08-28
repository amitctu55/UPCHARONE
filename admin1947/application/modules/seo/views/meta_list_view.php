<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          SEO & Meta Tags Management
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage search engine metadata, page titles, descriptions, and keywords across platform URLs</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url();?>seo/meta/add" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; box-shadow: 0 2px 4px rgba(13,148,136,0.25);">
          <i class="fa fa-plus"></i> Add New Meta Tag
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <!-- Filter Bar Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 18px 20px; margin-bottom: 20px;">
      <?php echo form_open("seo/meta/index", 'id="search_form" method="get" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;"'); ?>
        <div style="min-width: 140px;">
          <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Records Per Page</label>
          <div style="height: 38px;">
            <?php echo display_record_per_page();?>
          </div>
        </div>

        <div style="flex: 1; min-width: 240px;">
          <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Search Meta Title / URL</label>
          <input type="text" class="form-control" name="meta_title" value="<?php echo $this->input->get_post('meta_title');?>" placeholder="Filter by title..." style="height: 38px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
        </div>

        <div style="display: flex; gap: 8px;">
          <button type="submit" class="btn" style="height: 38px; background: #0d9488; color: #fff; font-weight: 600; padding: 0 16px; border-radius: 8px; border: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
            <i class="fa fa-search"></i> Filter
          </button>
          <?php if($this->input->get_post('meta_title') != '') { ?>
            <a href="<?=base_url();?>seo/meta/index/" class="btn" style="height: 38px; background: #F1F5F9; color: #64748B; font-weight: 600; padding: 0 14px; border-radius: 8px; border: 1px solid #CBD5E1; display: inline-flex; align-items: center; gap: 4px; font-size: 13px;">
              <i class="fa fa-times"></i> Clear
            </a>
          <?php } ?>
        </div>
      <?php echo form_close();?>
    </div>

    <?=$this->session->flashdata('flashmsg');?>

    <!-- Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-tags" style="color: #0d9488; margin-right: 8px;"></i> Configured URL Meta Tags
        </h3>
      </div>

      <div class="table-responsive">
        <table class="table table-hover" id="exportTable" style="margin: 0; border-collapse: separate; border-spacing: 0;">
          <thead>
            <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 60px;">ID</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Target Route / URL</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">SEO Title</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Keywords</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($data)) {
              foreach($data as $p) { ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 14px 16px; font-weight: 600; color: #64748B; font-size: 13px;">
                  #<?=$p->meta_id;?>
                </td>
                <td style="padding: 14px 16px; font-size: 13px; font-family: monospace; color: #0d9488;">
                  https://www.upcharr.com/<?=$p->page_url;?>
                </td>
                <td style="padding: 14px 16px; font-weight: 600; color: #0F172A; font-size: 13px; max-width: 200px;">
                  <?=$p->meta_title;?>
                </td>
                <td style="padding: 14px 16px; font-size: 12px; color: #64748B; max-width: 250px;">
                  <?=character_limiter($p->meta_description, 80);?>
                </td>
                <td style="padding: 14px 16px; font-size: 12px; color: #64748B; max-width: 180px;">
                  <?=character_limiter($p->meta_keyword, 60);?>
                </td>
                <td style="padding: 14px 16px;">
                  <?php if($p->status == '1') { ?>
                    <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #DCFCE7; color: #15803D;">Active</span>
                  <?php } else { ?>
                    <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #FEE2E2; color: #B91C1C;">Inactive</span>
                  <?php } ?>
                </td>
                <td style="padding: 14px 16px; text-align: right;">
                  <a href="<?=base_url();?>seo/meta/edit/<?=$p->meta_id;?>" class="btn btn-sm" style="background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; border-radius: 6px; padding: 5px 10px; font-weight: 600; font-size: 12px;">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                </td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="7" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                  No meta tag configurations found.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div style="display: flex; align-items: center; justify-content: flex-end; padding: 16px 20px; border-top: 1px solid #F1F5F9;">
        <div class="pagination" style="margin: 0;">
          <?php echo $page_links; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?=$this->load->view('inc/footer');?>

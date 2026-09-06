<div class="content-wrapper" style="background: #f8fafc; min-height: 900px;">
  <!-- Content Header & Breadcrumb -->
  <section class="content-header" style="padding: 24px 24px 12px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
      <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
          <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; box-shadow: 0 4px 10px rgba(13,148,136,0.3);">
            <i class="fa fa-line-chart"></i>
          </div>
          <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; font-family: 'Inter', -apple-system, sans-serif; letter-spacing: -0.5px;">
            SEO &amp; Meta Tags Dashboard
          </h1>
        </div>
        <p style="margin: 0; color: #64748b; font-size: 13.5px;">Manage custom page titles, search engine descriptions, Open Graph cards, canonical URLs, and schema markup</p>
      </div>

      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('seo/meta/add');?>" class="btn" style="background: linear-gradient(135deg, #0d9488, #0f766e); color: #ffffff; font-weight: 600; padding: 10px 20px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; box-shadow: 0 4px 12px rgba(13,148,136,0.25); border: none; transition: all 0.2s ease;">
          <i class="fa fa-plus-circle"></i> Add New Meta Tag
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 12px 24px 36px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- KPI Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
      <!-- Total URLs -->
      <a href="<?=base_url('seo/meta/index');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03); transition: transform 0.15s ease, box-shadow 0.15s ease;">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Total URLs</span>
            <span style="background: #f1f5f9; color: #475569; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-globe"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['total']);?></div>
          <div style="font-size: 12px; color: #64748b;">Configured Routes</div>
        </div>
      </a>

      <!-- Active URLs -->
      <a href="<?=base_url('seo/meta/index?status=1');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #16a34a; letter-spacing: 0.5px;">Active</span>
            <span style="background: #dcfce7; color: #15803d; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-check"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #15803d; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['active']);?></div>
          <div style="font-size: 12px; color: #16a34a;">Published &amp; Live</div>
        </div>
      </a>

      <!-- Inactive / Draft -->
      <a href="<?=base_url('seo/meta/index?status=0');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #b45309; letter-spacing: 0.5px;">Inactive</span>
            <span style="background: #fef3c7; color: #b45309; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-pause"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #b45309; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['inactive']);?></div>
          <div style="font-size: 12px; color: #b45309;">Draft or Disabled</div>
        </div>
      </a>

      <!-- Open Graph Configured -->
      <a href="<?=base_url('seo/meta/index?issue=missing_og');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #2563eb; letter-spacing: 0.5px;">Social OG</span>
            <span style="background: #dbeafe; color: #1d4ed8; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-share-alt"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #1d4ed8; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['og_count']);?></div>
          <div style="font-size: 12px; color: #2563eb;">Sharing Cards Ready</div>
        </div>
      </a>

      <!-- Schema Rich Snippets -->
      <a href="<?=base_url('seo/meta/index?issue=has_schema');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #7c3aed; letter-spacing: 0.5px;">Schema JSON</span>
            <span style="background: #ede9fe; color: #6d28d9; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-code"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #6d28d9; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['schema_count']);?></div>
          <div style="font-size: 12px; color: #7c3aed;">Structured Snippets</div>
        </div>
      </a>

      <!-- Missing Meta Description -->
      <a href="<?=base_url('seo/meta/index?issue=missing_desc');?>" style="text-decoration: none;">
        <div style="background: #ffffff; border-radius: 14px; padding: 18px 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #e11d48; letter-spacing: 0.5px;">Missing Desc</span>
            <span style="background: #ffe4e6; color: #be123c; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="fa fa-exclamation-triangle"></i>
            </span>
          </div>
          <div style="font-size: 26px; font-weight: 800; color: #be123c; line-height: 1.1; margin-bottom: 4px;"><?=number_format($stats['missing_desc']);?></div>
          <div style="font-size: 12px; color: #e11d48;">Needs Optimization</div>
        </div>
      </a>
    </div>

    <!-- Filter Bar Card -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); padding: 18px 24px; margin-bottom: 20px;">
      <form id="filterForm" method="get" action="<?=base_url('seo/meta/index');?>" style="display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end;">
        <div style="flex: 2; min-width: 260px;">
          <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Search Keywords / Title / Route</label>
          <div style="position: relative;">
            <i class="fa fa-search" style="position: absolute; left: 14px; top: 12px; color: #94a3b8;"></i>
            <input type="text" name="search" class="form-control" value="<?=htmlspecialchars($filters['search']);?>" placeholder="Search by route, title, keywords..." style="height: 40px; padding-left: 38px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px;">
          </div>
        </div>

        <div style="flex: 1; min-width: 140px;">
          <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
          <select name="status" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px;">
            <option value="">All Statuses</option>
            <option value="1" <?=$filters['status'] === '1' ? 'selected' : '';?>>Active Only</option>
            <option value="0" <?=$filters['status'] === '0' ? 'selected' : '';?>>Inactive Only</option>
          </select>
        </div>

        <div style="flex: 1; min-width: 170px;">
          <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">SEO Issue Filter</label>
          <select name="issue" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px;">
            <option value="">All Records</option>
            <option value="missing_desc" <?=$filters['issue'] === 'missing_desc' ? 'selected' : '';?>>Missing Description</option>
            <option value="missing_og" <?=$filters['issue'] === 'missing_og' ? 'selected' : '';?>>Missing Open Graph</option>
            <option value="noindex" <?=$filters['issue'] === 'noindex' ? 'selected' : '';?>>NoIndex Configured</option>
            <option value="has_schema" <?=$filters['issue'] === 'has_schema' ? 'selected' : '';?>>Has Schema JSON-LD</option>
          </select>
        </div>

        <div style="width: 110px;">
          <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Per Page</label>
          <select name="pagesize" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px;">
            <option value="10" <?=$pagesize == 10 ? 'selected' : '';?>>10</option>
            <option value="15" <?=$pagesize == 15 ? 'selected' : '';?>>15</option>
            <option value="25" <?=$pagesize == 25 ? 'selected' : '';?>>25</option>
            <option value="50" <?=$pagesize == 50 ? 'selected' : '';?>>50</option>
            <option value="100" <?=$pagesize == 100 ? 'selected' : '';?>>100</option>
          </select>
        </div>

        <div style="display: flex; gap: 8px;">
          <button type="submit" class="btn" style="height: 40px; background: #0d9488; color: #fff; font-weight: 600; padding: 0 18px; border-radius: 8px; border: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px;">
            <i class="fa fa-filter"></i> Apply
          </button>
          <?php if(!empty($filters['search']) || !empty($filters['status']) || !empty($filters['issue'])) { ?>
            <a href="<?=base_url('seo/meta/index');?>" class="btn" style="height: 40px; background: #f1f5f9; color: #475569; font-weight: 600; padding: 0 14px; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 4px; font-size: 13.5px;">
              <i class="fa fa-times"></i> Reset
            </a>
          <?php } ?>
        </div>
      </form>
    </div>

    <!-- Bulk Actions Floating Bar (appears when items selected) -->
    <div id="bulkActionBar" style="display: none; background: #0f172a; color: #fff; border-radius: 12px; padding: 12px 24px; margin-bottom: 16px; box-shadow: 0 10px 25px rgba(15,23,42,0.15); align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div style="display: flex; align-items: center; gap: 12px;">
        <span style="background: #0d9488; color: #fff; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;" id="selectedCountBadge">0 selected</span>
        <span style="font-size: 13.5px; color: #cbd5e1;">Bulk actions for selected URLs:</span>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <button type="button" class="btn btn-sm" onclick="executeBulkStatus('1')" style="background: #16a34a; color: #fff; font-weight: 600; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12.5px;">
          <i class="fa fa-check"></i> Activate
        </button>
        <button type="button" class="btn btn-sm" onclick="executeBulkStatus('0')" style="background: #d97706; color: #fff; font-weight: 600; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12.5px;">
          <i class="fa fa-pause"></i> Deactivate
        </button>
        <button type="button" class="btn btn-sm" onclick="confirmBulkDelete()" style="background: #e11d48; color: #fff; font-weight: 600; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12.5px;">
          <i class="fa fa-trash"></i> Bulk Delete
        </button>
        <button type="button" class="btn btn-sm" onclick="deselectAll()" style="background: #334155; color: #94a3b8; border: none; border-radius: 6px; padding: 6px 10px; font-size: 12.5px;">
          Cancel
        </button>
      </div>
    </div>

    <!-- Meta Tags Table Card -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); overflow: hidden;">
      <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: #fafafa;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fa fa-tags" style="color: #0d9488; margin-right: 6px;"></i> Target Page Meta Configurations
          </h3>
          <span class="badge" style="background: #e2e8f0; color: #475569; font-weight: 700; font-size: 12px;"><?=number_format($total_rows);?> Total</span>
        </div>

        <div style="font-size: 12.5px; color: #64748b;">
          Showing <?=($total_rows > 0) ? ($offset + 1) : 0;?> to <?=min($offset + $pagesize, $total_rows);?> of <?=number_format($total_rows);?> entries
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover" style="margin: 0; border-collapse: separate; border-spacing: 0; width: 100%;">
          <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
              <th style="padding: 14px 18px; width: 40px; text-align: center;">
                <input type="checkbox" id="checkAll" style="width: 16px; height: 16px; cursor: pointer;">
              </th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; min-width: 220px;">Target Route / URL</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; min-width: 240px;">SEO Title &amp; Description</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 140px;">SEO Health</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 100px; text-align: center;">Status</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 120px;">Updated</th>
              <th style="padding: 14px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($data)) {
              foreach($data as $row) { 
                $title_len = mb_strlen($row->meta_title ?? '');
                $desc_len  = mb_strlen($row->meta_description ?? '');
                $is_noindex = (isset($row->robots_meta) && stripos($row->robots_meta, 'noindex') !== false);
                $has_og     = !empty($row->og_title);
                $has_schema = !empty($row->schema_markup);
                $live_url   = ($row->page_url === 'home') ? base_url() : base_url($row->page_url);
              ?>
              <tr id="row_<?=$row->meta_id;?>" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                <td style="padding: 16px 18px; text-align: center; vertical-align: middle;">
                  <input type="checkbox" class="row-checkbox" value="<?=$row->meta_id;?>" style="width: 16px; height: 16px; cursor: pointer;">
                </td>

                <td style="padding: 16px; vertical-align: top;">
                  <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                    <span style="font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 4px;">ROUTE</span>
                    <strong style="font-size: 13.5px; color: #0f172a; font-family: monospace;">/<?=htmlspecialchars($row->page_url);?></strong>
                  </div>
                  <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b;">
                    <a href="<?=$live_url;?>" target="_blank" rel="noopener" style="color: #0d9488; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;" title="View Live Page">
                      <i class="fa fa-external-link"></i> Live URL
                    </a>
                    <span>&bull;</span>
                    <button type="button" class="btn btn-link" onclick="copyToClipboard('<?=$live_url;?>', this)" style="padding: 0; color: #64748b; font-size: 11.5px; text-decoration: none;" title="Copy Full URL">
                      <i class="fa fa-copy"></i> Copy
                    </button>
                    <?php if(!empty($row->canonical_url)) { ?>
                      <span>&bull;</span>
                      <span title="Canonical: <?=htmlspecialchars($row->canonical_url);?>" style="color: #6366f1; cursor: help;">
                        <i class="fa fa-link"></i> Canonical
                      </span>
                    <?php } ?>
                  </div>
                </td>

                <td style="padding: 16px; vertical-align: top;">
                  <!-- Title -->
                  <div style="font-weight: 700; color: #0f172a; font-size: 14px; margin-bottom: 4px; line-height: 1.3;">
                    <?=htmlspecialchars($row->meta_title);?>
                    <span style="display: inline-block; margin-left: 6px; font-size: 11px; font-weight: 600; padding: 1px 6px; border-radius: 10px; background: <?=($title_len >= 40 && $title_len <= 65) ? '#dcfce7; color: #15803d;' : '#fef3c7; color: #b45309;';?>">
                      <?=$title_len;?> chars
                    </span>
                  </div>

                  <!-- Description -->
                  <div style="font-size: 12.5px; color: #475569; line-height: 1.4; margin-bottom: 4px;">
                    <?php if(!empty($row->meta_description)) { ?>
                      <?=htmlspecialchars(character_limiter($row->meta_description, 110));?>
                      <span style="display: inline-block; margin-left: 4px; font-size: 11px; font-weight: 600; padding: 1px 6px; border-radius: 10px; background: <?=($desc_len >= 120 && $desc_len <= 165) ? '#dcfce7; color: #15803d;' : '#f1f5f9; color: #64748b;';?>">
                        <?=$desc_len;?> chars
                      </span>
                    <?php } else { ?>
                      <span style="color: #e11d48; font-style: italic;"><i class="fa fa-exclamation-circle"></i> Missing meta description tag</span>
                    <?php } ?>
                  </div>

                  <!-- Keywords Pill -->
                  <?php if(!empty($row->meta_keyword)) { ?>
                    <div style="font-size: 11.5px; color: #64748b; font-style: italic;">
                      <i class="fa fa-key" style="font-size: 10px; margin-right: 2px;"></i> <?=htmlspecialchars(character_limiter($row->meta_keyword, 60));?>
                    </div>
                  <?php } ?>
                </td>

                <td style="padding: 16px; vertical-align: top;">
                  <div style="display: flex; flex-direction: column; gap: 4px;">
                    <!-- Robots badge -->
                    <?php if($is_noindex) { ?>
                      <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background: #fee2e2; color: #b91c1c;" title="Search engines are instructed NOT to index this page">
                        <i class="fa fa-ban"></i> NoIndex
                      </span>
                    <?php } else { ?>
                      <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; background: #ecfdf5; color: #047857;" title="Index &amp; Follow Enabled">
                        <i class="fa fa-search"></i> Index
                      </span>
                    <?php } ?>

                    <!-- Social OG badge -->
                    <?php if($has_og) { ?>
                      <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; background: #eff6ff; color: #1d4ed8;" title="Social Open Graph card configured">
                        <i class="fa fa-share-alt"></i> OG Card
                      </span>
                    <?php } ?>

                    <!-- Schema badge -->
                    <?php if($has_schema) { ?>
                      <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; background: #f5f3ff; color: #6d28d9;" title="JSON-LD Structured Data configured">
                        <i class="fa fa-code"></i> Schema
                      </span>
                    <?php } ?>
                  </div>
                </td>

                <td style="padding: 16px; text-align: center; vertical-align: middle;">
                  <button type="button" class="btn btn-xs" onclick="toggleStatus(<?=$row->meta_id;?>, this)" style="border-radius: 20px; padding: 4px 12px; font-weight: 700; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; background: <?=$row->status == '1' ? '#dcfce7; color: #15803d;' : '#fee2e2; color: #b91c1c;';?>" id="status_btn_<?=$row->meta_id;?>">
                    <i class="fa <?=$row->status == '1' ? 'fa-check-circle' : 'fa-times-circle';?>"></i> <?=$row->status == '1' ? 'Active' : 'Inactive';?>
                  </button>
                </td>

                <td style="padding: 16px; vertical-align: middle; font-size: 12px; color: #64748b;">
                  <div><?=!empty($row->updated_at) ? date('d M Y', strtotime($row->updated_at)) : date('d M Y', strtotime($row->meta_date_added));?></div>
                  <div style="font-size: 11px; color: #94a3b8;"><?=!empty($row->updated_at) ? date('h:i A', strtotime($row->updated_at)) : date('h:i A', strtotime($row->meta_date_added));?></div>
                </td>

                <td style="padding: 16px 18px; text-align: right; vertical-align: middle;">
                  <div style="display: inline-flex; gap: 6px;">
                    <!-- Preview SERP & Social Modal Trigger -->
                    <button type="button" class="btn btn-default btn-sm" onclick="openPreviewModal(<?=$row->meta_id;?>)" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; color: #334155; padding: 6px 10px;" title="Preview Google &amp; Social Card">
                      <i class="fa fa-eye"></i>
                    </button>

                    <!-- Edit -->
                    <a href="<?=base_url('seo/meta/edit/' . $row->meta_id);?>" class="btn btn-default btn-sm" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; color: #0d9488; padding: 6px 10px;" title="Edit Meta Tag">
                      <i class="fa fa-pencil"></i>
                    </a>

                    <!-- Delete -->
                    <button type="button" class="btn btn-default btn-sm" onclick="confirmDelete(<?=$row->meta_id;?>, '<?=htmlspecialchars(addslashes($row->page_url));?>')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; color: #e11d48; padding: 6px 10px;" title="Delete Meta Tag">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="7" style="text-align: center; padding: 60px 20px; color: #64748b;">
                  <div style="font-size: 42px; color: #cbd5e1; margin-bottom: 12px;"><i class="fa fa-search-minus"></i></div>
                  <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">No Meta Tag Configurations Found</h4>
                  <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">No URLs match your search or filter criteria.</p>
                  <a href="<?=base_url('seo/meta/add');?>" class="btn" style="background: #0d9488; color: #fff; font-weight: 600; padding: 8px 18px; border-radius: 8px; text-decoration: none;">
                    <i class="fa fa-plus-circle"></i> Create New Meta Tag
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination Footer -->
      <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #fafafa; gap: 12px;">
        <div style="font-size: 13px; color: #64748b;">
          Total Configured URLs: <strong><?=number_format($total_rows);?></strong>
        </div>
        <div>
          <?=$page_links;?>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ==========================================
     Single Delete Confirmation Modal
     ========================================== -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 14px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #e11d48; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 16px;">
          <i class="fa fa-trash"></i>
        </div>
        <h4 style="font-weight: 800; color: #0f172a; margin: 0 0 8px;">Delete Meta Tag?</h4>
        <p style="color: #64748b; font-size: 13.5px; line-height: 1.5; margin: 0 0 20px;">
          Are you sure you want to delete the SEO configuration for <strong id="deleteUrlName" style="color: #0f172a;"></strong>? This cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn" data-dismiss="modal" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 9px 20px; border-radius: 8px; border: 1px solid #cbd5e1;">Cancel</button>
          <button type="button" class="btn" id="btnConfirmSingleDelete" style="background: #e11d48; color: #fff; font-weight: 600; padding: 9px 20px; border-radius: 8px; border: none;">
            <i class="fa fa-trash"></i> Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     Bulk Delete Confirmation Modal
     ========================================== -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 14px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #e11d48; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 16px;">
          <i class="fa fa-exclamation-triangle"></i>
        </div>
        <h4 style="font-weight: 800; color: #0f172a; margin: 0 0 8px;">Confirm Bulk Deletion</h4>
        <p style="color: #64748b; font-size: 13.5px; line-height: 1.5; margin: 0 0 20px;">
          You have selected <strong id="bulkDeleteCountText" style="color: #e11d48;">0</strong> meta configurations. Are you sure you want to permanently delete them?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn" data-dismiss="modal" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 9px 20px; border-radius: 8px; border: 1px solid #cbd5e1;">Cancel</button>
          <button type="button" class="btn" id="btnConfirmBulkDelete" style="background: #e11d48; color: #fff; font-weight: 600; padding: 9px 22px; border-radius: 8px; border: none;">
            <i class="fa fa-trash"></i> Yes, Delete All
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     SERP & Social Preview Modal
     ========================================== -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 720px; margin-top: 50px;">
    <div class="modal-content" style="border-radius: 14px; border: none; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background: #0f172a; color: #fff; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between;">
        <h4 class="modal-title" style="font-weight: 700; font-size: 16px; margin: 0;">
          <i class="fa fa-eye" style="color: #0d9488; margin-right: 8px;"></i> Live Search &amp; Social Snippet Simulator
        </h4>
        <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px;">&times;</button>
      </div>

      <div class="modal-body" style="padding: 24px; background: #f8fafc;">
        <!-- Tabs -->
        <ul class="nav nav-tabs" style="border-bottom: 2px solid #e2e8f0; margin-bottom: 20px;">
          <li class="active"><a href="#previewGoogleTab" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-google text-danger"></i> Google Search SERP</a></li>
          <li><a href="#previewOgTab" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-facebook-square text-primary"></i> Facebook / WhatsApp Card</a></li>
          <li><a href="#previewSchemaTab" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-code text-purple"></i> Schema JSON-LD</a></li>
        </ul>

        <div class="tab-content">
          <!-- Google SERP -->
          <div class="tab-pane active" id="previewGoogleTab">
            <div style="background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <div style="width: 26px; height: 26px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #0d9488;">
                  <i class="fa fa-globe"></i>
                </div>
                <div>
                  <div style="font-size: 13px; color: #202124; font-family: -apple-system, Roboto, sans-serif; line-height: 1.2;">Upchar Healthcare</div>
                  <div style="font-size: 12px; color: #4d5156; font-family: -apple-system, Roboto, sans-serif;" id="simGoogleUrl">https://upchar.info/...</div>
                </div>
              </div>

              <div style="color: #1a0dab; font-size: 19px; font-weight: 400; line-height: 1.3; font-family: -apple-system, Roboto, sans-serif; cursor: pointer; margin-bottom: 6px;" id="simGoogleTitle">
                Page Title Here
              </div>

              <div style="color: #4d5156; font-size: 14px; line-height: 1.5; font-family: -apple-system, Roboto, sans-serif;" id="simGoogleDesc">
                Meta description snippet will be rendered here.
              </div>
            </div>
          </div>

          <!-- Social OG Tab -->
          <div class="tab-pane" id="previewOgTab">
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; max-width: 520px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
              <div id="simOgImgContainer" style="width: 100%; height: 220px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; overflow: hidden;">
                <img id="simOgImg" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                <span id="simOgImgPlaceholder"><i class="fa fa-image fa-3x"></i></span>
              </div>
              <div style="padding: 16px; background: #f8fafc;">
                <div style="font-size: 11.5px; text-transform: uppercase; color: #64748b; font-weight: 600; margin-bottom: 4px;">UPCHAR.INFO</div>
                <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px; line-height: 1.3;" id="simOgTitle">Open Graph Title</div>
                <div style="font-size: 13px; color: #64748b; line-height: 1.4;" id="simOgDesc">Open Graph description text...</div>
              </div>
            </div>
          </div>

          <!-- Schema Tab -->
          <div class="tab-pane" id="previewSchemaTab">
            <pre id="simSchemaCode" style="background: #0f172a; color: #38bdf8; padding: 16px; border-radius: 10px; font-size: 12.5px; max-height: 300px; overflow-y: auto; font-family: monospace;">No custom schema markup specified.</pre>
          </div>
        </div>
      </div>

      <div class="modal-footer" style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 12px 24px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     Dashboard Scripts & AJAX Handlers
     ========================================== -->
<script>
let currentDeleteId = 0;

// Copy URL to clipboard
function copyToClipboard(text, btn) {
  navigator.clipboard.writeText(text).then(function() {
    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-check text-success"></i> Copied!';
    setTimeout(function() { btn.innerHTML = orig; }, 1800);
  });
}

// Single Delete Prompt
function confirmDelete(id, url) {
  currentDeleteId = id;
  $('#deleteUrlName').text('/' + url);
  $('#deleteConfirmModal').modal('show');
}

// Confirm Single Delete Button Click
$('#btnConfirmSingleDelete').on('click', function() {
  if (currentDeleteId <= 0) return;
  var btn = $(this);
  btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');

  $.ajax({
    url: '<?=base_url("seo/meta/delete");?>/' + currentDeleteId,
    type: 'POST',
    data: { is_ajax: 1, meta_id: currentDeleteId },
    dataType: 'json',
    success: function(res) {
      $('#deleteConfirmModal').modal('hide');
      btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Delete');
      if (res && res.status === 'success') {
        $('#row_' + currentDeleteId).fadeOut(300, function() { $(this).remove(); });
        showTopNotice('success', res.message || 'Meta tag deleted successfully.');
      } else {
        showTopNotice('danger', (res && res.message) ? res.message : 'Failed to delete meta tag.');
      }
    },
    error: function() {
      $('#deleteConfirmModal').modal('hide');
      btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Delete');
      showTopNotice('danger', 'Server connection error while deleting record.');
    }
  });
});

// Check All checkboxes
$('#checkAll').on('change', function() {
  $('.row-checkbox').prop('checked', $(this).prop('checked'));
  updateBulkBar();
});

$(document).on('change', '.row-checkbox', function() {
  updateBulkBar();
  var total = $('.row-checkbox').length;
  var checked = $('.row-checkbox:checked').length;
  $('#checkAll').prop('checked', total === checked);
});

function deselectAll() {
  $('#checkAll, .row-checkbox').prop('checked', false);
  updateBulkBar();
}

function updateBulkBar() {
  var selected = $('.row-checkbox:checked').length;
  if (selected > 0) {
    $('#selectedCountBadge').text(selected + ' selected');
    $('#bulkActionBar').slideDown(150).css('display', 'flex');
  } else {
    $('#bulkActionBar').slideUp(150);
  }
}

function getSelectedIds() {
  var ids = [];
  $('.row-checkbox:checked').each(function() {
    ids.push($(this).val());
  });
  return ids;
}

// Bulk Delete Confirm Modal
function confirmBulkDelete() {
  var ids = getSelectedIds();
  if (ids.length === 0) return;
  $('#bulkDeleteCountText').text(ids.length);
  $('#bulkDeleteModal').modal('show');
}

// Execute Bulk Delete
$('#btnConfirmBulkDelete').on('click', function() {
  var ids = getSelectedIds();
  if (ids.length === 0) return;

  var btn = $(this);
  btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');

  $.ajax({
    url: '<?=base_url("seo/meta/bulk_delete");?>',
    type: 'POST',
    data: { is_ajax: 1, ids: ids },
    dataType: 'json',
    success: function(res) {
      $('#bulkDeleteModal').modal('hide');
      btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Yes, Delete All');
      if (res && res.status === 'success') {
        ids.forEach(function(id) {
          $('#row_' + id).fadeOut(300, function() { $(this).remove(); });
        });
        deselectAll();
        showTopNotice('success', res.message || 'Selected meta tags deleted.');
      } else {
        showTopNotice('danger', (res && res.message) ? res.message : 'Bulk delete failed.');
      }
    },
    error: function() {
      $('#bulkDeleteModal').modal('hide');
      btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Yes, Delete All');
      showTopNotice('danger', 'Server error during bulk delete.');
    }
  });
});

// Bulk Status Update (Activate / Deactivate)
function executeBulkStatus(status) {
  var ids = getSelectedIds();
  if (ids.length === 0) return;

  $.ajax({
    url: '<?=base_url("seo/meta/bulk_status");?>',
    type: 'POST',
    data: { is_ajax: 1, ids: ids, status: status },
    dataType: 'json',
    success: function(res) {
      if (res && res.status === 'success') {
        ids.forEach(function(id) {
          var btn = $('#status_btn_' + id);
          if (status === '1') {
            btn.css({ 'background': '#dcfce7', 'color': '#15803d' }).html('<i class="fa fa-check-circle"></i> Active');
          } else {
            btn.css({ 'background': '#fee2e2', 'color': '#b91c1c' }).html('<i class="fa fa-times-circle"></i> Inactive');
          }
        });
        deselectAll();
        showTopNotice('success', res.message);
      }
    }
  });
}

// Single Status Toggle Click
function toggleStatus(id, btnElement) {
  var btn = $(btnElement);
  btn.prop('disabled', true);

  $.ajax({
    url: '<?=base_url("seo/meta/toggle_status");?>/' + id,
    type: 'POST',
    data: { is_ajax: 1 },
    dataType: 'json',
    success: function(res) {
      btn.prop('disabled', false);
      if (res && res.status === 'success') {
        if (res.new_status === '1') {
          btn.css({ 'background': '#dcfce7', 'color': '#15803d' }).html('<i class="fa fa-check-circle"></i> Active');
        } else {
          btn.css({ 'background': '#fee2e2', 'color': '#b91c1c' }).html('<i class="fa fa-times-circle"></i> Inactive');
        }
      }
    },
    error: function() {
      btn.prop('disabled', false);
    }
  });
}

// Open Live Preview Modal
function openPreviewModal(id) {
  $.getJSON('<?=base_url("seo/meta/quick_preview");?>/' + id, function(res) {
    if (res && res.status === 'success' && res.data) {
      var d = res.data;
      var fullUrl = (d.page_url === 'home') ? 'https://upchar.info/' : 'https://upchar.info/' + d.page_url;

      // Google SERP
      $('#simGoogleUrl').text(fullUrl);
      $('#simGoogleTitle').text(d.meta_title || 'No title set');
      $('#simGoogleDesc').text(d.meta_description || 'No description set for this URL.');

      // Social OG
      $('#simOgTitle').text(d.og_title || d.meta_title || 'No Title');
      $('#simOgDesc').text(d.og_description || d.meta_description || 'No description');

      if (d.og_image) {
        $('#simOgImg').attr('src', d.og_image).show();
        $('#simOgImgPlaceholder').hide();
      } else {
        $('#simOgImg').hide();
        $('#simOgImgPlaceholder').show();
      }

      // Schema
      if (d.schema_markup && d.schema_markup.trim() !== '') {
        try {
          var parsed = JSON.parse(d.schema_markup);
          $('#simSchemaCode').text(JSON.stringify(parsed, null, 2));
        } catch(e) {
          $('#simSchemaCode').text(d.schema_markup);
        }
      } else {
        $('#simSchemaCode').text('// No custom schema JSON-LD configured for this route.');
      }

      $('#previewModal').modal('show');
    }
  });
}

function showTopNotice(type, msg) {
  var html = '<div class="alert alert-' + type + ' alert-dismissible" style="border-radius: 8px; margin-bottom: 20px;">' +
    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
    '<strong>' + (type === 'success' ? '<i class="fa fa-check-circle"></i> Success: ' : '<i class="fa fa-exclamation-circle"></i> Error: ') + '</strong> ' + msg +
    '</div>';
  $('.content-header').after('<div class="container-fluid" id="dynamicNotice" style="padding: 0 24px;">' + html + '</div>');
  setTimeout(function() { $('#dynamicNotice').slideUp(300, function() { $(this).remove(); }); }, 4000);
}
</script>

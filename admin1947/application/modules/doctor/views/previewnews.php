<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          News Article Preview #<?=$news->id;?>
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View published content, featured imagery, author attribution, and status</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/newsreg/newsupdate/'.$news->id)?>" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-pencil"></i> Edit Article
        </a>
        <a href="<?=base_url('doctor/newsreg/viewnews')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to News List
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <div style="max-width: 850px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      
      <?php if(!empty($news->image)): ?>
        <div style="width: 100%; height: 320px; background: #F8FAFC; overflow: hidden; border-bottom: 1px solid #E2E8F0;">
          <img src="<?=base_url('public/assets/upload/'.$news->image);?>" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      <?php endif; ?>

      <div style="padding: 28px;">
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 14px; flex-wrap: wrap;">
          <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: <?=$news->status == '1' ? '#DCFCE7; color: #15803D;' : '#FEE2E2; color: #B91C1C;';?>">
            <?=$news->status == '1' ? 'Active' : 'Inactive';?>
          </span>
          <span style="font-size: 13px; color: #64748B;">
            <i class="fa fa-calendar-o" style="margin-right: 4px;"></i> <?=formatedate($news->creat_date);?>
          </span>
        </div>

        <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0 0 18px 0; line-height: 1.4;">
          <?=$news->title;?>
        </h2>

        <?php if(!empty($news->video_url)): ?>
          <div style="margin-bottom: 20px; padding: 12px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 13px;">
            <i class="fa fa-video-camera" style="color: #0d9488; margin-right: 6px;"></i> Video URL: <a href="<?=$news->video_url;?>" target="_blank" style="color: #0d9488; font-weight: 600;"><?=$news->video_url;?></a>
          </div>
        <?php endif; ?>

        <div style="font-size: 15px; line-height: 1.8; color: #334155; white-space: pre-line;">
          <?=$news->description;?>
        </div>
      </div>
    </div>
  </section>
</div>

<?=$this->load->view('inc/footer');?>

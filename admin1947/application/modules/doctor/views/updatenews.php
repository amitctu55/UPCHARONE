<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit News Article
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Update existing news post details, media attachments, and moderation status</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>doctor/newsreg/viewnews" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to News Directory
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 900px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-pencil-square-o" style="color: #0d9488; margin-right: 8px;"></i> Update Article Details
        </h3>
      </div>

      <form id="mainform" action="" method="post" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
          
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              News Title <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" class="form-control" id="t_fname" name="name" data-validation="required" data-validation-error-msg="Title is required" value="<?=$news->title;?>" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Full Description / Article Details <span style="color: #EF4444;">*</span>
            </label>
            <textarea class="form-control" id="description" name="description" data-validation="required" data-validation-error-msg="Content is required" rows="6" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 12px 14px;"><?=$news->description;?></textarea>
          </div>

          <?php if(!empty($news->hospital_id)) { ?>
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Associated Hospital</label>
            <input type="text" readonly class="form-control" value="<?=$news->name;?>" style="height: 42px; background: #F8FAFC; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
          </div>
          <?php } ?>

          <?php if(!empty($news->doctor_id)) { ?>
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Authoring Doctor</label>
            <input type="text" readonly class="form-control" value="<?=$news->fname;?>" style="height: 42px; background: #F8FAFC; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
          </div>
          <?php } ?>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Media Type <span style="color: #EF4444;">*</span>
              </label>
              <select name="type" class="form-control" id="type" onchange="mytype()" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="">-- Select Type --</option>
                <option value="1" <?php if(set_value('type',$news->type)=='1'){ echo "selected";}?>>Image Article</option>
                <option value="2" <?php if(set_value('type',$news->type)=='2'){ echo "selected";}?>>Video Article</option>
              </select>
            </div>

            <div id="image" <?php if($news->type!='1'){ ?> style="display: none;" <?php } ?>>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Change Featured Image
              </label>
              <input type="file" class="form-control" id="uploadimage" name="uploadimage" style="height: 42px; padding: 6px 12px; border-radius: 8px; border: 1px solid #CBD5E1;">
              <?php if(!empty($news->image)) { ?>
                <div style="margin-top: 8px; font-size: 12px;">
                  <a href="<?=base_url()?>public/assets/upload/<?=$news->image?>" target="_blank" style="color: #0d9488; font-weight: 600; text-decoration: underline;">
                    <i class="fa fa-image"></i> View current uploaded image
                  </a>
                </div>
              <?php } ?>
            </div>

            <div id="video" <?php if($news->type!='2'){ ?> style="display: none;" <?php } ?>>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                YouTube / Video URL
              </label>
              <input type="text" name="video_url" id="video_url" placeholder="https://www.youtube.com/watch?v=..." class="form-control" value="<?php echo set_value('video_url',$news->video_url);?>" maxlength="100" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
            </div>
          </div>

          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;">Publish Status</label>
              <div style="display: flex; gap: 16px; align-items: center;">
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                  <input type="radio" name="status" value="1" <?php if($news->status=='1'){ echo "checked";}?> style="accent-color: #0d9488;"> Active
                </label>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #64748B; cursor: pointer; margin: 0;">
                  <input type="radio" name="status" value="0" <?php if($news->status=='0'){ echo "checked";}?> style="accent-color: #0d9488;"> Inactive
                </label>
              </div>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;">Moderation Approval</label>
              <div style="display: flex; gap: 16px; align-items: center;">
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                  <input type="radio" name="approved" value="1" <?php if($news->approved=='1'){ echo "checked";}?> style="accent-color: #0d9488;"> Approved
                </label>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #64748B; cursor: pointer; margin: 0;">
                  <input type="radio" name="approved" value="0" <?php if($news->approved=='0'){ echo "checked";}?> style="accent-color: #0d9488;"> Pending / Unapproved
                </label>
              </div>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="submit" name="submit" value="Update" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Update News
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({});
  function mytype() {
    var type = document.getElementById('type').value;
    if(type == "1") {
      document.getElementById("image").style.display = "block";
      document.getElementById("video").style.display = "none";
    } else if(type == "2") {
      document.getElementById("video").style.display = "block";
      document.getElementById("image").style.display = "none";
    } else {
      document.getElementById("image").style.display = "none";
      document.getElementById("video").style.display = "none";
    }
  }
</script>
<?=$this->load->view('inc/footer');?>

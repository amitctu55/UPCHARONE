<div class="content-wrapper" style="background: #f8fafc; min-height: 900px;">
  <!-- Content Header -->
  <section class="content-header" style="padding: 24px 24px 12px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
      <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
          <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; box-shadow: 0 4px 10px rgba(13,148,136,0.3);">
            <i class="fa fa-pencil-square-o"></i>
          </div>
          <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; font-family: 'Inter', -apple-system, sans-serif;">
            Edit SEO Meta Tag #<?=$res['meta_id'];?>
          </h1>
        </div>
        <p style="margin: 0; color: #64748b; font-size: 13.5px;">Modify search engine metadata, Open Graph preview cards, and schema markup for <code>/<?=htmlspecialchars($res['page_url']);?></code></p>
      </div>

      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('seo/meta/index');?>" class="btn" style="background: #ffffff; color: #334155; font-weight: 600; padding: 9px 18px; border-radius: 10px; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px;">
          <i class="fa fa-arrow-left"></i> Back to SEO Dashboard
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content Form -->
  <section class="content" style="padding: 12px 24px 36px;">
    <?=$this->session->flashdata('flashmsg');?>

    <form action="<?=base_url('seo/meta/edit/' . $res['meta_id']);?>" method="post" id="metaForm">
      <input type="hidden" name="meta_id" value="<?=$res['meta_id'];?>">

      <div class="row">
        <!-- Left Column: Settings Form Tabs -->
        <div class="col-lg-8 col-md-7">
          <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 24px;">
            
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" style="background: #f8fafc; padding: 12px 18px 0; border-bottom: 1px solid #e2e8f0;">
              <li class="active"><a href="#tabCore" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-tags text-teal" style="color: #0d9488;"></i> 1. Core Meta Tags</a></li>
              <li><a href="#tabRobots" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-shield text-info"></i> 2. Robots &amp; Indexing</a></li>
              <li><a href="#tabSocial" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-share-alt text-primary"></i> 3. Social Media (OG)</a></li>
              <li><a href="#tabSchema" data-toggle="tab" style="font-weight: 700; font-size: 13.5px;"><i class="fa fa-code text-purple" style="color: #7c3aed;"></i> 4. Schema JSON-LD</a></li>
            </ul>

            <div class="tab-content" style="padding: 24px;">
              <!-- Tab 1: Core Meta Tags -->
              <div class="tab-pane active" id="tabCore">
                <!-- Target Route Slug -->
                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Target Route Slug <span style="color: #ef4444;">*</span>
                  </label>
                  <div style="display: flex; align-items: center; border-radius: 8px; border: 1px solid #cbd5e1; overflow: hidden; height: 42px; background: #fff;">
                    <span style="background: #f1f5f9; border-right: 1px solid #e2e8f0; padding: 0 14px; color: #64748b; font-size: 13px; font-family: monospace; line-height: 42px; user-select: none;">
                      https://upchar.info/
                    </span>
                    <input type="text" name="page_url" id="inp_page_url" class="form-control" value="<?=set_value('page_url', $res['page_url'] ?? '');?>" placeholder="doctors/delhi/cardiologist" style="border: none; box-shadow: none; height: 100%; font-size: 14px; padding: 0 14px; font-family: monospace;" required>
                  </div>
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Target URL route relative to domain. Leading domain and slashes are automatically stripped.</span>
                  <?=form_error('page_url', '<div style="color: #ef4444; font-size: 12.5px; margin-top: 4px;">', '</div>');?>
                </div>

                <!-- Meta Title -->
                <div class="form-group" style="margin-bottom: 20px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin: 0;">
                      SEO Title Tag <span style="color: #ef4444;">*</span>
                    </label>
                    <span id="titleCounter" style="font-size: 12px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 10px;">0 / 60 chars</span>
                  </div>
                  <input type="text" name="meta_title" id="inp_meta_title" class="form-control" value="<?=set_value('meta_title', $res['meta_title'] ?? '');?>" placeholder="e.g. Best Cardiologists in Delhi | Book Verified Doctor - Upchar" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 14px;" required>
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Recommended: 50 - 60 characters for optimal display on Google search results.</span>
                  <?=form_error('meta_title', '<div style="color: #ef4444; font-size: 12.5px; margin-top: 4px;">', '</div>');?>
                </div>

                <!-- Meta Description -->
                <div class="form-group" style="margin-bottom: 20px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin: 0;">
                      Meta Description Tag
                    </label>
                    <span id="descCounter" style="font-size: 12px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 10px;">0 / 160 chars</span>
                  </div>
                  <textarea name="meta_description" id="inp_meta_description" rows="3" class="form-control" placeholder="Search top cardiologists and heart specialists in Delhi. Read patient reviews, check doctor qualifications, consultation fees, and book appointments online." style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 10px 14px; line-height: 1.5;"><?=set_value('meta_description', $res['meta_description'] ?? '');?></textarea>
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Recommended: 120 - 160 characters. Provide an engaging summary that drives search clicks.</span>
                  <?=form_error('meta_description', '<div style="color: #ef4444; font-size: 12.5px; margin-top: 4px;">', '</div>');?>
                </div>

                <!-- Meta Keywords -->
                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Meta Keywords (Comma separated)
                  </label>
                  <input type="text" name="meta_keyword" id="inp_meta_keyword" class="form-control" value="<?=set_value('meta_keyword', $res['meta_keyword'] ?? '');?>" placeholder="cardiologist delhi, heart hospital, doctor appointment, upchar healthcare" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 14px;">
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Separate search keywords with commas.</span>
                </div>

                <!-- Status Selection -->
                <div class="form-group" style="margin-bottom: 10px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Publishing Status
                  </label>
                  <div style="display: flex; gap: 20px; align-items: center; background: #f8fafc; padding: 12px 18px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <label style="margin: 0; font-size: 13.5px; font-weight: 600; color: #15803d; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                      <input type="radio" name="status" value="1" <?=($res['status'] ?? '1') == '1' ? 'checked' : '';?> style="width: 16px; height: 16px;"> Active (Live in HTML head)
                    </label>
                    <label style="margin: 0; font-size: 13.5px; font-weight: 600; color: #b91c1c; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                      <input type="radio" name="status" value="0" <?=($res['status'] ?? '1') == '0' ? 'checked' : '';?> style="width: 16px; height: 16px;"> Inactive (Draft mode)
                    </label>
                  </div>
                </div>
              </div>

              <!-- Tab 2: Robots & Indexing -->
              <div class="tab-pane" id="tabRobots">
                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Robots Meta Directives
                  </label>
                  <?php $curr_robots = $res['robots_meta'] ?? 'index, follow'; ?>
                  <select name="robots_meta" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                    <option value="index, follow" <?=$curr_robots === 'index, follow' ? 'selected' : '';?>>index, follow (Default - Allow search engines to index and follow links)</option>
                    <option value="noindex, follow" <?=$curr_robots === 'noindex, follow' ? 'selected' : '';?>>noindex, follow (Exclude from search results, but follow internal links)</option>
                    <option value="index, nofollow" <?=$curr_robots === 'index, nofollow' ? 'selected' : '';?>>index, nofollow (Index page in search results, do not follow links)</option>
                    <option value="noindex, nofollow" <?=$curr_robots === 'noindex, nofollow' ? 'selected' : '';?>>noindex, nofollow (Strictly private - No search indexing, no link following)</option>
                  </select>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Canonical URL Override
                  </label>
                  <input type="url" name="canonical_url" id="inp_canonical_url" class="form-control" value="<?=set_value('canonical_url', $res['canonical_url'] ?? '');?>" placeholder="https://upchar.info/preferred-url-slug" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 14px;">
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Leave empty to automatically use the page URL as canonical. Specify if this is a duplicate or parameterized URL.</span>
                </div>
              </div>

              <!-- Tab 3: Social Media (Open Graph & Twitter) -->
              <div class="tab-pane" id="tabSocial">
                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Open Graph Title (Facebook / WhatsApp / LinkedIn)
                  </label>
                  <input type="text" name="og_title" id="inp_og_title" class="form-control" value="<?=set_value('og_title', $res['og_title'] ?? '');?>" placeholder="Leave empty to use SEO Title" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 14px;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Open Graph Description
                  </label>
                  <textarea name="og_description" id="inp_og_description" rows="3" class="form-control" placeholder="Leave empty to use Meta Description" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 10px 14px;"><?=set_value('og_description', $res['og_description'] ?? '');?></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Open Graph Image URL
                  </label>
                  <input type="url" name="og_image" id="inp_og_image" class="form-control" value="<?=set_value('og_image', $res['og_image'] ?? '');?>" placeholder="https://upchar.info/public/assets/images/banner.jpg" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 14px;">
                  <span style="font-size: 12px; color: #64748b; display: block; margin-top: 4px;">Recommended dimensions: 1200 x 630 pixels.</span>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                  <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Open Graph Type
                  </label>
                  <?php $curr_type = $res['og_type'] ?? 'website'; ?>
                  <select name="og_type" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                    <option value="website" <?=$curr_type === 'website' ? 'selected' : '';?>>website (General Webpage)</option>
                    <option value="article" <?=$curr_type === 'article' ? 'selected' : '';?>>article (Blog / Health Article)</option>
                    <option value="profile" <?=$curr_type === 'profile' ? 'selected' : '';?>>profile (Doctor / Staff Profile)</option>
                  </select>
                </div>
              </div>

              <!-- Tab 4: Schema JSON-LD -->
              <div class="tab-pane" id="tabSchema">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin: 0;">
                    Structured Data (JSON-LD)
                  </label>
                  <div style="display: flex; gap: 6px;">
                    <button type="button" class="btn btn-xs btn-default" onclick="insertSchemaTemplate('medical')">+ MedicalOrg</button>
                    <button type="button" class="btn btn-xs btn-default" onclick="insertSchemaTemplate('doctor')">+ Physician</button>
                    <button type="button" class="btn btn-xs btn-default" onclick="insertSchemaTemplate('faq')">+ FAQ</button>
                  </div>
                </div>
                <textarea name="schema_markup" id="inp_schema_markup" rows="8" class="form-control" placeholder='{&#10;  "@context": "https://schema.org",&#10;  "@type": "MedicalOrganization",&#10;  "name": "Upchar Healthcare"&#10;}' style="font-family: monospace; font-size: 13px; background: #0f172a; color: #38bdf8; border-radius: 8px; padding: 14px;"><?=set_value('schema_markup', $res['schema_markup'] ?? '');?></textarea>
                <span style="font-size: 12px; color: #64748b; display: block; margin-top: 6px;">Injected automatically inside <code>&lt;script type="application/ld+json"&gt;</code> in the header.</span>
              </div>
            </div>

            <!-- Submit Button Footer -->
            <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 12px;">
              <a href="<?=base_url('seo/meta/index');?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; padding: 10px 22px; border-radius: 8px; border: 1px solid #cbd5e1;">Cancel</a>
              <button type="submit" class="btn" style="background: #0d9488; color: #ffffff; font-weight: 700; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 4px 10px rgba(13,148,136,0.25);">
                <i class="fa fa-save" style="margin-right: 6px;"></i> Update SEO Changes
              </button>
            </div>
          </div>
        </div>

        <!-- Right Column: Live Google & Social Preview Simulator -->
        <div class="col-lg-4 col-md-5">
          <div style="position: sticky; top: 80px; display: flex; flex-direction: column; gap: 20px;">
            <!-- Live Google Search Simulator -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
              <h4 style="font-size: 13px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fa fa-google" style="color: #ea4335;"></i> Google Search Preview
              </h4>

              <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 10px; padding: 14px;">
                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                  <div style="width: 22px; height: 22px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                    <i class="fa fa-globe"></i>
                  </div>
                  <div>
                    <div style="font-size: 12px; color: #202124; line-height: 1.1;">upchar.info</div>
                    <div style="font-size: 11px; color: #4d5156; word-break: break-all;" id="liveGoogleUrl">https://upchar.info/...</div>
                  </div>
                </div>

                <div style="font-size: 17px; color: #1a0dab; line-height: 1.3; font-family: -apple-system, Roboto, sans-serif; cursor: pointer; margin-bottom: 4px;" id="liveGoogleTitle">
                  Enter an SEO Title...
                </div>

                <div style="font-size: 13px; color: #4d5156; line-height: 1.45; font-family: -apple-system, Roboto, sans-serif;" id="liveGoogleDesc">
                  Enter an SEO meta description to see how this page appears to searchers on Google.
                </div>
              </div>
            </div>

            <!-- Live Social Share Simulator -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
              <h4 style="font-size: 13px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fa fa-share-alt" style="color: #2563eb;"></i> Social Card Preview
              </h4>

              <div style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div id="liveOgImgBox" style="width: 100%; height: 130px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                  <img id="liveOgImgTag" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                  <span id="liveOgImgIcon"><i class="fa fa-image fa-2x"></i></span>
                </div>
                <div style="padding: 12px; background: #f8fafc;">
                  <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 2px;">UPCHAR.INFO</div>
                  <div style="font-size: 14px; font-weight: 700; color: #0f172a; line-height: 1.3; margin-bottom: 4px;" id="liveOgTitle">
                    Social Card Title
                  </div>
                  <div style="font-size: 12px; color: #64748b; line-height: 1.4;" id="liveOgDesc">
                    Social description preview...
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
</div>

<!-- Simulator Script -->
<script>
function updateSimulators() {
  var rawSlug = $('#inp_page_url').val().trim();
  var slug = rawSlug.replace(/^https?:\/\/[^\/]+\//i, '').replace(/^upchar\.info\//i, '').replace(/^\/+|\/+$/g, '');
  if (!slug) slug = 'slug';
  var fullUrl = (slug === 'home') ? 'https://upchar.info/' : 'https://upchar.info/' + slug;
  $('#liveGoogleUrl').text(fullUrl);

  var title = $('#inp_meta_title').val().trim();
  $('#titleCounter').text(title.length + ' / 60 chars');
  if (title.length >= 45 && title.length <= 65) {
    $('#titleCounter').css({ 'background': '#dcfce7', 'color': '#15803d' });
  } else if (title.length > 65) {
    $('#titleCounter').css({ 'background': '#fee2e2', 'color': '#b91c1c' });
  } else {
    $('#titleCounter').css({ 'background': '#f1f5f9', 'color': '#64748b' });
  }
  $('#liveGoogleTitle').text(title || 'Enter an SEO Title...');

  var desc = $('#inp_meta_description').val().trim();
  $('#descCounter').text(desc.length + ' / 160 chars');
  if (desc.length >= 120 && desc.length <= 165) {
    $('#descCounter').css({ 'background': '#dcfce7', 'color': '#15803d' });
  } else if (desc.length > 165) {
    $('#descCounter').css({ 'background': '#fee2e2', 'color': '#b91c1c' });
  } else {
    $('#descCounter').css({ 'background': '#f1f5f9', 'color': '#64748b' });
  }
  $('#liveGoogleDesc').text(desc || 'Enter an SEO meta description to see how this page appears on Google.');

  // Social
  var ogTitle = $('#inp_og_title').val().trim() || title;
  $('#liveOgTitle').text(ogTitle || 'Social Card Title');

  var ogDesc = $('#inp_og_description').val().trim() || desc;
  $('#liveOgDesc').text(ogDesc || 'Social description preview...');

  var ogImg = $('#inp_og_image').val().trim();
  if (ogImg) {
    $('#liveOgImgTag').attr('src', ogImg).show();
    $('#liveOgImgIcon').hide();
  } else {
    $('#liveOgImgTag').hide();
    $('#liveOgImgIcon').show();
  }
}

$('#inp_page_url, #inp_meta_title, #inp_meta_description, #inp_og_title, #inp_og_description, #inp_og_image').on('input', updateSimulators);
$(document).ready(updateSimulators);

function insertSchemaTemplate(type) {
  var template = '';
  if (type === 'medical') {
    template = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "MedicalOrganization",
      "name": "Upchar Healthcare",
      "url": "https://upchar.info/",
      "logo": "https://upchar.info/public/assets/images/logo.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-9876543210",
        "contactType": "customer service"
      }
    }, null, 2);
  } else if (type === 'doctor') {
    template = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "Physician",
      "name": "Dr. Specialist Name",
      "medicalSpecialty": "Cardiology",
      "availableService": {
        "@type": "MedicalTest",
        "name": "Online Video Consultation"
      }
    }, null, 2);
  } else if (type === 'faq') {
    template = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{
        "@type": "Question",
        "name": "How do I book a doctor appointment on Upchar?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Search for your required specialty or city, select a verified doctor, and choose an appointment slot."
        }
      }]
    }, null, 2);
  }
  $('#inp_schema_markup').val(template);
}
</script>

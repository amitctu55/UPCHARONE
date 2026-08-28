<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Biomedical Equipment Master
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Add and catalog hospital machines, laboratory apparatus, and distributor products</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <span style="font-size: 13px; color: #64748B;">Equipment & Infrastructure</span>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 900px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-stethoscope" style="color: #0d9488; margin-right: 8px;"></i> Register Biomedical Equipment
        </h3>
      </div>

      <form action="<?=base_url()?>doctor/clinicreg/biomedicalmachine" method="post" id="myform" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Equipment Name <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="equipment" placeholder="e.g., Digital X-Ray Machine / MRI Scanner" name="equipment" data-validation="required" data-validation-error-msg="Equipment name is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Manufacturing Company <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="company_name" placeholder="e.g., GE Healthcare, Siemens" name="company_name" data-validation="required" data-validation-error-msg="Company name is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Distributor Name <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="distributor_name" placeholder="Distributor entity..." name="distributor_name" data-validation="required" data-validation-error-msg="Distributor name is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Distributor Contact Mobile <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="distributor_mobile" placeholder="10-digit mobile..." name="distributor_mobile" data-validation="required" data-validation-error-msg="Mobile is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Distributor Contact Email <span style="color: #EF4444;">*</span>
              </label>
              <input type="email" class="form-control" id="distributor_email" placeholder="contact@distributor.com" name="distributor_email" data-validation="required" data-validation-error-msg="Email is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                MRP Price (₹) <span style="color: #EF4444;">*</span>
              </label>
              <input type="number" class="form-control" id="mrp_price" placeholder="MRP" name="mrp_price" data-validation="required" data-validation-error-msg="MRP is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Offer Price (₹) <span style="color: #EF4444;">*</span>
              </label>
              <input type="number" class="form-control" id="price" placeholder="Selling price" name="price" data-validation="required" data-validation-error-msg="Price is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Discount Details / % <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="discount" placeholder="e.g., 15% OFF" name="discount" data-validation="required" data-validation-error-msg="Discount info is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Short Summary</label>
            <textarea rows="2" class="form-control" name="short" placeholder="Brief technical specifications summary..." style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"></textarea>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Detailed Technical Description</label>
            <textarea rows="4" class="form-control" name="long" placeholder="Complete equipment parameters, warranty, compliance certifications..." style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"></textarea>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Equipment Image / Brochure</label>
            <input type="file" class="form-control" id="uploadimage" name="uploadimage" style="height: 42px; padding: 6px 12px; border-radius: 8px; border: 1px solid #CBD5E1;">
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="reset" id="reset" class="btn" style="background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #CBD5E1;">Reset</button>
            <button type="submit" id="submit" name="submit" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-plus" style="margin-right: 6px;"></i> Add Equipment
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script> $.validate({}); </script>
<?=$this->load->view('inc/footer');?>
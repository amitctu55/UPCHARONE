<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Clinic Profile & Details
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View registered clinic information, address, operational status, and contacts</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/clinicreg/updateclinic/'.@$clinic->id)?>" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-pencil"></i> Edit Clinic
        </a>
        <a href="<?=base_url('doctor/clinicreg/viewclinic')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Clinics Directory
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <div style="max-width: 900px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 20px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; align-items: center; justify-content: space-between;">
        <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0F172A;">
          <i class="fa fa-building-o" style="color: #0d9488; margin-right: 8px;"></i> <?=@$clinic->name;?>
        </h3>
        <span style="display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: <?=@$clinic->status == 'A' ? '#DCFCE7; color: #15803D;' : '#FEE2E2; color: #B91C1C;';?>">
          <?=@$clinic->status == 'A' ? 'Active Clinic' : 'Inactive';?>
        </span>
      </div>

      <div style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
          <div style="background: #F8FAFC; padding: 14px 18px; border-radius: 8px; border: 1px solid #F1F5F9;">
            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Contact Email</div>
            <div style="font-size: 14px; font-weight: 600; color: #1E293B; margin-top: 4px;"><?=@$clinic->email ?: 'N/A';?></div>
          </div>

          <div style="background: #F8FAFC; padding: 14px 18px; border-radius: 8px; border: 1px solid #F1F5F9;">
            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Contact Mobile</div>
            <div style="font-size: 14px; font-weight: 600; color: #1E293B; margin-top: 4px;"><?=@$clinic->mobile ?: 'N/A';?></div>
          </div>

          <div style="background: #F8FAFC; padding: 14px 18px; border-radius: 8px; border: 1px solid #F1F5F9;">
            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">City / Location</div>
            <div style="font-size: 14px; font-weight: 600; color: #1E293B; margin-top: 4px;">
              <?php
                $city = $this->db->get_where('master_city', array('id'=>@$clinic->city))->row();
                echo $city ? $city->name : 'N/A';
              ?>
            </div>
          </div>
        </div>

        <div style="background: #F8FAFC; padding: 14px 18px; border-radius: 8px; border: 1px solid #F1F5F9;">
          <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Physical Address</div>
          <div style="font-size: 14px; color: #334155; margin-top: 4px;"><?=@$clinic->address ?: 'No address specified';?></div>
        </div>

        <div style="background: #F8FAFC; padding: 14px 18px; border-radius: 8px; border: 1px solid #F1F5F9;">
          <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">About Facility</div>
          <div style="font-size: 14px; color: #334155; margin-top: 4px; line-height: 1.6;"><?=@$clinic->about ?: 'No description provided';?></div>
        </div>

        <div style="display: flex; gap: 20px; font-size: 13px; color: #64748B; padding-top: 8px; border-top: 1px solid #F1F5F9;">
          <div><i class="fa fa-globe"></i> Website: <?=@$clinic->website ? '<a href="'.@$clinic->website.'" target="_blank" style="color: #0d9488; font-weight: 600;">'.@$clinic->website.'</a>' : 'N/A';?></div>
          <div><i class="fa fa-calendar"></i> Registered: <?=@$clinic->creat_date ? formatedate(@$clinic->creat_date) : 'N/A';?></div>
        </div>
      </div>
    </div>
  </section>
</div>

<?=$this->load->view('inc/footer');?>

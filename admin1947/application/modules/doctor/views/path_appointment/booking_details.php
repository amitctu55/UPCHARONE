<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Test Booking Details #<?=$booking->booking_id;?>
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Diagnostic appointment order breakdown, patient demographics, and assigned tests</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>doctor/path_appointment" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Bookings
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
      
      <!-- Top Cards Grid: Pathology & Patient Demographics -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
        
        <!-- Pathology Lab Details -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-hospital-o" style="color: #0d9488; margin-right: 8px;"></i> Diagnostic Pathology Lab
            </h3>
          </div>
          <div style="padding: 20px;">
            <div style="margin-bottom: 14px;">
              <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Laboratory Name</div>
              <div style="font-size: 16px; font-weight: 700; color: #0F172A; margin-top: 2px;">
                <?=$booking->pathlab_name;?>
              </div>
            </div>
            <div>
              <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Location / City</div>
              <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 2px;">
                <i class="fa fa-map-marker" style="color: #0d9488; margin-right: 4px;"></i> <?=$booking->city_name;?>
              </div>
            </div>
          </div>
        </div>

        <!-- Customer Demographics -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-user" style="color: #0d9488; margin-right: 8px;"></i> Patient Demographics
            </h3>
          </div>
          <div style="padding: 20px;">
            <div style="margin-bottom: 14px;">
              <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Full Patient Name</div>
              <div style="font-size: 16px; font-weight: 700; color: #0F172A; margin-top: 2px;">
                <?=$booking->patient_name;?>
              </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
              <div>
                <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Contact Phone</div>
                <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px;">
                  <i class="fa fa-phone" style="color: #0d9488; margin-right: 4px;"></i> <?=$booking->patient_mobile;?>
                </div>
              </div>
              <div>
                <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase;">Email Address</div>
                <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px;">
                  <i class="fa fa-envelope-o" style="color: #0d9488; margin-right: 4px;"></i> <?=$booking->patient_email ? $booking->patient_email : 'N/A';?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Test Breakdown Table Card -->
      <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
          <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fa fa-list-alt" style="color: #0d9488; margin-right: 8px;"></i> Prescribed Pathology Tests
          </h3>
        </div>

        <div class="table-responsive">
          <table class="table table-hover" style="margin: 0; border-collapse: separate; border-spacing: 0;">
            <thead>
              <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 60px;">#</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Test Full Name</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Short Code</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Methodology</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Cost (₹)</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              if(is_array($booking_test) && !empty($booking_test)) {
                foreach($booking_test as $val) { ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                  <td style="padding: 14px 16px; font-weight: 600; color: #64748B; font-size: 13px;"><?=$i;?></td>
                  <td style="padding: 14px 16px; font-weight: 600; color: #0F172A; font-size: 14px;">
                    <?=$val['test_name'];?>
                  </td>
                  <td style="padding: 14px 16px; font-size: 13px; color: #475569; font-family: monospace;">
                    <?=$val['short_name'];?>
                  </td>
                  <td style="padding: 14px 16px; font-size: 13px; color: #64748B;">
                    <?=$val['method'];?>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 600; color: #0F172A; font-size: 14px; text-align: right;">
                    ₹<?=number_format($val['amount'], 2);?>
                  </td>
                </tr>
              <?php $i++; } } else { ?>
                <tr>
                  <td colspan="5" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                    No tests booked for this order.
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr style="background: #F8FAFC; border-top: 2px solid #E2E8F0;">
                <th colspan="4" style="padding: 16px; font-size: 14px; font-weight: 700; color: #0F172A; text-align: right; text-transform: uppercase;">Grand Total:</th>
                <th style="padding: 16px; font-size: 16px; font-weight: 800; color: #0d9488; text-align: right;">
                  ₹<?=number_format($booking->total_amount, 2);?>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>
<style>
  :root {
    --up-teal: #00a896;
    --up-teal-dark: #008f80;
    --up-teal-light: #f0fdfa;
    --up-navy: #1d2a44;
    --up-gold: #f59e0b;
    --up-gold-light: #fef3c7;
    --up-slate-900: #0f172a;
    --up-slate-800: #1e293b;
    --up-slate-600: #475569;
    --up-slate-100: #f8fafc;
    --up-border: #e2e8f0;
  }

  .wallet-page-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--up-slate-800);
    padding: 30px 0 60px;
    background: #f8fafc;
    min-height: 80vh;
  }

  /* Hero Points Balance Card */
  .points-hero-card {
    background: linear-gradient(135deg, #1d2a44 0%, #0f172a 100%);
    border-radius: 18px;
    padding: 30px;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
    position: relative;
    overflow: hidden;
    margin-bottom: 25px;
  }
  .points-hero-card::after {
    content: "";
    position: absolute;
    top: -40px;
    right: -40px;
    width: 180px;
    height: 180px;
    background: radial-gradient(circle, rgba(0, 168, 150, 0.35) 0%, rgba(0,0,0,0) 70%);
    border-radius: 50%;
  }

  .points-coin-badge {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
  }

  .points-amount-big {
    font-size: 38px;
    font-weight: 900;
    color: #ffffff;
    line-height: 1.1;
    margin: 10px 0 4px;
    font-family: 'Inter', sans-serif;
  }

  .points-equivalent-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.12);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13.5px;
    color: #a7f3d0;
    font-weight: 600;
  }

  /* Recharge Card */
  .wallet-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--up-border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    padding: 24px;
    margin-bottom: 25px;
  }

  .wallet-card-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--up-slate-900);
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .topup-chip {
    padding: 10px 16px;
    border-radius: 10px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
  }
  .topup-chip:hover, .topup-chip.active {
    background: var(--up-teal);
    color: #ffffff;
    border-color: var(--up-teal);
    box-shadow: 0 4px 10px rgba(0, 168, 150, 0.25);
  }

  /* Transaction History Table */
  .txn-table-wrap {
    overflow-x: auto;
  }
  .txn-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  .txn-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--up-border);
  }
  .txn-table td {
    padding: 14px 16px;
    font-size: 13.5px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .txn-table tr:hover td {
    background: #f8fafc;
  }

  .txn-badge-credit {
    background: #dcfce7;
    color: #15803d;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .txn-badge-debit {
    background: #fee2e2;
    color: #b91c1c;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
</style>

<div class="wallet-page-container">
  <div class="container">
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <div class="row">
      <!-- Left Column: Points Hero Balance & Quick Recharge -->
      <div class="col-md-5 col-sm-12">
        
        <!-- Upchar Points Balance Card -->
        <div class="points-hero-card">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
              <span style="font-size: 12.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">
                Your Healthcare Balance
              </span>
              <div class="points-amount-big">
                <?=number_format($wallet['points_balance'], 2);?> <span style="font-size: 20px; font-weight: 600; color: #f59e0b;">Pts</span>
              </div>
              <div class="points-equivalent-tag">
                <i class="fa fa-inr"></i> ₹<?=number_format($wallet['currency_equivalent'], 2);?> INR Value (1 Pts = ₹<?=$point_ratio;?>)
              </div>
            </div>
            <div class="points-coin-badge">
              <i class="fa fa-star"></i>
            </div>
          </div>

          <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.12); display: flex; justify-content: space-between;">
            <div>
              <span style="display: block; font-size: 11.5px; color: #94a3b8;">Lifetime Earned</span>
              <strong style="color: #ffffff; font-size: 14px;">+<?=number_format($wallet['lifetime_earned'], 2);?> Pts</strong>
            </div>
            <div>
              <span style="display: block; font-size: 11.5px; color: #94a3b8;">Total Redeemed</span>
              <strong style="color: #ffffff; font-size: 14px;">-<?=number_format($wallet['lifetime_spent'], 2);?> Pts</strong>
            </div>
            <div>
              <span style="display: block; font-size: 11.5px; color: #94a3b8;">Wallet Status</span>
              <strong style="color: #34d399; font-size: 14px;"><i class="fa fa-check-circle"></i> Active</strong>
            </div>
          </div>
        </div>

        <!-- Quick Top-Up / Buy Points Card -->
        <div class="wallet-card">
          <h3 class="wallet-card-title">
            <i class="fa fa-plus-circle" style="color: var(--up-teal);"></i> Recharge Upchar Points
          </h3>
          <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
            Buy Upchar Points to enjoy 1-click seamless checkout on appointments &amp; lab tests.
          </p>

          <form action="<?=base_url('wallet/recharge');?>" method="post" id="rechargeForm">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            <div class="form-group">
              <label style="font-size: 13px; font-weight: 700; color: #334155;">Select Quick Top-Up Amount:</label>
              <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px;">
                <span class="topup-chip" onclick="setTopupAmount(100)">₹100</span>
                <span class="topup-chip active" onclick="setTopupAmount(250)">₹250</span>
                <span class="topup-chip" onclick="setTopupAmount(500)">₹500</span>
                <span class="topup-chip" onclick="setTopupAmount(1000)">₹1,000</span>
                <span class="topup-chip" onclick="setTopupAmount(2000)">₹2,000</span>
              </div>
            </div>

            <div class="form-group">
              <label style="font-size: 13px; font-weight: 700; color: #334155;">Enter Amount (₹ INR):</label>
              <div class="input-group">
                <span class="input-group-addon" style="font-weight: 700; background: #f8fafc; border-color: #cbd5e1;">₹</span>
                <input type="number" step="1" min="10" name="amount" id="rechargeAmount" value="250" class="form-control" style="height: 44px; font-size: 16px; font-weight: 700; border-color: #cbd5e1;" required>
              </div>
            </div>

            <button type="submit" class="btn btn-block" style="background: var(--up-teal); color: #ffffff; font-weight: 700; padding: 12px; font-size: 15px; border-radius: 8px; border: none; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3); margin-top: 10px;">
              <i class="fa fa-lock"></i> Add Points Securely
            </button>
          </form>
        </div>

        <!-- Benefits & Rewards Card -->
        <div class="wallet-card" style="background: #f0fdfa; border-color: #ccfbf1;">
          <h4 style="margin: 0 0 10px; font-size: 14.5px; font-weight: 800; color: #065f46;">
            <i class="fa fa-gift" style="color: var(--up-teal);"></i> Upchar Points Benefits
          </h4>
          <ul style="padding-left: 18px; margin: 0; font-size: 13px; color: #047857; line-height: 1.6;">
            <li><strong><?=$cashback_pct;?>% Cashback Points</strong> on every completed doctor appointment.</li>
            <li>Instant 1-Click zero-OTP checkout for healthcare bookings.</li>
            <li>Points never expire and can be redeemed across any hospital or clinic.</li>
          </ul>
        </div>

      </div>

      <!-- Right Column: Transactions History Ledger -->
      <div class="col-md-7 col-sm-12">
        <div class="wallet-card">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
            <h3 class="wallet-card-title" style="margin: 0;">
              <i class="fa fa-history" style="color: var(--up-teal);"></i> Points &amp; Payment Ledger
            </h3>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">
              <?=count($transactions);?> Transactions Recorded
            </span>
          </div>

          <div class="txn-table-wrap">
            <table class="txn-table">
              <thead>
                <tr>
                  <th>Date &amp; Ref</th>
                  <th>Description</th>
                  <th>Type</th>
                  <th style="text-align: right;">Points</th>
                  <th style="text-align: right;">Balance</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($transactions)): ?>
                  <?php foreach($transactions as $txn): 
                    $isCredit = ($txn['type'] === 'CREDIT');
                  ?>
                  <tr>
                    <td>
                      <div style="font-weight: 700; color: #0f172a; font-size: 13px;">
                        <?=date('d M Y', strtotime($txn['created_at']));?>
                      </div>
                      <small style="color: #64748b; font-family: monospace; font-size: 11px;">
                        <?=$txn['txn_ref'];?>
                      </small>
                    </td>
                    <td>
                      <div style="font-weight: 600; color: #1e293b; font-size: 13px;">
                        <?=htmlspecialchars($txn['description'] ?: $txn['source']);?>
                      </div>
                      <?php if(!empty($txn['reference_id'])): ?>
                        <small style="color: #0284c7;">Ref #<?=htmlspecialchars($txn['reference_id']);?></small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="<?=$isCredit ? 'txn-badge-credit' : 'txn-badge-debit';?>">
                        <i class="fa <?=$isCredit ? 'fa-arrow-down' : 'fa-arrow-up';?>"></i>
                        <?=$txn['type'];?>
                      </span>
                    </td>
                    <td style="text-align: right; font-weight: 800; font-size: 14px; color: <?=$isCredit ? '#15803d' : '#b91c1c';?>;">
                      <?=$isCredit ? '+' : '-';?><?=number_format($txn['amount_points'], 2);?>
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #334155; font-size: 13px;">
                      <?=number_format($txn['balance_after'], 2);?> Pts
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                      <i class="fa fa-inbox" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                      No transactions recorded yet.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function setTopupAmount(amt) {
  document.getElementById('rechargeAmount').value = amt;
  var chips = document.querySelectorAll('.topup-chip');
  chips.forEach(function(c) {
    c.classList.remove('active');
    if (c.innerText === '₹' + amt || c.innerText === '₹' + Number(amt).toLocaleString()) {
      c.classList.add('active');
    }
  });
}
</script>

<style>
  :root {
    --adm-teal: #00a896;
    --adm-teal-dark: #008f80;
    --adm-teal-light: #f0fdfa;
    --adm-gold: #f59e0b;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-600: #475569;
    --adm-border: #e2e8f0;
  }

  .kpi-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }
  @media (max-width: 991px) {
    .kpi-grid-4 { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 600px) {
    .kpi-grid-4 { grid-template-columns: 1fr; }
  }

  .kpi-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .kpi-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .wallet-tab-nav {
    display: flex;
    gap: 10px;
    border-bottom: 2px solid var(--adm-border);
    margin-bottom: 20px;
    padding-bottom: 2px;
  }
  .wallet-tab-btn {
    padding: 10px 18px;
    border-radius: 8px 8px 0 0;
    font-size: 14px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
  }
  .wallet-tab-btn.active {
    color: var(--adm-teal);
    border-bottom: 3px solid var(--adm-teal);
    background: #ffffff;
  }

  .wallet-panel-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
  }
  .wallet-panel-header {
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid var(--adm-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 4px; font-family: 'Inter', sans-serif;">
          <i class="fa fa-star" style="color: #f59e0b;"></i> Upchar Points &amp; Payment Master
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage digital healthcare currency, monitor wallet balances, audit transactions, and adjust reward rules</p>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; padding: 0; background: transparent; margin: 0;">
        <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Masters</a></li>
        <li class="active">Upchar Points</li>
      </ol>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- 4 KPI Metrics -->
    <div class="kpi-grid-4">
      <div class="kpi-card">
        <div class="kpi-icon-wrap" style="background: #fef3c7; color: #d97706;">
          <i class="fa fa-star"></i>
        </div>
        <div>
          <span style="display: block; font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Points In Circulation</span>
          <h3 style="margin: 2px 0 0; font-size: 22px; font-weight: 800; color: #0f172a;"><?=number_format($total_points, 2);?></h3>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-wrap" style="background: #e0f2fe; color: #0284c7;">
          <i class="fa fa-users"></i>
        </div>
        <div>
          <span style="display: block; font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Active User Wallets</span>
          <h3 style="margin: 2px 0 0; font-size: 22px; font-weight: 800; color: #0f172a;"><?=number_format($total_wallets);?></h3>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-wrap" style="background: #dcfce7; color: #166534;">
          <i class="fa fa-gift"></i>
        </div>
        <div>
          <span style="display: block; font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Lifetime Points Awarded</span>
          <h3 style="margin: 2px 0 0; font-size: 22px; font-weight: 800; color: #166534;">+<?=number_format($total_earned, 2);?></h3>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-wrap" style="background: #fee2e2; color: #b91c1c;">
          <i class="fa fa-shopping-cart"></i>
        </div>
        <div>
          <span style="display: block; font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Lifetime Points Redeemed</span>
          <h3 style="margin: 2px 0 0; font-size: 22px; font-weight: 800; color: #b91c1c;">-<?=number_format($total_spent, 2);?></h3>
        </div>
      </div>
    </div>

    <!-- Tabbed Navigation -->
    <div class="wallet-tab-nav">
      <a href="<?=base_url('masters/walletadmin?tab=wallets');?>" class="wallet-tab-btn <?=$active_tab==='wallets'?'active':'';?>">
        <i class="fa fa-id-card-o"></i> User Wallets Directory
      </a>
      <a href="<?=base_url('masters/walletadmin?tab=txns');?>" class="wallet-tab-btn <?=$active_tab==='txns'?'active':'';?>">
        <i class="fa fa-list-alt"></i> Transaction Audit Ledger
      </a>
      <a href="<?=base_url('masters/walletadmin?tab=settings');?>" class="wallet-tab-btn <?=$active_tab==='settings'?'active':'';?>">
        <i class="fa fa-sliders"></i> Points &amp; Reward Rules
      </a>
    </div>

    <!-- TAB 1: User Wallets Directory -->
    <?php if($active_tab === 'wallets'): ?>
    <div class="wallet-panel-card">
      <div class="wallet-panel-header">
        <form action="<?=base_url('masters/walletadmin');?>" method="get" style="display: flex; gap: 8px; max-width: 400px; width: 100%;">
          <input type="hidden" name="tab" value="wallets">
          <input type="text" name="keyword" value="<?=$keyword;?>" placeholder="Search by name, mobile, email..." class="form-control" style="height: 38px; border-radius: 6px;">
          <button type="submit" class="btn" style="background: var(--adm-teal); color: #ffffff; font-weight: 600; padding: 0 16px; border-radius: 6px;">
            <i class="fa fa-search"></i>
          </button>
          <?php if(!empty($keyword)): ?>
            <a href="<?=base_url('masters/walletadmin?tab=wallets');?>" class="btn btn-default" style="border-radius: 6px;"><i class="fa fa-times text-danger"></i></a>
          <?php endif; ?>
        </form>

        <span style="font-size: 13px; color: #64748b; font-weight: 600;">
          Showing <?=count($wallets);?> User Wallets
        </span>
      </div>

      <div class="table-responsive" style="padding: 10px;">
        <table class="table table-hover table-striped" style="width: 100%; border-collapse: separate; border-spacing: 0;">
          <thead>
            <tr style="background: #f8fafc;">
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">#User ID</th>
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Patient Name</th>
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Contact Info</th>
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: right;">Points Balance</th>
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: right;">Lifetime Earned</th>
              <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($wallets)): ?>
              <?php foreach($wallets as $w): ?>
              <tr>
                <td style="padding: 12px 14px; font-weight: 700; color: #64748b; font-size: 13px;">#<?=$w['user_id'];?></td>
                <td style="padding: 12px 14px; font-weight: 700; color: #0f172a; font-size: 14px;">
                  <?=htmlspecialchars(trim($w['FNAME'] . ' ' . $w['LNAME']) ?: 'User #' . $w['user_id']);?>
                </td>
                <td style="padding: 12px 14px; font-size: 13px; color: #475569;">
                  <div><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($w['MOBILE'] ?: 'N/A');?></div>
                  <?php if(!empty($w['EMAIL'])): ?>
                    <small style="color: #0284c7;"><?=htmlspecialchars($w['EMAIL']);?></small>
                  <?php endif; ?>
                </td>
                <td style="padding: 12px 14px; text-align: right;">
                  <strong style="font-size: 15px; color: #0f172a;"><?=number_format($w['points_balance'], 2);?></strong>
                  <span style="font-size: 11.5px; color: #059669; display: block;">(₹<?=number_format($w['currency_equivalent'], 2);?>)</span>
                </td>
                <td style="padding: 12px 14px; text-align: right; color: #166534; font-weight: 600; font-size: 13px;">
                  +<?=number_format($w['lifetime_earned'], 2);?>
                </td>
                <td style="padding: 12px 14px; text-align: center;">
                  <button type="button" class="btn btn-sm btn-default adjust-btn" 
                          data-uid="<?=$w['user_id'];?>" 
                          data-uname="<?=htmlspecialchars(trim($w['FNAME'] . ' ' . $w['LNAME']));?>" 
                          data-balance="<?=$w['points_balance'];?>"
                          style="border-radius: 6px; font-weight: 600; color: #0284c7; border-color: #bae6fd; background: #f0f9ff;">
                    <i class="fa fa-sliders"></i> Adjust Points
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">No wallets found matching query.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- TAB 2: Transaction Audit Ledger -->
    <?php if($active_tab === 'txns'): ?>
    <div class="wallet-panel-card">
      <div class="wallet-panel-header">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">
          <i class="fa fa-history" style="color: var(--adm-teal);"></i> Master Transaction Ledger (Last 100)
        </h3>
      </div>
      <div class="table-responsive" style="padding: 10px;">
        <table class="table table-hover table-striped">
          <thead>
            <tr style="background: #f8fafc;">
              <th>Txn Ref &amp; Date</th>
              <th>User</th>
              <th>Source &amp; Description</th>
              <th>Type</th>
              <th style="text-align: right;">Points</th>
              <th style="text-align: right;">Balance (Before &rarr; After)</th>
              <th style="text-align: center;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($transactions)): ?>
              <?php foreach($transactions as $t): 
                $isCredit = ($t['type'] === 'CREDIT');
              ?>
              <tr>
                <td>
                  <strong style="color: #0f172a; font-family: monospace; font-size: 12px;"><?=$t['txn_ref'];?></strong>
                  <div style="font-size: 11.5px; color: #64748b;"><?=date('d M Y, h:i A', strtotime($t['created_at']));?></div>
                </td>
                <td>
                  <strong><?=htmlspecialchars(trim($t['FNAME'] . ' ' . $t['LNAME']) ?: 'User #' . $t['user_id']);?></strong>
                  <small style="display: block; color: #64748b;"><?=htmlspecialchars($t['MOBILE']);?></small>
                </td>
                <td>
                  <span class="label label-default" style="font-size: 11px;"><?=$t['source'];?></span>
                  <div style="font-size: 12.5px; color: #334155; margin-top: 3px;"><?=htmlspecialchars($t['description']);?></div>
                </td>
                <td>
                  <span class="label <?=$isCredit ? 'label-success' : 'label-danger';?>">
                    <?=$t['type'];?>
                  </span>
                </td>
                <td style="text-align: right; font-weight: 800; font-size: 14px; color: <?=$isCredit ? '#15803d' : '#b91c1c';?>;">
                  <?=$isCredit ? '+' : '-';?><?=number_format($t['amount_points'], 2);?>
                </td>
                <td style="text-align: right; font-size: 12.5px; color: #475569;">
                  <?=number_format($t['balance_before'], 2);?> &rarr; <strong><?=number_format($t['balance_after'], 2);?></strong>
                </td>
                <td style="text-align: center;">
                  <span class="label label-success" style="font-size: 10.5px;"><?=$t['status'];?></span>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- TAB 3: Points Conversion & Rules Settings -->
    <?php if($active_tab === 'settings'): ?>
    <div class="row">
      <div class="col-md-7 col-sm-12">
        <div class="wallet-panel-card">
          <div class="wallet-panel-header">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">
              <i class="fa fa-cog" style="color: var(--adm-teal);"></i> Points Valuation &amp; Cashback Rules
            </h3>
          </div>
          <form action="<?=base_url('masters/walletadmin/save_settings');?>" method="post" style="padding: 20px;">
            <div style="display: flex; flex-direction: column; gap: 16px;">
              <?php foreach($settings as $st): ?>
              <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                  <?=ucwords(str_replace('_', ' ', $st['setting_key']));?>
                </label>
                <input type="text" name="settings[<?=$st['setting_key'];?>]" value="<?=htmlspecialchars($st['setting_value']);?>" class="form-control" style="height: 40px; border-radius: 6px; font-weight: 600;" required>
                <?php if(!empty($st['description'])): ?>
                  <small style="color: #64748b; font-size: 12px;"><?=htmlspecialchars($st['description']);?></small>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>

              <button type="submit" class="btn" style="background: var(--adm-teal); color: #ffffff; font-weight: 700; padding: 10px 24px; border-radius: 6px; margin-top: 10px; align-self: flex-start;">
                <i class="fa fa-save"></i> Save Points Configuration
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </section>
</div>

<!-- Modal: Adjust Points -->
<div class="modal fade" id="adjustModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 440px;">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: 800; color: #0f172a; font-size: 16px;">
          <i class="fa fa-sliders" style="color: var(--adm-teal);"></i> Adjust User Points
        </h4>
      </div>
      <form action="<?=base_url('masters/walletadmin/adjust_points');?>" method="post" style="padding: 20px;">
        <input type="hidden" name="user_id" id="modalUserId">

        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div>
            <span style="font-size: 12px; color: #64748b; display: block;">Patient Account:</span>
            <strong id="modalUserName" style="font-size: 15px; color: #0f172a;"></strong>
            <div style="font-size: 13px; color: #059669; font-weight: 600; margin-top: 2px;">
              Current Balance: <span id="modalBalance"></span> Pts
            </div>
          </div>

          <div>
            <label style="font-size: 13px; font-weight: 700; color: #334155;">Adjustment Type:</label>
            <select name="type" class="form-control" style="height: 38px; border-radius: 6px; font-weight: 700;">
              <option value="CREDIT" style="color: #166534;">➕ CREDIT Points (Add Bonus / Reward)</option>
              <option value="DEBIT" style="color: #b91c1c;">➖ DEBIT Points (Deduct / Adjustment)</option>
            </select>
          </div>

          <div>
            <label style="font-size: 13px; font-weight: 700; color: #334155;">Amount of Upchar Points:</label>
            <input type="number" step="0.01" min="1" name="points" placeholder="e.g. 50" class="form-control" style="height: 40px; font-size: 16px; font-weight: 700;" required>
          </div>

          <div>
            <label style="font-size: 13px; font-weight: 700; color: #334155;">Reason / Admin Audit Note:</label>
            <input type="text" name="note" placeholder="e.g., Promotional welcome credit, compensation..." class="form-control" style="height: 38px;" required>
          </div>

          <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="flex: 1; border-radius: 6px; font-weight: 600;">Cancel</button>
            <button type="submit" class="btn" style="flex: 1.5; background: var(--adm-teal); color: #ffffff; font-weight: 700; border-radius: 6px;">
              Confirm Adjustment
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('.adjust-btn').click(function() {
    var uid = $(this).attr('data-uid');
    var uname = $(this).attr('data-uname');
    var bal = $(this).attr('data-balance');

    $('#modalUserId').val(uid);
    $('#modalUserName').text(uname + ' (#' + uid + ')');
    $('#modalBalance').text(Number(bal).toFixed(2));
    $('#adjustModal').modal('show');
  });
});
</script>

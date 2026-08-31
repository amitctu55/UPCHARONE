<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPCHAR Provider Payouts & Settlements Clearinghouse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d7a6e;
            --primary-light: #14b8a6;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-lg: 16px;
            --radius-md: 10px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: var(--text-dark);
            margin: 0;
            padding: 30px 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-trigger-batch {
            background: linear-gradient(135deg, #1ab5a0 0%, #0d7a6e 100%);
            color: #ffffff;
            border: none;
            padding: 12px 22px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-trigger-batch:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 122, 110, 0.3);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 22px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .metric-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metric-val {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
        }

        .card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            text-align: left;
            padding: 12px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-processing {
            background: #fef3c7;
            color: #d97706;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa-solid fa-money-bill-transfer" style="color: var(--primary);"></i> Payouts & Provider Settlements
        </h1>
        <button type="button" class="btn-trigger-batch" onclick="triggerPayoutBatch()">
            <i class="fa-solid fa-play"></i> Trigger Payout Batch (RazorpayX)
        </button>
    </div>

    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Pending Payout Pool</div>
            <div class="metric-val">₹<?php echo number_format($total_pending_amount, 2); ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Facilities with Pending Balances</div>
            <div class="metric-val"><?php echo count($pending_settlements); ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Settlement Frequency</div>
            <div class="metric-val" style="font-size: 20px; color: #1e293b;">Weekly (T+7)</div>
        </div>
    </div>

    <!-- Pending Facilities Table -->
    <div class="card">
        <h2 class="card-title"><i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i> Pending Provider Balances Ready for Disbursement</h2>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Facility Type</th>
                        <th>Facility ID</th>
                        <th>Facility Name</th>
                        <th>Completed Encounters</th>
                        <th>Net Share Payable (INR)</th>
                        <th>Disbursement Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pending_settlements)): ?>
                        <?php foreach ($pending_settlements as $ps): ?>
                        <tr>
                            <td><span style="text-transform: uppercase; font-weight: 600;"><?php echo htmlspecialchars($ps['facility_type']); ?></span></td>
                            <td><code>#<?php echo $ps['facility_id']; ?></code></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($ps['facility_name'] ?: 'Provider ' . $ps['facility_id']); ?></td>
                            <td><?php echo $ps['total_txns']; ?> Encounters</td>
                            <td style="font-weight: 700; color: var(--primary);">₹<?php echo number_format($ps['total_pending_amount'], 2); ?></td>
                            <td><span class="badge-status badge-processing"><i class="fa-solid fa-clock"></i> Queued</span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 25px;">
                                All provider payouts are settled! No pending balances.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Batches -->
    <div class="card">
        <h2 class="card-title"><i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Historical Payout Settlement Batches</h2>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Batch Ref</th>
                        <th>Date</th>
                        <th>Facilities</th>
                        <th>Total Amount</th>
                        <th>Success</th>
                        <th>Failed</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_batches)): ?>
                        <?php foreach ($recent_batches as $b): ?>
                        <tr>
                            <td><code><?php echo htmlspecialchars($b['batch_ref']); ?></code></td>
                            <td><?php echo date('d M Y', strtotime($b['batch_date'])); ?></td>
                            <td><?php echo $b['total_facilities']; ?></td>
                            <td style="font-weight: 700;">₹<?php echo number_format($b['total_amount'], 2); ?></td>
                            <td style="color: #16a34a; font-weight: 600;"><?php echo $b['successful_payouts']; ?></td>
                            <td style="color: #dc2626; font-weight: 600;"><?php echo $b['failed_payouts']; ?></td>
                            <td>
                                <span class="badge-status <?php echo ($b['status'] === 'COMPLETED') ? 'badge-completed' : 'badge-processing'; ?>">
                                    <?php echo $b['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 25px;">
                                No payout batches executed yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function triggerPayoutBatch() {
        if (!confirm('Are you sure you want to execute a live settlement batch to all verified providers?')) {
            return;
        }

        fetch('<?php echo base_url("payout/trigger_batch"); ?>', {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Batch processed.');
            window.location.reload();
        })
        .catch(err => {
            alert('Failed to trigger batch. Please try again.');
        });
    }
</script>

</body>
</html>

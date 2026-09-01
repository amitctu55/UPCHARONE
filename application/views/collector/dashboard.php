<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-mobile">
    <!-- Top KPI Bar -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 18px;">
        <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Today's Pickups</div>
            <div style="font-size: 24px; font-weight: 800; color: #0f172a; margin-top: 2px;">
                <?=$completed_tasks;?> <span style="font-size: 14px; color: #94a3b8; font-weight: 600;">/ <?=$total_tasks;?></span>
            </div>
            <div style="font-size: 11px; color: #00a896; font-weight: 700; margin-top: 4px;">
                <i class="fa fa-check-circle"></i> <?=$pending_tasks;?> Pending Pickups
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Cash Collected</div>
            <div style="font-size: 24px; font-weight: 800; color: #16a34a; margin-top: 2px;">
                ₹<?=number_format($cash_collected, 2);?>
            </div>
            <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 4px;">
                To deposit at Hub
            </div>
        </div>
    </div>

    <!-- Attendance Status Card -->
    <?php if (empty($today_punch)): ?>
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #f59e0b; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <strong style="color: #92400e; font-size: 13px;"><i class="fa fa-exclamation-circle"></i> Morning Punch Pending</strong>
                <div style="font-size: 11.5px; color: #b45309;">Punch in with selfie to begin fieldwork</div>
            </div>
            <a href="<?=base_url('attendance/punch');?>" class="btn btn-xs" style="background: #d97706; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 12px; text-decoration: none;">
                Punch Now
            </a>
        </div>
    <?php endif; ?>

    <!-- Section Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-calendar-check-o" style="color: var(--col-teal); margin-right: 6px;"></i> Doorstep Pickup Queue
        </h4>
        <span style="font-size: 12px; color: #64748b; font-weight: 600;"><?=date('D, d M Y');?></span>
    </div>

    <!-- Pickup Task Cards -->
    <?php if (!empty($tasks)): ?>
        <?php foreach ($tasks as $t): 
            $status = $t['collection_status'] ?: 'assigned';
            $isComplete = in_array($status, ['sample_collected', 'handed_to_lab', 'report_ready']);
            $badgeColor = ($status === 'sample_collected' || $status === 'handed_to_lab') ? '#10b981' : (($status === 'en_route') ? '#0284c7' : (($status === 'arrived') ? '#d97706' : '#64748b'));
        ?>
        <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); position: relative; border-left: 4px solid <?=$badgeColor;?>;">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">
                        Order #<?=$t['booking_id'];?> &bull; <?=$t['time_slot'] ?: 'Morning Slot';?>
                    </span>
                    <h5 style="margin: 3px 0 0; font-size: 16px; font-weight: 800; color: #0f172a;">
                        <?=html_escape($t['patient_name'] ?: 'Patient');?>
                    </h5>
                </div>
                <span style="background: <?=$badgeColor;?>; color: #ffffff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: capitalize;">
                    <?=str_replace('_', ' ', $status);?>
                </span>
            </div>

            <!-- Address & Navigation -->
            <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; font-size: 12.5px; color: #334155;">
                <div style="display: flex; align-items: flex-start; gap: 8px;">
                    <i class="fa fa-map-marker" style="color: #ef4444; font-size: 16px; margin-top: 2px;"></i>
                    <div>
                        <div style="font-weight: 600;"><?=html_escape($t['patient_address'] ?: 'Doorstep Collection, Lucknow');?></div>
                        <div style="color: #64748b; font-size: 11.5px; margin-top: 2px;">
                            <i class="fa fa-phone"></i> <?=html_escape($t['patient_mobile']);?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Item & Fee Breakdown -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; font-size: 13px;">
                <div>
                    <div style="font-weight: 700; color: #1e293b;"><?=html_escape($t['test_name'] ?: 'Diagnostic Pathology Test');?></div>
                    <small style="color: #64748b;"><i class="fa fa-hospital-o"></i> <?=$t['lab_name'] ?: 'Upchar Central Lab';?></small>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 800; color: #00a896; font-size: 15px;">₹<?=number_format($t['amount'], 2);?></div>
                    <small style="font-size: 11px; font-weight: 700; color: <?=$t['payment_status']=='1' ? '#16a34a' : '#ea580c';?>">
                        <?=$t['payment_status']=='1' ? 'PAID' : 'COLLECT CASH/UPI';?>
                    </small>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?=urlencode($t['patient_address'] ?: 'Lucknow');?>" target="_blank" class="btn btn-sm" style="background: #ffffff; color: #0284c7; border: 1px solid #cbd5e1; font-weight: 700; border-radius: 8px; padding: 8px 12px; text-decoration: none; text-align: center;">
                    <i class="fa fa-location-arrow"></i> Navigate
                </a>
                <a href="<?=base_url('collector/pickup/' . $t['booking_id']);?>" class="btn btn-sm" style="background: var(--col-teal); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 8px 12px; text-decoration: none; text-align: center; box-shadow: 0 2px 6px rgba(0,168,150,0.3);">
                    <?=$isComplete ? '<i class="fa fa-eye"></i> View Sample' : '<i class="fa fa-arrow-right"></i> Open Task';?>
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 40px 20px; text-align: center; color: #94a3b8;">
            <i class="fa fa-motorcycle" style="font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
            <h5 style="margin: 0 0 6px; font-weight: 700; color: #475569;">No Pickups Assigned</h5>
            <p style="font-size: 13px; margin: 0;">New doorstep pickup requests will appear here in real-time.</p>
        </div>
    <?php endif; ?>
</div>

<?php
$db = new mysqli('127.0.0.1', 'upchar5510', 'Ranu@28010', 'upchar5510_db', 3307);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error . "\n");
}

@$db->query("ALTER TABLE `medicines_master` ADD COLUMN IF NOT EXISTS `pack_size` varchar(50) DEFAULT '10 Tablets'");
@$db->query("ALTER TABLE `medicines_master` ADD COLUMN IF NOT EXISTS `hsn_code` varchar(20) DEFAULT '3004'");
@$db->query("ALTER TABLE `medicines_master` ADD COLUMN IF NOT EXISTS `default_gst_percent` decimal(5,2) DEFAULT 12.00");

// Add missing columns to pharmacy_settlements if table already existed
$alterCols = [
    'commission_rate' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `commission_rate` decimal(5,2) DEFAULT 8.00",
    'cod_remittance' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `cod_remittance` decimal(10,2) DEFAULT 0.00",
    'order_count' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `order_count` int(11) DEFAULT 0",
    'bank_account_no' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `bank_account_no` varchar(50) DEFAULT NULL",
    'bank_ifsc' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `bank_ifsc` varchar(20) DEFAULT NULL",
    'bank_name' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `bank_name` varchar(100) DEFAULT NULL",
    'settlement_notes' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `settlement_notes` text DEFAULT NULL",
    'created_at' => "ALTER TABLE `pharmacy_settlements` ADD COLUMN IF NOT EXISTS `created_at` datetime DEFAULT current_timestamp()"
];

foreach ($alterCols as $name => $sqlAlter) {
    @$db->query($sqlAlter);
}

@$db->query("ALTER TABLE `pharmacy_settlements` MODIFY COLUMN `settlement_status` enum('DUE','PENDING','PROCESSING','PAID','PROCESSED','FAILED') DEFAULT 'DUE'");

echo "=== Running Seeders ===\n";

// Ensure medicines_master has baseline records
$meds = [
    [1, 'Dolo 650', 'Paracetamol 650mg', 'Micro Labs Ltd', 'Tablet', '15 Tablets', '650mg', '3004', 12.00, 'OTC', 0],
    [2, 'Augmentin 625 Duo', 'Amoxicillin 500mg + Clavulanic Acid 125mg', 'GlaxoSmithKline', 'Tablet', '10 Tablets', '625mg', '3004', 12.00, 'H', 1],
    [3, 'Pan-D Capsule', 'Pantoprazole 40mg + Domperidone 30mg SR', 'Alkem Laboratories Ltd', 'Capsule', '15 Capsules', '40mg/30mg', '3004', 12.00, 'H', 1],
    [4, 'Azithral 500', 'Azithromycin 500mg', 'Alembic Pharmaceuticals Ltd', 'Tablet', '5 Tablets', '500mg', '3004', 12.00, 'H', 1],
    [5, 'Telma 40', 'Telmisartan 40mg', 'Glenmark Pharmaceuticals Ltd', 'Tablet', '15 Tablets', '40mg', '3004', 12.00, 'H', 1]
];

foreach ($meds as $m) {
    $stmt = $db->prepare("INSERT INTO `medicines_master` (`id`, `brand_name`, `generic_composition`, `manufacturer`, `dosage_form`, `pack_size`, `strength`, `hsn_code`, `default_gst_percent`, `schedule_type`, `is_prescription_required`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `brand_name`=VALUES(`brand_name`)");
    $stmt->bind_param('isssssssdss', $m[0], $m[1], $m[2], $m[3], $m[4], $m[5], $m[6], $m[7], $m[8], $m[9], $m[10]);
    $stmt->execute();
}
echo "Medicines master records verified.\n";

// Seed 10 Inventory Batches (FEFO Expiry dates)
$batches = [
    // Pharmacy 2 (Sanjivani 24x7 Chemist)
    [2, 1, 'BATCH-DL2601', '2026-11-30', 21.50, 33.60, 10.71, 30.00, 12.00, 140, 15, 1],
    [2, 1, 'BATCH-DL2704', '2027-04-30', 22.00, 33.60, 10.71, 30.00, 12.00, 250, 15, 1],
    [2, 2, 'BATCH-AUG2608', '2026-10-15', 140.00, 204.50, 14.42, 175.00, 12.00, 6, 10, 1],
    [2, 3, 'BATCH-PAND2607', '2026-07-31', 115.00, 199.00, 17.08, 165.00, 12.00, 48, 10, 1],
    [2, 4, 'BATCH-AZ2801', '2028-01-31', 82.00, 132.00, 12.87, 115.00, 12.00, 65, 10, 1],
    // Pharmacy 1 (Apex Care Medicos)
    [1, 1, 'BATCH-APX101', '2027-06-30', 20.00, 33.60, 15.17, 28.50, 12.00, 95, 10, 1],
    [1, 2, 'BATCH-APX102', '2027-09-30', 138.00, 204.50, 16.87, 170.00, 12.00, 42, 10, 1],
    [1, 3, 'BATCH-APX103', '2026-09-15', 110.00, 199.00, 19.59, 160.00, 12.00, 4, 10, 1],
    [1, 5, 'BATCH-APX104', '2028-06-30', 75.00, 120.00, 12.50, 105.00, 12.00, 50, 10, 1],
    [1, 4, 'BATCH-APX105', '2027-12-31', 80.00, 132.00, 15.15, 112.00, 12.00, 80, 10, 1]
];

$db->query("TRUNCATE TABLE `pharmacy_inventory_batches`");
foreach ($batches as $b) {
    $stmt = $db->prepare("INSERT INTO `pharmacy_inventory_batches` (`pharmacy_id`, `medicine_id`, `batch_number`, `expiry_date`, `buy_rate_per_unit`, `mrp_per_unit`, `discount_percent`, `selling_price_per_unit`, `gst_percent`, `available_quantity`, `low_stock_threshold`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('iisddddddiii', $b[0], $b[1], $b[2], $b[3], $b[4], $b[5], $b[6], $b[7], $b[8], $b[9], $b[10], $b[11]);
    $stmt->execute();
}
echo "10 Inventory Batches seeded successfully.\n";

// Seed Settlements Data
$settlements = [
    [
        'pharmacy_id' => 2, // Sanjivani 24x7 Chemist
        'period_start' => date('Y-m-d', strtotime('-14 days')),
        'period_end' => date('Y-m-d', strtotime('-8 days')),
        'gross_sales' => 14250.00,
        'commission' => 1140.00, // 8%
        'net_payout' => 13110.00,
        'utr' => 'HDFCR5202609180041289',
        'status' => 'PAID',
        'rate' => 8.00,
        'cod' => 1800.00,
        'orders' => 28,
        'acc' => '50200048123940',
        'ifsc' => 'HDFC0001254',
        'bank' => 'HDFC Bank, Maldahiya Branch',
        'notes' => 'Settled via Corporate NetBanking Batch #412'
    ],
    [
        'pharmacy_id' => 2, // Sanjivani 24x7 Chemist
        'period_start' => date('Y-m-d', strtotime('-7 days')),
        'period_end' => date('Y-m-d', strtotime('-1 days')),
        'gross_sales' => 18920.00,
        'commission' => 1513.60, // 8%
        'net_payout' => 17406.40,
        'utr' => NULL,
        'status' => 'PROCESSING',
        'rate' => 8.00,
        'cod' => 2200.00,
        'orders' => 36,
        'acc' => '50200048123940',
        'ifsc' => 'HDFC0001254',
        'bank' => 'HDFC Bank, Maldahiya Branch',
        'notes' => 'Queued for weekly Wednesday NEFT batch'
    ],
    [
        'pharmacy_id' => 1, // Apex Care Medicos
        'period_start' => date('Y-m-d', strtotime('-14 days')),
        'period_end' => date('Y-m-d', strtotime('-8 days')),
        'gross_sales' => 9840.00,
        'commission' => 787.20,
        'net_payout' => 9052.80,
        'utr' => 'ICICR5202609180088194',
        'status' => 'PAID',
        'rate' => 8.00,
        'cod' => 1400.00,
        'orders' => 19,
        'acc' => '002105018492',
        'ifsc' => 'ICIC0000021',
        'bank' => 'ICICI Bank, Sigra Branch',
        'notes' => 'Direct RTGS remittance verified'
    ],
    [
        'pharmacy_id' => 1, // Apex Care Medicos
        'period_start' => date('Y-m-d', strtotime('-7 days')),
        'period_end' => date('Y-m-d', strtotime('-1 days')),
        'gross_sales' => 12480.00,
        'commission' => 998.40,
        'net_payout' => 11481.60,
        'utr' => NULL,
        'status' => 'DUE',
        'rate' => 8.00,
        'cod' => 1950.00,
        'orders' => 24,
        'acc' => '002105018492',
        'ifsc' => 'ICIC0000021',
        'bank' => 'ICICI Bank, Sigra Branch',
        'notes' => 'Current weekly cycle reconciliation due'
    ],
    [
        'pharmacy_id' => 3, // LifeLine Pharmacy
        'period_start' => date('Y-m-d', strtotime('-7 days')),
        'period_end' => date('Y-m-d', strtotime('-1 days')),
        'gross_sales' => 6420.00,
        'commission' => 513.60,
        'net_payout' => 5906.40,
        'utr' => NULL,
        'status' => 'DUE',
        'rate' => 8.00,
        'cod' => 850.00,
        'orders' => 12,
        'acc' => '309988112233',
        'ifsc' => 'SBIN0000211',
        'bank' => 'State Bank of India, BHU Branch',
        'notes' => 'Cycle ready for approval'
    ]
];

$db->query("DELETE FROM `pharmacy_settlements` WHERE `id` > 0");
foreach ($settlements as $s) {
    $stmt = $db->prepare("INSERT INTO `pharmacy_settlements` (`pharmacy_id`, `settlement_period_start`, `settlement_period_end`, `gross_sales`, `upchar_commission`, `net_payout`, `utr_number`, `settlement_status`, `commission_rate`, `cod_remittance`, `order_count`, `bank_account_no`, `bank_ifsc`, `bank_name`, `settlement_notes`, `processed_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $procAt = ($s['status'] === 'PAID') ? date('Y-m-d H:i:s', strtotime('-5 days')) : null;
    $stmt->bind_param('issdddssddisssss', $s['pharmacy_id'], $s['period_start'], $s['period_end'], $s['gross_sales'], $s['commission'], $s['net_payout'], $s['utr'], $s['status'], $s['rate'], $s['cod'], $s['orders'], $s['acc'], $s['ifsc'], $s['bank'], $s['notes'], $procAt);
    $stmt->execute();
}
echo "5 Demo Settlements seeded successfully.\n";

$db->close();
echo "=== Done ===\n";
